<?php $title = 'Modifier année scolaire'; $layout = 'main'; require __DIR__ . '/../../layouts/header.php'; ?>
<div class="container mt-5">
    <div class="card p-5">
        <h2>Modifier l'année scolaire</h2>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $err): ?>
                        <li><?php echo htmlspecialchars($err); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form method="POST" action="<?php echo url('years/update'); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($year['id']); ?>" />
            <div class="mb-3">
                <label class="form-label">Titre</label>
                <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($year['title'] ?? ''); ?>" />
            </div>
            <div class="mb-3">
                <label class="form-label">Date de début</label>
                <input type="date" class="form-control" name="start_date" value="<?php echo htmlspecialchars($year['start_date'] ?? ''); ?>" />
            </div>
            <div class="mb-3">
                <label class="form-label">Date de fin</label>
                <input type="date" class="form-control" name="end_date" value="<?php echo htmlspecialchars($year['end_date'] ?? ''); ?>" />
            </div>
            <button class="btn btn-primary" type="submit">Mettre à jour</button>
        </form>
        <button type="button" class="btn btn-danger mt-3 btn-open-delete-modal" data-action="<?php echo url('years/delete'); ?>" data-id="<?php echo htmlspecialchars($year['id']); ?>" data-name="<?= htmlspecialchars($year['title']) ?>">Supprimer</button>
    </div>
</div>
<?php require __DIR__ . '/../../layouts/footer.php'; ?>