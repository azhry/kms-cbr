<div class="page-content">
	<!-- BEGIN PAGE CONTENT INNER -->
	<?= $this->session->flashdata('msg') ?>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Edit Pengguna
					</div>
				</div>
				<div class="portlet-body">
					<?= form_open('admin/edit-pengguna/' . $id_pengguna) ?>
					<div class="form-group">
						<label for="nip">NIP</label>
						<input type="text" name="nip" value="<?= $pengguna->nip ?>" class="form-control">
					</div>
					<div class="form-group">
						<label for="nama">Nama</label>
						<input type="text" name="nama" value="<?= $pengguna->nama ?>" class="form-control">
					</div>
					<div class="form-group">
						<label for="jenis_kelamin">Jenis Kelamin</label>
						<select class="form-control" name="jenis_kelamin" required>
							<option value="">Pilih Jenis Kelamin</option>
							<option <?= $pengguna->jenis_kelamin == 'Laki-laki' ? 'selected' : '' ?> value="Laki-laki">Laki-laki</option>
							<option <?= $pengguna->jenis_kelamin == 'Perempuan' ? 'selected' : '' ?> value="Perempuan">Perempuan</option>
						</select>
					</div>
					<div class="form-group">
						<label for="tempat_lahir">Tempat Lahir</label>
						<input type="text" name="tempat_lahir" value="<?= $pengguna->tempat_lahir ?>" class="form-control">
					</div>
					<div class="form-group">
						<label for="tanggal_lahir">Tanggal Lahir</label>
						<input type="date" name="tanggal_lahir" value="<?= $pengguna->tanggal_lahir ?>" class="form-control">
					</div>
					<div class="form-group">
						<label for="id_role">Role</label>
						<?php  
							$opt = [];
							foreach ($role as $row)
							{
								$opt[$row->id_role] = $row->role;
							}

							echo form_dropdown('id_role', $opt, $pengguna->id_role, ['required' => 'required', 'class' => 'form-control']);
						?>
					</div>
					<hr>
					<h3>Reset Password</h3>
					<div class="form-group">
						<label for="password">Password Baru</label>
						<input type="password" name="password" class="form-control">
					</div>
					<div class="form-group">
						<label for="rpassword">Konfirmasi Password</label>
						<input type="password" name="rpassword" class="form-control">
					</div>
					<hr>
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