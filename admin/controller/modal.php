<?php
// defined ('TATARUANG') or exit ( 'Forbidden Access' );

class modal extends Controller {
	
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
	
	public function jenis_produk()
	{
		$id = $_GET['id'];

		$data = $this->contentHelper->fetchData('jdih_jenis',0,'n_status = 1 AND id_jenis =' . $id);

		$this->view->assign('data',$data);

		return $this->loadView('modal/edit_jenisproduk');
	}

	public function admin()
	{
		$id = $_GET['id'];

		$data = $this->contentHelper->fetchData('ck_admin_member',0,'n_status = 1 AND id =' . $id);

		$this->view->assign('data',$data);

		return $this->loadView('modal/edit_admin');
	}

	

	
}

?>
