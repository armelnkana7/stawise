<?php $title = 'Gestion des matières';
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
        <!-- Subject edit modal -->
        <div class="modal fade" id="modalSubjectEdit" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modifier matière</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="<?php echo url('subjects/update'); ?>">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="id" id="edit_subject_id" value="" />
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nom</label>
                                <input type="text" class="form-control" name="name" id="edit_subject_name" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Code</label>
                                <input type="text" class="form-control" name="code" id="edit_subject_code" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" id="edit_subject_description"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Établissement</label>
                                <select name="establishment_id" id="edit_subject_est" class="form-control select2">
                                    <?php foreach ($ests as $e): ?>
                                        <option value="<?= $e['id'] ?>"><?= htmlspecialchars($e['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Département</label>
                                <select name="department_id" id="edit_subject_dept" class="form-control select2">
                                    <option value="">-- Aucun --</option>
                                    <?php foreach ($depts as $d): ?>
                                        <option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
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
                        <button type="button" class="btn btn-sm btn-primary ms-3 px-4 py-3" data-bs-toggle="modal"
                            data-bs-target="#modalId">
                            Nouvelle matière
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="modalId" tabindex="-1" role="dialog" aria-labelledby="modalTitleId"
                            aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalTitleId">
                                            Nouvelle matière
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form method="POST" action="<?php echo url('subjects'); ?>">
                                        <div class="modal-body">
                                            <?php echo csrf_field(); ?>
                                            <div class="mb-3">
                                                <label class="form-label">Nom</label>
                                                <input type="text" class="form-control" name="name" />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Code</label>
                                                <input type="text" class="form-control" name="code" />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea name="description" class="form-control"></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Établissement</label>
                                                <select name="establishment_id" class="form-control select2">
                                                    <?php foreach ($ests as $e): ?>
                                                        <option value="<?php echo $e['id']; ?>" <?php echo (isset($_SESSION['establishment_id']) && $_SESSION['establishment_id'] == $e['id']) ? 'selected' : ''; ?>>
                                                            <?php echo htmlspecialchars($e['name']); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Département</label>
                                                <select class="form-select" name="department_id">
                                                    <option value=""> Aucun département </option>
                                                    <!-- <option value="">-- Aucun --</option> -->
                                                    <?php foreach ($depts as $d): ?>
                                                        <option value="<?php echo $d['id']; ?>">
                                                            <?php echo htmlspecialchars($d['name']); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Close
                                            </button>
                                            <button type="submit" class="btn btn-primary">Save</button>
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
                            <th>Nom</th>
                            <th>Code</th>
                            <th>Département</th>
                            <th>Établissement</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($subjects as $s): ?>
                            <tr>
                                <td><?= $s['id'] ?></td>
                                <td><?= htmlspecialchars($s['name']) ?></td>
                                <td><?= htmlspecialchars($s['code'] ?? '--') ?></td>
                                <td><?= htmlspecialchars($s['department_name'] ?? '') ?></td>
                                <td><?= htmlspecialchars($s['establishment_name'] ?? '') ?></td>
                                <td>
                                    <a href="#" class="btn btn-light btn-active-light-primary btn-sm"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        Actions <i class="ki-duotone ki-down fs-5 ms-1"></i>
                                    </a>

                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded w-125px py-4"
                                        data-kt-menu="true">
                                        <div class="menu-item px-3">
                                            <button class="btn btn-sm btn-outline-primary btn-edit-subject" data-id="<?= $s['id'] ?>" data-name="<?= htmlspecialchars($s['name']) ?>" data-code="<?= htmlspecialchars($s['code']) ?>" data-desc="<?= htmlspecialchars($s['description'] ?? '') ?>" data-establishment-id="<?= $s['establishment_id'] ?? '' ?>" data-department-id="<?= $s['department_id'] ?? '' ?>" data-bs-toggle="modal" data-bs-target="#modalSubjectEdit">Éditer</button>
                                        </div>

                                        <div class="menu-item px-3">
                                            <button type="button" class="btn btn-sm btn-outline-danger btn-open-delete-modal" data-action="<?php echo url('subjects/delete'); ?>" data-id="<?= $s['id'] ?>" data-name="<?= htmlspecialchars($s['name']) ?>">Supprimer</button>
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