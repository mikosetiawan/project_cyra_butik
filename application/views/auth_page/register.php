    <?php if ($this->session->flashdata('error')) { ?>
        <script>
            swal({
                title: "Oops...",
                text: "<?php echo $this->session->flashdata('error'); ?>",
                icon: "error",
                button: "OK",
            });
        </script>
    <?php } ?>

    <section class="register-section">
        <div class="container">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-5 d-none d-lg-block" style="background-image: url('<?php echo base_url('assets/img/background-2.jpg'); ?>');"></div>
                        <div class="col-lg-7">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Buat sebuah Akun!</h1>
                                </div>
                                <form class="user" action="<?php echo base_url('auth/register') ?>" method="post">
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Username" value="<?php echo set_value('username'); ?>" autocomplete="on">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control form-control-user" id="nama" name="nama" placeholder="Nama Lengkap" value="<?php echo set_value('nama'); ?>" autocomplete="on">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="password" class="form-control form-control-user" id="repeatpassword" name="repeat_password" placeholder="Repeat Password">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block" style="font-size: 15px; background-color: var(--primary-color-1); border-color: var(--light-color-1);">
                                        Register Account
                                    </button>
                                    <hr>
                                    <?php echo form_error('username'); ?>
                                    <?php echo form_error('nama'); ?>
                                    <?php echo form_error('password'); ?>
                                    <?php echo form_error('repeat_password'); ?>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="forgot-password.html">Lupa Password?</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="login.html">Sudah memiliki akun? Login disini!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>