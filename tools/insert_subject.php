<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/Helpers/helpers.php';
use App\Core\Database;

Database::query('INSERT INTO subjects (code, name) VALUES (:code, :name)', ['code' => 'MAT', 'name' => 'Mathematiques']);
$sid = Database::connect()->lastInsertId();
echo "Inserted subject id $sid\n";
