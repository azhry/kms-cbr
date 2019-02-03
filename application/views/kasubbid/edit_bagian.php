<div class="page-content">
	<!-- BEGIN PAGE CONTENT INNER -->
	<?= $this->session->flashdata('msg') ?>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Edit Bagian
					</div>
				</div>
				<div class="portlet-body">
					<?= form_open('kasubbid/edit-bagian/' . $id_bagian) ?>
					<div class="form-group">
						<label for="bagian">Bagian</label>
						<input type="text" name="bagian" value="<?= $bagian->bagian ?>" class="form-control">
					</div>
					<div class="form-group">
						<label for="deskripsi">Deskripsi</label>
						<textarea name="deskripsi" class="form-control"><?= $bagian->deskripsi ?></textarea>
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