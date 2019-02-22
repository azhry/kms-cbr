<div class="page-content">
	<!-- BEGIN PAGE CONTENT INNER -->
	<?= $this->session->flashdata('msg') ?>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Profil Anda
					</div>
				</div>
				<div class="portlet-body">
					<ul class="nav nav-tabs">
						<li class="active">
							<a href="#tab_1_1" data-toggle="tab">
							Profil </a>
						</li>
						<li>
							<a href="#tab_1_2" data-toggle="tab">
							Pengetahuan Tacit Saya </a>
						</li>
						<li>
							<a href="#tab_1_3" data-toggle="tab">
							Pengetahuan Eksplisit Saya </a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane fade active in" id="tab_1_1">
							<?= form_open_multipart('unit/profile') ?>
							<div class="form-group">
								<label for="foto">Foto</label>
								<center>
									<?php if (file_exists(FCPATH . 'assets/foto/' . $data_pengguna->id_pengguna . '.jpg')): ?>
										<img src="<?= base_url('assets/foto/' . $data_pengguna->id_pengguna . '.jpg') ?>" width="200" height="200">
									<?php else: ?>
										<img src="http://placehold.it/200">
									<?php endif; ?>
								</center>
								<input type="file" name="foto" accept="image/*" class="form-control">
							</div>
							<div class="form-group">
								<label for="nip">NIP</label>
								<input type="text" readonly name="nip" value="<?= $data_pengguna->nip ?>" class="form-control">
							</div>
							<div class="form-group">
								<label for="nama">Nama</label>
								<input type="text" name="nama" value="<?= $data_pengguna->nama ?>" class="form-control">
							</div>
							<div class="form-group">
								<label for="jenis_kelamin">Jenis Kelamin</label>
								<select name="jenis_kelamin" class="form-control">
									<option <?= $data_pengguna->jenis_kelamin == 'Laki-laki' ? 'selected' : '' ?> value="Laki-laki">Laki-laki</option>
									<option <?= $data_pengguna->jenis_kelamin == 'Perempuan' ? 'selected' : '' ?> value="Perempuan">Perempuan</option>
								</select>
							</div>
							<div class="form-group">
								<label for="tempat_lahir">Tempat Lahir</label>
								<input type="text" name="tempat_lahir" value="<?= $data_pengguna->tempat_lahir ?>" class="form-control">
							</div>
							<div class="form-group">
								<label for="tanggal_lahir">Tanggal Lahir</label>
								<input type="date" name="tanggal_lahir" value="<?= $data_pengguna->tanggal_lahir ?>" class="form-control">
							</div>
							<div class="form-group">
								<label for="password">Password</label>
								<input type="password" name="password" class="form-control">
							</div>
							<div class="form-group">
								<label for="rpassword">Konfirmasi Password</label>
								<input type="password" name="rpassword" class="form-control">
							</div>
							<div class="form-group">
								<input type="submit" name="submit" value="Simpan" class="btn green">
							</div>
							<?= form_close() ?>	
						</div>
						<div class="tab-pane fade" id="tab_1_2">
							<table class="table table-hover table-striped table-bordered">
								<thead>
									<tr>
										<th>No.</th>
										<th>Kategori</th>
										<th>Judul</th>
										<th>Pengguna</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($pengetahuan_tacit as $i => $row): ?>
										<tr>
											<td><?= $i + 1 ?></td>
											<td><?= $row->kategori->kategori ?></td>
											<td><?= $row->judul ?></td>
											<td><?= $row->pengguna->nama ?></td>
											<td><?= $row->status ?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
						<div class="tab-pane fade" id="tab_1_3">
							<table class="table table-hover table-striped table-bordered">
								<thead>
									<tr>
										<th>No.</th>
										<th>Kategori</th>
										<th>Judul</th>
										<th>Pengguna</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($pengetahuan_eksplisit as $i => $row): ?>
										<tr>
											<td><?= $i + 1 ?></td>
											<td><?= $row->kategori->kategori ?></td>
											<td><?= $row->judul ?></td>
											<td><?= $row->pengguna->nama ?></td>
											<td><?= $row->status ?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
							
				</div>
			</div>
		</div>
	</div>
	<!-- END PAGE CONTENT INNER -->
</div>