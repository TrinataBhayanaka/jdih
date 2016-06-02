<?php
// defined ('TATARUANG') or exit ( 'Forbidden Access' );

class produk extends Controller {
	
	var $models = FALSE;
	
	public function __construct()
	{
		parent::__construct();

		global $app_domain;
		$this->loadmodule();
		$this->view = $this->setSmarty();
		$sessionAdmin = new Session;
		$this->admin = $sessionAdmin->get_session();
		// $this->validatePage();
		$this->view->assign('app_domain',$app_domain);
	}
	public function loadmodule()
	{
		
		$this->contentHelper = $this->loadModel('contentHelper');
		
		$this->mhome = $this->loadModel('mproduk');
	}
	
	public function index(){

		$data = $this->contentHelper->fetchData('jdih_produk',1,'n_status = 1','id_produk DESC');

		foreach ($data as $key => $value) {
			$jenis = $this->contentHelper->fetchData('jdih_jenis',0,"id_jenis = {$value['id_jenis']}");
			$data[$key]['id_jenis'] = $jenis['nama'];

			$data[$key]['tanggal'] = dateFormat($value['tanggal'],'article');

			if($value['create_date'] != "0000-00-00"){
				$data[$key]['create_date'] = dateFormat($value['create_date'],'article');
			}
		}
		
		$this->view->assign('data',$data);
		$this->view->assign('admin',$this->admin);

		return $this->loadView('produk/produk');

	}

	public function tambah(){

		$jenis = $this->contentHelper->fetchData('jdih_jenis',1,'n_status = 1');
		
		$this->view->assign('jenis',$jenis);
		$this->view->assign('admin',$this->admin);

		return $this->loadView('produk/tambah');

	}

	public function ins_produk()
	{
		global $basedomain;

		$data = $_POST;
		$upload = uploadFile('myfile','file');

		if($upload['status'] = 1){
			$data['file'] = "file/".$upload['full_name'];
			$data['file_name'] = $upload['real_name'];
		}

		$data['deskripsi'] = htmlentities(htmlspecialchars($_POST['deskripsi'], ENT_QUOTES));
		$data['tanggal'] = changeFormatDate($_POST['tanggal'],'d/m/Y','Y-m-d');
		$data['n_status'] = 1;

		$this->contentHelper->insertData($data,'jdih_produk');

		echo "<script>alert('Data berhasil disimpan');window.location.href='".$basedomain."produk'</script>";
		exit;
	}

	public function delete()
	{
		global $basedomain;

		$id_produk = $_GET['id'];

		$this->contentHelper->deleteData($id_produk,'id_produk','jdih_produk');

		echo "<script>alert('Data berhasil dihapus');window.location.href='".$basedomain."produk'</script>";
		exit;
	}

	public function edit()
	{
		$id_produk = $_GET['id'];

		$data = $this->contentHelper->fetchData('jdih_produk',0,"id_produk = {$id_produk}");
		$data['deskripsi'] = html_entity_decode(htmlspecialchars_decode($data['deskripsi'], ENT_NOQUOTES));
		$data['tanggal'] = changeFormatDate($data['tanggal'],'Y-m-d','d/m/Y');

		$jenis = $this->contentHelper->fetchData('jdih_jenis',1,'n_status = 1');
		
		$this->view->assign('jenis',$jenis);
		$this->view->assign('data',$data);
		$this->view->assign('admin',$this->admin);

		return $this->loadView('produk/edit');
	}

	public function edit_produk()
	{
		global $basedomain;

		$data = $_POST;
		
		if($_FILES['myfile']['error'] == 0){
			deleteFile($data['file']);
			$upload = uploadFile('myfile','file');

			if($upload['status'] = 1){
				$data['file'] = "file/".$upload['full_name'];
				$data['file_name'] = $upload['real_name'];
			}
		}

		$data['deskripsi'] = htmlentities(htmlspecialchars($_POST['deskripsi'], ENT_QUOTES));
		$data['tanggal'] = changeFormatDate($_POST['tanggal'],'d/m/Y','Y-m-d');

		
		$this->contentHelper->updateData($data,'jdih_produk',"id_produk = {$data['id_produk']}");

		echo "<script>alert('Data berhasil disimpan');window.location.href='".$basedomain."produk'</script>";
		exit;
	}

	public function ajaxPublish()
	{
		$data['id_produk'] = $_POST['id'];
		if($_POST['state'] == 1){
			$data['publish'] = 2;
		} else {
			$data['publish'] = 1;
		}

		$data['create_date'] = date("Y-m-d H:i:s");

		$this->contentHelper->updateData($data,'jdih_produk',"id_produk = {$data['id_produk']}");
		return true;
		exit;
	}
	
}

?>
