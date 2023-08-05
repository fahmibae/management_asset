<div class="row">
	<div class="col-lg-8">
		<div class="card">
			<div class="card-header border-0">
				<div class="row align-items-center">
					<div class="col">
						<h3 class="mb-0"> <?= $title ?> </h3>
					</div>
				</div>
			</div>
			<div class="card-body">
				
				<!-- <form id="form"> -->

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
									<th width="100"> Status </th>
								</tr>
							</thead>

							<tbody>
								<?php foreach($this->M_Pengajuan->pengajuanDetails($pengajuan->id) as $detail) : ?>
								<tr>
									<td> <?= $detail->nama_barang ?> </td>
									<td> <?= $detail->qty ?> </td>
									<td> <?= !empty($detail->catatan) ? $detail->catatan : '-' ?> </td>
									<td> <?= $this->M_Pengajuan->statusHtml($detail->status) ?> </td>
								</tr>
								<?php endforeach; ?>
							</tbody>

						</table>
					</div>
					
					<!-- <hr> -->

					<!-- <div class="form-group">
						<button class="btn btn-success" type="submit">
							<i class="ni ni-check-bold"></i> Simpan
						</button>
					</div>

				</form> -->

			</div>
		</div>
	</div>
</div>