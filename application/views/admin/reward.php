<div class="page-content">
	<!-- BEGIN PAGE CONTENT INNER -->
	<?= $this->session->flashdata('msg') ?>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Reward
					</div>
				</div>
				<div class="portlet-body">
					<a class="btn green" href="<?= base_url('admin/add-reward') ?>">
						<i class="fa fa-plus"></i> Tambah Data
					</a>
					<br><br>
					<table class="table table-hover table-striped table-bordered">
						<thead>
							<tr>
								<th>No.</th>
								<th>Reward</th>
								<th>Poin</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($reward as $i => $row): ?>
								<tr>
									<td><?= $i + 1 ?></td>
									<td><?= $row->reward ?></td>
									<td><?= $row->poin ?></td>
									<td>
										<div class="btn-group">
											<a href="<?= base_url('admin/detail-reward/' . $row->id_reward) ?>" class="btn blue">
												<i class="fa fa-eye"></i>
											</a>
											<a href="<?= base_url('admin/edit-reward/' . $row->id_reward) ?>" class="btn green">
												<i class="fa fa-edit"></i>
											</a>
											<a href="<?= base_url('admin/reward/' . $row->id_reward) ?>" class="btn red">
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