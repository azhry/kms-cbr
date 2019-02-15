<link rel="stylesheet" type="text/css" href="<?= base_url('assets/metronic') ?>/assets/global/plugins/jquery-tags-input/jquery.tagsinput.css"/>
<div class="page-content">
	<!-- BEGIN PAGE CONTENT INNER -->
	<?= $this->session->flashdata('msg') ?>
	<div class="row margin-top-10">
		<div class="col-md-12">
			<h2><?= $pengetahuan_tacit->judul ?></h2>
			<h4><?= $pengetahuan_tacit->pengguna->nama ?> | <?= time_elapsed_string($pengetahuan_tacit->created_at) ?></h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Konten Pengetahuan
					</div>
				</div>
				<div class="portlet-body">					
					<?= $pengetahuan_tacit->isi ?>
				</div>
			</div>
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Tag Pengguna
					</div>
				</div>
				<?php  
					$x = $pengetahuan_tacit->tag->toArray();
					$y = array_column($x, 'pengguna');
					var_dump(array_column($y, 'nama'));
				?>
				<div class="portlet-body" style="min-height: 100px;">					
					<?= form_open('unit/detail-pengetahuan-tacit/' . $id_tacit) ?>
					<div class="form-group">
						<div class="col-md-9">
							<input id="tags_1" type="text" name="tags" class="form-control tags" value=""/>
						</div>
					</div>
					<div class="form-group">
						<input type="submit" class="btn blue" name="submit_tag" value="Tag Pengguna">
					</div>
					<?= form_close() ?>
				</div>
			</div>
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Komentar
					</div>
				</div>
				<div class="portlet-body">
					<?= form_open('unit/detail-pengetahuan-tacit/' . $id_tacit) ?>
						<div class="form-group">
							<textarea class="form-control" name="komentar" placeholder="Komentar anda.."></textarea>
						</div>
						<div class="form-group">
							<input type="submit" class="btn blue" name="submit" value="Kirim">
						</div>
					<?= form_close() ?>
					
					<div class="general-item-list">
						<?php foreach ($pengetahuan_tacit->komentar as $komentar): ?>
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

<script src="<?= base_url('assets/metronic') ?>/assets/global/plugins/jquery-tags-input/jquery.tagsinput.min.js" type="text/javascript"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$('#tags_1').tagsInput({
            width: 'auto',
            'onAddTag': function () {
                //alert(1);
            },
        });
	});
</script>