<div class="page-content">
	<!-- BEGIN PAGE CONTENT INNER -->
	<?= $this->session->flashdata('msg') ?>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Bagian
					</div>
				</div>
				<div class="portlet-body">
					<a class="btn green" href="<?= base_url('kasubbid/add-bagian') ?>">
						<i class="fa fa-plus"></i> Tambah Data
					</a>
					<br><br>
					<table class="table table-hover table-striped table-bordered">
						<thead>
							<tr>
								<th>No.</th>
								<th>Bagian</th>
								<th>Deskripsi</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($bagian as $i => $row): ?>
								<tr>
									<td><?= $i + 1 ?></td>
									<td><?= $row->bagian ?></td>
									<td><?= $row->deskripsi ?></td>
									<td>
										<div class="btn-group">
											<a href="<?= base_url('kasubbid/edit-bagian/' . $row->id_bagian) ?>" class="btn green">
												<i class="fa fa-edit"></i>
											</a>
											<a href="<?= base_url('kasubbid/bagian/' . $row->id_bagian) ?>" class="btn red">
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