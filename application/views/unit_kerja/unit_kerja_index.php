<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header border-0">
				<div class="row align-items-center">
					<div class="col">
						<h3 class="mb-0"> <?= $title ?> </h3>
					</div>
					<div class="col text-right">
						<a href="<?= base_url('Unit_Kerja/create') ?>" class="btn btn-sm btn-primary">
							<i class="ni ni-fat-add"></i> Tambah 
						</a>
					</div>
				</div>
			</div>

			<div class="card-body">
				<div class="table-responsive">
					<!-- Projects table -->
					<table class="table align-items-center table-flush" id="mainTable">
						<thead class="thead-light">
							<tr>
								<th scope="col" width="50px"> No </th>
								<th scope="col"> Nama Unit Kerja </th>
								<th scope="col"> Kode Unit Kerja </th>
								<th scope="col" width="120px"> Aksi </th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1; ?>
							<?php foreach($this->M_Unit_Kerja->all() as $unitKerja) { ?>
							<tr>
								<td> <?= $i++; ?> </td>
								<td> <?= $unitKerja->nama_unit_kerja ?> </td>
								<td> <?= $unitKerja->kode_unit_kerja ?> </td>
								<td>
									<a href="<?= base_url('Unit_Kerja/edit/'.$unitKerja->id) ?>" class="btn btn-warning btn-sm">
										Edit
									</a>
									<button class="btn btn-danger btn-sm delete" data-href="<?= base_url('Unit_Kerja/delete/'.$unitKerja->id) ?>">
										Hapus
									</button>
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