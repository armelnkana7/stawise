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
                </div>
            </div>
            <div class="card-body pt-0">
                <table id="kt_datatable_zero_configuration"
                    class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer"
                    id="kt_ecommerce_products_table">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="w-10px pe-2">
                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                    <input class="form-check-input" type="checkbox" data-kt-check="true"
                                        data-kt-check-target="#kt_table_users .form-check-input" value="1" />
                                </div>
                            </th>
                            <th class="min-w-125px">Nom</th>
                            <th class="min-w-200px">Couverture</th>
                            <th class="min-w-125px">Département</th>
                            <th class="min-w-125px">Année scolaire</th>
                            <th class="text-end min-w-100px">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                        <tr class="element-a-supprimer" data-id="">
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input id="" class="c form-check-input" type="checkbox" value="1" />
                                </div>
                            </td>
                            <td class="d-flex align-items-center">
                                <div class="symbol symbol-50px overflow-hidden me-3">
                                    <svg width="40" height="40" viewBox="0 0 62 62" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M15.5 0C13.3687 0 11.625 1.74375 11.625 3.875V58.125C11.625 60.2562 13.3687 62 15.5 62H54.25C56.3812 62 58.125 60.2562 58.125 58.125V15.5L42.625 0H15.5Z"
                                            fill="#E2E5E7" />
                                        <path
                                            d="M46.5 15.5H58.125L42.625 0V11.625C42.625 13.7563 44.3687 15.5 46.5 15.5Z"
                                            fill="#B0B7BD" />
                                        <path d="M58.125 27.125L46.5 15.5H58.125V27.125Z" fill="#CAD1D8" />
                                        <path
                                            d="M50.375 50.375C50.375 51.4406 49.5031 52.3125 48.4375 52.3125H5.8125C4.74687 52.3125 3.875 51.4406 3.875 50.375V31C3.875 29.9344 4.74687 29.0625 5.8125 29.0625H48.4375C49.5031 29.0625 50.375 29.9344 50.375 31V50.375Z"
                                            fill="#F15642" />
                                        <path
                                            d="M12.3203 36.7099C12.3203 36.1984 12.7233 35.6404 13.3724 35.6404H16.9509C18.9659 35.6404 20.7794 36.9889 20.7794 39.5735C20.7794 42.0225 18.9659 43.3865 16.9509 43.3865H14.3644V45.4325C14.3644 46.1145 13.9304 46.5001 13.3724 46.5001C12.8609 46.5001 12.3203 46.1145 12.3203 45.4325V36.7099ZM14.3644 37.5914V41.4509H16.9509C17.9894 41.4509 18.8109 40.5345 18.8109 39.5735C18.8109 38.4904 17.9894 37.5914 16.9509 37.5914H14.3644Z"
                                            fill="white" />
                                        <path
                                            d="M23.8136 46.5C23.3021 46.5 22.7441 46.221 22.7441 45.5409V36.7408C22.7441 36.1847 23.3021 35.7798 23.8136 35.7798H27.3612C34.4408 35.7798 34.2858 46.5 27.5007 46.5H23.8136ZM24.7901 37.6708V44.6109H27.3612C31.5443 44.6109 31.7303 37.6708 27.3612 37.6708H24.7901Z"
                                            fill="white" />
                                        <path
                                            d="M36.7966 37.7948V40.2573H40.7472C41.3052 40.2573 41.8632 40.8153 41.8632 41.3559C41.8632 41.8674 41.3052 42.2859 40.7472 42.2859H36.7966V45.539C36.7966 46.0815 36.4111 46.498 35.8686 46.498C35.1866 46.498 34.77 46.0815 34.77 45.539V36.7388C34.77 36.1828 35.1885 35.7778 35.8686 35.7778H41.3071C41.9891 35.7778 42.3921 36.1828 42.3921 36.7388C42.3921 37.2348 41.9891 37.7928 41.3071 37.7928H36.7966V37.7948Z"
                                            fill="white" />
                                        <path
                                            d="M48.4375 52.3125H11.625V54.25H48.4375C49.5031 54.25 50.375 53.3781 50.375 52.3125V50.375C50.375 51.4406 49.5031 52.3125 48.4375 52.3125Z"
                                            fill="#CAD1D8" />
                                    </svg>
                                </div>
                                <!--begin::User details-->
                                <div class="d-flex flex-column">
                                    <a href="#" class="text-gray-800 text-hover-primary mb-1">
                                        Fiche statistique
                                    </a>
                                </div>
                                <!--begin::User details-->
                            </td>
                            <td>
                                <div style="display: flex;">
                                    <select class="form-select form-select-solid" name="coverages" id="couverture">
                                        <option value="all">Tous les programmes</option>
                                        <?php foreach ($programs as $s): ?>
                                            <option value="<?= $s['id'] ?>">
                                                <?= htmlspecialchars($s['class_name']) . ' - ' . htmlspecialchars($s['subject_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <select class="form-select form-select-solid" name="department_id" id="departement">
                                    <option value="all">Tous les départements</option>
                                    <?php if (!empty($departments)):
                                        foreach ($departments as $d): ?>
                                            <option value="<?= htmlspecialchars($d['id']); ?>">
                                                <?= htmlspecialchars($d['name']); ?>
                                            </option>
                                        <?php endforeach; endif; ?>
                                </select>
                            </td>
                            <td>
                                <select name="id_school_year" id="id_school_year" class="form-select form-select-solid"
                                    data-control="select2">
                                    <?php if (!empty($school_years)):
                                        foreach ($school_years as $y): ?>
                                            <option value="<?= htmlspecialchars($y['id']); ?>">
                                                <?= htmlspecialchars($y['title']); ?>
                                            </option>
                                        <?php endforeach; endif; ?>
                                </select>
                            </td>
                            <td class="text-end">
                                <form action="controllers/users.pdf.controller.php" method="post">
                                    <div class="d-grid gap-2">
                                        <button name="" id="" class="btn btn-primary">Télécharger</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        <tr class="element-a-supprimer" data-id="">
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input id="" class="c form-check-input" type="checkbox" value="1" />
                                </div>
                            </td>
                            <td class="d-flex align-items-center">
                                <div class="symbol symbol-50px overflow-hidden me-3">
                                    <svg width="40" height="40" viewBox="0 0 62 62" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M15.5 0C13.3687 0 11.625 1.74375 11.625 3.875V58.125C11.625 60.2562 13.3687 62 15.5 62H54.25C56.3812 62 58.125 60.2562 58.125 58.125V15.5L42.625 0H15.5Z"
                                            fill="#E2E5E7" />
                                        <path
                                            d="M46.5 15.5H58.125L42.625 0V11.625C42.625 13.7563 44.3687 15.5 46.5 15.5Z"
                                            fill="#9BBF9A" />
                                        <path d="M58.125 27.125L46.5 15.5H58.125V27.125Z" fill="#7FAE76" />
                                        <!-- main sheet body (was red) -> Excel green -->
                                        <path
                                            d="M50.375 50.375C50.375 51.4406 49.5031 52.3125 48.4375 52.3125H5.8125C4.74687 52.3125 3.875 51.4406 3.875 50.375V31C3.875 29.9344 4.74687 29.0625 5.8125 29.0625H48.4375C49.5031 29.0625 50.375 29.9344 50.375 31V50.375Z"
                                            fill="#217346" />
                                        <!-- stylized Excel "X" using two thick strokes -->
                                        <g transform="translate(0,0)">
                                            <path d="M13.5 35.5L20.9 44.6" stroke="#ffffff" stroke-width="3.8"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M20.9 35.5L13.5 44.6" stroke="#ffffff" stroke-width="3.8"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M26.5 35.5L33.9 44.6" stroke="#ffffff" stroke-width="3.8"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M33.9 35.5L26.5 44.6" stroke="#ffffff" stroke-width="3.8"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </g>
                                        <!-- corner fold shadow at bottom of sheet -->
                                        <path
                                            d="M48.4375 52.3125H11.625V54.25H48.4375C49.5031 54.25 50.375 53.3781 50.375 52.3125V50.375C50.375 51.4406 49.5031 52.3125 48.4375 52.3125Z"
                                            fill="#CAD1D8" />
                                    </svg>
                                </div>
                                <!--begin::User details-->
                                <div class="d-flex flex-column">
                                    <a href="#" class="text-gray-800 text-hover-primary mb-1">
                                        Fiche statistique
                                    </a>
                                </div>
                                <!--begin::User details-->
                            </td>
                            <td>
                                <div style="display: flex;">
                                    <select class="form-select form-select-solid" name="coverages" id="couverture">
                                        <option value="all">Tous les programmes</option>
                                        <?php foreach ($programs as $s): ?>
                                            <option value="<?= $s['id'] ?>">
                                                <?= htmlspecialchars($s['class_name']) . ' - ' . htmlspecialchars($s['subject_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <select class="form-select form-select-solid" name="department_id" id="departement">
                                    <option value="all">Tous les départements</option>
                                    <?php if (!empty($departments)):
                                        foreach ($departments as $d): ?>
                                            <option value="<?= htmlspecialchars($d['id']); ?>">
                                                <?= htmlspecialchars($d['name']); ?>
                                            </option>
                                        <?php endforeach; endif; ?>
                                </select>
                            </td>
                            <td>
                                <select name="id_school_year" id="id_school_year" class="form-select form-select-solid"
                                    data-control="select2">
                                    <?php if (!empty($school_years)):
                                        foreach ($school_years as $y): ?>
                                            <option value="<?= htmlspecialchars($y['id']); ?>">
                                                <?= htmlspecialchars($y['title']); ?>
                                            </option>
                                        <?php endforeach; endif; ?>
                                </select>
                            </td>
                            <td class="text-end">
                                <form action="controllers/users.pdf.controller.php" method="post">
                                    <div class="d-grid gap-2">
                                        <button name="" id="" class="btn btn-primary">Télécharger</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>