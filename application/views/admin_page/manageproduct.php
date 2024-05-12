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
    <h2 class="mb-4">Manage products</h2>
    <div class="text-right">
      <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#addproductModal">Tambah</button>
    </div>
    <table id="productTable" class="table table-striped">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th>Nama Produk</th>
                <th>Deskripsi</th>
                <th>Jenis</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Photo</th>
                <th style="width: 150px;" class="text-center">Aksi</th>
                <!-- Tambahkan kolom lainnya sesuai kebutuhan -->
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($products)) { ?>
                <?php foreach ($products as $index => $product) { ?>
                    <tr>
                        <td class="text-center"><?php echo $product['id_produk']; ?></td>
                        <td><?php echo $product['nama_produk']; ?></td>
                        <td><?php echo $product['deskripsi_produk']; ?></td>
                        <td><?php echo $product['jenis_produk']; ?></td>
                        <td class="text-center"><?php echo $product['harga_produk']; ?></td>
                        <td><?php echo $product['stok']; ?></td>
                        <td>
                          <?php if (!empty($product['img'])) : ?>
                            <img src="<?php echo base_url('assets/img/uploads/produk/' . $product['img']); ?>" alt="Gambar Produk" class="product-preview img-fluid">
                          <?php else : ?>
                            <img src="<?php echo base_url('assets/img/uploads/profil/default.svg'); ?>" alt="Default Gambar" class="avatar-preview img-fluid rounded-circle">
                          <?php endif; ?>
                        </td>

                        <td>
                          <button type="button" class="btn btn-primary edit-product btn-sm" data-id="1" data-toggle="modal" data-target="#editproductModal<?php echo $product['id_produk'];?>">Edit</button>
                          <a data-id="<?php echo $product['id_produk']; ?>" class="btn btn-danger btn-sm delete-product">Hapus</a>
                        </td>
                        <!-- Tambahkan kolom lainnya sesuai kebutuhan -->
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="3" class="text-center">No products found.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php $no = 0;
foreach ($products as $product) : $no++; ?>
<div class="modal fade" id="editproductModal<?php echo $product['id_produk'];?>" tabindex="-1" aria-labelledby="editproductModalLabel<?php echo $product['id_produk'];?>" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editproductModalLabel<?php echo $product['id_produk'];?>">Edit product</h5>
        <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i class="fas fa-times fa-1x"></i></span>
        </button>

      </div>
      <div class="modal-body">
        <?php echo form_open_multipart('product/update/' . $product['id_produk']); ?>
          <input type="hidden" name="productid" id="editproductId" value="<?php echo $product['id_produk']; ?>">
          <div class="mb-3">
            <label for="editNamaProduk" class="form-label">Nama Produk</label>
            <input type="text" class="form-control" id="editNamaProduk" name="nama_produk" value="<?php echo $product['nama_produk']; ?>">
          </div>
          <div class="mb-3">
            <label for="editDeskripsi" class="form-label">Deskripsi</label>
            <input type="text" class="form-control" id="editDeskripsi" name="deskripsi_produk" value="<?php echo $product['deskripsi_produk']; ?>">
          </div>
          <div class="mb-3">
            <label for="editJenis" class="form-label">Jenis Produk</label>
            <input type="text" class="form-control" id="editJenis" name="jenis_produk" value="<?php echo $product['jenis_produk']; ?>">
          </div>
          <div class="mb-3">
            <label for="editHarga" class="form-label">Harga Produk</label>
            <input type="text" class="form-control" id="editHarga" name="harga_produk" value="<?php echo $product['harga_produk']; ?>">
          </div>
          <div class="mb-3">
            <label for="editStok" class="form-label">Stok Produk</label>
            <input type="text" class="form-control" id="editStok" name="stok" value="<?php echo $product['stok']; ?>">
          </div>
          <div class="mb-3">
            <label for="editImg" class="form-label">Gambar Produk</label>
            <input type="file" class="form-control-file" id="editImg" name="img_produk" accept="image/*">
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

<div class="modal fade" id="addproductModal" tabindex="-1" aria-labelledby="addproductModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addproductModalLabel">Add product</h5>
        <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i class="fas fa-times fa-1x"></i></span>
        </button>

      </div>
      <div class="modal-body">
        <?php echo form_open_multipart('product/create/') ?>
          <div class="mb-3">
            <label for="editNamaProduk" class="form-label">Nama Produk</label>
            <input type="text" class="form-control" id="editNamaProduk" name="nama_produk" value="<?=set_value('nama_produk')?>">
          </div>
          <div class="mb-3">
            <label for="editDeskripsi" class="form-label">Deskripsi</label>
            <input type="text" class="form-control" id="editDeskripsi" name="deskripsi_produk" value="<?=set_value('deskripsi_produk')?>">
          </div>
          <div class="mb-3">
            <label for="editJenis" class="form-label">Jenis Produk</label>
            <input type="text" class="form-control" id="editJenis" name="jenis_produk" value="<?=set_value('jenis_produk')?>">
          </div>
          <div class="mb-3">
            <label for="editHarga" class="form-label">Harga Produk</label>
            <input type="text" class="form-control" id="editHarga" name="harga_produk" value="<?=set_value('harga_produk')?>">
          </div>
          <div class="mb-3">
            <label for="editStok" class="form-label">Stok Produk</label>
            <input type="text" class="form-control" id="editStok" name="stok" value="<?=set_value('stok')?>">
          </div>
          <div class="mb-3">
            <label for="editImg" class="form-label">Gambar Produk</label>
            <input type="file" class="form-control-file" id="editImg" name="img_produk" accept="image/*">
          </div>
          <hr class="sidebar-divider d-none d-md-block">
          <button type="submit" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Add Product</button>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function() {
        $('.delete-product').click(function(e) {
            e.preventDefault(); // Menghentikan perilaku default dari tombol
            var productId = $(this).data('id');

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
                    window.location.href = "<?php echo base_url('product/delete/'); ?>" + productId;
                }
            });
        });
    });

    $(document).ready(function() {
        $('#productTable').DataTable({
            paging: true, // Aktifkan paginasi
            searching: true // Aktifkan pencarian
            // Tambahkan opsi lainnya sesuai kebutuhan
        });
    });
</script>
