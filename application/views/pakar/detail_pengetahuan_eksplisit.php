<div class="page-content">
	<!-- BEGIN PAGE CONTENT INNER -->
	<?= $this->session->flashdata('msg') ?>
	<div class="row margin-top-10">
		<div class="col-md-12">
			<h2><?= $pengetahuan_eksplisit->judul ?></h2>
			<h4><?= $pengetahuan_eksplisit->pengguna->nama ?> | <?= time_elapsed_string($pengetahuan_eksplisit->created_at) ?></h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Keterangan
					</div>
				</div>
				<div class="portlet-body">					
					<?= $pengetahuan_eksplisit->keterangan ?>
				</div>
			</div>
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Referensi
					</div>
				</div>
				<div class="portlet-body">					
					<?= $pengetahuan_eksplisit->referensi ?>
				</div>
			</div>
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Lampiran
					</div>
				</div>
				<div class="portlet-body">					
					<?php if (file_exists(FCPATH . 'assets/lampiran/' . $pengetahuan_eksplisit->lampiran)): ?>
						<u><a href="<?= base_url('assets/lampiran/' . $pengetahuan_eksplisit->lampiran) ?>"><?= $pengetahuan_eksplisit->lampiran ?></a></u>
					<?php else: ?>
						Tidak ada lampiran
					<?php endif; ?>
				</div>
			</div>
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Komentar
					</div>
				</div>
				<div class="portlet-body">
					<?= form_open('pakar/detail-pengetahuan-eksplisit/' . $id_eksplisit) ?>
						<div class="form-group">
							<textarea class="form-control" name="komentar" placeholder="Komentar anda.."></textarea>
						</div>
						<div class="form-group">
							<input type="submit" class="btn blue" name="submit" value="Kirim">
						</div>
					<?= form_close() ?>
					
					<div class="general-item-list">
						<?php foreach ($pengetahuan_eksplisit->komentar as $komentar): ?>
						<div class="item">
							<div class="item-head">
								<div class="item-details">
									<img class="item-pic" src="http://placehold.it/100">
									<a href="" class="item-name primary-link"><?= $komentar->pengguna->nama ?></a>
									<span class="item-label"><?= time_elapsed_string($komentar->created_at) ?></span>
								</div>
							</div>
							<div class="item-body">
								<?= $komentar->komentar ?>
							</div>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END PAGE CONTENT INNER -->
</div>