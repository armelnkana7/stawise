<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/Helpers/helpers.php';
use App\Core\Router;

if (session_status() === PHP_SESSION_NONE) session_start();
// Authenticate as admin (seeded user 2)
$_SESSION['user_id'] = 2;
$_SESSION['user_name'] = 'Admin Demo';
$_SESSION['department_id'] = 1;

$router = Router::load(__DIR__ . '/../routes/web.php');

// Create a year
$_POST['title'] = '2025-2026';
$_POST['start_date'] = '2025-09-01';
$_POST['end_date'] = '2026-06-30';
try {
    $router->dispatch('years', 'POST');
    echo "Created year\n";
} catch (Exception $e) {
    echo "Error: {$e->getMessage()}\n";
}

// Check listing
try {
    $router->dispatch('years', 'GET');
    echo "Listed years\n";
} catch (Exception $e) {
    echo "Error: {$e->getMessage()}\n";
}
