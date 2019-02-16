<div class="page-content">
	<!-- BEGIN PAGE CONTENT INNER -->
	<?= $this->session->flashdata('msg') ?>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Detail Pengguna
					</div>
				</div>
				<div class="portlet-body">
					<div class="row">
						<div class="col-md-4">
							<center>
								<?php if (file_exists(FCPATH . 'assets/foto/' . $pengguna->id_pengguna . '.jpg')): ?>
									<img src="<?= base_url('assets/foto/' . $pengguna->id_pengguna . '.jpg') ?>" width="150" height="200">
								<?php else: ?>
									<img src="http://placehold.it/150x200">
								<?php endif; ?>
							</center>
						</div>
						<div class="col-md-8">
							<table class="table table-hover table-bordered table-striped">
								<tbody>
									<tr>
										<td width="20%"><b>Nama</b></td>
										<td><?= $pengguna->nama ?></td>
									</tr>
									<tr>
										<td><b>NIP</b></td>
										<td><?= $pengguna->nip ?></td>
									</tr>
									<tr>
										<td><b>Jenis Kelamin</b></td>
										<td><?= $pengguna->jenis_kelamin ?></td>
									</tr>
									<tr>
										<td><b>Tempat Lahir</b></td>
										<td><?= $pengguna->tempat_lahir ?></td>
									</tr>
									<tr>
										<td><b>Tanggal Lahir</b></td>
										<td><?= $pengguna->tanggal_lahir ?></td>
									</tr>
									<tr>
										<td><b>Role</b></td>
										<td><?= $pengguna->role->role ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>				
				</div>
			</div>
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Statistik
					</div>
				</div>
				<div class="portlet-body">
					<table class="table table-bordered table-striped table-hover">
						<tbody>
							<tr>
								<td width="30%"><b>Jumlah Pengetahuan Tacit</b></td>
								<td><?= count($pengguna->tacit) ?></td>
							</tr>
							<tr>
								<td><b>Jumlah Pengetahuan Eksplisit</b></td>
								<td><?= count($pengguna->eksplisit) ?></td>
							</tr>
							<tr>
								<td><b>Jumlah Pengetahuan Tacit Tervalidasi</b></td>
								<td><?= count($pengguna->tacit_tervalidasi) ?></td>
							</tr>
							<tr>
								<td><b>Jumlah Pengetahuan Eksplisit Tervalidasi</b></td>
								<td><?= count($pengguna->eksplisit_tervalidasi) ?></td>
							</tr>
							<tr>
								<td><b>Jumlah Poin</b></td>
								<td><?= $pengguna->poin ?></td>
							</tr>
						</tbody>
					</table>				
				</div>
			</div>
		</div>
	</div>
	<!-- END PAGE CONTENT INNER -->
</div>