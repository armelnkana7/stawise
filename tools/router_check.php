<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/Helpers/helpers.php';

// session needed for views and controllers
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use App\Core\Router;

$router = Router::load(__DIR__ . '/../routes/web.php');

$testUris = [
    '',
    '/',
    'login',
    'years',
    'establishments',
    'users',
    'classes',
    'departments',
    'roles',
    'reports',
    'statwise/public',
    'statwise/public/login'
];

foreach ($testUris as $uri) {
    echo "\nURI: '$uri' -> ";
    try {
        // We use GET to match sample routes
        $router->dispatch(trim($uri, '/'), 'GET');
        echo "ok\n";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

// Now simulate the behavior of index.php removing the base path '/statwise/public'
$scriptDir = str_replace('\\', '/', trim(dirname('/statwise/public/index.php'), '/'));
$uri = 'statwise/public/login';
$uriTrimmed = $uri;
if ($scriptDir !== '' && strpos($uriTrimmed, $scriptDir) === 0) {
    $uriTrimmed = trim(substr($uriTrimmed, strlen($scriptDir)), '/');
}

echo "\nAfter base path removal, '$uri' -> '$uriTrimmed'\n";
try {
    $router->dispatch($uriTrimmed, 'GET');
    echo "ok\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
