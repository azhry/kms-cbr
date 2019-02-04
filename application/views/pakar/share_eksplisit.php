<div class="page-content">
	<!-- BEGIN PAGE CONTENT INNER -->
	<?= $this->session->flashdata('msg') ?>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Pengetahuan Eksplisit
					</div>
				</div>
				<div class="portlet-body">
					<?php foreach ($pengetahuan_eksplisit as $row): ?>
					<div class="row">
						<div class="col-md-8 blog-article">
							<h3>
							<a href="<?= base_url('pakar/detail-pengetahuan-eksplisit/' . $row->id_eksplisit) ?>">
							<?= $row->judul ?></a>
							</h3>
							<ul class="list-inline">
								<li>
									<i class="fa fa-calendar"></i>
									<a href="javascript:;">
									<?= $row->created_at ?></a>
								</li>
								<li>
									<i class="fa fa-comments"></i>
									<a href="javascript:;">
									<?= count($row->komentar) . ' Komentar' ?> </a>
								</li>
								<li>
									<i class="fa fa-tags"></i>
									<?= $row->kategori->kategori ?>
								</li>
							</ul>
							<p>
								 <?= $row->isi ?>
							</p>
							<a class="btn blue btn-xs" href="<?= base_url('pakar/detail-pengetahuan-eksplisit/' . $row->id_eksplisit) ?>">
							Selengkapnya <i class="m-icon-swapright m-icon-white"></i>
							</a>
						</div>
					</div>
					<hr>
					<?php endforeach; ?>	
				</div>
			</div>
		</div>
	</div>
	<!-- END PAGE CONTENT INNER -->
</div>