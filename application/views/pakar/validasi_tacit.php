<div class="page-content">
	<!-- BEGIN PAGE CONTENT INNER -->
	<?= $this->session->flashdata('msg') ?>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Validasi Pengetahuan Tacit
					</div>
				</div>
				<div class="portlet-body">
					<table class="table table-hover table-striped table-bordered">
						<thead>
							<tr>
								<th>No.</th>
								<th>Kategori</th>
								<th>Judul</th>
								<th>Pengguna</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($pengetahuan_tacit as $i => $row): ?>
								<tr>
									<td><?= $i + 1 ?></td>
									<td><?= $row->kategori->kategori ?></td>
									<td><?= $row->judul ?></td>
									<td><?= $row->pengguna->nama ?></td>
									<td><?= $row->status == 'Pending' ? '<button onclick="validasi(' . $row->id_tacit . ', this);" type="button" class="btn red"><i class="fa fa-close"></i> Pending</button>' : '<button onclick="validasi(' . $row->id_tacit . ', this);" type="button" class="btn green"><i class="fa fa-check"></i> Valid</button>' ?></td>
									<td>
										<div class="btn-group">
											<a href="<?= base_url('pakar/detail-pengetahuan-tacit/' . $row->id_tacit) ?>" class="btn blue">
												<i class="fa fa-eye"></i>
											</a>
											<a href="<?= base_url('pakar/edit-pengetahuan-tacit/' . $row->id_tacit) ?>" class="btn green">
												<i class="fa fa-edit"></i>
											</a>
											<a href="<?= base_url('pakar/pengetahuan-tacit/' . $row->id_tacit) ?>" class="btn red">
												<i class="fa fa-trash"></i>
											</a>
										</div>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>					
				</div>
			</div>
		</div>
	</div>
	<!-- END PAGE CONTENT INNER -->
</div>

<script type="text/javascript">
	function validasi(id, obj) {
		$.ajax({
			url: '<?= base_url('pakar/validasi-tacit') ?>',
			type: 'POST',
			data: {
				validate: true,
				id: id
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