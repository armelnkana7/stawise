<?php $title = 'Créer une classe';
$layout = 'main';
require __DIR__ . '/../../layouts/header.php'; ?>
<div class="container mt-5">
    <div class="card p-5">
        <h2>Nouvelle classe</h2>
        <form method="POST" action="<?php echo url('classes'); ?>">
            <?php echo csrf_field(); ?>
            <div class="mb-3">
                <label class="form-label">Etablissement</label>
                <select name="establishment_id" class="form-control" disabled>
                    <?php foreach ($ests as $e): ?>
                        <option value="<?php echo $e['id']; ?>" <?php echo $e['id'] == $_SESSION['establishment_id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($e['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Nom de la classe</label>
                <input type="text" name="name" class="form-control" />
            </div>
            <div class="mb-3">
                <label class="form-label">Code de la classe</label>
                <input type="text" name="code" class="form-control" />
            </div>
            <div class="mb-3">
                <label class="form-label">Section</label>
                <select name="section" class="form-control">
                    <option value="" > Selectionner</option>
                    <option value="1" > Francophone</option>
                    <option value="2" > Anglophone</option>
                </select>
            </div>
            <button class="btn btn-success" type="submit">Créer</button>
        </form>
    </div>
</div>
<?php require __DIR__ . '/../../layouts/footer.php'; ?>