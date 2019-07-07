<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/css/core/menu/menu-types/vertical-menu-modern.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/css/vendors.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/vendors/css/extensions/unslider.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/vendors/css/weather-icons/climacons.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/fonts/meteocons/style.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/vendors/css/charts/morris.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/css/app.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/css/core/colors/palette-gradient.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/fonts/simple-line-icons/style.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/vendors/css/ui/prism.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/vendors/css/file-uploaders/dropzone.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/css/plugins/file-uploaders/dropzone.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/css/core/colors/palette-gradient.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/css/pages/timeline.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/vendors/css/tables/datatable/datatables.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/css/plugins/forms/wizard.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/vendors/css/extensions/sweetalert.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/backend/vendors/css/extensions/toastr.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/backend/css/plugins/extensions/toastr.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/backend/assets/css/style.css">

<body onload="window.print()">
<div class="app-content content" >
	<div class="content-wrapper">
		<div class="content-header row">
			<div class="content-header-left col-md-6 col-12 mb-2">
				<h3 class="content-header-title mb-0">Laporan Best CRR Pada PT. XL-Axiata</h3>
			</div>
		</div>
		<div class="content-body"><section class="card">
			<div id="invoice-template" class="card-body">

				<div id="invoice-company-details" class="row">
					<div class="col-md-6 col-sm-12 text-center text-md-left">
						<div class="media">
							<img src="<?= base_url('assets/backend/images/logo/xl.png')?>" style="width: 80px;height: 80px" alt="company logo" class=""/>
							<div class="media-body">
								<ul class="ml-2 px-0 list-unstyled">
									<li class="text-bold-800">XL - AXIATA</li>
									<li>Jl. Angkatan 45 No.818,</li>
									<li>Demang Lebar Daun,</li>
									<li>Kec. Ilir Bar. I, Kota Palembang</li>
									<li>Sumatera Selatan 30137</li>
								</ul>
							</div>
						</div>
					</div>
				</div>


				<div id="invoice-items-details" class="pt-2">
					<div class="row">
						<div class="table-responsive col-sm-12">
							<table class="table">
								<thead>
									<tr>
										<th>Rangking</th>
										<th>Kode</th>
										<th>Nama</th>
										<th>Nilai</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$no=0; foreach ($hasil_report as $key => $value) :
									$no++; ?>
									<tr>
										<td><?= $no; ?></td>
										<td><?= $value->alternatif_kode ?></td>
										<td><?= $value->alternatif_nama ?></td>
										<td><?= $value->hr_value ?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div id="invoice-footer">
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<h6>Terms & Condition</h6>
						<p>Hasil rangking ini berdasarkan dengan metode ahp dan topsis, untuk menentukan Best CRR pada PT. XL - Axiata Sumatera Selatan</p>
					</div>
				</div>
			</div>

		</div>
	</section>
</div>
</div>
</div>
</body>


<script src="<?php echo base_url();?>assets/backend/vendors/js/vendors.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/backend/vendors/js/tables/datatable/datatables.min.js"></script>
<script src="<?php echo base_url();?>assets/backend/vendors/js/tables/datatable/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url();?>assets/backend/vendors/js/tables/datatable/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url();?>assets/backend/vendors/js/tables/jszip.min.js"></script>
<script src="<?php echo base_url();?>assets/backend/vendors/js/tables/pdfmake.min.js"></script>
<script src="<?php echo base_url();?>assets/backend/vendors/js/tables/vfs_fonts.js"></script>
<script src="<?php echo base_url();?>assets/backend/vendors/js/tables/buttons.html5.min.js"></script>
<script src="<?php echo base_url();?>assets/backend/vendors/js/tables/buttons.print.min.js"></script>
<script src="<?php echo base_url();?>assets/backend/vendors/js/tables/buttons.colVis.min.js"></script>
<script src="<?php echo base_url();?>assets/backend/js/core/app-menu.js"></script>
<script src="<?php echo base_url();?>assets/backend/js/core/app.js"></script>
<script src="<?php echo base_url();?>assets/backend/js/scripts/customizer.js"></script>
<script src="<?php echo base_url();?>assets/backend/js/scripts/tables/datatables-extensions/datatable-button/datatable-html5.js"></script>