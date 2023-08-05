<div class="row">
	<div class="col-lg-12">
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

					<table class="table">
						<tr>
							<th> No Pengajuan </th>
							<td width="30"> : </td>
							<td> <?= $pengajuan->no_pengajuan ?> </td>
						</tr>

						<tr>
							<th> Tanggal Pengajuan </th>
							<td width="30"> : </td>
							<td> <?= $pengajuan->tgl_pengajuan ?> </td>
						</tr>

						<tr>
							<th> Unit Kerja </th>
							<td width="30"> : </td>
							<td> <?= $this->M_Pengajuan->namaUnitKerja($pengajuan->id) ?> </td>
						</tr>

						<tr>
							<th> Dibuat Oleh </th>
							<td width="30"> : </td>
							<td> <?= $this->M_Pengajuan->namaUser($pengajuan->id) ?> </td>
						</tr>

						<tr>
							<th> Status </th>
							<td width="30"> : </td>
							<td> <?= ucfirst($pengajuan->status) ?> </td>
						</tr>

						<?php if(!empty($pengajuan->tanda_terima)) : ?>
						<tr>
							<th> Tanda Terima </th>
							<td width="30"> : </td>
							<td>
								<a href="<?= base_url('uploads/'.$pengajuan->tanda_terima) ?>" target="_blank"> Klik Disini </a>
							</td>
						</tr>
						<?php endif; ?>
					</table>

					<hr>

					<h4 class="mb-3" align="center"> Daftar Barang </h4>

					<div class="table-responsive">
						<table class="table table-sm table-striped table-hover">
							
							<thead>
								<tr>
									<th> Nama Barang </th>
									<th> Qty </th>
									<th> Catatan </th>
									<th width="100"> Setuju </th>
								</tr>
							</thead>

							<tbody>
								<?php foreach($this->M_Pengajuan->pengajuanDetails($pengajuan->id) as $detail) : ?>
								<tr>
									<td> <?= $detail->nama_barang ?> </td>
									<td> <?= $detail->qty ?> </td>
									<td>
										<input type="text" name="details[catatan][]" class="form-control p-2" placeholder="Catatan (Opsional)">
									</td>
									<td align="center">
										<input type="checkbox" name="details[setuju][]" value="<?= $detail->id ?>">
									</td>
								</tr>
								<?php endforeach; ?>
							</tbody>

						</table>
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

		$form.on('submit', function(e){
			e.preventDefault();

			let formData = $(this).serialize();
			$submitBtn.ladda('start')

			$.ajax({
				url: `<?= base_url('Pengajuan/save_penyetujuan/'.$pengajuan->id) ?>`,
				method: 'post',
				dataType: 'json',
				data: formData
			})
			.done(response => {
				let { message } = response
				toastrAlert();
				toastr.success(message, 'Berhasil');

				setTimeout(() => {
					window.location.href = `<?= base_url('Pengajuan'); ?>`
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