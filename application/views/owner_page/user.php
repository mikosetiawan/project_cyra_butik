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
    <h2 class="mb-4">Manage Users</h2>
    <div class="text-right">
      <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#addUserModal">Tambah</button>
    </div>
    <table id="userTable" class="table table-striped">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th>Username</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Whatsapp</th>
                <th>Instagram</th>
                <th>Roles</th>
                <th>Photo</th>
                <th style="width: 200px;" class="text-center">Aksi</th>
                <!-- Tambahkan kolom lainnya sesuai kebutuhan -->
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)) { ?>
                <?php foreach ($users as $index => $user) { ?>
                    <tr>
                        <td class="text-center"><?php echo $user['id_user']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['nama']; ?></td>
                        <td><?php echo $user['alamat']; ?></td>
                        <td class="text-center"><?php echo $user['whatsapp']; ?></td>
                        <td><?php echo $user['instagram']; ?></td>
                        <td><?php echo $user['roles']; ?></td>
                        <td>
                          <?php if (!empty($user['img'])) : ?>
                            <img src="<?php echo base_url('assets/img/uploads/profil/' . $user['img']); ?>" alt="Avatar" class="avatar-preview img-fluid rounded-circle">
                          <?php else : ?>
                            <img src="<?php echo base_url('assets/img/uploads/profil/default.svg'); ?>" alt="Default Avatar" class="avatar-preview img-fluid rounded-circle">
                          <?php endif; ?>
                        </td>

                        <td>
                          <button type="button" class="btn btn-primary edit-user btn-sm" data-id="1" data-toggle="modal" data-target="#editUserModal<?php echo $user['id_user'];?>">Edit</button>
                          <a data-id="<?php echo $user['id_user']; ?>" class="btn btn-danger btn-sm delete-user">Hapus</a>
                        </td>
                        <!-- Tambahkan kolom lainnya sesuai kebutuhan -->
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="3" class="text-center">No users found.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addUserModalLabel">Edit User</h5>
        <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i class="fas fa-times fa-1x"></i></span>
        </button>

      </div>
      <div class="modal-body">
        <?php echo form_open_multipart('user/create/' . $user['id_user']); ?>
          <input type="hidden" name="userid" id="editUserId">
          <div class="mb-3">
            <label for="editUserName" class="form-label">Username</label>
            <input type="text" class="form-control" id="editUserName" name="username">
          </div>
          <div class="mb-3">
            <label for="editNama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="editNama" name="nama">
          </div>
          <div class="mb-3">
            <label for="editAlamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" id="editAlamat" name="alamat">
          </div>
          <div class="mb-3">
            <label for="editWhatsapp" class="form-label">Whatsapp</label>
            <input type="text" class="form-control" id="editWhatsapp" name="whatsapp">
          </div>
          <div class="mb-3">
            <label for="editInstagram" class="form-label">Instagram</label>
            <input type="text" class="form-control" id="editInstagram" name="instagram">
          </div>
          <div class="mb-3">
            <label for="editRoles" class="form-label">Roles</label><br>
            <select class="form-select" id="editRoles" name="roles">
              <option value="pelanggan" selected>Pelanggan</option>
              <option value="admin">Admin</option>
              <option value="owner">Owner</option>
              <!-- Tambahkan opsi lainnya sesuai dengan kebutuhan -->
            </select>
          </div>
          <div class="mb-3">
            <label for="addUserAvatar" class="form-label">Avatar</label>
            <input type="file" class="form-control-file" id="addUserAvatar" name="userAvatar" accept="image/*">
          </div>
          <div class="mb-3">
            <label for="editPassword" class="form-label">Password</label>
            <input type="text" class="form-control" id="editPassword" name="password" value="">
          </div>
          <hr class="sidebar-divider d-none d-md-block">
          <button type="submit" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Tambah</button>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>

<?php $no = 0;
foreach ($users as $user) : $no++; ?>
<div class="modal fade" id="editUserModal<?php echo $user['id_user'];?>" tabindex="-1" aria-labelledby="editUserModalLabel<?php echo $user['id_user'];?>" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editUserModalLabel<?php echo $user['id_user'];?>">Edit User</h5>
        <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i class="fas fa-times fa-1x"></i></span>
        </button>

      </div>
      <div class="modal-body">
        <?php echo form_open_multipart('user/update/' . $user['id_user']); ?>
          <input type="hidden" name="userid" id="editUserId" value="<?php echo $user['id_user']; ?>">
          <div class="mb-3">
            <label for="editUserName" class="form-label">Username</label>
            <input type="text" class="form-control" id="editUserName" name="username" value="<?php echo $user['username']; ?>">
          </div>
          <div class="mb-3">
            <label for="editNama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="editNama" name="nama" value="<?php echo $user['nama']; ?>">
          </div>
          <div class="mb-3">
            <label for="editAlamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" id="editAlamat" name="alamat" value="<?php echo $user['alamat']; ?>">
          </div>
          <div class="mb-3">
            <label for="editWhatsapp" class="form-label">Whatsapp</label>
            <input type="text" class="form-control" id="editWhatsapp" name="whatsapp" value="<?php echo $user['whatsapp']; ?>">
          </div>
          <div class="mb-3">
            <label for="editInstagram" class="form-label">Instagram</label>
            <input type="text" class="form-control" id="editInstagram" name="instagram" value="<?php echo $user['instagram']; ?>">
          </div>
          <div class="mb-3">
            <label for="editRoles" class="form-label">Roles</label><br>
            <select class="form-select" id="editRoles" name="roles">
              <option value="owner" <?php echo ($user['roles'] == 'owner') ? 'selected' : ''; ?>>Owner</option>
              <option value="admin" <?php echo ($user['roles'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
              <option value="pelanggan" <?php echo ($user['roles'] == 'pelanggan') ? 'selected' : ''; ?>>Pelanggan</option>
              <!-- Tambahkan opsi lainnya sesuai dengan kebutuhan -->
            </select>
          </div>
          <div class="mb-3">
            <label for="editUserAvatar" class="form-label">Avatar</label>
            <input type="file" class="form-control-file" id="editUserAvatar" name="userAvatar" accept="image/*">
          </div>
          <div class="mb-3">
            <label for="editPassword" class="form-label">Password</label>
            <input type="text" class="form-control" id="editPassword" name="password" value="">
          </div>
          <hr class="sidebar-divider d-none d-md-block">
          <button type="submit" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
<?php endforeach; ?>

<script>
    $(document).ready(function() {
        $('.delete-user').click(function(e) {
            e.preventDefault(); // Menghentikan perilaku default dari tombol
            var userId = $(this).data('id');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan menghapus pengguna ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect atau lakukan penghapusan pengguna di sini
                    window.location.href = "<?php echo base_url('user/delete/'); ?>" + userId;
                }
            });
        });
    });

    $(document).ready(function() {
        $('#userTable').DataTable({
            paging: true, // Aktifkan paginasi
            searching: true // Aktifkan pencarian
            // Tambahkan opsi lainnya sesuai kebutuhan
        });
    });
</script>
