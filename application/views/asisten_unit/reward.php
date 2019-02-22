<div class="page-content">
	<!-- BEGIN PAGE CONTENT INNER -->
	<?= $this->session->flashdata('msg') ?>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Reward | Poin anda: <?= $data_pengguna->poin ?>
					</div>
				</div>
				<div class="portlet-body">
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
										<a href="<?= base_url('asisten-unit/reward/' . $row->id_reward) ?>" class="btn red">
											Ambil Reward
										</a>
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