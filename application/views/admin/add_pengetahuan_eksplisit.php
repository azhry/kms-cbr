<div class="page-content">
	<!-- BEGIN PAGE CONTENT INNER -->
	<?= $this->session->flashdata('msg') ?>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Tambah Pengetahuan Eksplisit
					</div>
				</div>
				<div class="portlet-body">
					<?= form_open_multipart('admin/add-pengetahuan-eksplisit') ?>
					<div class="form-group">
						<label for="judul">Judul</label>
						<input type="text" name="judul" class="form-control">
					</div>
					<div class="form-group">
						<label for="id_kategori">Kategori</label>
						<select class="form-control" required name="id_kategori">
							<option value="">Pilih Kategori</option>
							<?php foreach ($kategori as $row): ?>
								<option value="<?= $row->id_kategori ?>"><?= $row->kategori ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group">
						<label for="keterangan">Keterangan</label>
						<textarea class="form-control" name="keterangan"></textarea>
					</div>
					<div class="form-group">
						<label for="referensi">Referensi</label>
						<input type="text" name="referensi" class="form-control">
					</div>
					<div class="form-group">
						<label for="lampiran">Lampiran</label>
						<input type="file" name="lampiran" class="form-control">
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