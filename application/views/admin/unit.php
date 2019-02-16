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
					<a class="btn green" href="<?= base_url('admin/add-unit') ?>">
						<i class="fa fa-plus"></i> Tambah Data
					</a>
					<br><br>
					<table class="table table-hover table-striped table-bordered">
						<thead>
							<tr>
								<th>No.</th>
								<th>Kode Bagian</th>
								<th>Unit</th>
								<th>Desa</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($unit as $i => $row): ?>
								<tr>
									<td><?= $i + 1 ?></td>
									<td><?= $row->kode_bagian ?></td>
									<td><?= $row->unit ?></td>
									<td><?= $row->desa ?></td>
									<td>
										<div class="btn-group">
											<a href="<?= base_url('admin/edit-unit/' . $row->id_unit) ?>" class="btn green">
												<i class="fa fa-edit"></i>
											</a>
											<a href="<?= base_url('admin/unit/' . $row->id_unit) ?>" class="btn red">
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