<div class="page-content">
	<!-- BEGIN PAGE CONTENT INNER -->
	<?= $this->session->flashdata('msg') ?>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Pengetahuan Tacit
					</div>
				</div>
				<div class="portlet-body">
					<?php foreach ($pengetahuan_tacit as $row): ?>
						<?php if (count($row->like) > 0): ?>
							<div class="row">
								<div class="col-md-8 blog-article">
									<h3>
									<a href="<?= base_url('unit/detail-pengetahuan-tacit/' . $row->id_tacit) ?>">
									<?= $row->judul ?></a>
									</h3>
									<p>
										 <?= $row->isi ?>
									</p>
									<a class="btn blue btn-xs" href="<?= base_url('unit/detail-pengetahuan-tacit/' . $row->id_tacit) ?>">
									Selengkapnya <i class="m-icon-swapright m-icon-white"></i>
									</a>
								</div>
							</div>
							<hr>
						<?php endif; ?>
					<?php endforeach; ?>	
				</div>
			</div>
		</div>
	</div>
	<!-- END PAGE CONTENT INNER -->
</div>