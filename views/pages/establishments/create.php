<?php $title = 'Créer établissement'; $layout = 'main'; require __DIR__ . '/../../layouts/header.php'; ?>
<div class="container mt-5">
    <div class="card p-5">
        <h2>Créer un établissement</h2>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $err): ?>
                        <li><?php echo htmlspecialchars($err); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form method="POST" action="<?php echo url('establishments'); ?>">
            <?php echo csrf_field(); ?>
            <div class="mb-3">
                <label class="form-label">Nom</label>
                <input type="text" name="name" class="form-control" value="<?php echo isset($old['name']) ? htmlspecialchars($old['name']) : (isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '') ?>" />
            </div>
            <button class="btn btn-success" type="submit">Créer</button>
        </form>
    </div>
</div>
<?php require __DIR__ . '/../../layouts/footer.php'; ?>
