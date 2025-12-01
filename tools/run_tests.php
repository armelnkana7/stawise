<?php
echo "Running tests...\n";
$cmds = [
    'php tools/seed_db.php',
    'php tools/programs_list_test.php',
    'php tools/departments_subjects_test.php',
    'php tools/classes_subjects_test.php',
    'php tools/report_test.php',
    'php tools/integration_test.php'
];
foreach ($cmds as $c) {
    echo "\n--- cmd: $c\n";
    passthru($c, $ret);
    if ($ret !== 0) {
        echo "Command failed with status $ret\n";
        exit($ret);
    }
}
echo "All tests passed\n";
