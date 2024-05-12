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
        <h2 class="card-header">Checkout</h2>
        <form class="card-body" action="<?php echo base_url('pesanan/process_checkout/' . $pesanan['kd_pesanan']); ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $user['nama'];?>" required>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?php echo $user['alamat'];?></textarea>
            </div>
            <div class="form-group">
                <label for="whatsapp">WhatsApp:</label>
                <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="<?php echo $user['whatsapp'];?>" required>
            </div>
            <div class="form-group">
                <label for="instagram">Instagram:</label>
                <input type="text" class="form-control" id="instagram" name="instagram" value="<?php echo $user['instagram'];?>">
            </div>
            <div class="form-group">
              <label for="jumlah_bayar">Jumlah yang Dibayar:</label>
              <div class="input-group">
                  <div class="input-group-prepend">
                      <span class="input-group-text">Rp</span>
                  </div>
                  <input type="text" class="form-control" id="jumlah_bayar" name="jumlah_bayar" required onkeyup="formatRupiah(this)">
              </div>
            </div>
            <div class="form-group">
              <label for="total_tagihan">Total Tagihan:</label>
              <div class="input-group">
                  <div class="input-group-prepend">
                      <span class="input-group-text">Rp</span>
                  </div>
                  <input type="text" class="form-control" id="total_tagihan" name="total_tagihan" value="<?php echo number_format($pesanan['total_tagihan'], 0, ',', '.'); ?>" required disabled>
              </div>
            </div>
            <div class="form-group">
                <label for="bukti_transfer">Upload Bukti Transfer:</label>
                <input type="file" class="form-control-file" id="bukti_transfer" name="bukti_transfer" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  var jumlah_bayar = document.getElementById('jumlah_bayar');
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
</script>