<div class="page-content">
	<!-- BEGIN PAGE CONTENT INNER -->
	<?= $this->session->flashdata('msg') ?>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Tambah Pengguna
					</div>
				</div>
				<div class="portlet-body">
					<?= form_open('kasubbid/add-pengguna') ?>
					<div class="form-group">
						<label for="nip">NIP</label>
						<input type="text" name="nip" class="form-control">
					</div>
					<div class="form-group">
						<label for="nama">Nama</label>
						<input type="text" name="nama" class="form-control">
					</div>
					<div class="form-group">
						<label for="jenis_kelamin">Jenis Kelamin</label>
						<select class="form-control" name="jenis_kelamin" required>
							<option value="">Pilih Jenis Kelamin</option>
							<option value="Laki-laki">Laki-laki</option>
							<option value="Perempuan">Perempuan</option>
						</select>
					</div>
					<div class="form-group">
						<label for="tempat_lahir">Tempat Lahir</label>
						<input type="text" name="tempat_lahir" class="form-control">
					</div>
					<div class="form-group">
						<label for="tanggal_lahir">Tanggal Lahir</label>
						<input type="date" name="tanggal_lahir" class="form-control">
					</div>
					<div class="form-group">
						<label for="id_role">Role</label>
						<select class="form-control" name="id_role" required>
							<option value="">Pilih Role</option>
							<?php foreach ($role as $row): ?>
							<option value="<?= $row->id_role ?>"><?= $row->role ?></option>
							<?php endforeach; ?>
						</select>
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
						<input type="submit" name="submit" class="btn green">
					</div>
					<?= form_close() ?>			
				</div>
			</div>
		</div>
	</div>
	<!-- END PAGE CONTENT INNER -->
</div>