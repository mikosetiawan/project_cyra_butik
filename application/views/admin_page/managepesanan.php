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

<?php
function getStatusPesanan($status_pesanan) {
    switch ($status_pesanan) {
        case 0:
            return "Menunggu konfirmasi";
            break;
        case 1:
            return "Belum dibayar";
            break;
        case 2:
            return "Menunggu dikirim";
            break;
        case 3:
            return "Sedang menuju lokasi";
            break;
        case 4:
            return "Selesai";
            break;
        default:
            return "Tidak valid";
            break;
    }
}
?>

<section>
    <div class="container mt-5" >
        <h2 class="mb-4">Pesanan Menunggu Konfirmasi</h2>
        <div class="row">
            <?php foreach ($kodepesanan as $kdpsn) { ?>
                <div class="col-md-8 mx-auto mb-4">
                    <div class="card rounded-0 border-primary ">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <a class="card-text text-white">#<?php echo $kdpsn['kd_pesanan']; ?></a>
                            <p class="card-text">Tanggal Dibuat: <?php echo $kdpsn['date_created']; ?></p>
                        </div>
                        <div class="card-body">
                        <table id="pesananTable" class="table table-responsive table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Gambar</th>
                                    <th class="w-100">Nama Produk</th>
                                    <th>Qty</th>
                                    <th style="white-space: nowrap;">Harga Satuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pesanan)) { ?>
                                    <?php $counter = 0; 
                                        foreach ($pesanan as $index => $psn) { ?>
                                        <?php if ($psn['kd_pesanan'] == $kdpsn['kd_pesanan']) { $counter++;?>
                                            <tr>
                                                <td class="text-center"><?php echo $counter ?></td>
                                                <td>
                                                <?php if (!empty($psn['gambar_produk'])) : ?>
                                                    <img src="<?php echo base_url('assets/img/uploads/produk/' . $psn['gambar_produk']); ?>" alt="Gambar Produk" class="product-preview img-fluid">
                                                <?php else : ?>
                                                    <img src="<?php echo base_url('assets/img/uploads/profil/default.svg'); ?>" alt="Default Gambar" class="avatar-preview img-fluid rounded-circle">
                                                <?php endif; ?>
                                                </td>
                                                <td><?php echo $psn['nama_produk']; ?></td>
                                                <td class="text-center"><?php echo $psn['qty']; ?></td>
                                                <td>Rp <span style="white-space: nowrap;"><?php echo number_format($psn['harga_produk'], 0, ',', '.'); ?></span></td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tr>
                                        <td colspan="3" class="text-center">No orders found.</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        </div>
                        <hr>
                        <div class="container mb-3">
                            <p class="card-text">Nama Pemesan: <strong><?php echo $kdpsn['nama_user'] ?></strong></p>
                            <p class="card-text" style="display: block;">Alamat Pemesan: <strong><?php echo $kdpsn['alamat_user'] ?></strong></p>
                            <p class="card-text">Whatsapp Pemesan: <strong><?php echo $kdpsn['whatsapp_user'] ?></strong></p>
                            <p class="card-text">Instagram Pemesan: <strong>@<?php echo $kdpsn['instagram_user'] ?></strong></p>
                            <p class="card-text">Total Harga: <strong>Rp <?php echo number_format($kdpsn['total_tagihan'], 0, ',', '.'); ?></strong></p>
                            <p class="card-text">Status Pesanan: <strong><?php echo getStatusPesanan($kdpsn['status_pesanan']); ?></strong></p>
                        </div>
                        <div class="card-footer bg-primary d-flex justify-content-between align-items-center">
                            <p class="card-text text-left text-white">Terakhir Diperbarui: <?php echo $kdpsn['date_updated']; ?></p>
                            <?php if ($kodekonfirmasi == 0) { ?>
                              <button type="button" class="btn btn-success konfirmasi-pesanan" data-id="<?php echo $kdpsn['kd_pesanan'] ?>" data-tagihan="<?php echo $kdpsn['total_tagihan'] ?>" data-toggle="modal" data-target="#konfirmasiPesananModal">Konfirmasi Pesanan</button>
                            <?php } elseif ($kodekonfirmasi == 1) { ?>
                                <button type="button" class="btn btn-success konfirmasi-pembayaran" data-id="<?php echo $kdpsn['kd_pesanan'] ?>">Konfirmasi Pembayaran</button>
                            <?php } elseif ($kodekonfirmasi == 2) { ?>
                                <button type="button" class="btn btn-success konfirmasi-pengiriman" data-id="<?php echo $kdpsn['kd_pesanan'] ?>">Konfirmasi Pengiriman</button>
                            <?php } elseif ($kodekonfirmasi == 3) { ?>
                                <button type="button" class="btn btn-success konfirmasi-penerimaan" data-id="<?php echo $kdpsn['kd_pesanan'] ?>">Konfirmasi Penerimaan</button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="konfirmasiPesananModal" tabindex="-1" role="dialog" aria-labelledby="konfirmasiPesananModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="konfirmasiPesananModalLabel">Konfirmasi Pesanan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="konfirmasiForm" action="" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="ongkir">Ongkos Kirim</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Rp</span>
              </div>
              <input type="text" class="form-control" id="ongkir" name="ongkir" required onkeyup="formatRupiah(this)">
              <input type="hidden" id="kdPesananInput" name="kd_pesanan">
              <input type="hidden" id="total_tagihan" name="total_tagihan">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Kembali</button>
        <button type="button" class="btn btn-success" id="konfirmasiBtn">Konfirmasi</button>
      </div>
    </div>
  </div>
</div>

<script>
  $('.konfirmasi-pesanan').click(function(e) {
      e.preventDefault();
      var id = $(this).data('id');
      var tagihan = $(this).data('tagihan');
      $('#kdPesananInput').val(id); // Set nilai kd_pesanan di dalam input tersembunyi
      $('#total_tagihan').val(tagihan);
      $('#konfirmasiPesananModal').modal('show'); // Tampilkan modal konfirmasi
  });

  $('#konfirmasiBtn').click(function() {
      var kdPesanan = $('#kdPesananInput').val(); // Dapatkan nilai kd_pesanan dari input tersembunyi
      var totalTagihan = $('#total_tagihan').val();
      $('#konfirmasiForm').attr('action', "<?php echo base_url('pesanan/confirm/'); ?>" + kdPesanan + '/0'); // Atur action form dengan nilai kd_pesanan
      $('#konfirmasiForm').submit(); // Kirim form
  });

  var jumlah_bayar = document.getElementById('ongkir');
  jumlah_bayar.addEventListener('keyup', function(e)
  {
      jumlah_bayar.value = formatRupiah(this.value, '');
  });
  
  /* Fungsi */
  function formatRupiah(angka, prefix)
  {
      var number_string = angka.replace(/[^,\d]/g, '').toString(),
          split    = number_string.split(','),
          sisa     = split[0].length % 3,
          rupiah     = split[0].substr(0, sisa),
          ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
          
      if (ribuan) {
          separator = sisa ? '.' : '';
          rupiah += separator + ribuan.join('.');
      }
      
      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
  }

  $(document).ready(function() {
        $('.konfirmasi-pembayaran').click(function(e) {
            e.preventDefault(); // Menghentikan perilaku default dari tombol
            var kdpesanan = $(this).data('id');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Pastikan anda sudah memeriksa dokumen pembayaran produk.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1cc88a',
                cancelButtonColor: '#D1BB9E',
                confirmButtonText: 'Konfirmasi',
                cancelButtonText: 'Kembali'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect atau lakukan penghapusan pengguna di sini
                    window.location.href = "<?php echo base_url('pesanan/confirm/'); ?>" + kdpesanan + "/<?php echo $kodekonfirmasi ?>";
                }
            });
        });

        $('.konfirmasi-pengiriman').click(function(e) {
            e.preventDefault(); // Menghentikan perilaku default dari tombol
            var kdpesanan = $(this).data('id');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Pastikan produk sudah dikirim ke alamat tujuan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1cc88a',
                cancelButtonColor: '#D1BB9E',
                confirmButtonText: 'Konfirmasi',
                cancelButtonText: 'Kembali'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect atau lakukan penghapusan pengguna di sini
                    window.location.href = "<?php echo base_url('pesanan/confirm/'); ?>" + kdpesanan + "/<?php echo $kodekonfirmasi ?>";
                }
            });
        });

        $('.konfirmasi-penerimaan').click(function(e) {
            e.preventDefault(); // Menghentikan perilaku default dari tombol
            var kdpesanan = $(this).data('id');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Pastikan produk sudah diterima oleh pemesan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1cc88a',
                cancelButtonColor: '#D1BB9E',
                confirmButtonText: 'Konfirmasi',
                cancelButtonText: 'Kembali'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect atau lakukan penghapusan pengguna di sini
                    window.location.href = "<?php echo base_url('pesanan/confirm/'); ?>" + kdpesanan + "/<?php echo $kodekonfirmasi ?>";
                }
            });
        });

        $('.konfirmasi-selesai').click(function(e) {
            e.preventDefault(); // Menghentikan perilaku default dari tombol
            var kdpesanan = $(this).data('id');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Pastikan pemesanan produk sudah selesai.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1cc88a',
                cancelButtonColor: '#D1BB9E',
                confirmButtonText: 'Konfirmasi',
                cancelButtonText: 'Kembali'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect atau lakukan penghapusan pengguna di sini
                    window.location.href = "<?php echo base_url('pesanan/confirm/'); ?>" + kdpesanan + "/<?php echo $kodekonfirmasi ?>";
                }
            });
        });
    });
</script>