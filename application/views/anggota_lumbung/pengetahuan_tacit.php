<div class="page-content">
	<!-- BEGIN PAGE CONTENT INNER -->
	<?= $this->session->flashdata('msg') ?>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Pengetahuan Tacit Saya
					</div>
				</div>
				<div class="portlet-body">
					<a class="btn green" href="<?= base_url('anggota-lumbung/add-pengetahuan-tacit') ?>">
						<i class="fa fa-plus"></i> Tambah Data
					</a>
					<br><br>
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
									<td><?= $row->status ?></td>
									<td>
										<div class="btn-group">
											<a href="<?= base_url('anggota-lumbung/detail-pengetahuan-tacit/' . $row->id_tacit) ?>" class="btn blue">
												<i class="fa fa-eye"></i>
											</a>
											<a href="<?= base_url('anggota-lumbung/edit-pengetahuan-tacit/' . $row->id_tacit) ?>" class="btn green">
												<i class="fa fa-edit"></i>
											</a>
											<a href="<?= base_url('anggota-lumbung/pengetahuan-tacit/' . $row->id_tacit) ?>" class="btn red">
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