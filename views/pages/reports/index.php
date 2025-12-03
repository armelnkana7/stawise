<?php $title = 'Rapports - Couverture hebdomadaire';
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
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalImportReportsLabel">Générer un rapport</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="<?php echo url('reports/generate'); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>

                        <div class="modal-body">



                            <!-- Période -->
                            <div class="mb-3">
                                <label class="form-label">Période</label>
                                <input type="date" id="kt_datepicker_7" name="period" class="form-control" required>
                            </div>

                            <!-- Départements -->
                            <div class="mb-3">
                                <label class="form-label">Département</label>
                                <select name="department_id" class="form-select">
                                    <option value="">Sélectionner un département</option>
                                    <?php foreach ($departments as $d): ?>
                                        <option value="<?php echo $d['id']; ?>">
                                            <?php echo htmlspecialchars($d['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Type de rapport -->
                            <div class="mb-3">
                                <label class="form-label">Type de rapport</label>
                                <select name="report_type" class="form-select" required>
                                    <option value="">Choisir...</option>
                                    <option value="pdf">PDF</option>
                                    <option value="excel">Excel</option>
                                </select>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-success">Obtenir</button>
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
                        <?php require_once __DIR__ . '/../../../app/Helpers/permissions.php'; ?>
                        <?php $roleId = $_SESSION['role_id'] ?? null;
                        $canRecord = ($roleId && role_has_permission($roleId, 'record_reports')) || ($roleId && role_has_permission($roleId, 'manage_reports'));
                        $can_view_all_reports = ($roleId && role_has_permission($roleId, 'view_all_reports')) || ($roleId && role_has_permission($roleId, 'manage_reports'));
                        ?>
                        <!-- <a class="btn btn-sm btn-outline-secondary me-2"
                            href="<?php echo url('reports/export') . (isset($_GET['q']) ? '?q=' . urlencode($_GET['q']) : ''); ?>">Exporter
                            CSV</a>
                        <button class="btn btn-sm btn-outline-secondary me-2" data-bs-toggle="modal"
                            data-bs-target="#modalImportReports">Importer</button> -->
                        <?php if ($can_view_all_reports): ?>
                            <button class="btn btn-sm btn-warning ms-3 px-4 py-3" data-bs-toggle="modal"
                                data-bs-target="#modalImportReports">Rapport spécifique</button>
                        <?php endif; ?>
                        <?php if ($canRecord): ?>
                            <button class="btn btn-sm btn-success ms-3 px-4 py-3" data-bs-toggle="modal"
                                data-bs-target="#modalReportCreate">Nouveau rapport</button>
                        <?php endif; ?>

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
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th class="w-10px pe-2">
                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                    <input class="form-check-input" type="checkbox" data-kt-check="true"
                                        data-kt-check-target="#kt_ecommerce_products_table .form-check-input"
                                        value="1" />
                                </div>
                            </th>
                            <th>ID</th>
                            <th>Classe</th>
                            <th>Mat</th>
                            <th>Hrs Ftes</th>
                            <th>Leç Ftes</th>
                            <th>Leç Dig Ftes</th>
                            <th>TP Fts</th>
                            <th>TP Dig Fts</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        <?php foreach ($reports as $r): ?>
                            <tr>
                                <td>
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="<?php echo $r['id']; ?>" />
                                    </div>
                                </td>
                                <td><?php echo $r['id']; ?></td>
                                <td><?php echo htmlspecialchars($r['class_name'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($r['subject_name'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($r['nbr_hours_do'] ?? 0); ?></td>
                                <td><?php echo htmlspecialchars($r['nbr_lesson_do'] ?? 0); ?></td>
                                <td><?php echo htmlspecialchars($r['nbr_lesson_dig_do'] ?? 0); ?></td>
                                <td><?php echo htmlspecialchars($r['nbr_tp_do'] ?? 0); ?></td>
                                <td><?php echo htmlspecialchars($r['nbr_tp_dig_do'] ?? 0); ?></td>
                                <td><?php echo htmlspecialchars($r['created_at']); ?></td>
                                <td>

                                    <a href="#" class="btn btn-light btn-active-light-primary btn-sm"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        Actions <i class="ki-duotone ki-down fs-5 ms-1"></i>
                                    </a>

                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded w-125px py-4"
                                        data-kt-menu="true">
                                        <div class="menu-item px-3">
                                            <a type="button" class="menu-link px-3" data-bs-toggle="modal"
                                                data-bs-target="#modalReportEdit<?= $r['id'] ?>">
                                                Éditer
                                            </a>
                                        </div>

                                        <div class="menu-item px-3">
                                            <button type="button" class="menu-link text-danger px-3 btn-open-delete-modal" data-action="<?php echo url('reports/delete'); ?>" data-id="<?php echo $r['id']; ?>" data-name="Rapport #<?php echo $r['id']; ?>">Supprimer</button>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="modalReportEdit<?= $r['id'] ?>" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-md">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title">Editer rapport hebdomadaire</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>

                                                <form method="POST" action="<?= url('reports/update'); ?>"
                                                    id="reportEditForm<?= $r['id'] ?>">
                                                    <?= csrf_field(); ?>
                                                    <input type="hidden" name="id" value="<?= $r['id']; ?>" />

                                                    <div class="modal-body">

                                                        <div class="row">
                                                            <div class="col-md-12 mb-3">
                                                                <label class="form-label">Programme</label>
                                                                <select name="" class="form-control" required
                                                                    disabled>
                                                                    <option value="">-- Sélectionner --</option>
                                                                    <?php foreach ($programs as $prog): ?>
                                                                        <option value="<?= $prog['id']; ?>" <?php if ($prog['id'] == $r['program_id'])
                                                                                                                echo 'selected'; ?>>
                                                                            <?= htmlspecialchars($prog['class_name'] . ' - ' . $prog['subject_name']); ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                    <?php $programId = $r['program_id']; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="program_id" value="<?= $programId; ?>" />
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Heures faites</label>
                                                                <input name="nbr_hours_do" type="number" min="0"
                                                                    class="form-control" required
                                                                    value="<?= htmlspecialchars($r['nbr_hours_do']); ?>" />
                                                            </div>

                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Leçons faites</label>
                                                                <input name="nbr_lesson_do" type="number" min="0"
                                                                    class="form-control" required
                                                                    value="<?= htmlspecialchars($r['nbr_lesson_do']); ?>" />
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Leçons digitalisées
                                                                    faites</label>
                                                                <input name="nbr_lesson_dig_do" type="number" min="0"
                                                                    class="form-control" required
                                                                    value="<?= htmlspecialchars($r['nbr_lesson_dig_do']); ?>" />
                                                            </div>

                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">TP faits</label>
                                                                <input name="nbr_tp_do" type="number" min="0"
                                                                    class="form-control" required
                                                                    value="<?= htmlspecialchars($r['nbr_tp_do']); ?>" />
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">TP digitalisés
                                                                    faits</label>
                                                                <input name="nbr_tp_dig_do" type="number" min="0"
                                                                    class="form-control" required
                                                                    value="<?= htmlspecialchars($r['nbr_tp_dig_do']); ?>" />
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Fermer</button>
                                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                    </div>

                                                </form>

                                            </div>
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
</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>