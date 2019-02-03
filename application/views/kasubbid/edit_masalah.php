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
					<?= form_open('kasubbid/edit-masalah/' . $id_masalah) ?>
					<div class="form-group">
						<label for="judul">Judul Masalah</label>
						<input type="text" name="judul" value="<?= $masalah->judul ?>" class="form-control">
					</div>
					<div class="form-group">
						<label for="bagian">Bagian</label>
						<?php  
							$opt = [];
							foreach ($bagian as $row)
							{
								$opt[$row->id_bagian] = $row->bagian;
							}

							echo form_dropdown('id_bagian', $opt, $masalah->id_bagian, ['class' => 'form-control', 'required' => 'required']);
						?>
					</div>
					<div class="form-group">
						<button type="button" onclick="tambah_gejala();" class="btn blue btn-xs">
							<i class="fa fa-plus"></i> Tambah Gejala
						</button>
					</div>
					<div id="list-gejala">
						<?php  
							$opt = [];
							foreach ($gejala as $row)
							{
								$opt[$row->id_gejala] = $row->gejala;
							}

							foreach ($masalah->gejala as $g)
							{
								echo '<div class="form-group">';
								echo '<div class="row">';
								echo '<div class="col-md-8">';
								echo form_dropdown('id_gejala[]', $opt, $g->id_gejala, ['class' => 'form-control', 'required' => 'required']);
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