<?= $this->extend($config->customViewLayout); ?>

<?= $this->section("pageInfo"); ?>
<title>Login - Ed Creative</title>
<?= $this->endSection(); ?>

<?= $this->section("contentSection"); ?>

<!-- Outer Row -->
<div class="row justify-content-center">

    <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-6 d-none d-lg-block">
                        <img src="https://source.unsplash.com/xiTFENI0dMY/800x600" load="lazy" class="login-register-image" alt="">
                    </div>
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900">Ed Creative - <?= lang('Auth.loginTitle') ?></h1>
                                <small class="d-block mb-4">Selamat Datang Kembali !</small>
                            </div>
                            <!-- badAttempt -->
                            <?php if (session('error')) : ?>
                                <div class="alert alert-danger" role="alert">
                                    Unable to log you in. Please check your credentials.
                                </div>
                                <!-- activation success -->
                            <?php elseif (session('message')) : ?>
                                <div class="alert alert-success" role="alert">
                                    <?= session('message'); ?>
                                </div>
                            <?php endif; ?>
                            <form class="user" action="<?= route_to('login') ?>" method="post">
                                <?= csrf_field() ?>
                                <?php if ($config->validFields === ['email']) : ?>
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user <?php if (session('errors.login') || session('error')) : ?>is-invalid<?php endif ?>" name="login" placeholder="<?= lang('Auth.email') ?>">
                                        <div class="invalid-feedback">
                                            <?= session('errors.login') ?>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user <?php if (session('errors.login') || session('error')) : ?>is-invalid<?php endif ?>" name="login" placeholder="<?= lang('Auth.emailOrUsername') ?>">
                                        <div class="invalid-feedback">
                                            <?= session('errors.login') ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="form-group">
                                    <input type="password" name="password" class="form-control form-control-user  <?php if (session('errors.password') || session('error')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>">
                                    <div class="invalid-feedback">
                                        <?= session('errors.password') ?>
                                    </div>
                                </div>

                                <?php if ($config->allowRemembering) : ?>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" name="remember" class="custom-control-input" <?php if (old('remember')) : ?> checked <?php endif ?>>
                                            <label class="custom-control-label" for="customCheck"><?= lang('Auth.rememberMe') ?></label>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <button type="submit" class="btn btn-primary btn-user btn-block"><?= lang('Auth.loginAction') ?></button>
                                <hr>
                            </form>

                            <?php if ($config->allowRegistration) : ?>
                                <div class="text-center">
                                    <a class="small" href="<?= route_to('register') ?>"><?= lang('Auth.needAnAccount') ?></a>
                                </div>
                            <?php endif; ?>
                            <?php if ($config->activeResetter) : ?>
                                <div class="text-center">
                                    <a class="small" href="<?= route_to('forgot') ?>"><?= lang('Auth.forgotYourPassword') ?></a>
                                </div>

                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<?= $this->endSection(); ?>