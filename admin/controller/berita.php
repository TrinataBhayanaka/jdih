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
	}
	
	public function index(){
		
		return $this->loadView('berita/berita');

	}

	public function tambah(){

		return $this->loadView('berita/tambah');

	}

	
}

?>
