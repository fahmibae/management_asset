<!DOCTYPE html>
<html>
<head>
	<title></title>

	<style type="text/css">
		
		.table {
			width: 100%;
			border-collapse: collapse;
		}

		.table td,
		.table th {
			padding: 3px 5px;
			border: 1px solid black;
		}

	</style>
</head>
<body>

	<h2 align="center"> Laporan Barang </h2>
	<h5 align="center"> <?= $kondisi ?> </h5>

	<br>

	<table class="table">
		<thead>
			<tr>
				<th width="20"> No </th>
				<th> No Barang </th>
				<th> Nama Barang </th>
				<th> Qty </th>
				<th> Kondisi </th>
				<th> Unit Kerja </th>
				<th> Catatan </th>
			</tr>
		</thead>

		<tbody>
			<?php $i = 1; ?>
			<?php foreach($barang as $b) : ?>
			<tr>
				<td align="center"> <?= $i++; ?> </td>
				<td> <?= $b->no_barang ?> </td>
				<td> <?= $b->nama_barang ?> </td>
				<td> <?= $b->qty ?> </td>
				<td> <?= ucfirst($b->kondisi) ?> </td>
				<td> <?= $this->M_Barang->namaUnitKerja($b->id) ?> </td>
				<td> <?= $b->catatan ?> </td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

</body>
</html>