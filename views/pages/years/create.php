<?php $title = 'Nouvelle année scolaire'; $layout = 'main'; require __DIR__ . '/../../layouts/header.php'; ?>
<div class="container mt-5">
    <div class="card p-5">
        <h2>Créer une nouvelle année</h2>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $err): ?>
                        <li><?php echo htmlspecialchars($err); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form method="POST" action="<?php echo url('years'); ?>">
            <?php echo csrf_field(); ?>
            <?php echo csrf_field(); ?>
            <div class="mb-3">
                <label class="form-label">Titre</label>
                <input type="text" class="form-control" name="title" value="<?php echo isset(
                    $old['title']
                ) ? htmlspecialchars($old['title']) : (isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''); ?>" />
            </div>
            <div class="mb-3">
                <label class="form-label">Date de début</label>
                <input type="date" class="form-control" name="start_date" value="<?php echo isset($old['start_date']) ? htmlspecialchars($old['start_date']) : (isset($_POST['start_date']) ? htmlspecialchars($_POST['start_date']) : ''); ?>" />
            </div>
            <div class="mb-3">
                <label class="form-label">Date de fin</label>
                <input type="date" class="form-control" name="end_date" value="<?php echo isset($old['end_date']) ? htmlspecialchars($old['end_date']) : (isset($_POST['end_date']) ? htmlspecialchars($_POST['end_date']) : ''); ?>" />
            </div>
            <button class="btn btn-success" type="submit">Enregistrer</button>
        </form>
    </div>
</div>
<?php require __DIR__ . '/../../layouts/footer.php'; ?>
