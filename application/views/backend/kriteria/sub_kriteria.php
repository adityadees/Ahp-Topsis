
<div class="app-content content">
	<div class="content-wrapper">
		<div class="content-header row">
			<div class="content-header-left col-md-6 col-12 mb-2">
				<h3 class="content-header-title mb-0">Data Sub Kriteria</h3>
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
													<th>Kode</th>
													<th>Kriteria</th>
													<th>Nama Sub Kriteria</th>
													<th>Aksi</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($sub_kriteria_grab as $i)  : ?>
													<tr>
														<td><?= $i->sk_id;?></td>
														<td>
															<?php foreach($kriteria_grab as $kr) :
																if($kr->kriteria_kode == $i->kriteria_kode){
																	echo $kr->kriteria_nama;
																}
															endforeach;?>
														</td>
														<td><?= $i->sk_nama;?></td>
														<td class=" text-center">
															<div class="btn-group mr-1 mb-1">
																<button type="button" class="btn btn-icon btn-pink dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-info"></i></button>
																<div class="dropdown-menu">
																	<a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalEdit<?= $i->sk_id ?>">Edit</a>
																	<a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalHapus<?= $i->sk_id ?>">Hapus</a>
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
						<h3 class="modal-title" id="myModalLabel34">Tambah Sub Kriteria</h3>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form action="<?= base_url('subkriteria/create')?>" method="POST" enctype="multipart/form-data">
						<div class="modal-body">

							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Sub Kriteria Kode: </label>
										<input type="text" placeholder="Sub Kriteria Kode" name="id" class="form-control">
									</div>
								</div>
							</div>
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
										<label>Nama Sub Kriteria: </label>
										<input type="text" placeholder="alternatamaif_nama" name="nama" class="form-control">
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal" value="close">
							<input type="submit" class="btn btn-outline-primary btn-lg" name="save_subkriteria" value="Submit">
						</div>
					</form>
				</div>
			</div>
		</div>
		
		<?php foreach ($sub_kriteria_grab as $ip)  : ?>
			<div class="modal fade text-left" id="modalEdit<?= $ip->sk_id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel34" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h3 class="modal-title" id="myModalLabel34">Edit Sub Kriteria</h3>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form action="<?= base_url('subkriteria/edit')?>" method="POST" enctype="multipart/form-data">
							<div class="modal-body">

								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>Kriteria Kode: </label>
											<select name="kriteria"  class="form-control">
												<?php foreach($kriteria_grab as $ix):?>
													<option value="<?= $ix->kriteria_kode?>" <?php if($ix->kriteria_kode == $ip->kriteria_kode) {echo "selected";}?>><?= $ix->kriteria_nama?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>Nama Sub Kriteria: </label>
											<input type="text" placeholder="Nama" name="nama" value="<?= $ip->sk_nama ?> " class="form-control">
											<input type="hidden" placeholder="ID" name="id" value="<?= $ip->sk_id ?>"class="form-control">
										</div>
									</div>
								</div>

							</div>
							<div class="modal-footer">
								<input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal" value="close">
								<input type="submit" class="btn btn-outline-primary btn-lg" name="edit_subkriteria" value="Submit">
							</div>
						</form>
					</div>
				</div>
			</div>


			<?php
		endforeach;
		foreach ($sub_kriteria_grab as $i)  : 
			?>

			<div class="modal fade text-left" id="modalHapus<?= $i->sk_id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel34" aria-hidden="true">
				<div class="modal-dialog modal-sm" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h3 class="modal-title" id="myModalLabel34">Konfirmasi</h3>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form action="<?= base_url('subkriteria/delete')?>" method="POST">
							<div class="modal-body bg-danger">

								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<input type="hidden" name="kode" value="<?= $i->sk_id?>">
											<label class="text-center text-white">Anda yakin ingin menghapus Sub Kriteria <b><?= $i->sk_nama ?></b> ?</label>
										</div>
									</div>

								</div>
							</div>
							<div class="modal-footer">
								<input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal" value="close">
								<input type="submit" class="btn btn-outline-primary btn-lg" name="delete_subkriteria" value="Submit">
							</div>
						</form>
					</div>
				</div>
			</div>

		<?php endforeach; ?>
