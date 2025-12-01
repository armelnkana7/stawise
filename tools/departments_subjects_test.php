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

$subjectId = 1; // use default subject

// Create department with subject assignment
$_POST = [
    '_csrf' => csrf_token(),
    'name' => 'DepTest ' . time(),
    'code' => 'DTEST',
    'establishment_id' => 1,
    'subject_ids' => [$subjectId]
];

ob_start();
$router->dispatch('departments','POST');
$out = ob_get_clean();

// verify
$sub = Database::query('SELECT id, department_id FROM subjects WHERE id = :id', ['id' => $subjectId])->fetch(\PDO::FETCH_ASSOC);
if ($sub && $sub['department_id']) {
    echo "SUCCESS: subject $subjectId assigned to department {$sub['department_id']}\n";
} else {
    echo "FAIL: subject $subjectId not assigned to any department.\n";
}

?>
