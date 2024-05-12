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
        <h2 class="mb-4">Pesanan Saya</h2>
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
                            <p class="card-text">Total Tagihan: <strong>Rp <?php echo number_format($kdpsn['total_tagihan'], 0, ',', '.'); ?></strong></p>
                            <p class="card-text">Ongkos Kirim: <strong>Rp <?php echo number_format($kdpsn['ongkir'], 0, ',', '.'); ?></strong></p>
                            <p class="card-text">Status Pesanan: <strong><?php echo getStatusPesanan($kdpsn['status_pesanan']); ?></strong></p>
                        </div>
                        <div class="card-footer bg-primary d-flex justify-content-between align-items-center">
                            <p class="card-text text-left text-white">Terakhir Diperbarui: <?php echo $kdpsn['date_updated']; ?></p>
                            <?php if ($kdpsn['status_pesanan'] == 0) { ?>
                                <a class="btn btn-danger delete-pesanan" data-id="<?php echo $kdpsn['kd_pesanan'] ?>">Cancel</a>
                            <?php } elseif ($kdpsn['status_pesanan'] == 1) { ?>
                                <a href="<?php echo base_url('pesanan/checkout/' . $kdpsn['kd_pesanan']); ?>" class="btn btn-success">Bayar</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        $('.delete-pesanan').click(function(e) {
            e.preventDefault(); // Menghentikan perilaku default dari tombol
            var id = $(this).data('id');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan membatalkan pesanan ini",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#D1BB9E',
                confirmButtonText: 'Batalkan',
                cancelButtonText: 'Kembali'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?php echo base_url('pesanan/cancel/'); ?>" + id;
                }
            });
        });
    });
</script>

    
    <!--
    <div class="container mt-5">
        <h2 class="mb-4">Pesanan Saya</h2>
        <table id="userTable" class="table table-responsive table-striped">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Foto Produk</th>
                    <th>Nama Produk</th>
                    <th>Qty</th>
                    <th style="white-space: nowrap;">Harga Satuan</th>
                    <th style="white-space: nowrap;">Ongkir</th>
                    <th style="white-space: nowrap;">Total Harga</th>
                    <th>Status Pesanan</th>
                    <th>Tanggal Dibuat</th>
                    <th>Tanggal Diperbarui</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($pesanan)) { ?>
                    <?php foreach ($pesanan as $index => $psn) { ?>
                        <tr>
                            <td class="text-center"><?php echo $index + 1 ?></td>
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
                            <td>Rp <span style="white-space: nowrap;"><?php echo number_format($psn['ongkir'], 0, ',', '.'); ?></span></td>
                            <td>Rp <span style="white-space: nowrap;"><?php echo number_format($psn['total_harga'], 0, ',', '.'); ?></span></td>
                            <td>
                                <?php
                                switch ($psn['status_pesanan']) {
                                    case 0:
                                        echo "Menunggu konfirmasi";
                                        break;
                                    case 1:
                                        echo "Belum dibayar";
                                        break;
                                    case 2:
                                        echo "Menunggu dikirim";
                                        break;
                                    case 3:
                                        echo "Sedang menuju lokasi";
                                        break;
                                    case 4:
                                        echo "Selesai";
                                        break;
                                    default:
                                        echo "Tidak valid";
                                        break;
                                }
                                ?>
                            </td>
                            <td><?php echo $psn['date_created']; ?></td>
                            <td><?php echo $psn['date_updated']; ?></td>
                            <?php if ($psn['status_pesanan'] <= 1) { ?>
                                <td>
                                    <?php if ($psn['status_pesanan'] == 0) { ?>
                                        <a data-id="<?php echo $psn['id_pesanan']; ?>" class="btn btn-secondary btn-sm delete-pesanan">Cancel</a>
                                    <?php } elseif ($psn['status_pesanan'] == 1) { ?>
                                        <a href="<?php echo base_url('pesanan/checkout/' . $psn['']); ?>" class="btn btn-success btn-sm">Bayar</a>
                                    <?php } ?>
                                </td>
                            <?php } else {?>
                                <td></td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="3" class="text-center">No orders found.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    -->