<?php if ($this->session->flashdata('error')) { ?>
<script>
    Swal.fire({
        title: "Oops...",
        text: "<?php echo $this->session->flashdata('error'); ?>",
        icon: "error",
        button: "OK",
    });
</script>
<?php } ?>

    <section class="login-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10 col-lg-12 col-md-9">
                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-lg-6 d-none d-lg-block bg-login-image" style="background-image: url('<?php echo base_url('assets/img/background-6.jpg'); ?>');"></div>
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                        </div>
                                        <form class="user" action="<?php echo base_url('auth/login') ?>" method="post">
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Username" value="<?php echo set_value('username'); ?>" autocomplete="on">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox small">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck">
                                                    <label class="custom-control-label" for="customCheck">Remember
                                                        Me</label>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-user btn-block" style="font-size: 15px; background-color: var(--primary-color-1); border-color: var(--light-color-1);">
                                                Login
                                            </button>
                                            <hr>
                                            <?php echo form_error('username'); ?>
                                            <?php echo form_error('password'); ?>
                                        </form>
                                        <hr>
                                        <div class="text-center">
                                            <a class="small" href="forgot-password.html">Lupa Password?</a>
                                        </div>
                                        <div class="text-center">
                                            <a class="small" href="<?php echo base_url('auth/register') ?>">Belum punya akun? Daftar disini!</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>