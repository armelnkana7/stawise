<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/Helpers/helpers.php';
use App\Core\Router;

if (session_status() === PHP_SESSION_NONE) session_start();
$_SESSION['user_id'] = 2; // admin demo
$_SESSION['role_id'] = 1;

$router = Router::load(__DIR__ . '/../routes/web.php');

try {
    ob_start();
    $router->dispatch('programs/list', 'GET');
    $out = ob_get_clean();
    echo "programs/list output length: " . strlen($out) . "\n";
    $json = json_decode($out, true);
    if ($json && is_array($json)) {
        echo "Programs returned: " . count($json) . "\n";
    } else {
        echo "programs/list JSON parse failed\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
