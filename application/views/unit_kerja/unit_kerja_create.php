<div class="row">
	<div class="col-lg-6">
		<div class="card">
			<div class="card-header border-0">
				<div class="row align-items-center">
					<div class="col">
						<h3 class="mb-0"> <?= $title ?> </h3>
					</div>
				</div>
			</div>
			<div class="card-body">
				
				<form id="form">
					
					<div class="form-group">
						<label> Nama Unit Kerja </label>
						<input type="text" name="nama_unit_kerja" class="form-control" placeholder="Nama Unit Kerja" required>
					</div>

					<div class="form-group">
						<label> Kode Unit Kerja </label>
						<input type="text" name="kode_unit_kerja" class="form-control" placeholder="Kode Unit Kerja" required>
					</div>

					<div class="form-group">
						<button class="btn btn-success" type="submit">
							<i class="ni ni-check-bold"></i> Simpan
						</button>
					</div>

				</form>

			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	
	$(function(){

		$form = $('#form');
		$submitBtn = $form.find(`[type="submit"]`).ladda();

		$form.find(`[name="nama_unit_kerja"]`).focus();

		$form.on('submit', function(e){
			e.preventDefault();

			let formData = $(this).serialize();
			$submitBtn.ladda('start')

			$.ajax({
				url: `<?= base_url('Unit_Kerja/store') ?>`,
				method: 'post',
				dataType: 'json',
				data: formData
			})
			.done(response => {
				let { message } = response
				toastrAlert();
				toastr.success(message, 'Berhasil');

				setTimeout(() => {
					window.location.href = `<?= base_url('Unit_Kerja'); ?>`
				}, 1000)
			})
			.fail(error => {
				let messageError = 'Gagal';
				if(error.message) {
					messageError = error.message;
				} else {
					if(error.responseJSON) {
						let { responseJSON } = error;
						if(responseJSON.message) messageError = responseJSON.message;
					}
				}
				toastrAlert();
				toastr.warning(messageError, 'Peringatan');

				$submitBtn.ladda('stop')
			})
		})

	})

</script>