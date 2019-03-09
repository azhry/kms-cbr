<div class="page-content">
	<!-- BEGIN PAGE CONTENT INNER -->
	<?= $this->session->flashdata('msg') ?>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Problem Solving
					</div>
				</div>
				<div class="portlet-body">
					<?= form_open('unit/problem-solving') ?>
					<table class="table">
						<thead>
							<tr>
								<th width="10%">No.</th>
								<th>Gejala</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($gejala as $i => $row): ?>
								<tr>
									<td><?= $i + 1 ?></td>
									<td>
										<div class="md-checkbox">
											<input type="checkbox" name="gejala[]" value="<?= $row->representasi ?>" id="checkbox<?= $i ?>" class="md-check">
											<label for="checkbox<?= $i ?>">
											<span></span>
											<span class="check"></span>
											<span class="box"></span>
											<?= $row->gejala ?> </label>
										</div>	
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
					<input type="submit" name="submit" value="Cari Solusi" class="btn blue">					
					<?= form_close() ?>
					<hr>
					<h4>Atau cari dengan memasukkan kata kunci</h4>
					<?= form_open('unit/problem-solving') ?>
					<div class="input-group" style="width: 50% !important;">
                        <input type="text" name="query" class="form-control" placeholder="Masukkan kata kunci">
                        <span class="input-group-btn">
                            <input type="submit" name="search" value="Cari" class="btn blue">
                        </span>
                    </div>   
					<?= form_close() ?>
				</div>
			</div>
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Request Gejala
					</div>
				</div>
				<div class="portlet-body">
					<?= form_open('unit/problem-solving') ?>
					<div class="form-group">
						<label for="gejala">Gejala</label>
						<input type="text" name="gejala" class="form-control">
					</div>
					<input type="submit" name="request" value="Submit" class="btn blue">					
					<?= form_close() ?>
				</div>
			</div>
			<?php if (isset($solusi)): ?>
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Solusi
					</div>
				</div>
				<div class="portlet-body">
					<table class="table">
						<thead>
							<tr>
								<th>No.</th>
								<th>Solusi</th>
								<th>Jarak Kedekatan</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($solusi as $i => $row): ?>
								<tr>
									<td><?= $i + 1 ?></td>
									<td>
										<ul>
											<?php foreach ($row['solusi'] as $s): ?>
												<li><?= $s['solusi'] ?></li>
											<?php endforeach; ?>
										</ul>
									</td>
									<td><?= $row['distance'] ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>		
				</div>
			</div>
			<?php endif; ?>
			<?php if (isset($masalah)): ?>
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Masalah
					</div>
				</div>
				<div class="portlet-body">
					<table class="table">
						<thead>
							<tr>
								<th>No.</th>
								<th>Masalah</th>
								<th>Gejala</th>
								<th>Solusi</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($masalah as $i => $row): ?>
								<tr>
									<td><?= $i + 1 ?></td>
									<td><?= $row['judul'] ?></td>
									<td>
										<ul>
											<?php foreach ($row['gejala'] as $g): ?>
												<li><?= $g['gejala']['gejala'] ?></li>
											<?php endforeach; ?>
										</ul>
									</td>
									<td>
										<ul>
											<?php foreach ($row['solusi'] as $s): ?>
												<li><?= $s['solusi'] ?></li>
											<?php endforeach; ?>
										</ul>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>		
				</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
	<!-- END PAGE CONTENT INNER -->
</div>