<?php $title = 'Tableau de bord - StatWise';
$layout = 'main';
require __DIR__ . '/../layouts/header.php'; ?>

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
                <h1>Bienvenue, <?php echo htmlspecialchars($user_name ?? 'Utilisateur'); ?></h1>
            </div>
        </div>
        <!--end::Toolbar wrapper-->
    </div>
    <!--end::Toolbar container-->
</div>

<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-fluid">

        <div class="row">
            <div class="col-md-4">
                <div class="card p-3">
                    <h4>Utilisateurs</h4>
                    <p class="fs-2 fw-bold"><?php echo number_format($users_count); ?></p>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card p-3">
                    <h4>Actions</h4>
                    <p>Ce tableau de bord est un exemple. Ajoutez des widgets et des graphiques avec le template.</p>
                </div>
            </div>
        </div>
    </div>

    <?php require __DIR__ . '/../layouts/footer.php'; ?>