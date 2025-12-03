<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Rapport de Couverture Hebdomadaire</title>
</head>

<body>
    <h1>Rapport de Couverture Hebdomadaire</h1>
    <p>Période: <?php echo $period; ?></p>
    <?php
    $current_dept = null;
    $dept_totals = [];
    foreach ($aggregated_reports as $r) {
        if ($current_dept !== $r['department_name']) {
            if ($current_dept !== null) {
                // Print department total
                echo '<tr style="font-weight: bold; background-color: #f0f0f0;"><td>Total ' . $current_dept . '</td>';
                echo '<td>' . $dept_totals['planned_hours'] . '</td><td>' . $dept_totals['done_hours'] . '</td><td>' . ($dept_totals['planned_hours'] > 0 ? round(($dept_totals['done_hours'] / $dept_totals['planned_hours']) * 100, 2) . '%' : '0%') . '</td>';
                echo '<td>' . $dept_totals['planned_lessons'] . '</td><td>' . $dept_totals['done_lessons'] . '</td><td>' . ($dept_totals['planned_lessons'] > 0 ? round(($dept_totals['done_lessons'] / $dept_totals['planned_lessons']) * 100, 2) . '%' : '0%') . '</td>';
                echo '<td>' . $dept_totals['planned_lesson_dig'] . '</td><td>' . $dept_totals['done_lesson_dig'] . '</td><td>' . ($dept_totals['planned_lesson_dig'] > 0 ? round(($dept_totals['done_lesson_dig'] / $dept_totals['planned_lesson_dig']) * 100, 2) . '%' : '0%') . '</td>';
                echo '<td>' . $dept_totals['planned_tp'] . '</td><td>' . $dept_totals['done_tp'] . '</td><td>' . ($dept_totals['planned_tp'] > 0 ? round(($dept_totals['done_tp'] / $dept_totals['planned_tp']) * 100, 2) . '%' : '0%') . '</td>';
                echo '<td>' . $dept_totals['planned_tp_dig'] . '</td><td>' . $dept_totals['done_tp_dig'] . '</td><td>' . ($dept_totals['planned_tp_dig'] > 0 ? round(($dept_totals['done_tp_dig'] / $dept_totals['planned_tp_dig']) * 100, 2) . '%' : '0%') . '</td></tr>';
            }
            $current_dept = $r['department_name'];
            $dept_totals = ['planned_hours' => 0, 'done_hours' => 0, 'planned_lessons' => 0, 'done_lessons' => 0, 'planned_lesson_dig' => 0, 'done_lesson_dig' => 0, 'planned_tp' => 0, 'done_tp' => 0, 'planned_tp_dig' => 0, 'done_tp_dig' => 0];
            echo '<h2>Département: ' . $current_dept . '</h2>';
            echo '<h3>Couverture des heures</h3>';
            echo '<table>';
            echo '<thead><tr><th>Matière</th><th>Heures Prévues</th><th>Heures Faites</th><th>% Heures</th>';
            echo '<th>Leçons Prévues</th><th>Leçons Faites</th><th>% Leçons</th>';
            echo '<th>Leçons Dig Prévues</th><th>Leçons Dig Faites</th><th>% Leçons Dig</th>';
            echo '<th>TP Prévus</th><th>TP Faits</th><th>% TP</th>';
            echo '<th>TP Dig Prévus</th><th>TP Dig Faits</th><th>% TP Dig</th></tr></thead><tbody>';
        }
        echo '<tr>';
        echo '<td>' . $r['subject_name'] . '</td>';
        echo '<td>' . $r['planned_hours'] . '</td>';
        echo '<td>' . $r['done_hours'] . '</td>';
        echo '<td>' . ($r['planned_hours'] > 0 ? round(($r['done_hours'] / $r['planned_hours']) * 100, 2) . '%' : '0%') . '</td>';
        echo '<td>' . $r['planned_lessons'] . '</td>';
        echo '<td>' . $r['done_lessons'] . '</td>';
        echo '<td>' . ($r['planned_lessons'] > 0 ? round(($r['done_lessons'] / $r['planned_lessons']) * 100, 2) . '%' : '0%') . '</td>';
        echo '<td>' . $r['planned_lesson_dig'] . '</td>';
        echo '<td>' . $r['done_lesson_dig'] . '</td>';
        echo '<td>' . ($r['planned_lesson_dig'] > 0 ? round(($r['done_lesson_dig'] / $r['planned_lesson_dig']) * 100, 2) . '%' : '0%') . '</td>';
        echo '<td>' . $r['planned_tp'] . '</td>';
        echo '<td>' . $r['done_tp'] . '</td>';
        echo '<td>' . ($r['planned_tp'] > 0 ? round(($r['done_tp'] / $r['planned_tp']) * 100, 2) . '%' : '0%') . '</td>';
        echo '<td>' . $r['planned_tp_dig'] . '</td>';
        echo '<td>' . $r['done_tp_dig'] . '</td>';
        echo '<td>' . ($r['planned_tp_dig'] > 0 ? round(($r['done_tp_dig'] / $r['planned_tp_dig']) * 100, 2) . '%' : '0%') . '</td>';
        echo '</tr>';
        // Accumulate totals
        $dept_totals['planned_hours'] += $r['planned_hours'];
        $dept_totals['done_hours'] += $r['done_hours'];
        $dept_totals['planned_lessons'] += $r['planned_lessons'];
        $dept_totals['done_lessons'] += $r['done_lessons'];
        $dept_totals['planned_lesson_dig'] += $r['planned_lesson_dig'];
        $dept_totals['done_lesson_dig'] += $r['done_lesson_dig'];
        $dept_totals['planned_tp'] += $r['planned_tp'];
        $dept_totals['done_tp'] += $r['done_tp'];
        $dept_totals['planned_tp_dig'] += $r['planned_tp_dig'];
        $dept_totals['done_tp_dig'] += $r['done_tp_dig'];
    }
    if ($current_dept !== null) {
        // Print last department total
        echo '<tr style="font-weight: bold; background-color: #f0f0f0;"><td>Total ' . $current_dept . '</td>';
        echo '<td>' . $dept_totals['planned_hours'] . '</td><td>' . $dept_totals['done_hours'] . '</td><td>' . ($dept_totals['planned_hours'] > 0 ? round(($dept_totals['done_hours'] / $dept_totals['planned_hours']) * 100, 2) . '%' : '0%') . '</td>';
        echo '<td>' . $dept_totals['planned_lessons'] . '</td><td>' . $dept_totals['done_lessons'] . '</td><td>' . ($dept_totals['planned_lessons'] > 0 ? round(($dept_totals['done_lessons'] / $dept_totals['planned_lessons']) * 100, 2) . '%' : '0%') . '</td>';
        echo '<td>' . $dept_totals['planned_lesson_dig'] . '</td><td>' . $dept_totals['done_lesson_dig'] . '</td><td>' . ($dept_totals['planned_lesson_dig'] > 0 ? round(($dept_totals['done_lesson_dig'] / $dept_totals['planned_lesson_dig']) * 100, 2) . '%' : '0%') . '</td>';
        echo '<td>' . $dept_totals['planned_tp'] . '</td><td>' . $dept_totals['done_tp'] . '</td><td>' . ($dept_totals['planned_tp'] > 0 ? round(($dept_totals['done_tp'] / $dept_totals['planned_tp']) * 100, 2) . '%' : '0%') . '</td>';
        echo '<td>' . $dept_totals['planned_tp_dig'] . '</td><td>' . $dept_totals['done_tp_dig'] . '</td><td>' . ($dept_totals['planned_tp_dig'] > 0 ? round(($dept_totals['done_tp_dig'] / $dept_totals['planned_tp_dig']) * 100, 2) . '%' : '0%') . '</td></tr>';
        echo '</tbody></table>';
    }
    ?>
</body>

</html>