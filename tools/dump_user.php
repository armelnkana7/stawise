<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/Helpers/helpers.php';
use App\Core\Database;

$stmt = Database::query('SELECT * FROM users WHERE id = :id', ['id' => 2]);
$u = $stmt->fetch(PDO::FETCH_ASSOC);
var_dump($u);
