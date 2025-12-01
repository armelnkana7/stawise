<?php $title = 'Programmes par classe';
$layout = 'main';
require __DIR__ . '/../../layouts/header.php'; ?>


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
                <h1><?= $title ?></h1>

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
                    <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click"
                        data-kt-menu-placement="bottom-end">
                        <i class="ki-duotone ki-filter fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>Filter</button>
                    <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true"
                        id="kt-toolbar-filter">
                        <!--begin::Header-->
                        <div class="px-7 py-5">
                            <div class="fs-4 text-dark fw-bold">Filter Options</div>
                        </div>
                        <div class="separator border-gray-200"></div>
                        <div class="px-7 py-5">
                            <!--begin::Input group-->
                            <div class="mb-10">
                                <!--begin::Label-->
                                <label class="form-label fs-5 fw-semibold mb-3">Month:</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select class="form-select form-select-solid fw-bold" data-kt-select2="true"
                                    data-placeholder="Select option" data-allow-clear="true"
                                    data-kt-customer-table-filter="month" data-dropdown-parent="#kt-toolbar-filter">
                                    <option></option>
                                    <option value="aug">August</option>
                                    <option value="sep">September</option>
                                    <option value="oct">October</option>
                                    <option value="nov">November</option>
                                    <option value="dec">December</option>
                                </select>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="mb-10">
                                <!--begin::Label-->
                                <label class="form-label fs-5 fw-semibold mb-3">Payment Type:</label>
                                <!--end::Label-->
                                <!--begin::Options-->
                                <div class="d-flex flex-column flex-wrap fw-semibold"
                                    data-kt-customer-table-filter="payment_type">
                                    <!--begin::Option-->
                                    <label
                                        class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                        <input class="form-check-input" type="radio" name="payment_type" value="all"
                                            checked="checked" />
                                        <span class="form-check-label text-gray-600">All</span>
                                    </label>
                                    <!--end::Option-->
                                    <!--begin::Option-->
                                    <label
                                        class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                        <input class="form-check-input" type="radio" name="payment_type" value="visa" />
                                        <span class="form-check-label text-gray-600">Visa</span>
                                    </label>
                                    <!--end::Option-->
                                    <!--begin::Option-->
                                    <label class="form-check form-check-sm form-check-custom form-check-solid mb-3">
                                        <input class="form-check-input" type="radio" name="payment_type"
                                            value="mastercard" />
                                        <span class="form-check-label text-gray-600">Mastercard</span>
                                    </label>
                                    <!--end::Option-->
                                    <!--begin::Option-->
                                    <label class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="radio" name="payment_type"
                                            value="american_express" />
                                        <span class="form-check-label text-gray-600">American Express</span>
                                    </label>
                                    <!--end::Option-->
                                </div>
                                <!--end::Options-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Actions-->
                            <div class="d-flex justify-content-end">
                                <button type="reset" class="btn btn-light btn-active-light-primary me-2"
                                    data-kt-menu-dismiss="true" data-kt-customer-table-filter="reset">Reset</button>
                                <button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true"
                                    data-kt-customer-table-filter="filter">Apply</button>
                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Content-->
                    </div>
                    <div class="d-flex">
                        <a class="btn btn-sm btn-outline-secondary me-2"
                            href="<?php echo url('reports/export') . (isset($_GET['q']) ? '?q=' . urlencode($_GET['q']) : ''); ?>">Exporter
                            CSV</a>
                        <button class="btn btn-sm btn-outline-secondary me-2" data-bs-toggle="modal"
                            data-bs-target="#modalImportReports">Importer</button>
                        <button class="btn btn-sm btn-primary ms-3 px-4 py-3" data-bs-toggle="modal"
                            data-bs-target="#modalProgramCreate">Nouveau</button>

                        <!-- Program create modal (small) -->
                        <div class="modal fade" id="modalReportCreate" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Nouveau rapport hebdomadaire</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <form method="POST" action="<?= url('reports'); ?>" id="reportCreateForm">
                                        <?= csrf_field(); ?>

                                        <div class="modal-body">

                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Programme</label>
                                                    <select name="program_id" class="form-control" required>
                                                        <option value="">-- Sélectionner --</option>
                                                        <?php foreach ($programs as $prog): ?>
                                                            <option value="<?= $prog['id']; ?>">
                                                                <?= htmlspecialchars($prog['class_name'] . ' - ' . $prog['subject_name']); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Heures faites</label>
                                                    <input name="nbr_hours_do" type="number" min="0"
                                                        class="form-control" required />
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Leçons faites</label>
                                                    <input name="nbr_lesson_do" type="number" min="0"
                                                        class="form-control" required />
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Leçons digitalisées faites</label>
                                                    <input name="nbr_lesson_dig_do" type="number" min="0"
                                                        class="form-control" required />
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">TP faits</label>
                                                    <input name="nbr_tp_do" type="number" min="0" class="form-control"
                                                        required />
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">TP digitalisés faits</label>
                                                    <input name="nbr_tp_dig_do" type="number" min="0"
                                                        class="form-control" required />
                                                </div>
                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Fermer</button>
                                            <button type="submit" class="btn btn-primary">Sauvegarder</button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <table id="kt_datatable_zero_configuration"
                    class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer"
                    id="kt_ecommerce_products_table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Classe</th>
                            <th>Matière</th>
                            <th>Heures prévues</th>
                            <th>Leçons</th>
                            <th>TP</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($programs as $p): ?>
                            <tr>
                                <td><?php echo $p['id']; ?></td>
                                <td><?php echo htmlspecialchars($p['class_name']); ?></td>
                                <td><?php echo htmlspecialchars($p['subject_name']); ?></td>
                                <td><?php echo htmlspecialchars($p['nbr_hours']); ?></td>
                                <td><?php echo htmlspecialchars($p['nbr_lesson']); ?></td>
                                <td><?php echo htmlspecialchars($p['nbr_tp']); ?></td>
                                <td>

                                    <a href="#" class="btn btn-light btn-active-light-primary btn-sm"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        Actions <i class="ki-duotone ki-down fs-5 ms-1"></i>
                                    </a>

                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded w-125px py-4"
                                        data-kt-menu="true">
                                        <div class="menu-item px-3">
                                            <button class="btn btn-sm btn-outline-primary btn-program-edit"
                                                data-id="<?php echo htmlspecialchars($p['id']); ?>"
                                                data-classe-id="<?php echo htmlspecialchars($p['classe_id']); ?>"
                                                data-subject-id="<?php echo htmlspecialchars($p['subject_id']); ?>"
                                                data-nbr-hours="<?php echo htmlspecialchars($p['nbr_hours']); ?>"
                                                data-nbr-lesson="<?php echo htmlspecialchars($p['nbr_lesson']); ?>"
                                                data-nbr-lesson-dig="<?php echo htmlspecialchars($p['nbr_lesson_dig']); ?>"
                                                data-nbr-tp="<?php echo htmlspecialchars($p['nbr_tp']); ?>"
                                                data-nbr-tp-dig="<?php echo htmlspecialchars($p['nbr_tp_dig']); ?>"
                                                data-bs-toggle="modal" data-bs-target="#modalProgramEdit">Éditer</button>
                                        </div>

                                        <div class="menu-item px-3">
                                            <button type="button" class="btn btn-sm btn-outline-danger btn-open-delete-modal" data-action="<?php echo url('programs/delete'); ?>" data-id="<?php echo htmlspecialchars($p['id']); ?>" data-name="<?php echo htmlspecialchars($p['class_name'] . ' - ' . $p['subject_name']); ?>">Supprimer</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal create -->
    <div class="modal fade" id="modalProgramCreate" tabindex="-1" aria-labelledby="modalProgramCreateLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalProgramCreateLabel">Nouveau programme</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="<?php echo url('programs'); ?>" id="programCreateForm">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="return_to" value="programs" />
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Classe</label>
                                <select name="classe_id" class="form-control">
                                    <?php foreach (\App\Core\Database::query('SELECT id, name FROM classes WHERE establishment_id = :establishment_id', ['establishment_id' => $_SESSION['establishment_id'] ?? 0])->fetchAll(\PDO::FETCH_ASSOC) as $c): ?>
                                        <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Matière</label>
                                <select name="subject_id" class="form-control">
                                    <?php foreach (\App\Core\Database::query('SELECT id, name FROM subjects WHERE establishment_id = :establishment_id', ['establishment_id' => $_SESSION['establishment_id'] ?? 0])->fetchAll(\PDO::FETCH_ASSOC) as $s): ?>
                                        <option value="<?php echo $s['id']; ?>"><?php echo htmlspecialchars($s['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3"><label class="form-label">Heures prévues</label><input
                                    type="number" name="nbr_hours" class="form-control" step="1" min="0" value="0">
                            </div>
                            <div class="col-md-4 mb-3"><label class="form-label">Leçons</label><input type="number"
                                    name="nbr_lesson" class="form-control" step="1" min="0" value="0"></div>
                            <div class="col-md-4 mb-3"><label class="form-label">Leçons digitalisées</label><input
                                    type="number" name="nbr_lesson_dig" class="form-control" step="1" min="0" value="0">
                            </div>
                            <div class="col-md-4 mb-3"><label class="form-label">TP prévues</label><input type="number"
                                    name="nbr_tp" class="form-control" step="1" min="0" value="0"></div>
                            <div class="col-md-4 mb-3"><label class="form-label">TP digitalisés</label><input
                                    type="number" name="nbr_tp_dig" class="form-control" step="1" min="0" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-success">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal edit (shared) -->
    <div class="modal fade" id="modalProgramEdit" tabindex="-1" aria-labelledby="modalProgramEditLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalProgramEditLabel">Modifier le programme</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="<?php echo url('programs/update'); ?>" id="programEditForm">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="program_edit_id" value="" />
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Classe</label>
                                <select name="classe_id" class="form-control" id="program_edit_classe_id">
                                    <?php foreach (\App\Core\Database::query('SELECT id, name FROM classes')->fetchAll(\PDO::FETCH_ASSOC) as $c): ?>
                                        <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Matière</label>
                                <select name="subject_id" class="form-control" id="program_edit_subject_id">
                                    <?php foreach (\App\Core\Database::query('SELECT id, name FROM subjects')->fetchAll(\PDO::FETCH_ASSOC) as $s): ?>
                                        <option value="<?php echo $s['id']; ?>"><?php echo htmlspecialchars($s['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3"><label class="form-label">Heures prévues</label><input
                                    type="number" name="nbr_hours" class="form-control" step="1" min="0"
                                    id="program_edit_nbr_hours">
                            </div>
                            <div class="col-md-4 mb-3"><label class="form-label">Leçons</label><input type="number"
                                    name="nbr_lesson" class="form-control" step="1" min="0"
                                    id="program_edit_nbr_lesson">
                            </div>
                            <div class="col-md-4 mb-3"><label class="form-label">Leçons digitalisées</label><input
                                    type="number" name="nbr_lesson_dig" class="form-control" step="1" min="0"
                                    id="program_edit_nbr_lesson_dig"></div>
                            <div class="col-md-4 mb-3"><label class="form-label">TP prévues</label><input type="number"
                                    name="nbr_tp" class="form-control" step="1" min="0" id="program_edit_nbr_tp"></div>
                            <div class="col-md-4 mb-3"><label class="form-label">TP digitalisés</label><input
                                    type="number" name="nbr_tp_dig" class="form-control" step="1" min="0"
                                    id="program_edit_nbr_tp_dig">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.btn-program-edit').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                document.getElementById('program_edit_id').value = id;
                document.getElementById('program_edit_classe_id').value = this.dataset.classeId;
                document.getElementById('program_edit_subject_id').value = this.dataset.subjectId;
                document.getElementById('program_edit_nbr_hours').value = this.dataset.nbrHours;
                document.getElementById('program_edit_nbr_lesson').value = this.dataset.nbrLesson;
                document.getElementById('program_edit_nbr_lesson_dig').value = this.dataset.nbrLessonDig;
                document.getElementById('program_edit_nbr_tp').value = this.dataset.nbrTp;
                document.getElementById('program_edit_nbr_tp_dig').value = this.dataset.nbrTpDig;
            });
        });
    });
</script>
<script>
    // provide a refresh function to reload the programs select
    function reloadPrograms(selectId, callback) {
        fetch('<?php echo url('programs/list'); ?>').then(r => r.json()).then(data => {
            const sel = document.getElementById(selectId);
            if (!sel) return;
            const cur = sel.value;
            sel.innerHTML = '';
            data.forEach(function(p) {
                const o = document.createElement('option');
                o.value = p.id;
                o.text = (p.class_name || 'Classe') + ' - ' + (p.subject_name || 'Matière');
                sel.appendChild(o);
            });
            if (cur) sel.value = cur;
            sel.dispatchEvent(new Event('change'));
            if (typeof callback === 'function') callback(data);
        }).catch(err => console.error(err));
    }
</script>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>