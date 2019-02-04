<div class="page-content">
	<!-- BEGIN PAGE CONTENT INNER -->
	<?= $this->session->flashdata('msg') ?>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Edit Pengetahuan Tacit
					</div>
				</div>
				<div class="portlet-body">
					<?= form_open('pakar/edit-pengetahuan-tacit/' . $id_tacit) ?>
					<div class="form-group">
						<label for="judul">Judul</label>
						<input type="text" name="judul" value="<?= $pengetahuan_tacit->judul ?>" class="form-control">
					</div>
					<div class="form-group">
						<label for="id_kategori">Kategori</label>
						<?php  
							$opt = [];
							foreach ($kategori as $row)
							{
								$opt[$row->id_kategori] = $row->kategori;
							}

							echo form_dropdown('id_kategori', $opt, $pengetahuan_tacit->id_kategori, ['required' => 'required', 'class' => 'form-control']);
						?>
					</div>
					<div class="form-group">
						<label for="isi">Isi</label>
						<textarea class="form-control" name="isi"><?= $pengetahuan_tacit->isi ?></textarea>
					</div>
					<div class="form-group">
						<input type="submit" name="submit" class="btn green">
					</div>
					<?= form_close() ?>			
				</div>
			</div>
		</div>
	</div>
	<!-- END PAGE CONTENT INNER -->
</div>