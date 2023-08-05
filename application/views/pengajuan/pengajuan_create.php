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

					<div class="row">
						
						<div class="col-lg-6">
							<div class="form-group">
								<label> No Pengajuan </label>
								<input type="text" class="form-control" placeholder="No Pengajuan" value="<?= $this->M_Pengajuan->generateNoPengajuan($this->M_User->authKodeUnitKerja()) ?>" readonly>
							</div>

							<div class="form-group">
								<label> Tanggal Pengajuan </label>
								<input type="date" name="tgl_pengajuan" class="form-control" value="<?= date('Y-m-d') ?>" required>
							</div>
						</div>

						<div class="col-lg-6">
							<div class="form-group">
								<label> Unit Kerja </label>
								<input type="text" class="form-control" placeholder="Unit Kerja" value="<?= $this->M_User->authNamaUnitKerja() ?>" readonly>
							</div>

							<div class="form-group">
								<label> Dibuat Oleh </label>
								<input type="text" class="form-control" value="<?= $this->session->userdata('user')->nama_user ?>" readonly>
							</div>
						</div>

					</div>

					<hr>

					<div class="table-responsive">
						<table class="table">
							
							<thead>
								<tr>
									<th> Nama Barang </th>
									<th> Qty </th>
									<th width="100"> Aksi </th>
								</tr>
							</thead>

							<tbody id="list-item">
								
							</tbody>

							<tfoot>
								<tr>
									<td colspan="3">
										<button type="button" class="btn btn-success btn-sm add">
											<i class="ni ni-fat-add"></i> Tambah
										</button>
									</td>
								</tr>
							</tfoot>

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

		$form.find(`[name="nama_unit_kerja"]`).focus();

		$form.on('submit', function(e){
			e.preventDefault();

			let amountOfItem = $('#list-item').find('.detail-item').length;
			if(amountOfItem == 0) {
				toastrAlert();
				toastr.warning('Masukkan minimal 1 barang', 'Peringatan');
				return;
			}

			let formData = $(this).serialize();
			$submitBtn.ladda('start')

			$.ajax({
				url: `<?= base_url('Pengajuan/store') ?>`,
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


		const renderEvent = () => {
			$('.delete').off('click')
			$('.delete').on('click', function(){

				$(this).parents('tr').remove();

			})
		}


		const addDetail = (data = null) => {
			let namaBarang = data ? data.nama_barang : '';
			let qty = data ? data.qty : 0;

			let html = $('#detailTemplate').text()
						.replaceAll(/{nama_barang}/g, namaBarang)
						.replaceAll(/{qty}/g, qty)

			$('#list-item').append(html);
			renderEvent();
		}

		$('.add').on('click', function(){
			addDetail();
		})


		addDetail();
		renderEvent();

	})

</script>


<script type="text/html" id="detailTemplate">
	<tr class="detail-item">
		<td>
			<input type="text" name="details[nama_barang][]" class="form-control" placeholder="Nama Barang" value="{nama_barang}" required>
		</td>
		<td>
			<input type="number" name="details[qty][]" class="form-control" placeholder="Qty" min="1" value="{qty}" required>
		</td>
		<td>
			<button class="btn btn-sm btn-danger delete" type="button">
				<i class="ni ni-fat-delete"></i>
			</button>
		</td>
	</tr>
</script>