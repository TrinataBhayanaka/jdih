<?php
// defined ('TATARUANG') or exit ( 'Forbidden Access' );

class referensi extends Controller {
	
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
		// $this->marticle = $this->loadModel('marticle');
		// $this->mquiz = $this->loadModel('mquiz');
		// $this->mcourse = $this->loadModel('mcourse');
		$this->mhome = $this->loadModel('mhome');
		$this->mref = $this->loadModel('mref');
	}
	
	public function index(){
	
		$data = $this->contentHelper->fetchData('jdih_referensi',1,'n_status = 1','id_ref DESC');

		foreach ($data as $key => $value) {

			$data[$key]['tanggal'] = dateFormat($value['tanggal'],'article');

			if($value['create_date'] != "0000-00-00"){
				$data[$key]['create_date'] = dateFormat($value['create_date'],'article');
			}
		}
		
		$this->view->assign('data',$data);
		$this->view->assign('admin',$this->admin);
		
		return $this->loadView('referensi/referensi');

	}
	
	public function tambah(){
	
		global $basedomain;
		
		$data = $_POST;
		$upload = uploadFile('myfile','ref');

		
		if($upload['status'] == 1){
			$data['file'] = "ref/".$upload['full_name'];
			$data['file_name'] = $upload['real_name'];
		}
		
		$upload_cover = uploadFile('cover','ref');
		if($upload_cover['status'] == 1){
			$data['cover'] = "ref/".$upload_cover['full_name'];	
		}
		
		$data['tanggal'] = changeFormatDate($_POST['tanggal'],'d/m/Y','Y-m-d');
		$data['n_status'] = 1;
		$data['resensi']=addslashes($data['resensi']);
		$this->contentHelper->insertData($data,'jdih_referensi');

		echo "<script>alert('Data berhasil disimpan');window.location.href='".$basedomain."referensi'</script>";
		exit;

	}
	
	public function edit()
	{
	
		global $basedomain;
		
		$data = $_POST;
		
		if($_FILES['myfile']['error'] == 0){
			deleteFile($data['ref']);
			$upload = uploadFile('myfile','ref');

			if($upload['status'] == 1){
				$data['file'] = "ref/".$upload['full_name'];
				$data['file_name'] = $upload['real_name'];
			}
		}

		$data['tanggal'] = changeFormatDate($_POST['tanggal'],'d/m/Y','Y-m-d');

		
		$this->contentHelper->updateData($data,'jdih_referensi',"id_ref = {$data['id_ref']}");

		echo "<script>alert('Data berhasil disimpan');window.location.href='".$basedomain."referensi'</script>";
		exit;
	
	}
	
	public function delete()
	{
		global $basedomain;
		$id_ref = $_GET['id'];
		
		$this->contentHelper->deleteData($id_ref,'id_ref','jdih_referensi');

		echo "<script>alert('Data berhasil dihapus');window.location.href='".$basedomain."referensi'</script>";
		exit;
	
	}
	
	public function ajax_ref()
	{
		$id_ref = $_GET['id'];
		
		$data = $this->contentHelper->fetchData('jdih_referensi',0,"id_ref= {$id_ref}");
		$data['tanggal'] = changeFormatDate($data['tanggal'],'Y-m-d','d/m/Y');
		
		$this->view->assign('data',$data);
		$this->view->assign('admin',$this->admin);
	
		return $this->loadView('referensi/modal_ref');
	}
	
	public function ajaxPublish()
	{
		$data['id_ref'] = $_POST['id'];
		if($_POST['state'] == 1){
			$data['publish'] = 2;
		} else {
			$data['publish'] = 1;
		}

		$data['create_date'] = date("Y-m-d H:i:s");

		$this->contentHelper->updateData($data,'jdih_referensi',"id_ref = {$data['id_ref']}");
		return true;
		exit;
	}

	
}

?>
