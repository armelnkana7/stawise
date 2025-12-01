<?php

// Affiche les erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Autoloader de Composer
require __DIR__.'/../vendor/autoload.php';
// Load app helpers (url, redirect and more)
require __DIR__.'/../app/Helpers/helpers.php';

// Chargement de la configuration de la base de données (si nécessaire globalement)
// $config = require __DIR__.'/../config/database.php';

// Routine
use App\Core\Router;

// Récupérer l'URI et la méthode de la requête
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$scriptDir = str_replace('\\', '/', trim(dirname($_SERVER['SCRIPT_NAME']), '/'));

if ($scriptDir !== '' && strpos($uri, $scriptDir) === 0) {
    $uri = trim(substr($uri, strlen($scriptDir)), '/');
}
$requestType = $_SERVER['REQUEST_METHOD'];

// Démarrer la session pour gérer l'authentification
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Charger le routeur et dispatcher la requête
try {
    Router::load(__DIR__.'/../routes/web.php')
        ->dispatch($uri, $requestType);
} catch (Exception $e) {
    echo '<h1>Erreur</h1>';
    echo '<p>' . $e . '</p>';
}
