<!DOCTYPE html>
<html lang="fr">
<!--begin::Head-->

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo htmlspecialchars($title ?? 'StatWise'); ?></title>
    <!-- Fonts -->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">


    <link rel="canonical" href="https://preview.keenthemes.com/saul-html-free" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <link href="<?php echo url('theme/dist/assets/plugins/custom/datatables/datatables.bundle.css'); ?>"
        rel="stylesheet" type="text/css" />
    <!-- Global styles -->
    <link href="<?php echo url('theme/dist/assets/plugins/global/plugins.bundle.css'); ?>" rel="stylesheet"
        type="text/css" />
    <link href="<?php echo url('theme/dist/assets/css/style.bundle.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo url('assets/plugins/global/plugins.bundle.css'); ?> " rel="stylesheet" type="text/css" />
    <script src="<?php echo url('assets/plugins/global/plugins.bundle.js'); ?>"></script>
</head>

</head>
<!--end::Head-->
<!--begin::Body-->
<?php if (isset($layout) && $layout === 'auth'): ?>

    <body id="kt_body" class="app-blank">
        <div class="d-flex flex-column flex-root" id="kt_app_root">
        <?php else: ?>

            <body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true"
                data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
                data-kt-app-toolbar-enabled="true" class="app-default">
                <!--begin::App-->
                <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
                    <!--begin::Page-->
                    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">

                        <div id="kt_app_header" class="app-header d-flex flex-column flex-stack">
                            <!--begin::Header main-->
                            <div class="d-flex align-items-center flex-stack flex-grow-1">
                                <div class="app-header-logo d-flex align-items-center flex-stack px-lg-11 mb-2"
                                    id="kt_app_header_logo">
                                    <!--begin::Sidebar mobile toggle-->
                                    <div class="btn btn-icon btn-active-color-primary w-35px h-35px ms-3 me-2 d-flex d-lg-none"
                                        id="kt_app_sidebar_mobile_toggle">
                                        <i class="ki-duotone ki-abstract-14 fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </div>
                                    <!--end::Sidebar mobile toggle-->
                                    <!--begin::Logo-->
                                    <a href="../dist/index.html" class="app-sidebar-logo">
                                        <img alt="Logo"
                                            src="<?php echo url('theme/dist/assets/media/logos/statwise2.png'); ?>"
                                            class="h-70px" />
                                    </a>
                                    <!--end::Logo-->
                                    <!--begin::Sidebar toggle-->
                                    <div id="kt_app_sidebar_toggle"
                                        class="app-sidebar-toggle btn btn-sm btn-icon btn-color-warning me-n2 d-none d-lg-flex"
                                        data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
                                        data-kt-toggle-name="app-sidebar-minimize">
                                        <i class="ki-duotone ki-exit-left fs-2x rotate-180">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </div>
                                    <!--end::Sidebar toggle-->
                                </div>
                                <!--begin::Navbar-->
                                <div class="app-navbar flex-grow-1 justify-content-end" id="kt_app_header_navbar">
                                    <div class="app-navbar-item d-flex align-items-stretch flex-lg-grow-1 me-2 me-lg-0">
                                        <!--begin::Search-->
                                        <div id="kt_header_search"
                                            class="header-search d-flex align-items-center w-lg-350px"
                                            data-kt-search-keypress="true" data-kt-search-min-length="2"
                                            data-kt-search-enter="enter" data-kt-search-layout="menu"
                                            data-kt-search-responsive="true" data-kt-menu-trigger="auto"
                                            data-kt-menu-permanent="true" data-kt-menu-placement="bottom-start">
                                            <!--begin::Tablet and mobile search toggle-->
                                            <div data-kt-search-element="toggle"
                                                class="search-toggle-mobile d-flex d-lg-none align-items-center">
                                                <div class="d-flex">
                                                    <i class="ki-duotone ki-magnifier fs-1 fs-1">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </div>
                                            </div>
                                            <!--end::Tablet and mobile search toggle-->
                                            <!--begin::Form(use d-none d-lg-block classes for responsive search)-->
                                            <form data-kt-search-element="form"
                                                class="d-none d-lg-block w-100 position-relative mb-5 mb-lg-0"
                                                autocomplete="off">
                                                <!--begin::Hidden input(Added to disable form autocomplete)-->
                                                <input type="hidden" />
                                                <!--end::Hidden input-->
                                                <!--begin::Icon-->
                                                <i
                                                    class="ki-duotone ki-magnifier search-icon fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-5">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <!--end::Icon-->
                                                <!--begin::Input-->
                                                <input type="text"
                                                    class="search-input form-control form-control border-0 h-lg-40px ps-13"
                                                    name="search" value="" placeholder="Search..."
                                                    data-kt-search-element="input" />
                                                <!--end::Input-->
                                                <!--begin::Spinner-->
                                                <span
                                                    class="search-spinner position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-5"
                                                    data-kt-search-element="spinner">
                                                    <span
                                                        class="spinner-border h-15px w-15px align-middle text-gray-400"></span>
                                                </span>
                                                <!--end::Spinner-->
                                                <!--begin::Reset-->
                                                <span
                                                    class="search-reset btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-4"
                                                    data-kt-search-element="clear">
                                                    <i class="ki-duotone ki-cross fs-2 fs-lg-1 me-0">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </span>
                                                <!--end::Reset-->
                                            </form>
                                            <!--end::Form-->
                                            <!--begin::Establishment switch for superadmin-->
                                            <?php if (isset($_SESSION['user_id'])):
                                                require_once __DIR__ . '/../../app/Helpers/permissions.php';
                                                $roleId = $_SESSION['role_id'] ?? null;
                                                $canSwitch = $roleId ? role_has_permission($roleId, 'switch_establishment') : false;
                                            ?>
                                                <?php if ($canSwitch): ?>
                                                    <?php $ests = App\Core\Database::query('SELECT id, name FROM establishments ORDER BY name')->fetchAll(PDO::FETCH_ASSOC); ?>
                                                    <form method="POST" action="<?= url('establishments/switch') ?>" class="d-flex align-items-center ms-3">
                                                        <?= csrf_field(); ?>
                                                        <select name="establishment_id" class="form-select form-select-sm" onchange="this.form.submit()">
                                                            <?php foreach ($ests as $e): ?>
                                                                <option value="<?= $e['id'] ?>" <?= (isset($_SESSION['establishment_id']) && $_SESSION['establishment_id'] == $e['id']) ? 'selected' : '' ?>><?= htmlspecialchars($e['name']) ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </form>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <!--end::Establishment switch -->
                                            <!--begin::Menu-->
                                            <div data-kt-search-element="content"
                                                class="menu menu-sub menu-sub-dropdown py-7 px-7 overflow-hidden w-300px w-md-350px">
                                                <!--begin::Wrapper-->
                                                <div data-kt-search-element="wrapper">
                                                    <!--begin::Recently viewed-->
                                                    <div data-kt-search-element="results" class="d-none">
                                                        <!--begin::Items-->
                                                        <div class="scroll-y mh-200px mh-lg-350px">
                                                            <!--begin::Category title-->
                                                            <h3 class="fs-5 text-muted m-0 pb-5"
                                                                data-kt-search-element="category-title">Users</h3>
                                                            <!--end::Category title-->
                                                            <!--begin::Item-->
                                                            <a href="#"
                                                                class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                                <!--begin::Symbol-->
                                                                <div class="symbol symbol-40px me-4">
                                                                    <img src="<?php echo url('theme/dist/assets/media/avatars/300-6.jpg'); ?>"
                                                                        alt="" />
                                                                </div>
                                                                <!--end::Symbol-->
                                                                <!--begin::Title-->
                                                                <div
                                                                    class="d-flex flex-column justify-content-start fw-semibold">
                                                                    <span class="fs-6 fw-semibold">Karina Clark</span>
                                                                    <span class="fs-7 fw-semibold text-muted">Marketing
                                                                        Manager</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </a>
                                                            <!--end::Item-->
                                                            <!--begin::Item-->
                                                            <a href="#"
                                                                class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                                <!--begin::Symbol-->
                                                                <div class="symbol symbol-40px me-4">
                                                                    <img src="<?php echo url('theme/dist/assets/media/avatars/300-2.jpg'); ?>"
                                                                        alt="" />
                                                                </div>
                                                                <!--end::Symbol-->
                                                                <!--begin::Title-->
                                                                <div
                                                                    class="d-flex flex-column justify-content-start fw-semibold">
                                                                    <span class="fs-6 fw-semibold">Olivia Bold</span>
                                                                    <span class="fs-7 fw-semibold text-muted">Software
                                                                        Engineer</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </a>
                                                            <!--end::Item-->
                                                            <!--begin::Item-->
                                                            <a href="#"
                                                                class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                                <!--begin::Symbol-->
                                                                <div class="symbol symbol-40px me-4">
                                                                    <img src="<?php echo url('theme/dist/assets/media/avatars/300-9.jpg'); ?>"
                                                                        alt="" />
                                                                </div>
                                                                <!--end::Symbol-->
                                                                <!--begin::Title-->
                                                                <div
                                                                    class="d-flex flex-column justify-content-start fw-semibold">
                                                                    <span class="fs-6 fw-semibold">Ana Clark</span>
                                                                    <span class="fs-7 fw-semibold text-muted">UI/UX
                                                                        Designer</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </a>
                                                            <!--end::Item-->
                                                            <!--begin::Item-->
                                                            <a href="#"
                                                                class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                                <!--begin::Symbol-->
                                                                <div class="symbol symbol-40px me-4">
                                                                    <img src="<?php echo url('theme/dist/assets/media/avatars/300-14.jpg'); ?>"
                                                                        alt="" />
                                                                </div>
                                                                <!--end::Symbol-->
                                                                <!--begin::Title-->
                                                                <div
                                                                    class="d-flex flex-column justify-content-start fw-semibold">
                                                                    <span class="fs-6 fw-semibold">Nick Pitola</span>
                                                                    <span class="fs-7 fw-semibold text-muted">Art
                                                                        Director</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </a>
                                                            <!--end::Item-->
                                                            <!--begin::Item-->
                                                            <a href="#"
                                                                class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                                <!--begin::Symbol-->
                                                                <div class="symbol symbol-40px me-4">
                                                                    <img src="<?php echo url('theme/dist/assets/media/avatars/300-11.jpg'); ?>"
                                                                        alt="" />
                                                                </div>
                                                                <!--end::Symbol-->
                                                                <!--begin::Title-->
                                                                <div
                                                                    class="d-flex flex-column justify-content-start fw-semibold">
                                                                    <span class="fs-6 fw-semibold">Edward Kulnic</span>
                                                                    <span class="fs-7 fw-semibold text-muted">System
                                                                        Administrator</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </a>
                                                            <!--end::Item-->
                                                            <!--begin::Category title-->
                                                            <h3 class="fs-5 text-muted m-0 pt-5 pb-5"
                                                                data-kt-search-element="category-title">Customers</h3>
                                                            <!--end::Category title-->
                                                            <!--begin::Item-->
                                                            <a href="#"
                                                                class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                                <!--begin::Symbol-->
                                                                <div class="symbol symbol-40px me-4">
                                                                    <span class="symbol-label bg-light">
                                                                        <img class="w-20px h-20px"
                                                                            src="<?php echo url('theme/dist/assets/media/svg/brand-logos/volicity-9.svg'); ?>"
                                                                            alt="" />
                                                                    </span>
                                                                </div>
                                                                <!--end::Symbol-->
                                                                <!--begin::Title-->
                                                                <div
                                                                    class="d-flex flex-column justify-content-start fw-semibold">
                                                                    <span class="fs-6 fw-semibold">Company Rbranding</span>
                                                                    <span class="fs-7 fw-semibold text-muted">UI
                                                                        Design</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </a>
                                                            <!--end::Item-->
                                                            <!--begin::Item-->
                                                            <a href="#"
                                                                class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                                <!--begin::Symbol-->
                                                                <div class="symbol symbol-40px me-4">
                                                                    <span class="symbol-label bg-light">
                                                                        <img class="w-20px h-20px"
                                                                            src="<?php echo url('theme/dist/assets/media/svg/brand-logos/tvit.svg'); ?>"
                                                                            alt="" />
                                                                    </span>
                                                                </div>
                                                                <!--end::Symbol-->
                                                                <!--begin::Title-->
                                                                <div
                                                                    class="d-flex flex-column justify-content-start fw-semibold">
                                                                    <span class="fs-6 fw-semibold">Company
                                                                        Re-branding</span>
                                                                    <span class="fs-7 fw-semibold text-muted">Web
                                                                        Development</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </a>
                                                            <!--end::Item-->
                                                            <!--begin::Item-->
                                                            <a href="#"
                                                                class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                                <!--begin::Symbol-->
                                                                <div class="symbol symbol-40px me-4">
                                                                    <span class="symbol-label bg-light">
                                                                        <img class="w-20px h-20px"
                                                                            src="<?php echo url('theme/dist/assets/media/svg/misc/infography.svg'); ?>"
                                                                            alt="" />
                                                                    </span>
                                                                </div>
                                                                <!--end::Symbol-->
                                                                <!--begin::Title-->
                                                                <div
                                                                    class="d-flex flex-column justify-content-start fw-semibold">
                                                                    <span class="fs-6 fw-semibold">Business Analytics
                                                                        App</span>
                                                                    <span
                                                                        class="fs-7 fw-semibold text-muted">Administration</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </a>
                                                            <!--end::Item-->
                                                            <!--begin::Item-->
                                                            <a href="#"
                                                                class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                                <!--begin::Symbol-->
                                                                <div class="symbol symbol-40px me-4">
                                                                    <span class="symbol-label bg-light">
                                                                        <img class="w-20px h-20px"
                                                                            src="<?php echo url('theme/dist/assets/media/svg/brand-logos/leaf.svg'); ?>"
                                                                            alt="" />
                                                                    </span>
                                                                </div>
                                                                <!--end::Symbol-->
                                                                <!--begin::Title-->
                                                                <div
                                                                    class="d-flex flex-column justify-content-start fw-semibold">
                                                                    <span class="fs-6 fw-semibold">EcoLeaf App Launch</span>
                                                                    <span
                                                                        class="fs-7 fw-semibold text-muted">Marketing</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </a>
                                                            <!--end::Item-->
                                                            <!--begin::Item-->
                                                            <a href="#"
                                                                class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                                <!--begin::Symbol-->
                                                                <div class="symbol symbol-40px me-4">
                                                                    <span class="symbol-label bg-light">
                                                                        <img class="w-20px h-20px"
                                                                            src="<?php echo url('theme/dist/assets/media/svg/brand-logos/tower.svg'); ?>"
                                                                            alt="" />
                                                                    </span>
                                                                </div>
                                                                <!--end::Symbol-->
                                                                <!--begin::Title-->
                                                                <div
                                                                    class="d-flex flex-column justify-content-start fw-semibold">
                                                                    <span class="fs-6 fw-semibold">Tower Group
                                                                        Website</span>
                                                                    <span class="fs-7 fw-semibold text-muted">Google
                                                                        Adwords</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </a>
                                                            <!--end::Item-->
                                                            <!--begin::Category title-->
                                                            <h3 class="fs-5 text-muted m-0 pt-5 pb-5"
                                                                data-kt-search-element="category-title">Projects</h3>
                                                            <!--end::Category title-->
                                                            <!--begin::Item-->
                                                            <a href="#"
                                                                class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                                <!--begin::Symbol-->
                                                                <div class="symbol symbol-40px me-4">
                                                                    <span class="symbol-label bg-light">
                                                                        <i class="ki-duotone ki-notepad fs-2 text-primary">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                            <span class="path3"></span>
                                                                            <span class="path4"></span>
                                                                            <span class="path5"></span>
                                                                        </i>
                                                                    </span>
                                                                </div>
                                                                <!--end::Symbol-->
                                                                <!--begin::Title-->
                                                                <div class="d-flex flex-column">
                                                                    <span class="fs-6 fw-semibold">Si-Fi Project by AU
                                                                        Themes</span>
                                                                    <span class="fs-7 fw-semibold text-muted">#45670</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </a>
                                                            <!--end::Item-->
                                                            <!--begin::Item-->
                                                            <a href="#"
                                                                class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                                <!--begin::Symbol-->
                                                                <div class="symbol symbol-40px me-4">
                                                                    <span class="symbol-label bg-light">
                                                                        <i class="ki-duotone ki-frame fs-2 text-primary">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                            <span class="path3"></span>
                                                                            <span class="path4"></span>
                                                                        </i>
                                                                    </span>
                                                                </div>
                                                                <!--end::Symbol-->
                                                                <!--begin::Title-->
                                                                <div class="d-flex flex-column">
                                                                    <span class="fs-6 fw-semibold">Shopix Mobile App
                                                                        Planning</span>
                                                                    <span class="fs-7 fw-semibold text-muted">#45690</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </a>
                                                            <!--end::Item-->
                                                            <!--begin::Item-->
                                                            <a href="#"
                                                                class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                                <!--begin::Symbol-->
                                                                <div class="symbol symbol-40px me-4">
                                                                    <span class="symbol-label bg-light">
                                                                        <i
                                                                            class="ki-duotone ki-message-text-2 fs-2 text-primary">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                            <span class="path3"></span>
                                                                        </i>
                                                                    </span>
                                                                </div>
                                                                <!--end::Symbol-->
                                                                <!--begin::Title-->
                                                                <div class="d-flex flex-column">
                                                                    <span class="fs-6 fw-semibold">Finance Monitoring SAAS
                                                                        Discussion</span>
                                                                    <span class="fs-7 fw-semibold text-muted">#21090</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </a>
                                                            <!--end::Item-->
                                                            <!--begin::Item-->
                                                            <a href="#"
                                                                class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                                <!--begin::Symbol-->
                                                                <div class="symbol symbol-40px me-4">
                                                                    <span class="symbol-label bg-light">
                                                                        <i
                                                                            class="ki-duotone ki-profile-circle fs-2 text-primary">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                            <span class="path3"></span>
                                                                        </i>
                                                                    </span>
                                                                </div>
                                                                <!--end::Symbol-->
                                                                <!--begin::Title-->
                                                                <div class="d-flex flex-column">
                                                                    <span class="fs-6 fw-semibold">Dashboard Analitics
                                                                        Launch</span>
                                                                    <span class="fs-7 fw-semibold text-muted">#34560</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </a>
                                                            <!--end::Item-->
                                                        </div>
                                                        <!--end::Items-->
                                                    </div>
                                                    <!--end::Recently viewed-->
                                                    <!--begin::Recently viewed-->
                                                    <div class="" data-kt-search-element="main">
                                                        <!--begin::Heading-->
                                                        <div class="d-flex flex-stack fw-semibold mb-4">
                                                            <!--begin::Label-->
                                                            <span class="text-muted fs-6 me-2">Recently Searched:</span>
                                                            <!--end::Label-->
                                                            <!--begin::Toolbar-->
                                                            <div class="d-flex" data-kt-search-element="toolbar">
                                                                <!--begin::Preferences toggle-->
                                                                <div data-kt-search-element="preferences-show"
                                                                    class="btn btn-icon w-20px btn-sm btn-active-color-primary me-2 data-bs-toggle="
                                                                    title="Show search preferences">
                                                                    <i class="ki-duotone ki-setting-2 fs-2">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                    </i>
                                                                </div>
                                                                <!--end::Preferences toggle-->
                                                                <!--begin::Advanced search toggle-->
                                                                <div data-kt-search-element="advanced-options-form-show"
                                                                    class="btn btn-icon w-20px btn-sm btn-active-color-primary me-n1"
                                                                    data-bs-toggle="tooltip"
                                                                    title="Show more search options">
                                                                    <i class="ki-duotone ki-down fs-2"></i>
                                                                </div>
                                                                <!--end::Advanced search toggle-->
                                                            </div>
                                                            <!--end::Toolbar-->
                                                        </div>
                                                        <!--end::Heading-->
                                                        <!--begin::Items-->
                                                        <div class="scroll-y mh-200px mh-lg-325px">
                                                            <!--begin::Item-->
                                                            <div class="d-flex align-items-center mb-5">
                                                                <!--begin::Symbol-->
                                                                <div class="symbol symbol-40px me-4">
                                                                    <span class="symbol-label bg-light">
                                                                        <i class="ki-duotone ki-laptop fs-2 text-primary">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                        </i>
                                                                    </span>
                                                                </div>
                                                                <!--end::Symbol-->
                                                                <!--begin::Title-->
                                                                <div class="d-flex flex-column">
                                                                    <a href="#"
                                                                        class="fs-6 text-gray-800 text-hover-primary fw-semibold">BoomApp
                                                                        by Keenthemes</a>
                                                                    <span class="fs-7 text-muted fw-semibold">#45789</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Item-->
                                                            <!--begin::Item-->
                                                            <div class="d-flex align-items-center mb-5">
                                                                <!--begin::Symbol-->
                                                                <div class="symbol symbol-40px me-4">
                                                                    <span class="symbol-label bg-light">
                                                                        <i
                                                                            class="ki-duotone ki-chart-simple fs-2 text-primary">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                            <span class="path3"></span>
                                                                            <span class="path4"></span>
                                                                        </i>
                                                                    </span>
                                                                </div>
                                                                <!--end::Symbol-->
                                                                <!--begin::Title-->
                                                                <div class="d-flex flex-column">
                                                                    <a href="#"
                                                                        class="fs-6 text-gray-800 text-hover-primary fw-semibold">"Kept
                                                                        API Project Meeting</a>
                                                                    <span class="fs-7 text-muted fw-semibold">#84050</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Item-->
                                                            <!--begin::Item-->
                                                            <div class="d-flex align-items-center mb-5">
                                                                <!--begin::Symbol-->
                                                                <div class="symbol symbol-40px me-4">
                                                                    <span class="symbol-label bg-light">
                                                                        <i class="ki-duotone ki-chart fs-2 text-primary">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                        </i>
                                                                    </span>
                                                                </div>
                                                                <!--end::Symbol-->
                                                                <!--begin::Title-->
                                                                <div class="d-flex flex-column">
                                                                    <a href="#"
                                                                        class="fs-6 text-gray-800 text-hover-primary fw-semibold">"KPI
                                                                        Monitoring App Launch</a>
                                                                    <span class="fs-7 text-muted fw-semibold">#84250</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Item-->
                                                            <!--begin::Item-->
                                                            <div class="d-flex align-items-center mb-5">
                                                                <!--begin::Symbol-->
                                                                <div class="symbol symbol-40px me-4">
                                                                    <span class="symbol-label bg-light">
                                                                        <i
                                                                            class="ki-duotone ki-chart-line-down fs-2 text-primary">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                        </i>
                                                                    </span>
                                                                </div>
                                                                <!--end::Symbol-->
                                                                <!--begin::Title-->
                                                                <div class="d-flex flex-column">
                                                                    <a href="#"
                                                                        class="fs-6 text-gray-800 text-hover-primary fw-semibold">Project
                                                                        Reference FAQ</a>
                                                                    <span class="fs-7 text-muted fw-semibold">#67945</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Item-->
                                                            <!--begin::Item-->
                                                            <div class="d-flex align-items-center mb-5">
                                                                <!--begin::Symbol-->
                                                                <div class="symbol symbol-40px me-4">
                                                                    <span class="symbol-label bg-light">
                                                                        <i class="ki-duotone ki-sms fs-2 text-primary">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                        </i>
                                                                    </span>
                                                                </div>
                                                                <!--end::Symbol-->
                                                                <!--begin::Title-->
                                                                <div class="d-flex flex-column">
                                                                    <a href="#"
                                                                        class="fs-6 text-gray-800 text-hover-primary fw-semibold">"FitPro
                                                                        App Development</a>
                                                                    <span class="fs-7 text-muted fw-semibold">#84250</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Item-->
                                                            <!--begin::Item-->
                                                            <div class="d-flex align-items-center mb-5">
                                                                <!--begin::Symbol-->
                                                                <div class="symbol symbol-40px me-4">
                                                                    <span class="symbol-label bg-light">
                                                                        <i class="ki-duotone ki-bank fs-2 text-primary">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                        </i>
                                                                    </span>
                                                                </div>
                                                                <!--end::Symbol-->
                                                                <!--begin::Title-->
                                                                <div class="d-flex flex-column">
                                                                    <a href="#"
                                                                        class="fs-6 text-gray-800 text-hover-primary fw-semibold">Shopix
                                                                        Mobile App</a>
                                                                    <span class="fs-7 text-muted fw-semibold">#45690</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Item-->
                                                            <!--begin::Item-->
                                                            <div class="d-flex align-items-center mb-5">
                                                                <!--begin::Symbol-->
                                                                <div class="symbol symbol-40px me-4">
                                                                    <span class="symbol-label bg-light">
                                                                        <i
                                                                            class="ki-duotone ki-chart-line-down fs-2 text-primary">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                        </i>
                                                                    </span>
                                                                </div>
                                                                <!--end::Symbol-->
                                                                <!--begin::Title-->
                                                                <div class="d-flex flex-column">
                                                                    <a href="#"
                                                                        class="fs-6 text-gray-800 text-hover-primary fw-semibold">"Landing
                                                                        UI Design" Launch</a>
                                                                    <span class="fs-7 text-muted fw-semibold">#24005</span>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Item-->
                                                        </div>
                                                        <!--end::Items-->
                                                    </div>
                                                    <!--end::Recently viewed-->
                                                    <!--begin::Empty-->
                                                    <div data-kt-search-element="empty" class="text-center d-none">
                                                        <!--begin::Icon-->
                                                        <div class="pt-10 pb-10">
                                                            <i class="ki-duotone ki-search-list fs-4x opacity-50">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                            </i>
                                                        </div>
                                                        <!--end::Icon-->
                                                        <!--begin::Message-->
                                                        <div class="pb-15 fw-semibold">
                                                            <h3 class="text-gray-600 fs-5 mb-2">No result found</h3>
                                                            <div class="text-muted fs-7">Please try again with a different
                                                                query</div>
                                                        </div>
                                                        <!--end::Message-->
                                                    </div>
                                                    <!--end::Empty-->
                                                </div>
                                                <!--end::Wrapper-->
                                                <!--begin::Preferences-->
                                                <form data-kt-search-element="advanced-options-form" class="pt-1 d-none">
                                                    <!--begin::Heading-->
                                                    <h3 class="fw-semibold text-dark mb-7">Advanced Search</h3>
                                                    <!--end::Heading-->
                                                    <!--begin::Input group-->
                                                    <div class="mb-5">
                                                        <input type="text"
                                                            class="form-control form-control-sm form-control-solid"
                                                            placeholder="Contains the word" name="query" />
                                                    </div>
                                                    <!--end::Input group-->
                                                    <!--begin::Input group-->
                                                    <div class="mb-5">
                                                        <!--begin::Radio group-->
                                                        <div class="nav-group nav-group-fluid">
                                                            <!--begin::Option-->
                                                            <label>
                                                                <input type="radio" class="btn-check" name="type"
                                                                    value="has" checked="checked" />
                                                                <span
                                                                    class="btn btn-sm btn-color-muted btn-active btn-active-primary">All</span>
                                                            </label>
                                                            <!--end::Option-->
                                                            <!--begin::Option-->
                                                            <label>
                                                                <input type="radio" class="btn-check" name="type"
                                                                    value="users" />
                                                                <span
                                                                    class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">Users</span>
                                                            </label>
                                                            <!--end::Option-->
                                                            <!--begin::Option-->
                                                            <label>
                                                                <input type="radio" class="btn-check" name="type"
                                                                    value="orders" />
                                                                <span
                                                                    class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">Orders</span>
                                                            </label>
                                                            <!--end::Option-->
                                                            <!--begin::Option-->
                                                            <label>
                                                                <input type="radio" class="btn-check" name="type"
                                                                    value="projects" />
                                                                <span
                                                                    class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">Projects</span>
                                                            </label>
                                                            <!--end::Option-->
                                                        </div>
                                                        <!--end::Radio group-->
                                                    </div>
                                                    <!--end::Input group-->
                                                    <!--begin::Input group-->
                                                    <div class="mb-5">
                                                        <input type="text" name="assignedto"
                                                            class="form-control form-control-sm form-control-solid"
                                                            placeholder="Assigned to" value="" />
                                                    </div>
                                                    <!--end::Input group-->
                                                    <!--begin::Input group-->
                                                    <div class="mb-5">
                                                        <input type="text" name="collaborators"
                                                            class="form-control form-control-sm form-control-solid"
                                                            placeholder="Collaborators" value="" />
                                                    </div>
                                                    <!--end::Input group-->
                                                    <!--begin::Input group-->
                                                    <div class="mb-5">
                                                        <!--begin::Radio group-->
                                                        <div class="nav-group nav-group-fluid">
                                                            <!--begin::Option-->
                                                            <label>
                                                                <input type="radio" class="btn-check" name="attachment"
                                                                    value="has" checked="checked" />
                                                                <span
                                                                    class="btn btn-sm btn-color-muted btn-active btn-active-primary">Has
                                                                    attachment</span>
                                                            </label>
                                                            <!--end::Option-->
                                                            <!--begin::Option-->
                                                            <label>
                                                                <input type="radio" class="btn-check" name="attachment"
                                                                    value="any" />
                                                                <span
                                                                    class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">Any</span>
                                                            </label>
                                                            <!--end::Option-->
                                                        </div>
                                                        <!--end::Radio group-->
                                                    </div>
                                                    <!--end::Input group-->
                                                    <!--begin::Input group-->
                                                    <div class="mb-5">
                                                        <select name="timezone" aria-label="Select a Timezone"
                                                            data-control="select2" data-dropdown-parent="#kt_header_search"
                                                            data-placeholder="date_period"
                                                            class="form-select form-select-sm form-select-solid">
                                                            <option value="next">Within the next</option>
                                                            <option value="last">Within the last</option>
                                                            <option value="between">Between</option>
                                                            <option value="on">On</option>
                                                        </select>
                                                    </div>
                                                    <!--end::Input group-->
                                                    <!--begin::Input group-->
                                                    <div class="row mb-8">
                                                        <!--begin::Col-->
                                                        <div class="col-6">
                                                            <input type="number" name="date_number"
                                                                class="form-control form-control-sm form-control-solid"
                                                                placeholder="Lenght" value="" />
                                                        </div>
                                                        <!--end::Col-->
                                                        <!--begin::Col-->
                                                        <div class="col-6">
                                                            <select name="date_typer" aria-label="Select a Timezone"
                                                                data-control="select2"
                                                                data-dropdown-parent="#kt_header_search"
                                                                data-placeholder="Period"
                                                                class="form-select form-select-sm form-select-solid">
                                                                <option value="days">Days</option>
                                                                <option value="weeks">Weeks</option>
                                                                <option value="months">Months</option>
                                                                <option value="years">Years</option>
                                                            </select>
                                                        </div>
                                                        <!--end::Col-->
                                                    </div>
                                                    <!--end::Input group-->
                                                    <!--begin::Actions-->
                                                    <div class="d-flex justify-content-end">
                                                        <button type="reset"
                                                            class="btn btn-sm btn-light fw-bold btn-active-light-primary me-2"
                                                            data-kt-search-element="advanced-options-form-cancel">Cancel</button>
                                                        <a href="../dist/pages/search/horizontal.html"
                                                            class="btn btn-sm fw-bold btn-primary"
                                                            data-kt-search-element="advanced-options-form-search">Search</a>
                                                    </div>
                                                    <!--end::Actions-->
                                                </form>
                                                <!--end::Preferences-->
                                                <!--begin::Preferences-->
                                                <form data-kt-search-element="preferences" class="pt-1 d-none">
                                                    <!--begin::Heading-->
                                                    <h3 class="fw-semibold text-dark mb-7">Search Preferences</h3>
                                                    <!--end::Heading-->
                                                    <!--begin::Input group-->
                                                    <div class="pb-4 border-bottom">
                                                        <label
                                                            class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
                                                            <span
                                                                class="form-check-label text-gray-700 fs-6 fw-semibold ms-0 me-2">Projects</span>
                                                            <input class="form-check-input" type="checkbox" value="1"
                                                                checked="checked" />
                                                        </label>
                                                    </div>
                                                    <!--end::Input group-->
                                                    <!--begin::Input group-->
                                                    <div class="py-4 border-bottom">
                                                        <label
                                                            class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
                                                            <span
                                                                class="form-check-label text-gray-700 fs-6 fw-semibold ms-0 me-2">Targets</span>
                                                            <input class="form-check-input" type="checkbox" value="1"
                                                                checked="checked" />
                                                        </label>
                                                    </div>
                                                    <!--end::Input group-->
                                                    <!--begin::Input group-->
                                                    <div class="py-4 border-bottom">
                                                        <label
                                                            class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
                                                            <span
                                                                class="form-check-label text-gray-700 fs-6 fw-semibold ms-0 me-2">Affiliate
                                                                Programs</span>
                                                            <input class="form-check-input" type="checkbox" value="1" />
                                                        </label>
                                                    </div>
                                                    <!--end::Input group-->
                                                    <!--begin::Input group-->
                                                    <div class="py-4 border-bottom">
                                                        <label
                                                            class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
                                                            <span
                                                                class="form-check-label text-gray-700 fs-6 fw-semibold ms-0 me-2">Referrals</span>
                                                            <input class="form-check-input" type="checkbox" value="1"
                                                                checked="checked" />
                                                        </label>
                                                    </div>
                                                    <!--end::Input group-->
                                                    <!--begin::Input group-->
                                                    <div class="py-4 border-bottom">
                                                        <label
                                                            class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
                                                            <span
                                                                class="form-check-label text-gray-700 fs-6 fw-semibold ms-0 me-2">Users</span>
                                                            <input class="form-check-input" type="checkbox" value="1" />
                                                        </label>
                                                    </div>
                                                    <!--end::Input group-->
                                                    <!--begin::Actions-->
                                                    <div class="d-flex justify-content-end pt-7">
                                                        <button type="reset"
                                                            class="btn btn-sm btn-light fw-bold btn-active-light-primary me-2"
                                                            data-kt-search-element="preferences-dismiss">Cancel</button>
                                                        <button type="submit" class="btn btn-sm fw-bold btn-primary">Save
                                                            Changes</button>
                                                    </div>
                                                    <!--end::Actions-->
                                                </form>
                                                <!--end::Preferences-->
                                            </div>
                                            <!--end::Menu-->
                                        </div>
                                        <!--end::Search-->
                                    </div>
                                    <!--begin::Notifications-->
                                    <div class="app-navbar-item me-lg-1">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div>
                                                <a class="btn btn-outline-secondary me-2"
                                                    href="<?php echo url(''); ?>">Accueil</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Notifications-->
                                    <!--begin::Quick links-->
                                    <div class="app-navbar-item">
                                        <!--begin::Menu- wrapper-->
                                        <div class="btn btn-icon btn-custom btn-color-gray-600 btn-active-color-primary w-35px h-35px w-md-40px h-md-40px"
                                            data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                            data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                            <i class="ki-duotone ki-notification-status fs-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                            </i>
                                        </div>
                                        <!--begin::Menu-->
                                        <div class="menu menu-sub menu-sub-dropdown menu-column w-250px w-lg-325px"
                                            data-kt-menu="true">
                                            <!--begin::Heading-->
                                            <div class="d-flex flex-column flex-center bgi-no-repeat rounded-top px-9 py-10"
                                                style="background-image:url('assets/media/misc/menu-header-bg.jpg')">
                                                <!--begin::Title-->
                                                <h3 class="text-white fw-semibold mb-3">Quick Links</h3>
                                                <!--end::Title-->
                                                <!--begin::Status-->
                                                <span class="badge bg-primary text-inverse-primary py-2 px-3">25 pending
                                                    tasks</span>
                                                <!--end::Status-->
                                            </div>
                                            <!--end::Heading-->
                                            <!--begin:Nav-->
                                            <div class="row g-0">
                                                <!--begin:Item-->
                                                <div class="col-6">
                                                    <a href="#"
                                                        class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-end border-bottom">
                                                        <i class="ki-duotone ki-dollar fs-3x text-primary mb-2">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                        </i>
                                                        <span class="fs-5 fw-semibold text-gray-800 mb-0">Accounting</span>
                                                        <span class="fs-7 text-gray-400">eCommerce</span>
                                                    </a>
                                                </div>
                                                <!--end:Item-->
                                                <!--begin:Item-->
                                                <div class="col-6">
                                                    <a href="#"
                                                        class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-bottom">
                                                        <i class="ki-duotone ki-sms fs-3x text-primary mb-2">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                        <span
                                                            class="fs-5 fw-semibold text-gray-800 mb-0">Administration</span>
                                                        <span class="fs-7 text-gray-400">Console</span>
                                                    </a>
                                                </div>
                                                <!--end:Item-->
                                                <!--begin:Item-->
                                                <div class="col-6">
                                                    <a href="../dist/apps/projects/list.html"
                                                        class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-end">
                                                        <i class="ki-duotone ki-abstract-41 fs-3x text-primary mb-2">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                        <span class="fs-5 fw-semibold text-gray-800 mb-0">Projects</span>
                                                        <span class="fs-7 text-gray-400">Pending Tasks</span>
                                                    </a>
                                                </div>
                                                <!--end:Item-->
                                                <!--begin:Item-->
                                                <div class="col-6">
                                                    <a href="#"
                                                        class="d-flex flex-column flex-center h-100 p-6 bg-hover-light">
                                                        <i class="ki-duotone ki-briefcase fs-3x text-primary mb-2">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                        <span class="fs-5 fw-semibold text-gray-800 mb-0">Customers</span>
                                                        <span class="fs-7 text-gray-400">Latest cases</span>
                                                    </a>
                                                </div>
                                                <!--end:Item-->
                                            </div>
                                            <!--end:Nav-->
                                            <!--begin::View more-->
                                            <div class="py-2 text-center border-top">
                                                <a href="#" class="btn btn-color-gray-600 btn-active-color-primary">View All
                                                    <i class="ki-duotone ki-arrow-right fs-5">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i></a>
                                            </div>
                                            <!--end::View more-->
                                        </div>
                                        <!--end::Menu-->
                                        <!--end::Menu wrapper-->
                                    </div>
                                    <!--end::Quick links-->
                                    <!--begin::User menu-->
                                    <div class="app-navbar-item ms-3 ms-lg-4 me-lg-2" id="kt_header_user_menu_toggle">
                                        <!--begin::Menu wrapper-->
                                        <div class="cursor-pointer symbol symbol-30px symbol-lg-40px"
                                            data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                            data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                            <img src="<?php echo url('theme/dist/assets/media/avatars/300-2.jpg'); ?>"
                                                alt="user" />
                                        </div>
                                        <!--begin::User account menu-->
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                                            data-kt-menu="true">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="menu-content d-flex align-items-center px-3">
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-50px me-5">
                                                        <img alt="Logo"
                                                            src="<?php echo url('theme/dist/assets/media/avatars/300-2.jpg'); ?>" />
                                                    </div>
                                                    <!--end::Avatar-->
                                                    <!--begin::Username-->
                                                    <div class="d-flex flex-column">
                                                        <div class="fw-bold d-flex align-items-center fs-5">Jane Cooper
                                                            <span
                                                                class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Pro</span>
                                                        </div>
                                                        <a href="#"
                                                            class="fw-semibold text-muted text-hover-primary fs-7">jane@kt.com</a>
                                                    </div>
                                                    <!--end::Username-->
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu separator-->
                                            <div class="separator my-2"></div>
                                            <!--end::Menu separator-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-5">
                                                <a href="../dist/account/overview.html" class="menu-link px-5">My
                                                    Profile</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-5">
                                                <a href="../dist/apps/projects/list.html" class="menu-link px-5">
                                                    <span class="menu-text">My Projects</span>
                                                    <span class="menu-badge">
                                                        <span
                                                            class="badge badge-light-danger badge-circle fw-bold fs-7">3</span>
                                                    </span>
                                                </a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-5"
                                                data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                                data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                                                <a href="#" class="menu-link px-5">
                                                    <span class="menu-title">My Subscription</span>
                                                    <span class="menu-arrow"></span>
                                                </a>
                                                <!--begin::Menu sub-->
                                                <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-5">Referrals</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-5">Billing</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-5">Payments</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link d-flex flex-stack px-5">Statements
                                                            <span class="ms-2 lh-0" data-bs-toggle="tooltip"
                                                                title="View your statements">
                                                                <i class="ki-duotone ki-information-5 fs-5">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                    <span class="path3"></span>
                                                                </i>
                                                            </span></a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu separator-->
                                                    <div class="separator my-2"></div>
                                                    <!--end::Menu separator-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <div class="menu-content px-3">
                                                            <label
                                                                class="form-check form-switch form-check-custom form-check-solid">
                                                                <input class="form-check-input w-30px h-20px"
                                                                    type="checkbox" value="1" checked="checked"
                                                                    name="notifications" />
                                                                <span
                                                                    class="form-check-label text-muted fs-7">Notifications</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <!--end::Menu item-->
                                                </div>
                                                <!--end::Menu sub-->
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-5">
                                                <a href="#" class="menu-link px-5">My Statements</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu separator-->
                                            <div class="separator my-2"></div>
                                            <!--end::Menu separator-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-5"
                                                data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                                data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                                                <a href="#" class="menu-link px-5">
                                                    <span class="menu-title position-relative">Mode
                                                        <span
                                                            class="ms-5 position-absolute translate-middle-y top-50 end-0">
                                                            <i class="ki-duotone ki-night-day theme-light-show fs-2">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                                <span class="path4"></span>
                                                                <span class="path5"></span>
                                                                <span class="path6"></span>
                                                                <span class="path7"></span>
                                                                <span class="path8"></span>
                                                                <span class="path9"></span>
                                                                <span class="path10"></span>
                                                            </i>
                                                            <i class="ki-duotone ki-moon theme-dark-show fs-2">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                        </span></span>
                                                </a>
                                                <!--begin::Menu-->
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px"
                                                    data-kt-menu="true" data-kt-element="theme-mode-menu">
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3 my-0">
                                                        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                                                            data-kt-value="light">
                                                            <span class="menu-icon" data-kt-element="icon">
                                                                <i class="ki-duotone ki-night-day fs-2">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                    <span class="path3"></span>
                                                                    <span class="path4"></span>
                                                                    <span class="path5"></span>
                                                                    <span class="path6"></span>
                                                                    <span class="path7"></span>
                                                                    <span class="path8"></span>
                                                                    <span class="path9"></span>
                                                                    <span class="path10"></span>
                                                                </i>
                                                            </span>
                                                            <span class="menu-title">Light</span>
                                                        </a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3 my-0">
                                                        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                                                            data-kt-value="dark">
                                                            <span class="menu-icon" data-kt-element="icon">
                                                                <i class="ki-duotone ki-moon fs-2">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>
                                                            </span>
                                                            <span class="menu-title">Dark</span>
                                                        </a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3 my-0">
                                                        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                                                            data-kt-value="system">
                                                            <span class="menu-icon" data-kt-element="icon">
                                                                <i class="ki-duotone ki-screen fs-2">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                    <span class="path3"></span>
                                                                    <span class="path4"></span>
                                                                </i>
                                                            </span>
                                                            <span class="menu-title">System</span>
                                                        </a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                </div>
                                                <!--end::Menu-->
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-5"
                                                data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                                data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                                                <a href="#" class="menu-link px-5">
                                                    <span class="menu-title position-relative">Language
                                                        <span
                                                            class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">English
                                                            <img class="w-15px h-15px rounded-1 ms-2"
                                                                src="<?php echo url('theme/dist/assets/media/flags/united-states.svg'); ?>"
                                                                alt="" /></span></span>
                                                </a>
                                                <!--begin::Menu sub-->
                                                <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="../dist/account/settings.html"
                                                            class="menu-link d-flex px-5 active">
                                                            <span class="symbol symbol-20px me-4">
                                                                <img class="rounded-1"
                                                                    src="<?php echo url('theme/dist/assets/media/flags/united-states.svg'); ?>"
                                                                    alt="" />
                                                            </span>English</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="../dist/account/settings.html"
                                                            class="menu-link d-flex px-5">
                                                            <span class="symbol symbol-20px me-4">
                                                                <img class="rounded-1"
                                                                    src="<?php echo url('theme/dist/assets/media/flags/spain.svg'); ?>"
                                                                    alt="" />
                                                            </span>Spanish</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="../dist/account/settings.html"
                                                            class="menu-link d-flex px-5">
                                                            <span class="symbol symbol-20px me-4">
                                                                <img class="rounded-1"
                                                                    src="<?php echo url('theme/dist/assets/media/flags/germany.svg'); ?>"
                                                                    alt="" />
                                                            </span>German</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="../dist/account/settings.html"
                                                            class="menu-link d-flex px-5">
                                                            <span class="symbol symbol-20px me-4">
                                                                <img class="rounded-1"
                                                                    src="<?php echo url('theme/dist/assets/media/flags/japan.svg'); ?>"
                                                                    alt="" />
                                                            </span>Japanese</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="../dist/account/settings.html"
                                                            class="menu-link d-flex px-5">
                                                            <span class="symbol symbol-20px me-4">
                                                                <img class="rounded-1"
                                                                    src="<?php echo url('theme/dist/assets/media/flags/france.svg'); ?>"
                                                                    alt="" />
                                                            </span>French</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                </div>
                                                <!--end::Menu sub-->
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-5 my-1">
                                                <a href="../dist/account/settings.html" class="menu-link px-5">Account
                                                    Settings</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-5">
                                                <?php if (isset($_SESSION['user_id'])): ?>
                                                    <a href="<?php echo url('logout'); ?>" class="menu-link px-5">Se
                                                        déconnecter</a>
                                                <?php else: ?>
                                                    <a class="btn btn-sm btn-primary"
                                                        href="<?php echo url('login'); ?>">Connexion</a>
                                                <?php endif; ?>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::User account menu-->
                                        <!--end::Menu wrapper-->
                                    </div>
                                    <!--end::User menu-->
                                    <!--begin::Action-->
                                    <div class="app-navbar-item ms-3 ms-lg-4 me-lg-6">
                                        <!--begin::Link-->
                                        <a href="../dist/authentication/sign-in/basic.html"
                                            class="btn btn-icon btn-custom btn-color-gray-600 btn-active-color-primary w-35px h-35px w-md-40px h-md-40px">
                                            <i class="ki-duotone ki-setting-3 fs-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                                <span class="path5"></span>
                                            </i>
                                        </a>
                                        <!--end::Link-->
                                    </div>
                                    <!--end::Action-->
                                    <!--begin::Header menu toggle-->
                                    <div class="app-navbar-item ms-3 ms-lg-4 ms-n2 me-3 d-flex d-lg-none">
                                        <div class="btn btn-icon btn-custom btn-color-gray-600 btn-active-color-primary w-35px h-35px w-md-40px h-md-40px"
                                            id="kt_app_aside_mobile_toggle">
                                            <i class="ki-duotone ki-burger-menu-2 fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                                <span class="path5"></span>
                                                <span class="path6"></span>
                                                <span class="path7"></span>
                                                <span class="path8"></span>
                                                <span class="path9"></span>
                                                <span class="path10"></span>
                                            </i>
                                        </div>
                                    </div>
                                    <!--end::Header menu toggle-->
                                </div>
                                <!--end::Navbar-->
                            </div>
                            <!--end::Header main-->
                            <!--begin::Separator-->
                            <div class="app-header-separator"></div>
                            <!--end::Separator-->
                        </div>
                        <div class="app-wrapper d-flex flex-column flex-row-fluid" id="kt_app_wrapper">
                            <?php require_once __DIR__ . '/sidebar.php'; ?>
                            <!--begin::Content-->
                            <div class="app-main d-flex flex-column flex-row-fluid" id="kt_app_main">
                                <div class="d-flex flex-column flex-column-fluid">

                                    <!-- begin page content -->
                                    <?php
                                    // Expose flash messages to JS so we can show toasts in the footer
                                    if (function_exists('get_flash')) {
                                        $flashes = get_flash();
                                        echo '<script>window.__flash = ' . json_encode($flashes) . ';</script>';
                                    } else {
                                        echo '<script>window.__flash = {};</script>';
                                    }
                                    ?>
                                <?php endif; ?>