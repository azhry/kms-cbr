<div class="page-content">
	<!-- BEGIN PAGE CONTENT INNER -->
	<?= $this->session->flashdata('msg') ?>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Ubah Solusi
					</div>
				</div>
				<div class="portlet-body">
					<?= form_open('pakar/ubah-solusi/' . $id_masalah) ?>
					<div class="form-group">
						<button type="button" onclick="tambah_solusi();" class="btn blue btn-xs">
							<i class="fa fa-plus"></i> Tambah Solusi
						</button>
					</div>
					<div id="list-solusi">
						<?php  
							foreach ($masalah->solusi as $solusi)
							{
								echo '<div class="form-group">';
								echo '<label for="solusi">Solusi</label>';
								echo '<div class="row">';
								echo '<div class="col-md-8">';
								echo '<input type="text" name="solusi[]" value="' . $solusi->solusi . '" class="form-control">';
								echo '</div>';
								echo '<div class="col-md-4">';
								echo '<button type="button" onclick="$(this).parent().parent().parent().remove();" class="btn red btn-xs"><i class="fa fa-trash"></i></button>';
								echo '</div>';
								echo '</div>';
								echo '</div>';
							}
						?>
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