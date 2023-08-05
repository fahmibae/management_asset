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
						<label> Barang </label>
						<input type="text" class="form-control" value="<?= $barang->no_barang ?> - <?= $barang->nama_barang ?>" readonly>
					</div>

					<div class="form-group">
						<label> Catatan </label>
						<textarea class="form-control" rows="2" name="catatan" placeholder="Catatan" required></textarea>
					</div>

					<hr>

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

		$form.find(`[name="catatan"]`).focus();

		$form.on('submit', function(e){
			e.preventDefault();

			let formData = $(this).serialize();
			$submitBtn.ladda('start')

			$.ajax({
				url: `<?= base_url('Barang/save_rusak/'.$barang->id) ?>`,
				method: 'post',
				dataType: 'json',
				data: formData
			})
			.done(response => {
				let { message } = response
				toastrAlert();
				toastr.success(message, 'Berhasil');

				setTimeout(() => {
					window.location.href = `<?= base_url('Barang'); ?>`
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