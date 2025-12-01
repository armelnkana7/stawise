<?php $title = 'Créer département'; $layout = 'main'; require __DIR__ . '/../../layouts/header.php'; ?>
<div class="container mt-5">
    <div class="card p-5">
        <h2>Nouveau département</h2>
        <form method="POST" action="<?php echo url('departments'); ?>">
            <?php echo csrf_field(); ?>
            <div class="mb-3">
                <label class="form-label">Nom</label>
                <input type="text" class="form-control" name="name" />
            </div>
            <div class="mb-3">
                <label class="form-label">Établissement</label>
                <select name="establishment_id" class="form-control">
                    <?php foreach ($ests as $e): ?>
                        <option value="<?php echo $e['id']; ?>" <?php echo (isset($_SESSION['establishment_id']) && $_SESSION['establishment_id'] == $e['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($e['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Matières (sélection multiple)</label>
                <select name="subject_ids[]" multiple class="form-control select2">
                    <?php foreach ($subjects as $s): ?>
                        <option value="<?php echo $s['id']; ?>"><?php echo htmlspecialchars($s['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button class="btn btn-success" type="submit">Créer</button>
        </form>
    </div>
</div>
<?php require __DIR__ . '/../../layouts/footer.php'; ?>
