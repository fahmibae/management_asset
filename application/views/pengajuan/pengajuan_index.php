<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header border-0">
				<div class="row align-items-center">
					<div class="col">
						<h3 class="mb-0"> <?= $title ?> </h3>
					</div>
					<?php if($this->session->userdata('user')->role == 'unit_kerja') : ?>
					<div class="col text-right">
						<a href="<?= base_url('Pengajuan/create') ?>" class="btn btn-sm btn-primary">
							<i class="ni ni-fat-add"></i> Tambah 
						</a>
					</div>
					<?php endif; ?>
				</div>
			</div>

			<div class="card-body">
				<div class="table-responsive">
					<!-- Projects table -->
					<table class="table align-items-center table-flush" id="mainTable">
						<thead class="thead-light">
							<tr>
								<th scope="col" width="50px"> No </th>
								<th scope="col"> No Pengajuan </th>
								<th scope="col"> Tgl Pengajuan </th>
								<th scope="col"> Unit Kerja </th>
								<th scope="col"> Status </th>
								<th scope="col" width="120px"> Aksi </th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1; $role = $this->session->userdata('user')->role; ?>
							<?php foreach($this->M_Pengajuan->allByRole() as $pengajuan) { ?>
							<tr>
								<td> <?= $i++; ?> </td>
								<td> <?= $pengajuan->no_pengajuan ?> </td>
								<td> <?= $pengajuan->tgl_pengajuan ?> </td>
								<td> <?= $this->M_Pengajuan->namaUnitKerja($pengajuan->id) ?> </td>
								<td> <?= $this->M_Pengajuan->statusHtml($pengajuan->status) ?> </td>
								<td>
									<a href="<?= base_url('Pengajuan/detail/'.$pengajuan->id) ?>" class="btn btn-primary btn-sm">
										Detail
									</a>
									<?php if($role == 'unit_kerja' && $pengajuan->status == 'menunggu') : ?>
									<a href="<?= base_url('Pengajuan/edit/'.$pengajuan->id) ?>" class="btn btn-warning btn-sm">
										Edit
									</a>
									<button class="btn btn-danger btn-sm delete" data-href="<?= base_url('Pengajuan/delete/'.$pengajuan->id) ?>">
										Hapus
									</button>
									<?php endif; ?>
									<?php if($role == 'admin' && $pengajuan->status == 'menunggu') : ?>
									<a href="<?= base_url('Pengajuan/penyetujuan/'.$pengajuan->id) ?>" class="btn btn-success btn-sm">
										Penyetujuan
									</a>
									<?php endif; ?>
									<?php if($role == 'logistik' && $pengajuan->status == 'disetujui') : ?>
									<a href="<?= base_url('Pengajuan/penerimaan/'.$pengajuan->id) ?>" class="btn btn-success btn-sm">
										Penerimaan
									</a>
									<?php endif; ?>

								</td>
							</tr>

							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	
	$(function(){

		$('#mainTable').DataTable();

		$('.delete').on('click', function(){
			let { href } = $(this).data();

			confirmation('Yakin ingin dihapus', () => {
				window.location.href = href;
			})
		})
	})

</script>