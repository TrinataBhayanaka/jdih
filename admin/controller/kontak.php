<?php
// defined ('TATARUANG') or exit ( 'Forbidden Access' );

class kontak extends Controller {
	
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
		// $this->model = $this->loadModel('msetting');
	}
	
	public function index(){
		global $basedomain;

		// if($this->admin['type'] == 1){
			// $getUser = $this->contentHelper->fetchData('ck_admin_member',1,'n_status = 1');
			$getKontak = $this->contentHelper->fetchData('jdih_kontak',1,'id is not null');
			$this->view->assign('data',$getKontak);
			return $this->loadView('kontak');
			/*$this->view->assign('jenis',$getJenis);
			$this->view->assign('admin',$this->admin);
			
			return $this->loadView('kontak');	
		} else {
			echo "<script>alert('Anda tidak memiliki akses');window.location.href='".$basedomain."home'</script>";
			exit;	
		}*/
	}
}

?>
