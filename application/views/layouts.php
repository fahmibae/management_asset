<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
		<meta name="author" content="Creative Tim">
		<title> <?= $title ?> | Pengelolaan Asset </title>
		<!-- Favicon -->
		<!-- Fonts -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
		<!-- Icons -->
		<link rel="stylesheet" href="<?= site_url('assets/vendor/nucleo/css/nucleo.css') ?>" type="text/css">
		<link rel="stylesheet" href="<?= site_url('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') ?>" type="text/css">
		<!-- Page plugins -->
		<!-- Argon CSS -->
		<link rel="stylesheet" href="<?= site_url('assets/css/argon.css?v=1.2.0') ?>" type="text/css">

		<link rel="stylesheet" href="<?= site_url('assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') ?>" type="text/css">
		<link rel="stylesheet" href="<?= site_url('assets/vendor/ladda/ladda-themeless.min.css') ?>">
		<link rel="stylesheet" href="<?= site_url('assets/vendor/toastr/toastr.min.css') ?>">
		<link rel="stylesheet" href="<?= site_url('assets/vendor/jquery-confirm/jquery-confirm.css') ?>">


		<!-- Argon Scripts -->
		<!-- Core -->
		<script src="<?= site_url('assets/vendor/jquery/dist/jquery.min.js') ?>"></script>
		<script src="<?= site_url('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
		<script src="<?= site_url('assets/vendor/js-cookie/js.cookie.js') ?>"></script>
		<script src="<?= site_url('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') ?>"></script>
		<script src="<?= site_url('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') ?>"></script>
		<!-- Optional JS -->
		<script src="<?= site_url('assets/vendor/chart.js/dist/Chart.min.js') ?>"></script>
		<script src="<?= site_url('assets/vendor/chart.js/dist/Chart.extension.js') ?>"></script>
		<!-- Argon JS -->

		<script src="<?= site_url('assets/vendor/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
		<script src="<?= site_url('assets/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>

		<script src="<?= site_url('assets/vendor/ladda/spin.min.js') ?>"></script>
		<script src="<?= site_url('assets/vendor/ladda/ladda.min.js') ?>"></script>
		<script src="<?= site_url('assets/vendor/ladda/ladda.jquery.min.js') ?>"></script>

		<script src="<?= site_url('assets/vendor/toastr/toastr.min.js') ?>"></script>
		<script src="<?= site_url('assets/vendor/jquery-confirm/jquery-confirm.js') ?>"></script>

		<script>
			const toastrAlert = () => {
				toastr.options = {
					closeButton: true,
					progressBar: true,
					showMethod: 'slideDown',
					timeOut: 4000
				};
			}

			const confirmation = (message, yesAction = null, cancelAction = null) => {
				$.confirm({
					title: 'Konfirmasi',
					content: message,
					buttons: {
						ya: {
							text: 'Ya',
							btnClass: 'btn-primary',
							keys: ['enter' ],
							action: function(){
								if(yesAction) {
									yesAction()
								}
							}
						},
						batal: {
							text: 'Batal',
							btnClass: 'btn-danger',
							keys: ['esc'],
							action: function(){
								if(cancelAction) {
									cancelAction()
								}
							}
						}
					}
				});
			}

		</script>

		<style type="text/css">
			.dataTables_paginate .page-item.previous a,
			.dataTables_paginate .page-item.next a {
				border-radius: 30px !important;
				width: 100%;
				padding: 10px;
			}

			#nav-menu .nav-item {
				margin-bottom: .25rem;
			}

			#nav-menu a.nav-link.active {
				background: #e6eef7 !important;
			}

			#nav-menu a.nav-link:hover {
				border-radius: .375rem;
				margin-left: .5rem;
				margin-right: .5rem;
				padding-right: 1rem !important;
				padding-left: 1rem !important;
				background: #f6f9fc;
			}
		</style>
	</head>
	<body>
		<!-- Sidenav -->
		<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
			<div class="scrollbar-inner">
				<!-- Brand -->
				<div class="sidenav-header align-items-center mb-3">
					<a class="navbar-brand" href="javascript:void(0)">
						<img src="<?= site_url('assets/img/rsud-logo.png') ?>" class="navbar-brand-img" alt="...">
					</a>
					<h5> Management Aset </h5>
				</div>
				<div class="navbar-inner">
					<!-- Collapse -->
					<div class="collapse navbar-collapse" id="nav-menu">
						<!-- Nav items -->
						<?php $role = $this->session->userdata('user')->role ?>

						<ul class="navbar-nav">
							<li class="nav-item">
								<a class="nav-link" href="<?= base_url('Dashboard') ?>">
								<i class="ni ni-tv-2 text-primary"></i>
								<span class="nav-link-text"> Dashboard </span>
								</a>
							</li>

							<?php if($role == 'admin') : ?>
							<li class="nav-item">
								<a class="nav-link" href="<?= base_url('Barang') ?>">
								<i class="ni ni-box-2 text-orange"></i>
								<span class="nav-link-text"> Barang </span>
								</a>
							</li>

							<li class="nav-item">
								<a class="nav-link" href="<?= base_url('Pengajuan') ?>">
								<i class="ni ni-single-copy-04 text-success"></i>
								<span class="nav-link-text"> Penyetujuan </span>
								</a>
							</li>

							<li class="nav-item">
								<a class="nav-link" href="<?= base_url('Pengajuan/create') ?>">
								<i class="ni ni-single-copy-04 text-primary"></i>
								<span class="nav-link-text"> Buat Pengajuan </span>
								</a>
							</li>
							
							<li class="nav-item">
								<a class="nav-link" href="<?= base_url('Unit_Kerja') ?>">
								<i class="ni ni-shop text-yellow"></i>
								<span class="nav-link-text"> Unit Kerja </span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?= base_url('User') ?>">
								<i class="ni ni-single-02 text-success"></i>
								<span class="nav-link-text"> User </span>
								</a>
							</li>
							<?php endif; ?>

							<?php if($role == 'unit_kerja') : ?>
							<li class="nav-item">
								<a class="nav-link" href="<?= base_url('Barang') ?>">
								<i class="ni ni-box-2 text-orange"></i>
								<span class="nav-link-text"> Barang </span>
								</a>
							</li>

							<li class="nav-item">
								<a class="nav-link" href="<?= base_url('Pengajuan') ?>">
								<i class="ni ni-single-copy-04 text-primary"></i>
								<span class="nav-link-text"> Pengajuan </span>
								</a>
							</li>
							<?php endif; ?>

							<?php if($role == 'logistik') : ?>
							<li class="nav-item">
								<a class="nav-link" href="<?= base_url('Barang') ?>">
								<i class="ni ni-box-2 text-orange"></i>
								<span class="nav-link-text"> Barang </span>
								</a>
							</li>

							<li class="nav-item">
								<a class="nav-link" href="<?= base_url('Pengajuan') ?>">
								<i class="ni ni-single-copy-04 text-success"></i>
								<span class="nav-link-text"> Penerimaan </span>
								</a>
							</li>

							<li class="nav-item">
								<a class="nav-link" href="<?= base_url('Pengajuan/create') ?>">
								<i class="ni ni-single-copy-04 text-primary"></i>
								<span class="nav-link-text"> Buat Pengajuan </span>
								</a>
							</li>
							<?php endif; ?>

						</ul>
					</div>
				</div>
			</div>
		</nav>
		<!-- Main content -->
		<div class="main-content" id="panel">
			<!-- Topnav -->
			<nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
				<div class="container-fluid">
					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="navbar-nav align-items-center  ml-md-auto ">
							<li class="nav-item d-xl-none">
								<!-- Sidenav toggler -->
								<div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
									<div class="sidenav-toggler-inner">
										<i class="sidenav-toggler-line"></i>
										<i class="sidenav-toggler-line"></i>
										<i class="sidenav-toggler-line"></i>
									</div>
								</div>
							</li>
						</ul>
						<ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
							<li class="nav-item dropdown">
								<a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<div class="media align-items-center">
										<span class="avatar avatar-sm rounded-circle bg-">
											<i class="ni ni-single-02"></i>
										<!-- <img alt="Image placeholder" src="<?= site_url('assets/img/theme/team-4.jpg') ?>"> -->
										</span>
										<div class="media-body  ml-2  d-none d-lg-block">
											<span class="mb-0 text-sm  font-weight-bold">
												<?= $this->session->userdata('user')->nama_user ?>
											</span>
										</div>
									</div>
								</a>
								<div class="dropdown-menu  dropdown-menu-right ">
									<div class="dropdown-header noti-title">
										<h6 class="text-overflow m-0"> Welcome! </h6>
									</div>
									<a href="<?= base_url('Setting/ganti_password') ?>" class="dropdown-item">
										<i class="ni ni-settings-gear-65"></i>
										<span> Ganti Password </span>
									</a>
									<div class="dropdown-divider"></div>
									<a href="<?= base_url('Logout') ?>" class="dropdown-item">
										<i class="ni ni-user-run"></i>
										<span> Logout </span>
									</a>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</nav>
			<!-- Header -->
			<!-- Header -->
			<div class="header pb-6">
				<div class="container-fluid">
					<div class="header-body">
						<div class="row align-items-center py-4">
							<div class="col-lg-12">
								<h6 class="h2 d-inline-block mb-0">
									<?= isset($title) ? $title : 'Judul' ?>
								</h6>
								<nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
									<ol class="breadcrumb breadcrumb-links breadcrumb-dark">
										<li class="breadcrumb-item">
											<a href="<?= base_url('Dashboard') ?>"><i class="fas fa-home"></i></a>
										</li>
										<li class="breadcrumb-item">
											<a href="<?= base_url('Dashboard') ?>"> Dashboard </a>
										</li>
										<?php if(isset($breadcrumbs)) { ?>
											<?php $i = 1; ?>
											<?php foreach($breadcrumbs as $breadcrumb) { ?>

												<?php if($i == count($breadcrumbs)) { ?>
												<li class="breadcrumb-item active">
													<?= $breadcrumb['title'] ?>
												</li>
												<?php } else { ?>
												<li class="breadcrumb-item">
													<a href="<?= $breadcrumb['link'] ?>">
														<?= $breadcrumb['title'] ?>
													</a>
												</li>
												<?php } ?>

											<?php } ?>

											<?php $i++; ?>
										<?php } ?>
									</ol>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Page content -->
			<div class="container-fluid mt--6">

				<?php $this->load->view($content) ?>
				
				<!-- Footer -->
				<footer class="footer pt-0">
					<div class="row align-items-center justify-content-lg-between">
						<div class="col-lg-6">
							<div class="copyright text-center text-xl-left text-muted">
								&copy; <?= date('Y') ?> <a href="<?= base_url('') ?>" class="font-weight-bold ml-1" target="_blank"> Nama Mahasiswa </a>
							</div>
						</div>
					</div>
				</footer>
			</div>
			
		</div>

		<script src="<?= site_url('assets/js/argon.js?v=1.2.0') ?>"></script>

		<script type="text/javascript">
			
			const setActiveMenu = () => {
				let isFoundLink = false;
				let path = [];
				window.location.pathname.split("/").forEach(item => {
					if(item !== "") path.push(item);
				})
				let lengthPath = path.length;
				let lengthUse = lengthPath;
				let origin = window.location.origin;

				while(lengthUse >= 1) {
					let link = '';
					for (let i = 0; i < lengthUse; i++) {
						link += `/${path[i]}`;
					}
					$.each($('#nav-menu').find('.nav-link'), (i, elem) => {
						if($(elem).attr('href') == `${origin}${link}` && !isFoundLink) {
							$(elem).addClass('active')
							isFoundLink = true
						}
					})

					if(isFoundLink) break;
					lengthUse--;
				}
			}

			setActiveMenu();

		</script>
	</body>
</html>