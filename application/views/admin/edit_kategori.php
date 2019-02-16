<div class="page-content">
	<!-- BEGIN PAGE CONTENT INNER -->
	<?= $this->session->flashdata('msg') ?>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Tambah Kategori Pengetahuan
					</div>
				</div>
				<div class="portlet-body">
					<?= form_open('admin/edit-kategori/' . $kategori->id_kategori) ?>
					<div class="form-group">
						<label for="kategori">Kategori</label>
						<input type="text" name="kategori" class="form-control" value="<?= $kategori->kategori ?>">
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