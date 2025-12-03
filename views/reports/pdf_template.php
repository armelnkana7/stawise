<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Rapport de Couverture Hebdomadaire</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1 style="font-size: 14px;">Rapport de Couverture Hebdomadaire</h1>
    <p style="font-size: 10px;"><strong>Période:</strong> <?php echo $period; ?></p>
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
            echo '<h2 style="font-size: 12px;">Département: ' . $current_dept . '</h2>';
            echo '<h3 style="font-size: 10px;">Couverture des heures</h3>';
            echo '<table style="border-collapse: collapse; font-size: 8px;">';
            echo '<thead><tr><th style="border: 1px solid #000; padding: 2px;">Matière</th><th style="border: 1px solid #000; padding: 2px;">Heures Prévues</th><th style="border: 1px solid #000; padding: 2px;">Heures Faites</th><th style="border: 1px solid #000; padding: 2px;">% Heures</th>';
            echo '<th style="border: 1px solid #000; padding: 2px;">Leçons Prévues</th><th style="border: 1px solid #000; padding: 2px;">Leçons Faites</th><th style="border: 1px solid #000; padding: 2px;">% Leçons</th>';
            echo '<th style="border: 1px solid #000; padding: 2px;">Leçons Dig Prévues</th><th style="border: 1px solid #000; padding: 2px;">Leçons Dig Faites</th><th style="border: 1px solid #000; padding: 2px;">% Leçons Dig</th>';
            echo '<th style="border: 1px solid #000; padding: 2px;">TP Prévus</th><th style="border: 1px solid #000; padding: 2px;">TP Faits</th><th style="border: 1px solid #000; padding: 2px;">% TP</th>';
            echo '<th style="border: 1px solid #000; padding: 2px;">TP Dig Prévus</th><th style="border: 1px solid #000; padding: 2px;">TP Dig Faits</th><th style="border: 1px solid #000; padding: 2px;">% TP Dig</th></tr></thead><tbody>';
        }
        echo '<tr>';
        echo '<td style="border: 1px solid #000; padding: 2px;">' . ($r['subject_name']) . '</td>';
        echo '<td style="border: 1px solid #000; padding: 2px;">' . ($r['planned_hours']) . '</td>';
        echo '<td style="border: 1px solid #000; padding: 2px;">' . $r['done_hours'] . '</td>';
        echo '<td style="border: 1px solid #000; padding: 2px;">' . ($r['planned_hours'] > 0 ? round(($r['done_hours'] / $r['planned_hours']) * 100, 2) . '%' : '0%') . '</td>';
        echo '<td style="border: 1px solid #000; padding: 2px;">' . ($r['planned_lessons']) . '</td>';
        echo '<td style="border: 1px solid #000; padding: 2px;">' . $r['done_lessons'] . '</td>';
        echo '<td style="border: 1px solid #000; padding: 2px;">' . ($r['planned_lessons'] > 0 ? round(($r['done_lessons'] / $r['planned_lessons']) * 100, 2) . '%' : '0%') . '</td>';
        echo '<td style="border: 1px solid #000; padding: 2px;">' . ($r['planned_lesson_dig']) . '</td>';
        echo '<td style="border: 1px solid #000; padding: 2px;">' . $r['done_lesson_dig'] . '</td>';
        echo '<td style="border: 1px solid #000; padding: 2px;">' . ($r['planned_lesson_dig'] > 0 ? round(($r['done_lesson_dig'] / $r['planned_lesson_dig']) * 100, 2) . '%' : '0%') . '</td>';
        echo '<td style="border: 1px solid #000; padding: 2px;">' . ($r['planned_tp']) . '</td>';
        echo '<td style="border: 1px solid #000; padding: 2px;">' . ($r['done_tp']) . '</td>';
        echo '<td style="border: 1px solid #000; padding: 2px;">' . ($r['planned_tp'] > 0 ? round(($r['done_tp'] / $r['planned_tp']) * 100, 2) . '%' : '0%') . '</td>';
        echo '<td style="border: 1px solid #000; padding: 2px;">' . ($r['planned_tp_dig']) . '</td>';
        echo '<td style="border: 1px solid #000; padding: 2px;">' . ($r['done_tp_dig']) . '</td>';
        echo '<td style="border: 1px solid #000; padding: 2px;">' . ($r['planned_tp_dig'] > 0 ? round(($r['done_tp_dig'] / $r['planned_tp_dig']) * 100, 2) . '%' : '0%') . '</td>';
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