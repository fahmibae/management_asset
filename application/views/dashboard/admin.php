<div class="row">
	<div class="col-lg-3">

		<div class="card card-stats">
		<!-- Card body -->
			<div class="card-body" style="min-height: 100px;">
				<div class="row">
					<div class="col">
						<h5 class="card-title text-uppercase text-muted mb-0"> Barang (Kondisi Baik) </h5>
						<span class="h2 font-weight-bold mb-0"> <?= $this->M_Barang->jumlahBarangKondisiBaikByRole() ?> </span>
					</div>
					<div class="col-auto">
						<div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
							<i class="ni ni-box-2"></i>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

	<div class="col-lg-3">

		<div class="card card-stats">
		<!-- Card body -->
			<div class="card-body" style="min-height: 100px;">
				<div class="row">
					<div class="col">
						<h5 class="card-title text-uppercase text-muted mb-0"> Pengajuan (Menunggu) </h5>
						<span class="h2 font-weight-bold mb-0"> <?= $this->M_Pengajuan->jumlahPengajuanMenungguByRole() ?> </span>
					</div>
					<div class="col-auto">
						<div class="icon icon-shape bg-gradient-blue text-white rounded-circle shadow">
							<i class="ni ni-single-copy-04"></i>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>