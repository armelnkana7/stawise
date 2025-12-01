<?php $title = 'Modifier matière'; $layout = 'main'; require __DIR__ . '/../../layouts/header.php'; ?>
<div class="container mt-5">
    <div class="card p-5">
        <h2>Modifier matière</h2>
        <form method="POST" action="<?php echo url('subjects/update'); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="id" value="<?php echo $subject['id']; ?>" />
            <div class="mb-3">
                <label class="form-label">Nom</label>
                <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($subject['name']); ?>" />
            </div>
            <div class="mb-3">
                <label class="form-label">Code</label>
                <input type="text" class="form-control" name="code" value="<?php echo htmlspecialchars($subject['code']); ?>" />
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control"><?php echo htmlspecialchars($subject['description'] ?? ''); ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Établissement</label>
                <select name="establishment_id" class="form-control select2">
                    <?php foreach ($ests as $e): ?>
                        <option value="<?php echo $e['id']; ?>" <?php echo ($e['id'] == $subject['establishment_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($e['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Département</label>
                <select name="department_id" class="form-control select2">
                    <option value="">-- Aucun --</option>
                    <?php foreach ($depts as $d): ?>
                        <option value="<?php echo $d['id']; ?>" <?php echo $d['id'] == ($subject['department_id'] ?? '') ? 'selected' : ''; ?>><?php echo htmlspecialchars($d['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button class="btn btn-primary" type="submit">Enregistrer</button>
        </form>
    </div>
</div>
<?php require __DIR__ . '/../../layouts/footer.php'; ?>
