<?php if ($this->session->flashdata('error')) { ?>
<script>
    Swal.fire({
        title: "Oops...",
        text: <?php echo json_encode($this->session->flashdata('error')); ?>,
        icon: "error",
        button: "OK",
    });
</script>
<?php } ?>
<?php if ($this->session->flashdata('success')) { ?>
<script>
    Swal.fire({
        title: "Success",
        text: <?php echo json_encode($this->session->flashdata('success')); ?>,
        icon: "success",
        button: "OK",
    });
</script>
<?php } ?>

<div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Edit Profile
                    </div>
                    <div class="card-body">
                      <?php echo form_open_multipart('user/profile'); ?>
                          <div class="form-group">
                              <label for="inputNama">Nama</label>
                              <input type="text" class="form-control" id="inputNama" name="nama" value="<?php echo $user['nama']; ?>">
                          </div>
                          <div class="form-group">
                              <label for="inputAlamat">Alamat</label>
                              <input type="text" class="form-control" id="inputAlamat" name="alamat" value="<?php echo $user['alamat']; ?>">
                          </div>
                          <div class="form-group">
                              <label for="inputWhatsApp">WhatsApp</label>
                              <input type="text" class="form-control" id="inputWhatsApp" name="whatsapp" value="<?php echo $user['whatsapp']; ?>">
                          </div>
                          <div class="form-group">
                              <label for="inputInstagram">Instagram</label>
                              <input type="text" class="form-control" id="inputInstagram" name="instagram" value="<?php echo $user['instagram']; ?>">
                          </div>
                          <div class="form-group">
                              <label for="inputPassword">Password</label>
                              <input type="password" class="form-control" id="inputPassword" name="password">
                          </div>
                          <div class="form-group">
                              <label for="inputConfirmPassword">Confirm Password</label>
                              <input type="password" class="form-control" id="inputConfirmPassword" name="confirm_password">
                          </div>
                          <div class="form-group">
                              <label for="userAvatar">Avatar</label>
                              <input type="file" class="form-control-file" id="userAvatar" name="userAvatar" accept="image/*">
                          </div>
                          <button type="submit" class="btn btn-primary">Save Changes</button>
                      <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>