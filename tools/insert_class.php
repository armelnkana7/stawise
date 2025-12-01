<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/Helpers/helpers.php';
use App\Core\Database;

Database::query('INSERT INTO classes (establishment_id, department_id, name) VALUES (:est, :dept, :name)', ['est' => 1, 'dept' => 1, 'name' => '6e A']);
$cid = Database::connect()->lastInsertId();
echo "Inserted class id $cid\n";
