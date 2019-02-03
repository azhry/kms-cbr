<div class="page-content">
	<!-- BEGIN PAGE CONTENT INNER -->
	<?= $this->session->flashdata('msg') ?>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Edit Gejala
					</div>
				</div>
				<div class="portlet-body">
					<?= form_open('kasubbid/edit-gejala/' . $id_gejala) ?>
					<div class="form-group">
						<label for="gejala">Gejala</label>
						<input type="text" name="gejala" value="<?= $gejala->gejala ?>" class="form-control">
					</div>
					<div class="form-group">
						<label for="representasi">Representasi</label>
						<input type="number" name="representasi" value="<?= $gejala->representasi ?>" class="form-control">
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