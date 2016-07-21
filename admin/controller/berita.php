<?php
// defined ('TATARUANG') or exit ( 'Forbidden Access' );

class berita extends Controller {
	
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
		$this->mberita= $this->loadModel('mberita');
	}
	
	public function index(){
	
		$data = $this->contentHelper->fetchData('jdih_berita',1,'n_status = 1','id_berita DESC');

		foreach ($data as $key => $value) {

			$data[$key]['tanggal'] = dateFormat($value['tanggal'],'article');

			if($value['create_date'] != "0000-00-00"){
				$data[$key]['create_date'] = dateFormat($value['create_date'],'article');
			}
		}
		
		$this->view->assign('data',$data);
		
		return $this->loadView('berita/berita');

	}

	public function tambah(){
		return $this->loadView('berita/tambah');

	}
	
	public function insert_berita()
	{
		global $basedomain;

		$data = $_POST;
		$upload = uploadFile('myfile','berita');
		//db($upload);

		if($upload['status'] = 1)
		{
			$data['file'] = "berita/".$upload['full_name'];
			$data['file_name'] = $upload['real_name'];
		}
		
		$upload_cover = uploadFile('cover','berita');
		
		if($upload_cover['status'] == 1){
			$data['cover'] = "berita/".$upload_cover['full_name'];	
		}

		$data['ringkasan'] = htmlentities(htmlspecialchars($_POST['ringkasan'], ENT_QUOTES));
		$data['isi'] = htmlentities(htmlspecialchars($_POST['isi'], ENT_QUOTES));
		$data['tanggal'] = changeFormatDate($_POST['tanggal'],'d/m/Y','Y-m-d');
		$data['n_status'] = 1;
		
		$this->contentHelper->insertData($data,'jdih_berita');
		
		echo "<script>alert('Data berhasil disimpan');window.location.href='".$basedomain."berita'</script>";
		exit;
	
	}
	
	public function edit_berita()
	{
		global $basedomain;
		
		$id_berita = $_GET['id'];
		
		$data = $this->contentHelper->fetchData('jdih_berita',0,"id_berita = {$id_berita}");
		$data['ringkasan'] = html_entity_decode(htmlspecialchars_decode($data['ringkasan'], ENT_NOQUOTES));
		$data['isi'] = html_entity_decode(htmlspecialchars_decode($data['isi'], ENT_NOQUOTES));
		$data['tanggal'] = changeFormatDate($data['tanggal'],'Y-m-d','d/m/Y');
		//db($data);
		
		$this->view->assign('data',$data);
		
		return $this->loadView('berita/edit_berita');
	}
	
	public function edit()
	{
	
		global $basedomain;
		
		$data = $_POST;
		
		if($_FILES['myfile']['error'] == 0){
				deleteFile($data['file']);
				$upload = uploadFile('myfile','berita');

				if($upload['status'] = 1){
					$data['file'] = "berita/".$upload['full_name'];
					$data['file_name'] = $upload['real_name'];
				}
			}
			
		if($_FILES['cover']['error'] == 0){
			deleteFile($data['cover']);
			$uploadCover = uploadFile('cover','berita');

			if($uploadCover['status'] = 1){
				$data['cover'] = "berita/".$uploadCover['full_name'];
			}
		}
		
			$data['ringkasan'] = htmlentities(htmlspecialchars($_POST['ringkasan'], ENT_QUOTES));
			$data['isi'] = htmlentities(htmlspecialchars($_POST['isi'], ENT_QUOTES));
			$data['tanggal'] = changeFormatDate($_POST['tanggal'],'d/m/Y','Y-m-d');
			//db($data);
			$this->contentHelper->updateData($data,'jdih_berita',"id_berita = {$data['id_berita']}");

			echo "<script>alert('Data berhasil disimpan');window.location.href='".$basedomain."berita'</script>";
			exit;
	
	}
	
	
	public function delete()
	{
		global $basedomain;
		
		$data= $_GET['id'];
		
		$this->contentHelper->deleteData($data,'id_berita','jdih_berita');
		
		echo "<script>alert('Data berhasil dihapus');window.location.href='".$basedomain."berita'</script>";
		exit;
	
	
	}
	
}
?>
