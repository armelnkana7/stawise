<?php
if (!function_exists('get_permissions_for_role_id')) {
    require_once __DIR__ . '/../Helpers/permissions.php';
}
// Get user role permissions if user is logged in
$userPerms = [];
if (isset($_SESSION['role_id'])) {
    $userPerms = get_permissions_for_role_id($_SESSION['role_id']);
}
?>

<!--begin::Sidebar-->
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Main-->
    <div class="d-flex flex-column justify-content-between h-100 hover-scroll-overlay-y my-2 d-flex flex-column"
        id="kt_app_sidebar_main" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto"
        data-kt-scroll-dependencies="#kt_app_header" data-kt-scroll-wrappers="#kt_app_main" data-kt-scroll-offset="5px">

        <div class="flex-column-fluid">
            <div id="kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false"
                class="flex-column-fluid menu menu-column menu-rounded menu-sub-indention menu-active-bg mb-7">

                <!-- Dashboard - Accessible to all -->
                <div class="menu-item">
                    <a class="menu-link" href="<?php echo url('dashboard'); ?>">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-element-11 fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                            </i>
                        </span>
                        <span class="menu-title">Tableau de bord</span>
                    </a>
                </div>

                <!-- Management Section - For admin and censeur -->
                <?php if (!empty($userPerms['manage_school_years']) || !empty($userPerms['manage_users']) || !empty($userPerms['manage_establishments']) || !empty($userPerms['manage_departments']) || !empty($userPerms['manage_subjects']) || !empty($userPerms['manage_classes']) || !empty($userPerms['manage_programs']) || !empty($userPerms['manage_roles'])): ?>
                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-some-files fs-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                            <span class="menu-title">Gestion</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">

                            <!-- School Years -->
                            <?php if (!empty($userPerms['manage_school_years'])): ?>
                                <div class="menu-item">
                                    <a class="menu-link" href="<?= url('years'); ?>">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Années scolaires</span>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <!-- Establishments -->
                            <?php if (!empty($userPerms['manage_establishments']) || !empty($userPerms['switch_establishment'])): ?>
                                <div class="menu-item">
                                    <a class="menu-link" href="<?= url('establishments'); ?>">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Établissements</span>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <!-- Users -->
                            <?php if (!empty($userPerms['manage_users'])): ?>
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                    <span class="menu-link">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Utilisateurs</span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <div class="menu-sub menu-sub-accordion">
                                        <div class="menu-item">
                                            <a class="menu-link" href="<?= url('users'); ?>">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">Liste</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Classes -->
                            <?php if (!empty($userPerms['manage_classes']) || !empty($userPerms['view_class_and_programs'])): ?>
                                <div class="menu-item">
                                    <a class="menu-link" href="<?= url('classes'); ?>">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Classes</span>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <!-- Programs -->
                            <?php if (!empty($userPerms['manage_programs']) || !empty($userPerms['view_class_and_programs'])): ?>
                                <div class="menu-item">
                                    <a class="menu-link" href="<?= url('programs'); ?>">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Programmes</span>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <!-- Subjects -->
                            <?php if (!empty($userPerms['manage_subjects'])): ?>
                                <div class="menu-item">
                                    <a class="menu-link" href="<?= url('subjects'); ?>">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Matières</span>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <!-- Departments -->
                            <?php if (!empty($userPerms['manage_departments'])): ?>
                                <div class="menu-item">
                                    <a class="menu-link" href="<?= url('departments'); ?>">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Départements</span>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <!-- Roles -->
                            <?php if (!empty($userPerms['manage_roles'])): ?>
                                <div class="menu-item">
                                    <a class="menu-link" href="<?= url('roles'); ?>">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Rôles</span>
                                    </a>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                <?php endif; ?>

                <!-- Reports Section -->
                <?php if (!empty($userPerms['manage_reports']) || !empty($userPerms['record_reports']) || !empty($userPerms['view_department_reports']) || !empty($userPerms['view_all_reports'])): ?>
                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-chart-line-star fs-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                            </span>
                            <span class="menu-title">Rapports</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <?php if (!empty($userPerms['manage_reports']) || !empty($userPerms['record_reports'])): ?>
                                <div class="menu-item">
                                    <a class="menu-link" href="<?php echo url('reports'); ?>">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Saisie des heures</span>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($userPerms['view_department_reports']) || !empty($userPerms['view_all_reports'])): ?>
                                <div class="menu-item">
                                    <a class="menu-link" href="<?php echo url('reports/consult'); ?>">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">Consulter les rapports</span>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>
<!--end::Sidebar-->