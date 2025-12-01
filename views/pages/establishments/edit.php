<?php $title = 'Modifier établissement'; $layout = 'main'; require __DIR__ . '/../../layouts/header.php'; ?>
<div class="container mt-5">
    <div class="card p-5">
        <h2>Modifier l'établissement</h2>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $err): ?>
                        <li><?php echo htmlspecialchars($err); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form method="POST" action="<?php echo url('establishments/update'); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($est['id']); ?>" />
            <div class="mb-3">
                <label class="form-label">Nom</label>
                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($est['name'] ?? ''); ?>" />
            </div>
            <button class="btn btn-primary" type="submit">Mettre à jour</button>
        </form>
        <button type="button" class="btn btn-danger mt-3 btn-open-delete-modal" data-action="<?php echo url('establishments/delete'); ?>" data-id="<?php echo htmlspecialchars($est['id']); ?>" data-name="<?= htmlspecialchars($est['name']) ?>">Supprimer</button>
    </div>
</div>
<?php require __DIR__ . '/../../layouts/footer.php'; ?>