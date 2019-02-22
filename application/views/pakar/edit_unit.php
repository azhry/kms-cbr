<div class="page-content">
	<!-- BEGIN PAGE CONTENT INNER -->
	<?= $this->session->flashdata('msg') ?>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Edit Unit
					</div>
				</div>
				<div class="portlet-body">
					<?= form_open('pakar/edit-unit/' . $id_unit) ?>
					<div class="form-group">
						<label for="kode_bagian">Kode Bagian</label>
						<input type="text" name="kode_bagian" value="<?= $unit->kode_bagian ?>" class="form-control">
					</div>
					<div class="form-group">
						<label for="unit">Nama Unit</label>
						<input type="text" name="unit" value="<?= $unit->unit ?>" class="form-control">
					</div>
					<div class="form-group">
						<label for="desa">Desa</label>
						<input type="text" name="desa" value="<?= $unit->desa ?>" class="form-control">
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