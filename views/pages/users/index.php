<?php $title = 'Gestion des utilisateurs';
$layout = 'main';
require __DIR__ . '/../../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../../../app/Helpers/permissions.php'; ?>


<!--begin::Toolbar-->
<div id="kt_app_toolbar" class="app-toolbar pt-5">
    <!--begin::Toolbar container-->
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
        <!--begin::Toolbar wrapper-->
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column gap-1 me-3 mb-2">
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold mb-6">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                        <a href="../dist/index.html" class="text-gray-500">
                            <i class="ki-duotone ki-home fs-3 text-gray-400 me-n1"></i>
                        </a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Pages</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Careers</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-700">Careers Apply</li>
                    <!--end::Item-->
                </ul>
                <h1>Utilisateurs</h1>

            </div>
        </div>
        <!-- Import modal -->
        <div class="modal fade" id="modalImportReports" tabindex="-1" aria-labelledby="modalImportReportsLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalImportReportsLabel">Importer des rapports (CSV)</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="<?php echo url('reports'); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Fichier CSV</label>
                                <input type="file" name="import_file" accept=".csv,.xlsx,.pdf" class="form-control" />
                            </div>
                            <div class="mb-3">
                                <small class="text-muted">Le fichier CSV doit contenir une colonne program_id ou
                                    ('class' et 'subject') et des colonnes nbr_hours_do, nbr_lesson_do,
                                    nbr_lesson_dig_do, nbr_tp_do, nbr_tp_dig_do. Le champ created_at peut être
                                    présent.</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-success">Importer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--end::Toolbar wrapper-->
    </div>
    <!--end::Toolbar container-->
</div>
<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-fluid">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <input type="text" data-kt-customer-table-filter="search"
                            class="form-control form-control-solid w-250px ps-12" placeholder="Rechercher" />
                    </div>
                    <!--end::Search-->
                </div>

                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                    <div class="d-flex">
                        <button class="btn btn-sm btn-primary ms-3 px-4 py-3" data-bs-toggle="modal" data-bs-target="#modalUserCreate">Nouvel utilisateur</button>
                        <a class="btn btn-sm btn-outline-secondary me-2"
                            href="<?php echo url('reports/export') . (isset($_GET['q']) ? '?q=' . urlencode($_GET['q']) : ''); ?>">Exporter
                            CSV</a>
                            
                        <!-- User create modal -->
                        <div class="modal fade" id="modalUserCreate" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Nouvel utilisateur (Chef de département)</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="<?= url('users'); ?>">
                                            <?= csrf_field(); ?>
                                            <div class="mb-3">
                                                <label class="form-label">Nom complet</label>
                                                <input type="text" name="full_name" class="form-control" required />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="email" name="email" class="form-control" required />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Mot de passe</label>
                                                <input type="password" name="password" class="form-control" required />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Rôle</label>
                                                <select name="role_id" id="create_user_role" class="form-control">
                                                    <?php foreach ($roles as $r): ?>
                                                        <option value="<?= $r['id'] ?>" data-desc="<?= htmlspecialchars($r['description'] ?? '') ?>"><?= htmlspecialchars($r['name']) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <small id="createRoleDesc" class="text-muted"></small>
                                            </div>
                                            <?php $permMap = include __DIR__ . '/../../../config/permissions.php';
                                            $allPerms = [];
                                            foreach ($permMap as $rolePerms) {
                                                foreach ($rolePerms as $p => $v) {
                                                    $allPerms[$p] = true;
                                                }
                                            }
                                            $allPerms = array_keys($allPerms);
                                            ?>
                                            <!-- <div class="mb-3">
                                                <label class="form-label">Permissions avancées (override)</label>
                                                <div>
                                                    <?php foreach ($allPerms as $p): ?>
                                                        <label class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="extra_permissions[]" value="<?= $p ?>"> <span class="form-check-label"><?= htmlspecialchars($p) ?></span>
                                                        </label>
                                                    <?php endforeach; ?>
                                                </div>
                                                <small class="text-muted">Ces permissions seront enregistrées comme override pour l'utilisateur (si supportées).</small>
                                            </div> -->
                                            <div class="mb-3">
                                                <label class="form-label">Département</label>
                                                <select name="department_id" class="form-control">
                                                    <option value="">-- Aucun --</option>
                                                    <?php foreach ($depts as $d): ?>
                                                        <option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['name']) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Etablissement</label>
                                                <select name="establishment_id" class="form-control" <?= isset($_SESSION['role_id']) && !role_has_permission($_SESSION['role_id'], 'switch_establishment') ? 'disabled' : '' ?>>
                                                    <option value="">-- Aucun --</option>
                                                    <?php foreach ($ests as $e): ?>
                                                        <option value="<?= $e['id'] ?>" <?= (isset($_SESSION['establishment_id']) && $_SESSION['establishment_id'] == $e['id']) ? 'selected' : '' ?>><?= htmlspecialchars($e['name']) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="alert alert-info">
                    <strong>Rôles et permissions :</strong>
                    <?php foreach ($roles as $r): ?>
                        <div><b><?= htmlspecialchars($r['name']) ?>:</b> <?= htmlspecialchars($r['description'] ?? '') ?></div>
                    <?php endforeach; ?>
                    <br>
                    Vous pouvez attribuer un rôle à un utilisateur et optionnellement ajouter des permissions spécifiques via les cases "Permissions avancées".
                </div>
                <table id="kt_datatable_zero_configuration" class="table table-row-dashed border-gray-300 align-middle gy-6">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $u): ?>
                            <tr>
                                <td><?php echo $u['id']; ?></td>
                                <td><?php echo htmlspecialchars($u['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($u['email']); ?></td>
                                <td><?php echo htmlspecialchars($u['role_name']); ?></td>
                                <td>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-user-edit-<?= $u['id'] ?>">Edit</button>
                                </td>

                                <!-- User edit modal -->
                                <div class="modal fade" id="modal-user-edit-<?= $u['id'] ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Modifier l'utilisateur</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="<?php echo url('users/update'); ?>">
                                                    <?= csrf_field(); ?>
                                                    <input type="hidden" name="id" value="<?= $u['id'] ?>">
                                                    <div class="mb-3">
                                                        <label class="form-label">Nom</label>
                                                        <input type="text" class="form-control" disabled value="<?= htmlspecialchars($u['full_name']) ?>" />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Email</label>
                                                        <input type="email" class="form-control" disabled value="<?= htmlspecialchars($u['email']) ?>" />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Rôle</label>
                                                        <select name="role_id" id="edit_role_select_<?= $u['id'] ?>" class="form-control">
                                                            <?php foreach ($roles as $r): ?>
                                                                <option value="<?= $r['id'] ?>" data-desc="<?= htmlspecialchars($r['description'] ?? '') ?>" <?= ($r['id'] == $u['role_id']) ? 'selected' : '' ?>><?= htmlspecialchars($r['name']) ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <small id="editRoleDesc_<?= $u['id'] ?>" class="text-muted"><?= htmlspecialchars($u['role_name'] ?? '') ?></small>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Département</label>
                                                        <select name="department_id" class="form-control">
                                                            <option value="">-- Aucun --</option>
                                                            <?php foreach ($depts as $d): ?>
                                                                <option value="<?= $d['id'] ?>" <?= ($d['id'] == $u['department_id']) ? 'selected' : '' ?>><?= htmlspecialchars($d['name']) ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Etablissement</label>
                                                        <select name="establishment_id" class="form-control" <?= isset($_SESSION['role_id']) && !role_has_permission($_SESSION['role_id'], 'switch_establishment') ? 'disabled' : '' ?>>
                                                            <option value="">-- Aucun --</option>
                                                            <?php foreach ($ests as $e): ?>
                                                                <option value="<?= $e['id'] ?>" <?= ($e['id'] == ($u['establishment_id'] ?? '')) ? 'selected' : '' ?>><?= htmlspecialchars($e['name']) ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <?php $meta = null;
                                                    if (!empty($u['meta']) && is_string($u['meta'])) {
                                                        $meta = json_decode($u['meta'], true);
                                                    }
                                                    $userPerms = $meta['permissions'] ?? []; ?>
                                                    <div class="mb-3">
                                                        <label class="form-label">Permissions avancées (override)</label>
                                                        <div>
                                                            <?php foreach ($allPerms as $p): ?>
                                                                <label class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" name="extra_permissions[]" value="<?= $p ?>" <?= in_array($p, $userPerms) ? 'checked' : '' ?>> <span class="form-check-label"><?= htmlspecialchars($p) ?></span>
                                                                </label>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>