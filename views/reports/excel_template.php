<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Rapport de Couverture Hebdomadaire</title>
</head>

<body>
    <h1>Rapport de Couverture Hebdomadaire</h1>
    <p>Période: <?php echo htmlspecialchars($period); ?></p>
    <p>Département ID: <?php echo htmlspecialchars($department_id); ?></p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Classe</th>
                <th>Matière</th>
                <th>Heures Ftes</th>
                <th>Leçons Ftes</th>
                <th>Leçons Dig Ftes</th>
                <th>TP Fts</th>
                <th>TP Dig Fts</th>
                <th>Date</th>
                <th>Enregistré par</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reports as $r): ?>
                <tr>
                    <td><?php echo htmlspecialchars($r['id']); ?></td>
                    <td><?php echo htmlspecialchars($r['class_name']); ?></td>
                    <td><?php echo htmlspecialchars($r['subject_name']); ?></td>
                    <td><?php echo htmlspecialchars($r['nbr_hours_do']); ?></td>
                    <td><?php echo htmlspecialchars($r['nbr_lesson_do']); ?></td>
                    <td><?php echo htmlspecialchars($r['nbr_lesson_dig_do']); ?></td>
                    <td><?php echo htmlspecialchars($r['nbr_tp_do']); ?></td>
                    <td><?php echo htmlspecialchars($r['nbr_tp_dig_do']); ?></td>
                    <td><?php echo htmlspecialchars($r['created_at']); ?></td>
                    <td><?php echo htmlspecialchars($r['recorded_by']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>