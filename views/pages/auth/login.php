<?php $title = 'Connexion - StatWise'; $layout = 'auth'; require __DIR__ . '/../../layouts/header.php'; ?>

<div class="d-flex flex-column flex-root" id="kt_app_root">
    <!--begin::Authentication - Sign-in -->
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <!--begin::Aside-->
        <div class="d-flex flex-column flex-lg-row-auto bg-primary w-xl-600px positon-xl-relative">
            <!--begin::Wrapper-->
            <div class="d-flex flex-column position-xl-fixed top-0 bottom-0 w-xl-600px scroll-y">
                <!--begin::Header-->
                <div class="d-flex flex-row-fluid flex-column text-center p-5 p-lg-10 pt-lg-20">
                    <!--begin::Logo-->
                    <a href="<?php echo url(''); ?>" class="py-2 py-lg-20">
                        <img alt="Logo" src="<?php echo url('theme/dist/assets/media/logos/statwise2.png'); ?>" class="h-40px h-lg-50px" />
                    </a>
                    <!--end::Logo-->
                    <!--begin::Title-->
                    <h1 class="d-none d-lg-block fw-bold text-white fs-2qx pb-5 pb-md-10">Bienvenue sur StatWise</h1>
                    <!--end::Title-->
                    <!--begin::Description-->
                    <p class="d-none d-lg-block fw-semibold fs-2 text-white">Gestion et rapports pédagogiques faciles</p>
                    <!--end::Description-->
                </div>
                <!--end::Header-->
                <!--begin::Illustration-->
                <div class="d-none d-lg-block d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px" style="background-image: url(<?php echo url('theme/dist/assets/media/illustrations/sketchy-1/17.png'); ?>)"></div>
                <!--end::Illustration-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--begin::Body-->
        <div class="d-flex flex-column flex-lg-row-fluid py-10">
            <!--begin::Content-->
            <div class="d-flex flex-center flex-column flex-column-fluid">
                <!--begin::Wrapper-->
                <div class="w-lg-500px p-10 p-lg-15 mx-auto">
                    <!--begin::Form-->
                    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" method="POST" action="<?php echo url('login'); ?>">
                        <!--begin::Heading-->
                        <div class="text-center mb-10">
                            <!--begin::Title-->
                            <h1 class="text-dark mb-3">Connexion à StatWise</h1>
                            <!--end::Title-->
                            <!--begin::Link-->
                            <div class="text-gray-400 fw-semibold fs-4">Nouveau ici?
                            <a href="#" class="link-primary fw-bold">Créer un compte</a></div>
                            <!--end::Link-->
                        </div>
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <label class="form-label fs-6 fw-bold text-dark">Email</label>
                            <input class="form-control form-control-lg form-control-solid" type="text" name="email" autocomplete="off" />
                        </div>
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <div class="d-flex flex-stack mb-2">
                                <label class="form-label fw-bold text-dark fs-6 mb-0">Mot de passe</label>
                                <a href="#" class="link-primary fs-6 fw-bold">Mot de passe oublié ?</a>
                            </div>
                            <input class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="off" />
                        </div>
                        <!--begin::Actions-->
                        <div class="text-center">
                            <button type="submit" id="kt_sign_in_submit2" class="btn btn-lg btn-primary w-100 mb-5">
                                <span class="indicator-label">Continuer</span>
                                <span class="indicator-progress">Veuillez patienter...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Content-->
            <!--begin::Footer-->
            <div class="d-flex flex-center flex-wrap fs-6 p-5 pb-0">
                <!--begin::Links-->
                <div class="d-flex flex-center fw-semibold fs-6">
                    <a href="https://keenthemes.com" class="text-muted text-hover-primary px-2" target="_blank">About</a>
                    <a href="https://devs.keenthemes.com" class="text-muted text-hover-primary px-2" target="_blank">Support</a>
                    <a href="https://keenthemes.com/products/saul-html-pro" class="text-muted text-hover-primary px-2" target="_blank">Purchase</a>
                </div>
                <!--end::Links-->
            </div>
            <!--end::Footer-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Authentication - Sign-in-->
</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
