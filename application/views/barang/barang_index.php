<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header border-0">
				<div class="row align-items-center">
					<div class="col">
						<h3 class="mb-0"> <?= $title ?> </h3>
					</div>
					<div class="btn-group" role="group">
						<button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Export PDF
						</button>
						<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
							<a class="dropdown-item" href="<?= base_url('Barang/pdf/all') ?>" target="_blank"> Semua Barang </a>
							<a class="dropdown-item" href="<?= base_url('Barang/pdf/baik') ?>" target="_blank"> Barang Kondisi Baik </a>
							<a class="dropdown-item" href="<?= base_url('Barang/pdf/buruk') ?>" target="_blank"> Barang Kondisi Buruk </a>
						</div>
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
								<th scope="col"> No Barang </th>
								<th scope="col"> Nama Barang </th>
								<th scope="col"> Qty </th>
								<th scope="col"> Kondisi </th>
								<th scope="col"> Unit Kerja </th>
								<th scope="col" width="120px"> Aksi </th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1; ?>
							<?php foreach($this->M_Barang->allByRole() as $barang) { ?>
							<tr>
								<td> <?= $i++; ?> </td>
								<td> <?= $barang->no_barang ?> </td>
								<td> <?= $barang->nama_barang ?> </td>
								<td> <?= $barang->qty ?> </td>
								<td> <?= $this->M_Barang->kondisiHtml($barang->kondisi) ?> </td>
								<td> <?= $this->M_Barang->namaUnitKerja($barang->id) ?> </td>
								<td>
									<a class="btn btn-primary btn-sm" href="<?= base_url('Barang/detail/'.$barang->id) ?>">
										Detail
									</a>
									<?php if($barang->kondisi == 'baik' && $this->session->userdata('user')->id_unit_kerja == $barang->id_unit_kerja) : ?>
									<a class="btn btn-danger btn-sm" href="<?= base_url('Barang/rusak/'.$barang->id) ?>">
										Nyatakan Rusak
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