<?php

class referensi extends Controller {
	
	var $models = FALSE;
	var $view;
	var $reportHelper;
	
	function __construct()
	{
		global $basedomain;
		$this->loadmodule();
		$this->view = $this->setSmarty();
		$this->view->assign('basedomain',$basedomain);
		$getUserLogin = $this->isUserOnline();
		$this->user = $getUserLogin[0];
        $this->token = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
    }
	
	function loadmodule()
	{
        $this->contentHelper = $this->loadModel('contentHelper');
        $this->userHelper = $this->loadModel('userHelper');
	}
	
	function index(){
		
		return $this->loadView('home');
    }
	
	function detail(){
		$id = $_GET['id'];
		$ref = $this->contentHelper->fetchData('jdih_referensi',0,'n_status = 1 and id_ref='.$id,'id_ref DESC');
		
		$this->view->assign('ref',$ref);
		return $this->loadView('referensi/detail_referensi');
    }
	


}

?>
