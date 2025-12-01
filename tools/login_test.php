<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/Helpers/helpers.php';

use App\Core\Router;
use App\Models\User;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$_POST['email'] = 'admin@statwise.local';
$_POST['password'] = 'password';

$u = User::findByEmail($_POST['email']);
echo "Find user: "; var_dump((bool)$u);
if ($u) { echo "user id={$u->id}\n"; }

$router = Router::load(__DIR__ . '/../routes/web.php');
try {
    $router->dispatch('login', 'POST');
    echo "Dispatched POST login successfully\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

print_r($_SESSION);

// Try to access dashboard now
try {
    echo "\n--- Dashboard GET ---\n";
    $router->dispatch('dashboard', 'GET');
    echo "\n--- End Dashboard ---\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Access reports create
try {
    echo "\n--- Reports Create GET ---\n";
    $router->dispatch('reports/create', 'GET');
    echo "\n--- End Reports Create ---\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Check user edit page
try {
    echo "\n--- Users Edit GET -- id=2 ---\n";
    $_GET['id'] = 2;
    $router->dispatch('users/edit', 'GET');
    echo "\n--- End Users Edit GET ---\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Test logout
try {
    echo "\n--- Logout GET ---\n";
    $router->dispatch('logout', 'GET');
    echo "\n--- End Logout ---\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Attempt to access dashboard again
try {
    echo "\n--- Dashboard GET (after logout) ---\n";
    $router->dispatch('dashboard', 'GET');
    echo "\n--- End Dashboard (after logout) ---\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
