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
							<a href="<?= base_url('kasubbid/detail-pengetahuan-eksplisit/' . $row->id_eksplisit) ?>">
							<?= $row->judul ?></a>
							</h3>
							<ul class="list-inline">
								<li>
									<i class="fa fa-calendar"></i>
									<a href="javascript:;">
									<?= $row->created_at ?></a>
								</li>
								<li>
									<?php  
										$likes = $row->like->toArray();
										$likePengguna = array_column($likes, 'id_pengguna');
										$likeCount = $row->like->count();
									?>
									<input type="hidden" value="<?= $likeCount ?>">
									<i class="fa fa-thumbs-up" <?= in_array($id_pengguna, $likePengguna) ? 'style="color: blue;"' : '' ?>></i>
									<a href="javascript:;" onclick="set_like(<?= $row->id_eksplisit ?>, this)">
									<?= $likeCount  . ' Menyukai' ?> </a>
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
							<a class="btn blue btn-xs" href="<?= base_url('kasubbid/detail-pengetahuan-eksplisit/' . $row->id_eksplisit) ?>">
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

<script type="text/javascript">
	function set_like(id_eksplisit, obj) {
		let current_likes = $(obj).prev().prev().val();
		$.ajax({
			url: '<?= base_url('kasubbid/share-eksplisit') ?>',
			type: 'POST',
			data: {
				like: true,
				id_eksplisit: id_eksplisit
			},
			success: function(response) {
				const json = $.parseJSON(response);
				if (json.response == 'like') {
					$(obj).prev().css('color', 'blue');
					current_likes++;
					$(obj).text(current_likes + ' Menyukai');
				} else {
					$(obj).prev().css('color', '');
					current_likes--;
					$(obj).text(current_likes + ' Menyukai');
				}
				$(obj).prev().prev().val(current_likes);
			},
			error: function(err) { console.log(err.responseText); }
		});
		return false;
	}
</script>