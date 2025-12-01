<?php $title = 'Modifier rapport'; $layout = 'main'; require __DIR__ . '/../../layouts/header.php'; ?>
<div class="container mt-5">
    <div class="card p-5">
        <h2>Modifier rapport</h2>
        <form method="POST" action="<?php echo url('reports/update'); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($report['id']); ?>" />
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Programme</label>
                    <select name="program_id" class="form-control">
                        <?php foreach ($programs as $p): ?>
                            <option value="<?php echo $p['id']; ?>" <?php if ($p['id'] == $report['program_id']) echo 'selected'; ?>><?php echo htmlspecialchars($p['class_name'].' - '.$p['subject_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Date</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($report['created_at']); ?>" readonly />
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3"><label class="form-label">Heures faites</label><input type="number" name="nbr_hours_do" class="form-control" value="<?php echo htmlspecialchars($report['nbr_hours_do']); ?>" /></div>
                <div class="col-md-4 mb-3"><label class="form-label">Leçons faites</label><input type="number" name="nbr_lesson_do" class="form-control" value="<?php echo htmlspecialchars($report['nbr_lesson_do']); ?>" /></div>
                <div class="col-md-4 mb-3"><label class="form-label">Leçons digitalisées faites</label><input type="number" name="nbr_lesson_dig_do" class="form-control" value="<?php echo htmlspecialchars($report['nbr_lesson_dig_do']); ?>" /></div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3"><label class="form-label">TP faits</label><input name="nbr_tp_do" class="form-control" value="<?php echo htmlspecialchars($report['nbr_tp_do']); ?>"></div>
                <div class="col-md-6 mb-3"><label class="form-label">TP digitalisés faits</label><input name="nbr_tp_dig_do" class="form-control" value="<?php echo htmlspecialchars($report['nbr_tp_dig_do']); ?>"></div>
            </div>
            <button class="btn btn-primary" type="submit">Mettre à jour</button>
        </form>
    </div>
</div>
<?php require __DIR__ . '/../../layouts/footer.php'; ?>
