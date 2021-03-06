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
								echo '<div class="col-md-6">';
								echo '<input type="text" name="solusi[]" value="' . $solusi->solusi . '" class="form-control">';
								echo '</div>';
								echo '<div class="col-md-3">';
								echo $solusi->status == 'Pending' ? '<button onclick="validasi_solusi(' . $solusi->id_solusi . ', this);" type="button" class="btn red"><i class="fa fa-close"></i> Pending</button>' : '<button onclick="validasi_solusi(' . $solusi->id_solusi . ', this);" type="button" class="btn green"><i class="fa fa-check"></i> Valid</button>';
								echo '</div>';
								echo '<div class="col-md-3">';
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
	function tambah_solusi() {
		let html = '<div class="form-group">' +
						'<label for="solusi">Solusi</label>' +
						'<div class="row">' +
							'<div class="col-md-6">' +
								'<input type="text" name="solusi[]" class="form-control">' +
							'</div>' +
							'<div class="col-md-3">' +
								'<button type="button" onclick="$(this).parent().parent().parent().remove();" class="btn red btn-xs"><i class="fa fa-trash"></i></button>' +
							'</div>' +
						'</div>' +
					'</div>';
		$('#list-solusi').append(html);
	}

	function validasi_solusi(id_solusi, obj) {
		$.ajax({
			url: '<?= base_url('pakar/ubah-solusi/' . $id_masalah) ?>',
			type: 'POST',
			data: {
				validasi_solusi: true,
				id_solusi: id_solusi
			},
			success: function(response) {
				const json = $.parseJSON(response);
				if (json.status == 'Pending') {
					$(obj).removeClass('green')
							.addClass('red')
							.html('<i class="fa fa-close"></i> Pending');
				} else {
					$(obj).removeClass('red')
							.addClass('green')
							.html('<i class="fa fa-check"></i> Valid');
				}
			},
			error: function(err) { console.log(err.responseText); }
		});
		return false;
	}
</script>