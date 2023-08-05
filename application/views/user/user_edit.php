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
						<label> Nama User </label>
						<input type="text" name="nama_user" class="form-control" placeholder="Nama User" value="<?= $user->nama_user ?>" required>
					</div>

					<div class="form-group">
						<label> Username </label>
						<input type="text" name="username" class="form-control" placeholder="Username" value="<?= $user->username ?>" required>
					</div>

					<div class="form-group">
						<label> Password </label>
						<input type="password" name="password" class="form-control" placeholder="Isi Jika Ingin Ganti Password">
					</div>

					<div class="form-group">
						<label> Role </label>
						<select class="form-control" name="role" required>
							<option value="" selected disabled> - Pilih Role -</option>
							<option value="admin"> Administrator </option>
							<option value="logistik"> Logistik </option>
							<option value="unit_kerja"> Unit Kerja </option>
						</select>
					</div>

					<div class="form-group">
						<label> Unit Kerja </label>
						<select class="form-control" name="id_unit_kerja" required>
							<option value="" selected disabled> - Pilih Unit Kerja -</option>
							<?php foreach($this->M_Unit_Kerja->all() as $unitKerja) { ?>
							<option value="<?= $unitKerja->id ?>"> <?= $unitKerja->nama_unit_kerja ?> </option>
							<?php } ?>
						</select>
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

		$form.find(`[name="nama_user"]`).focus();

		$form.on('submit', function(e){
			e.preventDefault();

			let formData = $(this).serialize();
			$submitBtn.ladda('start')

			$.ajax({
				url: `<?= base_url('User/update/'.$user->id) ?>`,
				method: 'post',
				dataType: 'json',
				data: formData
			})
			.done(response => {
				let { message } = response
				toastrAlert();
				toastr.success(message, 'Berhasil');

				setTimeout(() => {
					window.location.href = `<?= base_url('User'); ?>`
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

		$form.find(`[name="role"]`).on('change', function(){
			let role = $(this).val();

			if(role == 'unit_kerja') {
				$('.unit_kerja').html($('#unit_kerja_input').html())
			} else {
				$('.unit_kerja').html('')
			}
		})

		$form.find(`[name="role"]`).val(`<?= $user->role ?>`)
		$form.find(`[name="id_unit_kerja"]`).val(`<?= $user->id_unit_kerja ?>`)

	})

</script>