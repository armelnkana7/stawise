<?php $title = 'Créer role'; $layout = 'main'; require __DIR__ . '/../../layouts/header.php'; ?>
<div class="container mt-5">
    <div class="card p-5">
        <h2>Nouveau rôle</h2>
        <form method="POST" action="<?php echo url('roles'); ?>">
            <?php echo csrf_field(); ?>
            <div class="mb-3">
                <label class="form-label">Nom du rôle</label>
                <input type="text" name="name" class="form-control" />
            </div>
            <button class="btn btn-success" type="submit">Créer</button>
        </form>
    </div>
</div>
<?php require __DIR__ . '/../../layouts/footer.php'; ?>
