
<div class="app-content content">
	<div class="content-wrapper">
		<div class="content-header row">
			<div class="content-header-left col-md-6 col-12 mb-2">
				<h3 class="content-header-title mb-0">Data Parameter</h3>
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
													<th>Kriteria</th>
													<th>Parameter</th>
													<th>Nilai</th>
													<th>Aksi</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($parameter_grab as $i)  : ?>
													<tr>
														<td>
															<?php foreach($kriteria_grab as $kr) :
																if($kr->kriteria_kode == $i->kriteria_kode){
																	echo $kr->kriteria_nama;
																}
															endforeach;?>
														</td>
														<td><?= $i->parameter_ukuran;?></td>
														<td><?= $i->parameter_nilai;?></td>
														<td class=" text-center">
															<div class="btn-group mr-1 mb-1">
																<button type="button" class="btn btn-icon btn-pink dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-info"></i></button>
																<div class="dropdown-menu">
																	<a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalEdit<?= $i->parameter_id ?>">Edit</a>
																	<a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalHapus<?= $i->parameter_id ?>">Hapus</a>
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
						<h3 class="modal-title" id="myModalLabel34">Tambah Parameter</h3>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form action="<?= base_url('parameter/create')?>" method="POST" enctype="multipart/form-data">
						<div class="modal-body">

							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Kriteria Kode: </label>
										<select name="kriteria"  class="form-control">
											<?php foreach($kriteria_grab as $ix):?>
												<option value="<?= $ix->kriteria_kode?>"><?= $ix->kriteria_nama?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Parameter Ukuran: </label>
										<input type="text" placeholder="Parameter Ukuran" name="ukuran" class="form-control">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Nilai Parameter: </label>
										<input type="text" placeholder="Nilai Parameter" name="nilai" class="form-control">
									</div>
								</div>
							</div>

						</div>
						<div class="modal-footer">
							<input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal" value="close">
							<input type="submit" class="btn btn-outline-primary btn-lg" name="save_parameter" value="Submit">
						</div>
					</form>
				</div>
			</div>
		</div>
		
		<?php foreach ($parameter_grab as $i)  : ?>
			<div class="modal fade text-left" id="modalEdit<?= $i->parameter_id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel34" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h3 class="modal-title" id="myModalLabel34">Edit Parameter</h3>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form action="<?= base_url('parameter/edit')?>" method="POST" enctype="multipart/form-data">
							<div class="modal-body">

								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>Kriteria Kode: </label>
											<select name="kriteria"  class="form-control">
												<?php foreach($kriteria_grab as $ix):?>
													<option value="<?= $ix->kriteria_kode?>" <?php if($ix->kriteria_kode == $i->kriteria_kode) {echo "selected";}?>><?= $ix->kriteria_nama?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>Parameter Ukuran: </label>
											<input type="text" placeholder="Parameter Ukuran" name="ukuran" value="<?= $i->parameter_ukuran ?>" class="form-control">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>Nilai Parameter: </label>
											<input type="text" placeholder="Nilai Parameter" name="nilai" value="<?= $i->parameter_nilai ?>" class="form-control">
											<input type="hidden" placeholder="Parametername" name="id" class="form-control" value="<?= $i->parameter_id ?>" readonly="readonly">
										</div>
									</div>
								</div>


							</div>
							<div class="modal-footer">
								<input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal" value="close">
								<input type="submit" class="btn btn-outline-primary btn-lg" name="edit_parameter" value="Submit">
							</div>
						</form>
					</div>
				</div>
			</div>


			<?php
		endforeach;
		foreach ($parameter_grab as $i)  : 
			?>

			<div class="modal fade text-left" id="modalHapus<?= $i->parameter_id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel34" aria-hidden="true">
				<div class="modal-dialog modal-sm" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h3 class="modal-title" id="myModalLabel34">Konfirmasi</h3>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form action="<?= base_url('parameter/delete')?>" method="POST">
							<div class="modal-body bg-danger">

								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<input type="hidden" name="kode" value="<?= $i->parameter_id?>">
											<label class="text-center text-white">Anda yakin ingin menghapus parameter <b><?= $i->parameter_ukuran ?></b> ?</label>
										</div>
									</div>

								</div>
							</div>
							<div class="modal-footer">
								<input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal" value="close">
								<input type="submit" class="btn btn-outline-primary btn-lg" name="delete_parameter" value="Submit">
							</div>
						</form>
					</div>
				</div>
			</div>

		<?php endforeach; ?>
