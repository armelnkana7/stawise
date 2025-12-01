<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Core\Database;

echo "Import DB schema from db.sql\n";

$sql = file_get_contents(__DIR__ . '/../db.sql');
if ($sql === false) {
    die("Could not read db.sql\n");
}

// Split statements by semicolon that are at the end of a line.
// Prepare statements naive split; we'll disable FK checks to avoid ordering issues
$stmts = preg_split('/;\s*\n/', $sql);

// Disable foreign key checks
Database::connect()->exec('SET FOREIGN_KEY_CHECKS = 0;');

foreach ($stmts as $s) {
    $s = trim($s);
    if ($s === '') continue;

    try {
        Database::connect()->exec($s);
        echo "Executed statement\n";
    } catch (PDOException $e) {
        echo "Failed: " . $e->getMessage() . "\n";
    }
}
// Re-enable foreign key checks
Database::connect()->exec('SET FOREIGN_KEY_CHECKS = 1;');

echo "Done.\n";
