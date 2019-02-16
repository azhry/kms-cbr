<div class="page-content">
	<!-- BEGIN PAGE CONTENT INNER -->
	<?= $this->session->flashdata('msg') ?>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Informasi Reward
					</div>
				</div>
				<div class="portlet-body">
					<table class="table table-bordered table-striped table-hover">
						<tbody>
							<tr>
								<td width="30%"><b>Reward</b></td>
								<td><?= $reward->reward ?></td>
							</tr>
							<tr>
								<td><b>Poin</b></td>
								<td><?= $reward->poin ?></td>
							</tr>
							<tr>
								<td><b>Keterangan</b></td>
								<td><?= $reward->keterangan ?></td>
							</tr>
						</tbody>
					</table>			
				</div>
			</div>
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Daftar Penerima Reward
					</div>
				</div>
				<div class="portlet-body">
					<table class="table table-bordered table-striped table-hover">
						<thead>
							<tr>
								<th>No.</th>
								<th>NIP</th>
								<th>Nama</th>
								<th>Role</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($reward->penerima as $i => $row): ?>
								<tr>
									<td><?= $i + 1 ?></td>
									<td><?= $row->pengguna->nip ?></td>
									<td><?= $row->pengguna->nama ?></td>
									<td><?= $row->pengguna->role->role ?></td>
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