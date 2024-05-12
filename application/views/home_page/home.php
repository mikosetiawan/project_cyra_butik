	<!-- Konten Hero -->
	<section class="hero-section d-flex align-items-center justify-content-center" style="background-image: url('<?php echo base_url('assets/img/background-5.jpg'); ?>');">
		<div>
			<div class="text-center text-white">
				<p class="text-shadow medium-color fw-bold" style="letter-spacing: 3px;">NEW COLLECTION</p>
				<h1 class="font-cormorant-garamond fw-bold light-color text-shadow">CYRA FASHION GALERY</h1>
				<p class="font-roboto light-color">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam euismod felis at mauris aliquam, at vehicula orci consequat.</p>
				<div class="mt-4">
					<a href="<?php echo base_url('product'); ?>" class="mt-2 font-roboto fw-bold btn btn-primary rounded-pill p-3 px-5 btn-produk" style="font-size: 15px; background-color: var(--primary-color-1); border-color: var(--light-color-1);">LIHAT PRODUK</a>
					<a href="#" class="mx-3 font-roboto fw-bold btn btn-outline-light btn-lg rounded-pill p-3 px-5" style="font-size: 15px;">LOGIN</a>
				</div>
			</div>
			<a href="#produk-section" class="arrow-down">
				<i class="fas fa-arrow-down"></i>
			</a>
		</div>
	</section>

	<!-- Bagian Daftar Produk -->
	<section id="produk-section" class="py-5">
		<div class="container">
			<h1 class="text-center mb-4 font-cormorant-garamond fw-bold header-color">Daftar Produk</h1>
			<div id="produk-container" class="mt-3 row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-5">
					<!-- Card Produk -->
					<?php foreach ($products as $product): ?>
            <div class="col-md-4 mb-4">
                <div class="card border-0 h-100">
                    <img src="<?php echo base_url('assets/img/uploads/produk/' . $product['img']); ?>" alt="..." class="img-produk">
                    <div class="card-body text-center">
                        <h5 class="card-title font-playfair-display"><?php echo $product['nama_produk']; ?></h5>
                        <p class="card-text font-roboto"><?php echo $product['deskripsi_produk']; ?></p>
                        <p class="card-text font-quicksand"><?php echo 'Rp ' . number_format($product['harga_produk'], 0, ',', '.'); ?></p>
                        <button class="btn btn-outline-dark btn-sm rounded-pill btn-outline-light px-4" data-bs-toggle="modal" data-bs-target="#addToCartModal<?php echo $product['id_produk'];?>">Add to Cart</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
					<!-- Tambahkan card lainnya di sini -->
			</div>
			<div class="text-center">
					<a href="<?php echo base_url('product'); ?>" class="btn btn-outline-dark btn-sm rounded-pill btn-outline-light px-4">LIHAT PRODUK LAINNYA</a>
				</div>
		</div>
	</section>

<?php foreach ($products as $product): ?>
	<!-- Modal -->
	<div class="modal fade" id="addToCartModal<?php echo $product['id_produk'];?>" tabindex="-1" role="dialog" aria-labelledby="addToCartModalLabel<?php echo $product['id_produk'];?>" aria-hidden="true">
			<div class="modal-dialog" role="document">
					<div class="modal-content">
							<div class="modal-header">
									<h5 class="modal-title" id="addToCartModalLabel">Add to Cart</h5>
									<button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
										<span aria-hidden="true"><i class="fas fa-times fa-1x"></i></span>
									</button>
							</div>
							<div class="modal-body">
									<!-- Form to add product to cart -->
									<form action="<?php echo base_url('pesanan/add_to_cart'); ?>" method="post">
											<div class="form-group">
													<label for="quantity">Quantity:</label>
													<input type="number" class="form-control" id="quantity" name="quantity" min="1" value="1">
											</div>
											<input type="hidden" name="id_produk" value="<?php echo $product['id_produk'];?>">
											<input type="hidden" name="nama_produk" value="<?php echo $product['nama_produk'];?>">
											<input type="hidden" name="harga" value="<?php echo $product['harga_produk'];?>">
											<button type="submit" class="btn btn-primary mt-3">Add to Cart</button>
									</form>
							</div>
					</div>
			</div>
	</div>
<?php endforeach; ?>

	<script src="<?php echo base_url('assets/js/main.js'); ?>"></script>