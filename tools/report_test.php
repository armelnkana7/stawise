<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/Helpers/helpers.php';
use App\Core\Router;

if (session_status() === PHP_SESSION_NONE) session_start();
// Simulate an authenticated user
$_SESSION['user_id'] = 2;
$_SESSION['user_name'] = 'Admin Demo';
$_SESSION['department_id'] = 1;

$router = Router::load(__DIR__ . '/../routes/web.php');

// Create a program
$_POST['classe_id'] = 1; // 6e A
$_POST['subject_id'] = 1; // MAT
$_POST['nbr_hours'] = 10;
$_POST['nbr_lesson'] = 20;
$_POST['nbr_lesson_dig'] = 2;
$_POST['nbr_tp'] = 0;
$_POST['nbr_tp_dig'] = 0;
try {
    // Simulate AJAX create of program
    $_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
    // CSRF token for POST
    $_POST['_csrf'] = csrf_token();
    ob_start();
    $router->dispatch('programs', 'POST');
    $jsonout = ob_get_clean();
    echo "Program created (AJAX): {$jsonout}\n";
    unset($_SERVER['HTTP_X_REQUESTED_WITH']);
    echo "Program created\n";
} catch (Exception $e) {
    echo "Error (program create): " . $e->getMessage() . "\n";
}

// Create a report for the program (take first program)
$progStmt = \App\Core\Database::query('SELECT id FROM programs LIMIT 1');
$program = $progStmt->fetch(\PDO::FETCH_ASSOC);
$programId = $program['id'] ?? 1;

$_POST = [];
$_POST['program_id'] = $programId;
$_POST['nbr_hours_do'] = 2;
$_POST['nbr_lesson_do'] = 1;
$_POST['nbr_lesson_dig_do'] = 0;
$_POST['nbr_tp_do'] = 0;
$_POST['nbr_tp_dig_do'] = 0;
// Add CSRF token for report create
$_POST['_csrf'] = csrf_token();
try {
    $router->dispatch('reports', 'POST');
    echo "Report created for program {$programId}\n";
} catch (Exception $e) {
    echo "Error (report create): " . $e->getMessage() . "\n";
}

// List reports
try {
    $router->dispatch('reports', 'GET');
    echo "Displayed reports\n";
} catch (Exception $e) {
    echo "Error (reports get): " . $e->getMessage() . "\n";
}

// Export
try {
    ob_start();
    $router->dispatch('reports/export', 'GET');
    $csv = ob_get_clean();
    echo "CSV export length: " . strlen($csv) . "\n";
} catch (Exception $e) {
    echo "Error (reports export): " . $e->getMessage() . "\n";
}
