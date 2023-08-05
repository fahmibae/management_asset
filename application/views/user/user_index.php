<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header border-0">
				<div class="row align-items-center">
					<div class="col">
						<h3 class="mb-0"> <?= $title ?> </h3>
					</div>
					<div class="col text-right">
						<a href="<?= base_url('User/create') ?>" class="btn btn-sm btn-primary">
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
								<th scope="col"> Nama User </th>
								<th scope="col"> Username </th>
								<th scope="col"> Role </th>
								<th scope="col"> Unit Kerja </th>
								<th scope="col" width="120px"> Aksi </th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1; ?>
							<?php foreach($this->M_User->all() as $user) { ?>
							<tr>
								<td> <?= $i++; ?> </td>
								<td> <?= $user->nama_user ?> </td>
								<td> <?= $user->username ?> </td>
								<td> <?= $this->M_User->namaRole($user->role) ?> </td>
								<td> <?= $this->M_User->namaUnitKerja($user->id) ?> </td>
								<td>
									<a href="<?= base_url('User/edit/'.$user->id) ?>" class="btn btn-warning btn-sm">
										Edit
									</a>
									<button class="btn btn-danger btn-sm delete" data-href="<?= base_url('User/delete/'.$user->id) ?>">
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