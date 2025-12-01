<?php $title = 'Modifier utilisateur'; $layout = 'main'; require __DIR__ . '/../../layouts/header.php'; ?>
<div class="container mt-5">
    <div class="card p-5">
        <h2>Modifier l'utilisateur</h2>
        <form method="POST" action="<?php echo url('users/update'); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>" />
            <div class="mb-3">
                <label class="form-label">Nom</label>
                <input type="text" class="form-control" disabled value="<?php echo htmlspecialchars($user['full_name']); ?>" />
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" disabled value="<?php echo htmlspecialchars($user['email']); ?>" />
            </div>
            <div class="mb-3">
                <label class="form-label">Rôle</label>
                <select name="role_id" class="form-control">
                    <?php foreach ($roles as $r): ?>
                        <option value="<?php echo $r['id']; ?>" <?php echo ($r['id'] == $user['role_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($r['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Département</label>
                <select name="department_id" class="form-control">
                    <option value="">-- Aucun --</option>
                    <?php foreach ($depts as $d): ?>
                        <option value="<?php echo $d['id']; ?>" <?php echo ($d['id'] == $user['department_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($d['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button class="btn btn-success" type="submit">Enregistrer</button>
        </form>
    </div>
</div>
<?php require __DIR__ . '/../../layouts/footer.php'; ?>
