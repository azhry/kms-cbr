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
					<?= form_open('kasubbid/problem-solving') ?>
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
		</div>
	</div>
	<!-- END PAGE CONTENT INNER -->
</div>