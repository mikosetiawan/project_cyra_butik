<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page['title']; ?></title>
    <!-- Tautkan berkas CSS -->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css'); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/font.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('vendor/twbs/bootstrap/dist/css/bootstrap.min.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('vendor/fontawesome-free/css/all.min.css');?>">
		<?php if ($page['page'] == 'login' || $page['page'] == 'register' || $page['page'] == 'keranjang' || $page['page'] == 'list-produk') : ?>
    	<link href="<?php echo base_url('assets/css/sb-admin-2.min.css'); ?>" rel="stylesheet">
		<?php endif; ?>

		<!-- Tautkan berkas JS -->
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
<main>
	<!-- Navigasi -->
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container font-quicksand">
			<a class="navbar-brand" href="<?php echo base_url(); ?>">
				<img src="<?php echo base_url('assets/img/logo-pil-mini.png'); ?>" alt="Cyra Butik Logo" class="img-fluid">
			</a>

			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse navbar-container" id="navbarNav">
				<ul class="navbar-nav">
					<li class="nav-item ms-xl-5 me-xl-3 <?php echo ($page['page'] == 'home') ? 'active' : ''; ?>">
						<a class="nav-link" href="<?php echo base_url(); ?>">Home</a>
					</li>
					<li class="nav-item <?php echo ($page['page'] == 'produk') ? 'active' : ''; ?>">
						<a class="nav-link" href="<?php echo base_url('product'); ?>">Produk</a>
					</li>
				</ul>
				<!-- Tombol Login / Logout di sebelah kanan -->
				<ul class="navbar-nav ms-auto">
					<?php if ($this->session->userdata('user_id')) { ?>
					<!-- Jika pengguna sudah login -->
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url('dashboard'); ?>">Dashboard</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url('logout'); ?>">Keluar Akun</a>
					</li>
					<?php } else { ?>
						<!-- Jika pengguna belum login -->
						<li class="nav-item <?php echo ($page['page'] == 'login') ? 'active' : ''; ?>">
							<a class="nav-link" href="<?php echo base_url('login'); ?>">Masuk</a>
						</li>
						<li class="nav-item ms-xl-3 <?php echo ($page['page'] == 'register') ? 'active' : ''; ?>">
							<a class="nav-link" href="<?php echo base_url('register'); ?>">Daftar</a>
						</li>
					<?php } ?>
					<li class="nav-item mx-3 d-none d-lg-block">
							<a class="nav-link" href="<?php echo base_url('keranjang') ?>"><i class="fa fa-shopping-bag fa-lg" aria-hidden="true"></i></a>
					</li>
					<li class="nav-item d-lg-none <?php echo ($page['page'] == 'keranjang') ? 'active' : ''; ?>">
						<a class="nav-link" href="<?php echo base_url('keranjang') ?>">Keranjang</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

<?php $this->load->view($page['content']); ?>

	<footer class="text-white text-center py-4" style="background-color:var(--primary-color-1);">
    <div class="container">
        <p>&copy; 2024 Cyra Boutique. All rights reserved.</p>
    </div>
	</footer>
</main>

<script src="<?php echo base_url('vendor/twbs/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('vendor/jquery/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>
<?php if ($page['page'] == 'login' || $page['page'] == 'register') : ?>
	<script src="<?php echo base_url('assets/js/sb-admin-2.min.js'); ?>"></script>
<?php endif; ?>
</body>
</html>