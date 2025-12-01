<?php
require __DIR__ . '/../vendor/autoload.php';
use App\Core\Database;

// Simple CLI script to insert a program
$classe_id = $argv[1] ?? 1;
$subject_id = $argv[2] ?? 1;
$nbr_hours = $argv[3] ?? 10;
$nbr_lesson = $argv[4] ?? 20;
$nbr_lesson_dig = $argv[5] ?? 0;
$nbr_tp = $argv[6] ?? 0;
$nbr_tp_dig = $argv[7] ?? 0;

Database::query('INSERT INTO programs (classe_id, subject_id, nbr_hours, nbr_lesson, nbr_lesson_dig, nbr_tp, nbr_tp_dig) VALUES (:c, :s, :h, :l, :ld, :tp, :tpd)', ['c' => $classe_id, 's' => $subject_id, 'h' => $nbr_hours, 'l' => $nbr_lesson, 'ld' => $nbr_lesson_dig, 'tp' => $nbr_tp, 'tpd' => $nbr_tp_dig]);
echo "Program inserted for class {$classe_id} subject {$subject_id}\n";
