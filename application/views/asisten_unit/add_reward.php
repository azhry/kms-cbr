<div class="page-content">
	<!-- BEGIN PAGE CONTENT INNER -->
	<?= $this->session->flashdata('msg') ?>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Tambah Reward
					</div>
				</div>
				<div class="portlet-body">
					<?= form_open('asisten-unit/add-reward') ?>
					<div class="form-group">
						<label for="reward">Reward</label>
						<input type="text" name="reward" class="form-control">
					</div>
					<div class="form-group">
						<label for="poin">Poin</label>
						<input type="number" name="poin" class="form-control">
					</div>
					<div class="form-group">
						<label for="keterangan">Keterangan</label>
						<textarea name="keterangan" class="form-control"></textarea>
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