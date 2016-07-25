<?php
// defined ('TATARUANG') or exit ( 'Forbidden Access' );

class home extends Controller {
	
	var $models = FALSE;
	
	public function __construct()
	{
		parent::__construct();
		$this->loadmodule();
		
		// $this->validatePage();
	}
	public function loadmodule()
	{
		
		$this->contentHelper = $this->loadModel('contentHelper');
	}
	
	public function index(){
		// echo json_encode($data);
		// exit;
		return $this->loadView('home');

	}
	
	public function list(){
		//
		$produk = $this->contentHelper->fetchData('jdih_produk',1,'n_status = 1 AND publish = 1','tanggal',1);
		foreach ($produk as $key => $value) {
			$produk[$key]['deskripsi'] = html_entity_decode(htmlspecialchars_decode($value['deskripsi'], ENT_NOQUOTES));
			$produk[$key]['tanggal'] = dateFormat($value['tanggal'],'article-day');
		
			$jenis = $this->contentHelper->fetchData('jdih_jenis',0,"n_status = 1 AND id_jenis = {$value['id_jenis']}");
			$produk[$key]['jenis'] = $jenis['nama'];
			$hit_count = $this->contentHelper->statistik($value['id_produk'],1);
			$produk[$key]['hit'] = $hit_count['hit'];
		}
		// print_r(json_encode($produk));
		print json_encode($produk);
		exit;

	}
	
	
	
	function listBerita()
	{
		global $basedomain;
		
		$table="dtataruang_news_content";
		$categoryid="4";
		$articletype="1";
		$orderby=array('postdate','DESC');
       
		// $result_data = $this->contentHelper->getData_news($table,$categoryid,$articletype,$orderby);
		
		// pr($result_data);
		if ($result_data) return $result_data;
	}
    
	public function informasi_gallery(){
        
		global $basedomain;
		
		
		// $result_data = $this->contentHelper->getData_gallery('dtataruang_news_content','6','2');
		
		
		if ($result_data) return $result_data;

	}
	
	public function ajax()
	{
		
		$idLocation = explode("_",$_POST['idLocation']);
		
		
		if ($_POST['idLocation']){
			// $data = $this->contentHelper->getChildLoc($idLocation[0]);
			echo json_encode($data);
		}
		exit;
	} 
}

?>
