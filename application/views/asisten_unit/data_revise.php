<div class="page-content">
	<!-- BEGIN PAGE CONTENT INNER -->
	<?= $this->session->flashdata('msg') ?>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Data Revise
					</div>
				</div>
				<div class="portlet-body">
					<table class="table table-hover table-striped table-bordered">
						<thead>
							<tr>
								<th>No.</th>
								<th>Judul</th>
								<th>Gejala</th>
								<th>Solusi</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($masalah as $i => $row): ?>
								<tr>
									<td><?= $i + 1 ?></td>
									<td><?= $row->judul ?></td>
									<td>
										<ul>
											<?php foreach ($row->gejala as $gejala): ?>
												<li><?= $gejala->gejala->gejala ?></li>
											<?php endforeach; ?>
										</ul>
									</td>
									<td>
										<ul>
											<?php foreach ($row->solusi as $solusi): ?>
												<li><?= $solusi->solusi ?></li>
											<?php endforeach; ?>
										</ul>
									</td>
									<td>
										<div class="btn-group">
											<a href="<?= base_url('asisten-unit/ubah-solusi/' . $row->id_masalah) ?>" class="btn green">
												<i class="fa fa-edit"></i> Ubah Solusi
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