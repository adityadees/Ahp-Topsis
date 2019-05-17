
<div class="app-content content">
	<div class="content-wrapper">
		<div class="content-header row">
			<div class="content-header-left col-md-6 col-12 mb-2">
				<h3 class="content-header-title mb-0">Data Nilai</h3>
			</div>
		</div>
		<div class="content-body">
			
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h4 class="card-title">
								<a class="btn btn-primary" href="" data-toggle="modal" data-target="#modalAdd">Tambah Data</a></h4>
								<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
								<div class="heading-elements">
									<ul class="list-inline mb-0">
										<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
										<li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
										<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
										<li><a data-action="close"><i class="ft-x"></i></a></li>
									</ul>
								</div>
							</div>
							<div class="card-content collapse show">
								<div class="card-body card-dashboard">
									<p>
										<?= $this->session->flashdata('msg');?>
									</p>

									<div class="table-responsive">
										<table class="table table-striped table-bordered complex-headers">
											<thead>
												<tr>
													<th>Alternatif</th>
													<th>Kriteria</th>
													<th>Nilai</th>
													<th>Aksi</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($nilai_grab as $i)  : ?>
													<tr>
														<td>
															<?php foreach($alternatif_grab as $kr) :
																if($kr->alternatif_kode == $i->alternatif_kode){
																	echo $kr->alternatif_nama;
																}
															endforeach;?>
														</td>
														<td>
															<?php foreach($parameter_grab as $kr) :
																if($kr->parameter_id == $i->parameter_id){
																	foreach($kriteria_grab as $kx) :
																		if($kr->kriteria_kode == $kx->kriteria_kode){
																			echo $kx->kriteria_nama ." ( ".$kr->parameter_ukuran." )";
																		}
																	endforeach;
																}
															endforeach;?>
														</td>
														<td>
															<?php foreach($parameter_grab as $kk) :
																if($kk->parameter_id == $i->parameter_id){
																	echo $kk->parameter_nilai;
																}
															endforeach;?>
														</td>
														<td class=" text-center">
															<div class="btn-group mr-1 mb-1">
																<button type="button" class="btn btn-icon btn-pink dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-info"></i></button>
																<div class="dropdown-menu">
																	<a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalEdit<?= $i->nilai_id ?>">Edit</a>
																	<a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalHapus<?= $i->nilai_id ?>">Hapus</a>
																</div>
															</div>
														</td>
													</tr>
												<?php endforeach; ?>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


		<div class="modal fade text-left" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel34" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title" id="myModalLabel34">Tambah Nilai</h3>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form action="<?= base_url('nilai/create')?>" method="POST" enctype="multipart/form-data">
						<div class="modal-body">

							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Alternatif: </label>
										<select name="alternatif"  class="form-control">
											<?php foreach($alternatif_grab as $ix):?>
												<option value="<?= $ix->alternatif_kode?>"><?= $ix->alternatif_nama?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Parameter: </label>
										<select name="parameter"  class="form-control">
											<?php foreach($parameter_grab as $kx):?>
												<option value="<?= $kx->parameter_id?>">
													<?php foreach($kriteria_grab as $kt) :
														if($kx->kriteria_kode == $kt->kriteria_kode){
															echo $kt->kriteria_nama." (".$kx->parameter_ukuran ." | ".$kx->parameter_nilai.")" ;
														}
													endforeach;
													?>
												</option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							</div>


						</div>
						<div class="modal-footer">
							<input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal" value="close">
							<input type="submit" class="btn btn-outline-primary btn-lg" name="save_nilai" value="Submit">
						</div>
					</form>
				</div>
			</div>
		</div>

		<?php foreach ($nilai_grab as $i)  : ?>
			<div class="modal fade text-left" id="modalEdit<?= $i->nilai_id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel34" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h3 class="modal-title" id="myModalLabel34">Edit Nilai</h3>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form action="<?= base_url('nilai/edit')?>" method="POST" enctype="multipart/form-data">
							<div class="modal-body">

								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>Alternatif: </label>
											<input type="hidden" name="id" value="<?= $i->nilai_id?>">
											<select name="alternatif"  class="form-control">
												<?php foreach($alternatif_grab as $ix):?>
													<option value="<?= $ix->alternatif_kode?>" <?php if($ix->alternatif_kode == $i->alternatif_kode){echo "selected";}?>><?= $ix->alternatif_nama?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>Parameter: </label>
											<select name="parameter"  class="form-control">
												<?php foreach($parameter_grab as $kx):?>
													<option value="<?= $kx->parameter_id?>" <?php if($kx->parameter_id == $i->parameter_id){echo "selected";}?>>
														<?php foreach($kriteria_grab as $kt) :
															if($kx->kriteria_kode == $kt->kriteria_kode){
																echo $kt->kriteria_nama." (".$kx->parameter_ukuran ." | ".$kx->parameter_nilai.")" ;
															}
														endforeach;
														?>
													</option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
								</div>


							</div>
							<div class="modal-footer">
								<input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal" value="close">
								<input type="submit" class="btn btn-outline-primary btn-lg" name="edit_nilai" value="Submit">
							</div>
						</form>
					</div>
				</div>
			</div>


			<?php
		endforeach;
		foreach ($nilai_grab as $i)  : 
			?>

			<div class="modal fade text-left" id="modalHapus<?= $i->nilai_id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel34" aria-hidden="true">
				<div class="modal-dialog modal-sm" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h3 class="modal-title" id="myModalLabel34">Konfirmasi</h3>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form action="<?= base_url('nilai/delete')?>" method="POST">
							<div class="modal-body bg-danger">

								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<input type="hidden" name="kode" value="<?= $i->nilai_id?>">
											<label class="text-center text-white">Anda yakin ingin menghapus data ini ?</label>
										</div>
									</div>

								</div>
							</div>
							<div class="modal-footer">
								<input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal" value="close">
								<input type="submit" class="btn btn-outline-primary btn-lg" name="delete_nilai" value="Submit">
							</div>
						</form>
					</div>
				</div>
			</div>

		<?php endforeach; ?>
