<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/Helpers/helpers.php';
use App\Core\Database;

Database::query('INSERT INTO departments (establishment_id, name) VALUES (:est,:name)', ['est' => 1, 'name' => 'Mathématiques']);
$did = Database::connect()->lastInsertId();
echo 'Inserted dept id ' . $did . PHP_EOL;
Database::query('UPDATE users SET department_id = :d WHERE id = 2', ['d' => $did]);
echo 'Updated user 2 to dept ' . $did . PHP_EOL;
