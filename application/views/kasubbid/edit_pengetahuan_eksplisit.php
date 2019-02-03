<div class="page-content">
	<!-- BEGIN PAGE CONTENT INNER -->
	<?= $this->session->flashdata('msg') ?>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Edit Pengetahuan Eksplisit
					</div>
				</div>
				<div class="portlet-body">
					<?= form_open_multipart('kasubbid/edit-pengetahuan-eksplisit/' . $id_eksplisit) ?>
					<div class="form-group">
						<label for="judul">Judul</label>
						<input type="text" name="judul" value="<?= $pengetahuan_eksplisit->judul ?>" class="form-control">
					</div>
					<div class="form-group">
						<label for="id_kategori">Kategori</label>
						<?php  
							$opt = [];
							foreach ($kategori as $row)
							{
								$opt[$row->id_kategori] = $row->kategori;
							}

							echo form_dropdown('id_kategori', $opt, $pengetahuan_eksplisit->id_kategori, ['required' => 'required', 'class' => 'form-control']);
						?>
					</div>
					<div class="form-group">
						<label for="keterangan">Keterangan</label>
						<textarea class="form-control" name="keterangan"><?= $pengetahuan_eksplisit->keterangan ?></textarea>
					</div>
					<div class="form-group">
						<label for="referensi">Referensi</label>
						<input type="text" name="referensi" value="<?= $pengetahuan_eksplisit->referensi ?>" class="form-control">
					</div>
					<div class="form-group">
						<label for="lampiran">Lampiran</label>
						<?php if (file_exists(FCPATH . 'assets/lampiran/' . $pengetahuan_eksplisit->lampiran)): ?>
						<br>
						<u><a href="<?= base_url('assets/lampiran/' . $pengetahuan_eksplisit->lampiran) ?>"><?= $pengetahuan_eksplisit->lampiran ?></a></u>
						<?php endif; ?>
						<input type="file" name="lampiran" class="form-control">
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