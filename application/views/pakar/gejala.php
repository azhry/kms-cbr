<div class="page-content">
	<!-- BEGIN PAGE CONTENT INNER -->
	<?= $this->session->flashdata('msg') ?>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Gejala
					</div>
				</div>
				<div class="portlet-body">
					<a class="btn green" href="<?= base_url('pakar/add-gejala') ?>">
						<i class="fa fa-plus"></i> Tambah Data
					</a>
					<br><br>
					<table class="table table-hover table-striped table-bordered">
						<thead>
							<tr>
								<th>No.</th>
								<th>Gejala</th>
								<th>Representasi</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($gejala as $i => $row): ?>
								<tr>
									<td><?= $i + 1 ?></td>
									<td><?= $row->gejala ?></td>
									<td><?= $row->representasi ?></td>
									<td>
										<div class="btn-group">
											<a href="<?= base_url('pakar/edit-gejala/' . $row->id_gejala) ?>" class="btn green">
												<i class="fa fa-edit"></i>
											</a>
											<a href="<?= base_url('pakar/gejala/' . $row->id_gejala) ?>" class="btn red">
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