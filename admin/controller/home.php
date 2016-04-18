<?php
// defined ('TATARUANG') or exit ( 'Forbidden Access' );

class home extends Controller {
	
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
	}
	
	public function index(){

		$data = $this->contentHelper->fetchData('jdih_produk',1,'n_status = 1 AND publish = 2','id_produk DESC');

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
		
		return $this->loadView('home/home');

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
