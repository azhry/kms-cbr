<div class="page-content">
	<!-- BEGIN PAGE CONTENT INNER -->
	<?= $this->session->flashdata('msg') ?>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						My Reward
					</div>
				</div>
				<div class="portlet-body">
					<table class="table table-hover table-striped table-bordered">
						<thead>
							<tr>
								<th>No.</th>
								<th>Reward</th>
								<th>Keterangan</th>
								<th>Tanggal Reward</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($reward as $i => $row): ?>
								<tr>
									<td><?= $i + 1 ?></td>
									<td><?= $row->reward->reward ?></td>
									<td><?= $row->reward->keterangan ?></td>
									<td><?= $row->created_at ?></td>
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