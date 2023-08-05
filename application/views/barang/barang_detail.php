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

				<table class="table">
					<tr>
						<th> No Barang </th>
						<td width="30"> : </td>
						<td> <?= $barang->no_barang ?> </td>
					</tr>

					<tr>
						<th> Nama Barang </th>
						<td width="30"> : </td>
						<td> <?= $barang->nama_barang ?> </td>
					</tr>
					<tr>
						<th> Qty </th>
						<td width="30"> : </td>
						<td> <?= $barang->qty ?> </td>
					</tr>
					<tr>
						<th> Kondisi </th>
						<td width="30"> : </td>
						<td> <?= $this->M_Barang->kondisiHtml($barang->kondisi) ?> </td>
					</tr>
					<tr>
						<th> Unit Kerja </th>
						<td width="30"> : </td>
						<td> <?= $this->M_Barang->namaUnitKerja($barang->id) ?> </td>
					</tr>
					<tr>
						<th> Catatan </th>
						<td width="30"> : </td>
						<td> <?= !empty($barang->catatan) ? $barang->catatan : '-' ?> </td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>