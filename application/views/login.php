<!--
	=========================================================
	* Argon Dashboard - v1.2.0
	=========================================================
	* Product Page: https://www.creative-tim.com/product/argon-dashboard
	
	* Copyright  Creative Tim (http://www.creative-tim.com)
	* Coded by www.creative-tim.com
	=========================================================
	* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
	-->
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
		<meta name="author" content="Creative Tim">
		<title> Login </title>
		<!-- Fonts -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
		<!-- Icons -->
		<link rel="stylesheet" href="<?= base_url('assets/vendor/nucleo/css/nucleo.css') ?>" type="text/css">
		<link rel="stylesheet" href="<?= base_url('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') ?>" type="text/css">
		<!-- Argon CSS -->
		<link rel="stylesheet" href="<?= base_url('assets/css/argon.css?v=1.2.0') ?>" type="text/css">

		<link rel="stylesheet" href="<?= site_url('assets/vendor/ladda/ladda-themeless.min.css') ?>">
		<link rel="stylesheet" href="<?= site_url('assets/vendor/toastr/toastr.min.css') ?>">

	</head>
	<body class="bg-default">
		<!-- Main content -->
		<div class="main-content">
			<!-- Header -->
			<div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-9">
				<div class="separator separator-bottom separator-skew zindex-100">
					<svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
						<polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
					</svg>
				</div>
			</div>
			<!-- Page content -->
			<div class="container mt--8 pb-5" style="margin-top: -12rem !important;">
				<div class="row justify-content-center">
					<div class="col-lg-5 col-md-7">
						<div class="card bg-secondary border-0 mb-0">
							<div class="card-body px-lg-5 py-lg-5">
								<figure class="text-center">
									<img src="<?= base_url('assets/img/rsud-logo.png') ?>" style="max-width: 200px; height: auto;">
								</figure>
								<h2 align="center" class="mb-3">
									Pengelolaan Asset <br>
									Login 
								</h2>
								<form id="form">
									<div class="form-group mb-3">
										<div class="input-group input-group-merge input-group-alternative">
											<div class="input-group-prepend">
												<span class="input-group-text"><i class="ni ni-single-02"></i></span>
											</div>
											<input class="form-control" placeholder="Username" type="text" name="username" required>
										</div>
									</div>
									<div class="form-group">
										<div class="input-group input-group-merge input-group-alternative">
											<div class="input-group-prepend">
												<span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
											</div>
											<input class="form-control" placeholder="Password" type="password" name="password" required>
										</div>
									</div>
									<div class="text-center">
										<button type="submit" class="btn btn-primary my-2">
											Sign in
										</button>
									</div>

									<p class="mt-1 mb-0 feedback-message text-danger text-sm" align="center"></p>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<footer class="py-5" id="footer-main">
			<div class="container">
				<div class="row align-items-center justify-content-xl-between">
					<div class="col-xl-6">
						<div class="copyright text-center text-xl-left text-muted">
							&copy; <?= date('Y') ?> <a href="<?= base_url('') ?>" class="font-weight-bold ml-1" target="_blank"> Nama Mahasiswa </a>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<!-- Argon Scripts -->
		<!-- Core -->
		<script src="<?= base_url('assets/vendor/jquery/dist/jquery.min.js') ?>"></script>
		<script src="<?= base_url('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
		<script src="<?= base_url('assets/vendor/js-cookie/js.cookie.js') ?>"></script>
		<script src="<?= base_url('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') ?>"></script>
		<script src="<?= base_url('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') ?>"></script>
		<!-- Argon JS -->
		<script src="<?= base_url('assets/js/argon.js?v=1.2.0') ?>"></script>

		<script src="<?= site_url('assets/vendor/ladda/spin.min.js') ?>"></script>
		<script src="<?= site_url('assets/vendor/ladda/ladda.min.js') ?>"></script>
		<script src="<?= site_url('assets/vendor/ladda/ladda.jquery.min.js') ?>"></script>
		<script src="<?= site_url('assets/vendor/toastr/toastr.min.js') ?>"></script>

		<script type="text/javascript">

			const toastrAlert = () => {
				toastr.options = {
					closeButton: true,
					progressBar: true,
					showMethod: 'slideDown',
					timeOut: 4000
				};
			}
			
			$(function(){

				$form = $('#form');
				$submitBtn = $form.find(`[type="submit"]`).ladda();

				$form.on('submit', function(e){
					e.preventDefault();
					$('.feedback-message').empty();

					let formData = $(this).serialize();
					$submitBtn.ladda('start')

					$.ajax({
						url: `<?= base_url('login') ?>`,
						method: 'post',
						dataType: 'json',
						data: formData
					})
					.done(response => {
						let { message } = response
						toastrAlert();
						toastr.success(message, 'Berhasil');

						setTimeout(() => {
							window.location.href = `<?= base_url('Dashboard'); ?>`
						}, 1000)
					})
					.fail(error => {
						toastrAlert();
						let message = 'Gagal';
						let { responseJSON } = error;
						if(responseJSON.message) {
							message = responseJSON.message;
						}
						toastr.warning(message, 'Peringatan');
						$('.feedback-message').html(message);

						$submitBtn.ladda('stop')
					})
				})

			})

		</script>
	</body>
</html>