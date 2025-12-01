<?php
require __DIR__ . '/../vendor/autoload.php';
use App\Core\Database;

// Usage: php insert_report.php <program_id> <nbr_hours_do> <nbr_lesson_do> <nbr_lesson_dig_do> <nbr_tp_do> <nbr_tp_dig_do>
$program = $argv[1] ?? 1;
$nbr_hours_do = $argv[2] ?? 0;
$nbr_lesson_do = $argv[3] ?? 0;
$nbr_lesson_dig_do = $argv[4] ?? 0;
$nbr_tp_do = $argv[5] ?? 0;
$nbr_tp_dig_do = $argv[6] ?? 0;

Database::query('INSERT INTO weekly_coverage_reports (program_id, nbr_hours_do, nbr_lesson_do, nbr_lesson_dig_do, nbr_tp_do, nbr_tp_dig_do) VALUES (:p, :h, :l, :ld, :tp, :tpd)', ['p' => $program, 'h' => $nbr_hours_do, 'l' => $nbr_lesson_do, 'ld' => $nbr_lesson_dig_do, 'tp' => $nbr_tp_do, 'tpd' => $nbr_tp_dig_do]);

echo "Inserted report for program {$program}\n";
