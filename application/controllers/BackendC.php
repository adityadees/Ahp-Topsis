<?php

class BackendC extends CI_Controller{
	function __construct(){
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){
			$url=base_url('loginadmin');
			redirect($url);
		};
		$this->load->model('Mymod');
	}

	public function index()
	{
		$y['title']='Dashboard';


		$this->load->view('backend/layout/header',$y);
		$this->load->view('backend/layout/topbar');
		$this->load->view('backend/layout/sidebar');
		$this->load->view('backend/index');
		$this->load->view('backend/layout/footer');
	}
	

	public function laporan()
	{
		$y['title']='Laporan';
		$x['data'] = $this->Mymod->JoinPesan();
		$x['datas'] = $this->Mymod->JoinBayar();
		$this->load->view('backend/layout/header',$y);
		$this->load->view('backend/layout/topbar');
		$this->load->view('backend/layout/sidebar');
		$this->load->view('backend/laporan/laporan',$x);
		$this->load->view('backend/layout/footer');
	}
	
	public function produk()
	{

		$jtable=[
			'produk' => 'sk_id',
			'sub_kategori' => 'sk_id'
		];

		$prod = $this->Mymod->GetDataJoinNW($jtable)->result_array();
		$sk_data = $this->Mymod->ViewData('sub_kategori');
		$x['produk'] = $prod;
		$x['datalist'] = $sk_data;
		$y['title']='Produk';
		$this->load->view('backend/layout/header',$y);
		$this->load->view('backend/layout/topbar');
		$this->load->view('backend/layout/sidebar');
		$this->load->view('backend/produk/produk',$x);
		$this->load->view('backend/layout/footer');
	}
	public function invoice()
	{
		$segment=$this->uri->segment(3);

		$where=[
			't1.pemesanan_kode'=>$segment,
		];

		$jtable=[
			'pemesanan' => 'pemesanan_kode',
			'pemesanan_detailp' => 'pemesanan_kode',
			'pemesanan_ship' => 'pemesanan_kode',
			'pembayaran' => 'pemesanan_kode',
		];


		$data = $this->Mymod->GetDataJoinArr($jtable,$where);
		$y['title']='Invoice';
		$x['data'] = $data->row_array();

		$this->load->view('backend/layout/header',$y);
		$this->load->view('backend/layout/topbar');
		$this->load->view('backend/layout/sidebar');
		$this->load->view('backend/transaksi/invoice',$x);
		$this->load->view('backend/layout/footer');
	}

	public function cetak()
	{
		$segment=$this->uri->segment(3);

		$where=[
			't1.pemesanan_kode'=>$segment,
		];

		$jtable=[
			'pemesanan' => 'pemesanan_kode',
			'pemesanan_detailp' => 'pemesanan_kode',
			'pemesanan_ship' => 'pemesanan_kode',
			'pembayaran' => 'pemesanan_kode',
		];


		$data = $this->Mymod->GetDataJoinArr($jtable,$where);
		$y['title']='Invoice';
		$x['data'] = $data->row_array();

		$this->load->view('backend/layout/header',$y);
		$this->load->view('backend/transaksi/cetak',$x);
		$this->load->view('backend/layout/footer');
	}

	public function promo()
	{

		$jtable=[
			'produk' => 'produk_kode',
			'promo' => 'produk_kode'
		];
		$promo = $this->Mymod->GetDataJoinNW($jtable)->result_array();
		$produk = $this->Mymod->ViewData('produk');
		$x['promo'] = $promo;
		$x['produk'] = $produk;
		$y['title']='Produk';
		$this->load->view('backend/layout/header',$y);
		$this->load->view('backend/layout/topbar');
		$this->load->view('backend/layout/sidebar');
		$this->load->view('backend/produk/promo',$x);
		$this->load->view('backend/layout/footer');
	}
	public function rekening()
	{
		$rekening = $this->Mymod->ViewData('rekening');
		$x['rekening'] = $rekening;
		$y['title']='Bank';
		$this->load->view('backend/layout/header',$y);
		$this->load->view('backend/layout/topbar');
		$this->load->view('backend/layout/sidebar');
		$this->load->view('backend/rekening/rekening',$x);
		$this->load->view('backend/layout/footer');
	}
	public function kategori()
	{
		$table='kategori';
		$data = $this->Mymod->ViewData($table);
		$x['kategori'] = $data;
		$y['title']='kategori';
		$this->load->view('backend/layout/header',$y);
		$this->load->view('backend/layout/topbar');
		$this->load->view('backend/layout/sidebar');
		$this->load->view('backend/produk/kategori',$x);
		$this->load->view('backend/layout/footer');
	}
	public function subkategori()
	{

		$jtable=[
			'kategori' => 'kategori_id',
			'sub_kategori' => 'kategori_id'
		];

		$kategori = $this->Mymod->ViewData('kategori');

		$data = $this->Mymod->GetDataJoinNW($jtable)->result_array();
		$x['subkategori'] = $data;
		$x['kategori'] = $kategori;
		$y['title']='Sub-Kategori';
		$this->load->view('backend/layout/header',$y);
		$this->load->view('backend/layout/topbar');
		$this->load->view('backend/layout/sidebar');
		$this->load->view('backend/produk/sub_kategori',$x);
		$this->load->view('backend/layout/footer');
	}
	public function list()
	{

		$jtable=[
			'list' => 'sk_id',
			'sub_kategori' => 'sk_id'
		];

		$subkategori = $this->Mymod->ViewData('sub_kategori');

		$data = $this->Mymod->GetDataJoinNW($jtable)->result_array();
		$x['listdata'] = $data;
		$x['subkategori'] = $subkategori;
		$y['title']='List';
		$this->load->view('backend/layout/header',$y);
		$this->load->view('backend/layout/topbar');
		$this->load->view('backend/layout/sidebar');
		$this->load->view('backend/produk/list',$x);
		$this->load->view('backend/layout/footer');
	}

	public function pemesanan()
	{
		$y['title']='Pemesanan';

		$x['data'] = $this->Mymod->JoinPesan();

		$this->load->view('backend/layout/header',$y);
		$this->load->view('backend/layout/topbar');
		$this->load->view('backend/layout/sidebar');
		$this->load->view('backend/transaksi/pemesanan',$x);
		$this->load->view('backend/layout/footer');
	}

	public function pembayaran()
	{
		$y['title']='Pembayaran';
		$x['data'] = $this->Mymod->JoinBayar();
		$this->load->view('backend/layout/header',$y);
		$this->load->view('backend/layout/topbar');
		$this->load->view('backend/layout/sidebar');
		$this->load->view('backend/transaksi/pembayaran',$x);
		$this->load->view('backend/layout/footer');
	}

	public function user()
	{
		$table='user';
		$data = $this->Mymod->ViewData($table);
		$x['user'] = $data;
		$y['title']='user';
		$this->load->view('backend/layout/header',$y);
		$this->load->view('backend/layout/topbar');
		$this->load->view('backend/layout/sidebar');
		$this->load->view('backend/user/user',$x);
		$this->load->view('backend/layout/footer');
	}


	public function slider()
	{
		$table='slider';
		$data = $this->Mymod->ViewData($table);
		$x['slider'] = $data;
		$y['title']='Slider';
		$this->load->view('backend/layout/header',$y);
		$this->load->view('backend/layout/topbar');
		$this->load->view('backend/layout/sidebar');
		$this->load->view('backend/slider/slider',$x);
		$this->load->view('backend/layout/footer');
	}

	public function save_user(){
		$username=$this->input->post('username');
		$password=$this->input->post('password');
		$repassword=$this->input->post('repassword');
		$nama=$this->input->post('nama');
		$email=$this->input->post('email');
		$tel=$this->input->post('tel');
		$alamat=$this->input->post('alamat');
		$jk=$this->input->post('jk');
		$role=$this->input->post('role');

		$table='user';
		$where='user_username';
		$data=$username;
		$cekuname=$this->Mymod->ViewNumRows($table,$where,$data);

		if($cekuname==1){
			$this->session->set_flashdata('error', 'Username telah dipakai, silahkan ulangi lagi');
			redirect('admin/user');	
		}else{
			if($password==$repassword){

				if($jk=='on'){
					$jk='L';
				}else {
					$jk='P';
				}
				$title='User';
				$table='user';
				$data=[
					'user_username'=>$username,
					'user_password'=>md5($password),
					'user_nama'=>$nama,
					'user_email'=>$email,
					'user_alamat'=>$alamat,
					'user_jk'=>$jk,
					'user_tel'=>$tel,
					'user_role'=>$role,
				];
				$rd=$this->Mymod->InsertData($table,$data);
				$this->session->set_flashdata('success', 'Berhasil menambah '.$title);
				redirect('admin/user');		
			}else {
				$this->session->set_flashdata('error', 'Password tidak sama, silahkan diulangi lagi');
				redirect('admin/user');		
			}
		}


	}	


	public function edit_user(){
		$nama=$this->input->post('nama');
		$email=$this->input->post('email');
		$tel=$this->input->post('tel');
		$alamat=$this->input->post('alamat');
		$jk=$this->input->post('jk');
		$role=$this->input->post('role');
		$user_id=$this->input->post('user_id');
		if($jk=='on'){
			$jk='L';
		}else {
			$jk='P';
		}

		$title = 'User';

		$table='user';
		$data=[
			'user_nama'=>$nama,
			'user_email'=>$email,
			'user_alamat'=>$alamat,
			'user_jk'=>$jk,
			'user_tel'=>$tel,
			'user_role'=>$role
		];
		$where =[ 
			'user_id' => $user_id
		];		
		$this->Mymod->UpdateData($table,$data,$where);
		$this->session->set_flashdata('success', 'Berhasil merubah data '.$title);
		redirect('admin/user');		
	}	


	public function konfirmasi_pembayaran(){
		$pembayaran_kode=$this->input->post('pembayaran_kode');
		$title = 'Konfirmasi';

		$table='pembayaran';
		$data=[
			'pembayaran_status'=>'selesai',
		];
		$where =[ 
			'pembayaran_kode' => $pembayaran_kode
		];		
		$this->Mymod->UpdateData($table,$data,$where);
		$this->session->set_flashdata('success', 'Berhasil merubah data '.$title);
		redirect('admin/pemesanan');		
	}

	public function konfirmasi_pengiriman(){
		$pemesanan_kode=$this->input->post('pemesanan_kode');
		$title = 'Konfirmasi';

		$table='pemesanan';
		$data=[
			'pemesanan_status'=>'selesai',
		];
		$where =[ 
			'pemesanan_kode' => $pemesanan_kode
		];		
		$this->Mymod->UpdateData($table,$data,$where);
		$this->session->set_flashdata('success', 'Berhasil merubah data '.$title);
		redirect('admin/pemesanan');		
	}

	public function delete_user(){
		$title = 'User';
		$user_id=$this->input->post('user_id');
		$table='user';

		$where =[ 
			'user_id' => $user_id
		];
		$this->Mymod->DeleteData($table,$where);
		$this->session->set_flashdata('success', 'Berhasil menghapus data '.$title);
		redirect('admin/user');
	}		

	public function save_kategori(){

		$kategori_nama=$this->input->post('kategori_nama');
		$keterangan=$this->input->post('keterangan');
		$title='kategori';
		$table='kategori';

		
		$data =[ 
			'kategori_nama'=>$kategori_nama,
			'kategori_ket'=>$keterangan,
		];
		$InsertData=$this->Mymod->InsertData($table,$data);
		if($InsertData){
			$this->session->set_flashdata('success', 'Berhasil menambah data '.$title);
			redirect('admin/kategori');		
		}else{
			$this->session->set_flashdata('error', 'Gagal menambah data '.$title);
			redirect('admin/kategori');		
		}
	}	


	public function save_promo(){
		$produk_kode=$this->input->post('produk_kode');
		$promo_diskon=$this->input->post('promo_diskon');
		$promo_start=$this->input->post('promo_start');
		$promo_end=$this->input->post('promo_end');

		$title='Promo';
		$table='promo';
		$data=[
			'produk_kode'=>$produk_kode,
			'promo_diskon'=>$promo_diskon,
			'promo_start'=>$promo_start,
			'promo_end'=>$promo_end
		];
		$rd=$this->Mymod->insertData($table,$data);
		$this->session->set_flashdata('success', 'Berhasil menambah '.$title);
		redirect('admin/promo');
	}	
	public function save_subkategori(){
		$sk_nama=$this->input->post('sk_nama');
		$kategori_id=$this->input->post('kategori_id');

		$title='Sub-Kategori';
		$table='sub_kategori';
		$data=[
			'sk_nama'=>$sk_nama,
			'kategori_id'=>$kategori_id
		];
		$rd=$this->Mymod->insertData($table,$data);
		$this->session->set_flashdata('success', 'Berhasil menambah '.$title);
		redirect('admin/subkategori');
	}	

	public function save_list(){
		$list_nama=$this->input->post('list_nama');
		$sk_id=$this->input->post('sk_id');

		$title='List';
		$table='list';
		$data=[
			'list_nama'=>$list_nama,
			'sk_id'=>$sk_id
		];
		$rd=$this->Mymod->insertData($table,$data);
		$this->session->set_flashdata('success', 'Berhasil menambah '.$title);
		redirect('admin/list');
	}	


	public function edit_kategori(){
		$kategori_nama=$this->input->post('kategori_nama');
		$keterangan=$this->input->post('keterangan');
		$kategori_id=$this->input->post('kategori_id');
		$title = 'kategori';
		$table='kategori';

		$where = [
			'kategori_id' => $kategori_id
		];

		$data =[ 
			'kategori_nama'=>$kategori_nama,
			'kategori_ket'=>$keterangan,
		];
		$UpdateData=$this->Mymod->UpdateData($table,$data,$where);
		if($UpdateData){
			$this->session->set_flashdata('success', 'Berhasil merubah data '.$title);
			redirect('admin/kategori');		
		}else{
			$this->session->set_flashdata('error', 'Gagal merubah data '.$title);
			redirect('admin/kategori');		
		}
	}

	public function delete_kategori(){
		$title = 'kategori';
		$kategori_id=$this->input->post('kategori_id');
		$table='kategori';

		$where = [
			'kategori_id' => $kategori_id
		];
		$this->Mymod->DeleteData($table,$where);
		$this->session->set_flashdata('success', 'Berhasil menghapus data '.$title);
		redirect('admin/kategori');
	}		


	public function edit_list(){
		$list_nama=$this->input->post('list_nama');
		$sk_id=$this->input->post('sk_id');
		$list_id=$this->input->post('list_id');
		$title = 'List';
		$table='list';
		$data=[
			'list_nama'=>$list_nama,
			'sk_id'=>$sk_id
		];
		$where =[ 
			'list_id' => $list_id
		];
		$this->Mymod->UpdateData($table,$data,$where);
		$this->session->set_flashdata('success', 'Berhasil merubah data '.$title);
		redirect('admin/list');		
	}

	public function delete_list(){
		$title = 'List';
		$list_id=$this->input->post('list_id');
		$table='list';

		$where = [
			'list_id' => $list_id
		];
		$this->Mymod->DeleteData($table,$where);
		$this->session->set_flashdata('success', 'Berhasil menghapus data '.$title);
		redirect('admin/list');
	}		


	public function edit_subkategori(){
		$sk_nama=$this->input->post('sk_nama');
		$sk_id=$this->input->post('sk_id');
		$kategori_id=$this->input->post('kategori_id');
		$title = 'Sub-Kategori';
		$table='sub_kategori';
		$data=[
			'sk_nama'=>$sk_nama,
			'kategori_id'=>$kategori_id
		];
		$where =[ 
			'sk_id' => $sk_id
		];
		$this->Mymod->UpdateData($table,$data,$where);
		$this->session->set_flashdata('success', 'Berhasil merubah data '.$title);
		redirect('admin/subkategori');		
	}

	public function delete_subkategori(){
		$title = 'Sub-Kategori';
		$sk_id=$this->input->post('sk_id');
		$table='sub_kategori';

		$where = [
			'sk_id' => $sk_id
		];
		$this->Mymod->DeleteData($table,$where);
		$this->session->set_flashdata('success', 'Berhasil menghapus data '.$title);
		redirect('admin/subkategori');
	}		

	public function save_slider(){
		$slider_judul=$this->input->post('slider_judul');
		$keterangan=$this->input->post('keterangan');
		$table='slider';
		$title='slider';

		if(!empty($_FILES['filefoto']['name'])){

			$config['upload_path'] = './assets/images/slider';
			$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; 
			$config['encrypt_name'] = TRUE; 

			$this->upload->initialize($config);
			if(!empty($_FILES['filefoto']['name'])){

				if ($this->upload->do_upload('filefoto')){
					$gbr = $this->upload->data();
					$config['image_library']='gd2';
					$config['source_image']='./assets/images/slider/'.$gbr['file_name'];
					$config['create_thumb']= FALSE;
					$config['maintain_ratio']= FALSE;
					$config['quality']= '100%';
					$config['width']= 1920;
					$config['height']= 760;
					$config['new_image']= './assets/images/slider/'.$gbr['file_name'];
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();

					$gambar=$gbr['file_name'];
					
					$data =[ 
						'slider_judul' => $slider_judul,
						'slider_ket' => $keterangan,
						'slider_gambar' => $gambar
					];
					$InsertData=$this->Mymod->InsertData($table,$data);
					if($InsertData){
						$this->session->set_flashdata('success', 'Berhasil merubah data '.$title);
						redirect('admin/slider');		
					}else{
						$this->session->set_flashdata('error', 'Gagal merubah data '.$title);
						redirect('admin/slider');		
					}
				}

			}else{
				$this->session->set_flashdata('error', 'Gagal mengupload gambar '.$title);
				redirect('admin/slider');	
			}
		} else{
			$data =[ 
				'slider_judul' => $slider_judul,
				'slider_ket' => $keterangan,
			];
			$UpdateData=$this->Mymod->UpdateData($table,$data,$where);
			if($UpdateData){
				$this->session->set_flashdata('success', 'Berhasil merubah data '.$title);
				redirect('admin/slider');		
			}else{
				$this->session->set_flashdata('error', 'Gagal merubah data '.$title);
				redirect('admin/slider');		
			}

		}

	}	


	public function edit_slider(){
		$slider_judul=$this->input->post('slider_judul');
		$slider_id=$this->input->post('slider_id');
		$keterangan=$this->input->post('keterangan');
		$oldimg=$this->input->post('oldimg');
		$table='slider';
		$title='slider';

		$where = [
			'slider_id' => $slider_id
		];

		if(!empty($_FILES['filefoto']['name'])){

			$config['upload_path'] = './assets/images/slider';
			$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; 
			$config['encrypt_name'] = TRUE; 

			$this->upload->initialize($config);
			if(!empty($_FILES['filefoto']['name'])){

				if ($this->upload->do_upload('filefoto')){
					$gbr = $this->upload->data();
                //Compress Image
					$config['image_library']='gd2';
					$config['source_image']='./assets/images/slider/'.$gbr['file_name'];
					$config['create_thumb']= FALSE;
					$config['maintain_ratio']= FALSE;
					$config['quality']= '100%';
					$config['width']= 1920;
					$config['height']= 760;
					$config['new_image']= './assets/images/slider/'.$gbr['file_name'];
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();

					$gambar=$gbr['file_name'];
					

					$data = [
						'slider_judul' => $slider_judul,
						'slider_ket' => $keterangan,
						'slider_gambar' => $gambar
					];

					$UpdateData=$this->Mymod->UpdateData($table,$data,$where);
					if($UpdateData){

						if($oldimg != null){
							if(file_exists('assets/images/slider/'.$oldimg)) {
								unlink('assets/images/slider/'.$oldimg);
							}
						}

						$this->session->set_flashdata('success', 'Berhasil merubah data '.$title);
						redirect('admin/slider');		
					}else{
						$this->session->set_flashdata('error', 'Gagal merubah data '.$title);
						redirect('admin/slider');		
					}
				}

			}else{
				$this->session->set_flashdata('error', 'Gagal mengupload gambar '.$title);
				redirect('admin/slider');	
			}
		} else{
			$data =[ 
				'slider_judul' => $slider_judul,
				'slider_ket' => $keterangan,
			];
			$UpdateData=$this->Mymod->UpdateData($table,$data,$where);
			if($UpdateData){
				$this->session->set_flashdata('success', 'Berhasil merubah data '.$title);
				redirect('admin/slider');		
			}else{
				$this->session->set_flashdata('error', 'Gagal merubah data '.$title);
				redirect('admin/slider');		
			}

		}
	}

	public function delete_slider(){
		$title = 'slider';
		$slider_id=$this->input->post('slider_id');
		$table='slider';

		$where =[ 
			'slider_id' => $slider_id
		];
		$this->Mymod->DeleteData($table,$where);
		$this->session->set_flashdata('success', 'Berhasil menghapus data '.$title);
		redirect('admin/slider');
	}		



	public function save_produk(){
		$produk_kode=$this->input->post('produk_kode');
		$produk_nama=$this->input->post('produk_nama');
		$produk_harga=$this->input->post('produk_harga');
		$produk_up=$this->input->post('produk_up');
		$produk_parent=$this->input->post('produk_parent');
		$sk_id=$this->input->post('sk_id');
		$keterangan=$this->input->post('keterangan');
		$table='produk';
		$title='produk';

		$config['upload_path'] = 'assets\images\product';
		$config['allowed_types'] = 'jpg|jpeg|png|gif';
		$config['encrypt_name'] = TRUE; 

		$this->upload->initialize($config);
		if(!empty($_FILES['filefoto']['name'])){

			if ($this->upload->do_upload('filefoto')){
				$config['image_library'] = 'gd2';
				$config['source_image'] = $this->upload->upload_path.$this->upload->file_name;
				$filename = $_FILES['filefoto']['tmp_name'];


				$imgdata=exif_read_data($this->upload->upload_path.$this->upload->file_name, 'IFD0');


				list($width, $height) = getimagesize($filename);
				if ($width >= $height){
					$config['width'] = 800;
				}
				else{
					$config['height'] = 800;
				}
				$config['master_dim'] = 'auto';


				$this->load->library('image_lib',$config); 

				if (!$this->image_lib->resize()){  
					echo "error";
				}else{

					$this->image_lib->clear();
					$config=array();

					$config['image_library'] = 'gd2';
					$config['source_image'] = $this->upload->upload_path.$this->upload->file_name;


					switch($imgdata['Orientation']) {
						case 3:
						$config['rotation_angle']='180';
						break;
						case 6:
						$config['rotation_angle']='270';
						break;
						case 8:
						$config['rotation_angle']='90';
						break;
					}

					$this->image_lib->initialize($config); 
					$this->image_lib->rotate();
					$gambar=$imgdata['FileName'];

					$data = [
						'produk_kode' => $produk_kode,
						'produk_nama' => $produk_nama,
						'sk_id' => $sk_id,
						'produk_harga' => $produk_harga,
						'produk_up' => $produk_up,
						'produk_parent' => $produk_parent,
						'produk_ket' => $keterangan,
						'produk_gambar' => $gambar
					];
					$InsertData=$this->Mymod->InsertData($table,$data);
					if($InsertData){
						$this->session->set_flashdata('success', 'Berhasil menambah data '.$title);
						redirect('admin/produk');		
					}else{
						$this->session->set_flashdata('error', 'Gagal menambah data '.$title);
						redirect('admin/produk');		
					}
				}
			}

		}else{
			$data = [
				'produk_kode' => $produk_kode,
				'produk_nama' => $produk_nama,
				'sk_id' => $sk_id,
				'produk_harga' => $produk_harga,
				'produk_up' => $produk_up,
				'produk_parent' => $produk_parent,
				'produk_ket' => $keterangan,
			];
			$InsertData=$this->Mymod->InsertData($table,$data);
			if($InsertData){
				$this->session->set_flashdata('success', 'Berhasil menambah data '.$title);
				redirect('admin/produk');		
			}else{
				$this->session->set_flashdata('error', 'Gagal menambah data '.$title);
				redirect('admin/produk');		
			}
		}
	}	

	public function save_rekening(){
		$rekening_bank=$this->input->post('rekening_bank');
		$rekening_nama=$this->input->post('rekening_nama');
		$rekening_nomor=$this->input->post('rekening_nomor');
		$table='rekening';
		$title='Rekening';

		if(!empty($_FILES['filefoto']['name'])){
			$config['upload_path'] = 'assets\images';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$config['file_name'] = $_FILES['filefoto']['name'];
			$config['width'] = 1000;
			$config['height'] = 750;

			$this->load->library('upload',$config);
			$this->upload->initialize($config);

			if($this->upload->do_upload('filefoto')){
				$uploadData = $this->upload->data();
				$rekening_gambar = $uploadData['file_name'];
				$data = [
					'rekening_bank' => $rekening_bank,
					'rekening_nama' => $rekening_nama,
					'rekening_nomor' => $rekening_nomor,
					'rekening_gambar' => $rekening_gambar
				];
				$InsertData=$this->Mymod->InsertData($table,$data);
				if($InsertData){
					$this->session->set_flashdata('success', 'Berhasil menambah data '.$title);
					redirect('admin/rekening');		
				}else{
					$this->session->set_flashdata('error', 'Gagal menambah data '.$title);
					redirect('admin/rekening');		
				}
			}else{
				$data =[
					'rekening_bank' => $rekening_bank,
					'rekening_nama' => $rekening_nama,
					'rekening_nomor' => $rekening_nomor,
				];
				$InsertData=$this->Mymod->InsertData($table,$data);
				if($InsertData){
					$this->session->set_flashdata('success', 'Berhasil menambah data '.$title);
					redirect('admin/rekening');		
				}else{
					$this->session->set_flashdata('error', 'Gagal menambah data '.$title);
					redirect('admin/rekening');		
				}
			}
		}else{
			$data =[ 
				'rekening_bank' => $rekening_bank,
				'rekening_nama' => $rekening_nama,
				'rekening_nomor' => $rekening_nomor,
			];
			$InsertData=$this->Mymod->InsertData($table,$data);
			if($InsertData){
				$this->session->set_flashdata('success', 'Berhasil menambah data '.$title);
				redirect('admin/rekening');		
			}else{
				$this->session->set_flashdata('error', 'Gagal menambah data '.$title);
				redirect('admin/rekening');		
			}
		}


	}	

	public function edit_produk(){
		$produk_parent=$this->input->post('produk_parent');
		$produk_kode=$this->input->post('produk_kode');
		$produk_nama=$this->input->post('produk_nama');
		$produk_harga=$this->input->post('produk_harga');
		$produk_up=$this->input->post('produk_up');
		$produk_parent=$this->input->post('produk_parent');
		$sk_id=$this->input->post('sk_id');
		$keterangan=$this->input->post('keterangan');
		$oldimg=$this->input->post('oldimg');
		$table='produk';
		$title='produk';

		$where =[ 
			'produk_kode' => $produk_kode
		];

		$config['upload_path'] = 'assets\images\product';
		$config['allowed_types'] = 'jpg|jpeg|png|gif';
		$config['encrypt_name'] = TRUE; 

		$this->upload->initialize($config);
		if(!empty($_FILES['filefoto']['name'])){

			if ($this->upload->do_upload('filefoto')){
				$config['image_library'] = 'gd2';
				$config['source_image'] = $this->upload->upload_path.$this->upload->file_name;
				$filename = $_FILES['filefoto']['tmp_name'];

				if($oldimg != null){
					if(file_exists('assets/images/product/'.$oldimg)) {
						unlink('assets/images/product/'.$oldimg);
					}
				}

				$imgdata=exif_read_data($this->upload->upload_path.$this->upload->file_name, 'IFD0');


				list($width, $height) = getimagesize($filename);
				if ($width >= $height){
					$config['width'] = 800;
				}
				else{
					$config['height'] = 800;
				}
				$config['master_dim'] = 'auto';


				$this->load->library('image_lib',$config); 

				if (!$this->image_lib->resize()){  
					echo "error";
				}else{

					$this->image_lib->clear();
					$config=array();

					$config['image_library'] = 'gd2';
					$config['source_image'] = $this->upload->upload_path.$this->upload->file_name;


					switch($imgdata['Orientation']) {
						case 3:
						$config['rotation_angle']='180';
						break;
						case 6:
						$config['rotation_angle']='270';
						break;
						case 8:
						$config['rotation_angle']='90';
						break;
					}

					$this->image_lib->initialize($config); 
					$this->image_lib->rotate();
					$gambar=$imgdata['FileName'];

					$data = [
						'produk_nama' => $produk_nama,
						'sk_id' => $sk_id,
						'produk_harga' => $produk_harga,
						'produk_ket' => $keterangan,
						'produk_up' => $produk_up,
						'produk_parent' => $produk_parent,
						'produk_gambar' => $gambar
					];

					$UpdateData=$this->Mymod->UpdateData($table,$data,$where);
					if($UpdateData){
						$this->session->set_flashdata('success', 'Berhasil merubah data '.$title);
						redirect('admin/produk');		
					}else{
						$this->session->set_flashdata('error', 'Gagal merubah data '.$title);
						redirect('admin/produk');		
					}
				}
			}

		}else{
			$data = [
				'produk_kode' => $produk_kode,
				'produk_nama' => $produk_nama,
				'sk_id' => $sk_id,
				'produk_up' => $produk_up,
				'produk_parent' => $produk_parent,
				'produk_harga' => $produk_harga,
				'produk_ket' => $keterangan,
			];

			$UpdateData=$this->Mymod->UpdateData($table,$data,$where);
			if($UpdateData){
				$this->session->set_flashdata('success', 'Berhasil merubah data '.$title);
				redirect('admin/produk');		
			}else{
				$this->session->set_flashdata('error', 'Gagal merubah data '.$title);
				redirect('admin/produk');		
			}
		}
	}
	public function edit_rekening(){
		$rekening_id=$this->input->post('rekening_id');
		$rekening_bank=$this->input->post('rekening_bank');
		$rekening_nama=$this->input->post('rekening_nama');
		$rekening_nomor=$this->input->post('rekening_nomor');
		$table='rekening';
		$title='Rekening';

		$where =[ 
			'rekening_id' => $rekening_id
		];


		if(!empty($_FILES['filefoto']['name'])){
			$config['upload_path'] = 'assets\images';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$config['file_name'] = $_FILES['filefoto']['name'];
			$config['width'] = 1000;
			$config['height'] = 750;

			$this->load->library('upload',$config);
			$this->upload->initialize($config);

			if($this->upload->do_upload('filefoto')){
				$uploadData = $this->upload->data();
				$rekening_gambar = $uploadData['file_name'];
				$data = [
					'rekening_bank' => $rekening_bank,
					'rekening_nama' => $rekening_nama,
					'rekening_nomor' => $rekening_nomor,
					'rekening_gambar' => $rekening_gambar
				];

				$UpdateData=$this->Mymod->UpdateData($table,$data,$where);
				if($UpdateData){
					$this->session->set_flashdata('success', 'Berhasil merubah data '.$title);
					redirect('admin/rekening');		
				}else{
					$this->session->set_flashdata('error', 'Gagal merubah data '.$title);
					redirect('admin/rekening');		
				}
			}else{

				$data = [
					'rekening_id' => $rekening_id,
					'rekening_bank' => $rekening_bank,
					'rekening_nama' => $rekening_nama,
					'rekening_nomor' => $rekening_nomor,
				];

				$UpdateData=$this->Mymod->UpdateData($table,$data,$where);
				if($UpdateData){
					$this->session->set_flashdata('success', 'Berhasil merubah data '.$title);
					redirect('admin/rekening');		
				}else{
					$this->session->set_flashdata('error', 'Gagal merubah data '.$title);
					redirect('admin/rekening');		
				}
			}
		}else{

			$data = [
				'rekening_id' => $rekening_id,
				'rekening_bank' => $rekening_bank,
				'rekening_nama' => $rekening_nama,
				'rekening_nomor' => $rekening_nomor,
			];

			$UpdateData=$this->Mymod->UpdateData($table,$data,$where);
			if($UpdateData){
				$this->session->set_flashdata('success', 'Berhasil merubah data '.$title);
				redirect('admin/rekening');		
			}else{
				$this->session->set_flashdata('error', 'Gagal merubah data '.$title);
				redirect('admin/rekening');		
			}
		}
	}	



	public function delete_produk(){
		$title = 'produk';
		$produk_kode=$this->input->post('produk_kode');
		$table='produk';

		$where = [
			'produk_kode' => $produk_kode
		];
		$this->Mymod->DeleteData($table,$where);
		$this->session->set_flashdata('success', 'Berhasil menghapus data '.$title);
		redirect('admin/produk');
	}		
	public function delete_rekening(){
		$title = 'Rekening';
		$rekening_id=$this->input->post('rekening_id');
		$table='rekening';

		$where =[ 
			'rekening_id' => $rekening_id
		];
		$this->Mymod->DeleteData($table,$where);
		$this->session->set_flashdata('success', 'Berhasil menghapus data '.$title);
		redirect('admin/rekening');
	}		


}