<?php
// defined ('TATARUANG') or exit ( 'Forbidden Access' );

class pengaturan extends Controller {
	
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
		$this->model = $this->loadModel('msetting');
	}
	
	public function index(){
		global $basedomain;

		if($this->admin['type'] == 1){
			$getUser = $this->contentHelper->fetchData('ck_admin_member',1,'n_status = 1');
			$getJenis = $this->contentHelper->fetchData('jdih_jenis',1,'n_status = 1');

			$this->view->assign('user',$getUser);
			$this->view->assign('jenis',$getJenis);
			$this->view->assign('admin',$this->admin);
			
			return $this->loadView('pengaturan/pengaturan');	
		} else {
			echo "<script>alert('Anda tidak memiliki akses');window.location.href='".$basedomain."home'</script>";
			exit;	
		}
		

	}

	public function add_admin()
	{
		global $basedomain;

		$_POST['salt'] = "codekir v3.0";
		$_POST['n_status'] = "1";
		$_POST['password'] = sha1($_POST['password'].$_POST['salt']);

		$this->contentHelper->insertData($_POST,'ck_admin_member');

		echo "<script>alert('Data berhasil disimpan');window.location.href='".$basedomain."pengaturan'</script>";
		exit;
	}

	public function add_produk()
	{
		global $basedomain;

		$_POST['n_status'] = 1;

		$this->contentHelper->insertData($_POST,'jdih_jenis');

		echo "<script>alert('Data berhasil disimpan');window.location.href='".$basedomain."pengaturan'</script>";
		exit;
	}

	public function del_jenis()
	{
		global $basedomain;

		$id = $_GET['id'];

		$this->contentHelper->deleteData($id,'id_jenis','jdih_jenis');

		echo "<script>alert('Data berhasil dihapus');window.location.href='".$basedomain."pengaturan'</script>";
		exit;
	}

	public function edit_produk()
	{
		global $basedomain;

		$this->contentHelper->updateData($_POST,'jdih_jenis',"id_jenis = {$_POST['id_jenis']}");

		echo "<script>alert('Data berhasil disimpan');window.location.href='".$basedomain."pengaturan'</script>";
		exit;
	}

	public function edit_admin()
	{
		global $basedomain;

		$_POST['salt'] = "codekir v3.0";
		$_POST['password'] = sha1($_POST['password'].$_POST['salt']);

		$this->contentHelper->updateData($_POST,'ck_admin_member',"id = {$_POST['id']}");

		echo "<script>alert('Data berhasil disimpan');window.location.href='".$basedomain."pengaturan'</script>";
		exit;
	}

	public function dis_admin()
	{
		global $basedomain;

		$id = $_GET['id'];

		$this->contentHelper->deleteData($id,'id','ck_admin_member');

		echo "<script>alert('Data berhasil dihapus');window.location.href='".$basedomain."pengaturan'</script>";
		exit;


	}

	public function ajaxgetkonten()
	{
		$data = $this->contentHelper->fetchData('jdih_konten',0,"id_kontent = {$_POST['type']}");

		echo json_encode($data);
		exit;
	}

	public function konten()
	{
		global $basedomain;

		$this->contentHelper->updateData($_POST,'jdih_konten',"type = {$_POST['type']}");

		echo "<script>alert('Data berhasil disimpan');window.location.href='".$basedomain."pengaturan'</script>";
		exit;
	}

	
}

?>
