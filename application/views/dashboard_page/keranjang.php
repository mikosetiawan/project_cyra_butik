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
<section id="produk-section" style="height: 90vh;">
  <div class="container mt-5">
      <h2 class="mb-3">Keranjang Saya</h2>
      <div class="row">
          <div class="col-md-8">
              <table class="table">
                  <thead>
                      <tr>
                          <th>Product</th>
                          <th class="text-center">Price</th>
                          <th class="text-center">Quantity</th>
                          <th class="text-center">Total</th>
                          <th class="text-center">Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      <!-- Loop through cart items -->
                      <?php foreach ($this->cart->contents() as $items): ?>
                          <tr>
                              <td><?php echo $items['name']; ?></td>
                              <td class="text-center">Rp <?php echo number_format($items['price'], 0, ',', '.'); ?></td>
                              <td class="text-center"><?php echo $items['qty']; ?></td>
                              <td class="text-center">Rp <?php echo number_format($items['subtotal'], 0, ',', '.'); ?></td>
                              <td>
                                <a href="<?php echo base_url('pesanan/remove_from_cart/'.$items['rowid']); ?>" class="btn btn-danger btn-sm">-</a>
                                <a href="<?php echo base_url('pesanan/add_from_cart/'.$items['rowid']); ?>" class="btn btn-success btn-sm">+</a>
                            </td>
                          </tr>
                      <?php endforeach; ?>
                  </tbody>
              </table>
          </div>
          <div class="col-md-4">
              <div class="card">
                  <div class="card-body">
                      <h5 class="card-title">Keranjang</h5>
                      <p class="card-text">Total Barang: <?php echo $this->cart->total_items(); ?></p>
                      <p class="card-text">Total Harga: Rp <?php echo number_format($this->cart->total(), 0, ',', '.'); ?></p>
                      <a href="<?php echo site_url('pesanan/clear_cart'); ?>" class="btn btn-danger">Clear</a>
                      <a href="<?php echo base_url('pesanan/tambah_pesanan'); ?>" class="btn btn-primary tambah-pesanan">Checkout</a>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>

<script>
    $(document).ready(function() {
        $('.tambah-pesanan').click(function(e) {
            e.preventDefault(); // Menghentikan perilaku default dari tombol
            var id = $(this).data('id');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Lanjutkan pemesanan",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1cc88a',
                cancelButtonColor: '#D1BB9E',
                confirmButtonText: 'Check Out   ',
                cancelButtonText: 'Kembali'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?php echo base_url('pesanan/tambah_pesanan/'); ?>" + id;
                }
            });
        });
    });
</script>