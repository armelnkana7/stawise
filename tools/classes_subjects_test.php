<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/Helpers/helpers.php';
use App\Core\Router;
use App\Core\Database;

if (session_status() === PHP_SESSION_NONE) session_start();
$_SESSION['user_id'] = 2;
$_SESSION['role_id'] = 1;
$_SESSION['establishment_id'] = 1;

$router = Router::load(__DIR__ . '/../routes/web.php');

// Ensure class exists
$class = Database::query('SELECT id FROM classes LIMIT 1')->fetch(\PDO::FETCH_ASSOC);
if (!$class) {
    Database::query('INSERT INTO classes (establishment_id, name) VALUES (:est, :name)', ['est' => 1, 'name' => 'Test Class']);
    $classId = Database::connect()->lastInsertId();
} else {
    $classId = $class['id'];
}

// Ensure subject exists
$sub = Database::query('SELECT id FROM subjects LIMIT 1')->fetch(\PDO::FETCH_ASSOC);
if (!$sub) {
    Database::query('INSERT INTO subjects (code, name, establishment_id) VALUES (:code, :name, :est)', ['code' => 'SUBT', 'name' => 'Subject Test', 'est' => 1]);
    $subjectId = Database::connect()->lastInsertId();
} else {
    $subjectId = $sub['id'];
}

// Prepare POST to classes/subjects
$_POST = [
    '_csrf' => csrf_token(),
    'class_id' => $classId,
    'subject_id' => $subjectId,
    'planned_hours_per_week' => 1.5
];

ob_start();
$router->dispatch('classes/subjects','POST');
$out = ob_get_clean();

// Verify assignment
$assigned = Database::query('SELECT id FROM class_subjects WHERE class_id = :c AND subject_id = :s', ['c' => $classId, 's' => $subjectId])->fetch(\PDO::FETCH_ASSOC);
if ($assigned) {
    echo "SUCCESS: subject $subjectId assigned to class $classId (id {$assigned['id']}).\n";
} else {
    echo "FAIL: subject $subjectId not assigned to class $classId.\n";
}

?>
