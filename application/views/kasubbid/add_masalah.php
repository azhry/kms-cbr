<div class="page-content">
	<!-- BEGIN PAGE CONTENT INNER -->
	<?= $this->session->flashdata('msg') ?>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Tambah Masalah
					</div>
				</div>
				<div class="portlet-body">
					<?= form_open('kasubbid/add-masalah') ?>
					<div class="form-group">
						<label for="judul">Judul Masalah</label>
						<input type="text" name="judul" class="form-control">
					</div>
					<div class="form-group">
						<label for="bagian">Bagian</label>
						<select class="form-control" name="id_bagian" required>
							<option value="">Pilih Bagian</option>
							<?php foreach ($bagian as $row): ?>
								<option value="<?= $row->id_bagian ?>"><?= $row->bagian ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group">
						<button type="button" onclick="tambah_gejala();" class="btn blue btn-xs">
							<i class="fa fa-plus"></i> Tambah Gejala
						</button>
					</div>
					<div id="list-gejala">
						<div class="form-group">
							<select class="form-control" name="id_gejala[]" required>
								<option value="">Pilih Gejala</option>
								<?php foreach ($gejala as $row): ?>
									<option value="<?= $row->id_gejala ?>"><?= $row->gejala ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<button type="button" onclick="tambah_solusi();" class="btn blue btn-xs">
							<i class="fa fa-plus"></i> Tambah Solusi
						</button>
					</div>
					<div id="list-solusi">
						<div class="form-group">
							<label for="solusi">Solusi</label>
							<input type="text" name="solusi[]" class="form-control">
						</div>
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

<script type="text/javascript">
	function tambah_gejala() {
		let html = '<div class="form-group">' +
							'<select class="form-control" name="id_gejala[]" required>' +
								'<option value="">Pilih Gejala</option>';

		<?php foreach ($gejala as $row): ?>
		html += '<option value="<?= $row->id_gejala ?>"><?= $row->gejala ?></option>';
		<?php endforeach; ?>

		html += '</select>';
		$('#list-gejala').append(html);
	}

	function tambah_solusi() {
		let html = '<div class="form-group">' +
							'<label for="solusi">Solusi</label>' +
							'<input type="text" name="solusi[]" class="form-control">' +
						'</div>';
		$('#list-solusi').append(html);
	}
</script>