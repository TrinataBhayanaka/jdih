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
		$jenis = $this->contentHelper->fetchData('jdih_jenis',1,"n_status = 1");
		// pr($jenis);
		// $this->view->assign('jenis',$jenis);
		return $this->loadView('home');

	}
	public function tutorial(){
		// echo json_encode($data);
		// exit;
		// $jenis = $this->contentHelper->fetchData('jdih_jenis',1,"n_status = 1");
		// pr($jenis);
		// $this->view->assign('jenis',$jenis);
		return $this->loadView('tutorial');

	}
	
	public function listData(){
		
		//$sql = "SELECT * FROM Orders LIMIT 0, 10";
		//The SQL query above says "return only 10 records, start on record 0 (OFFSET 0)":
		//param URL : page
		//example URL 
		//URL :http://localhost/jdih/services/home/listData/?page=1
		//return only 50 records, start on record 0 (OFFSET 0)
		
			$page = $_GET['page'];
			$item_perpage = 50;
			$position = ($page-1) * $item_perpage;
			if($page != ''){
				$produk = $this->contentHelper->fetchData('jdih_produk',1,'n_status = 1 AND publish = 1','id_produk',"{$position},{$item_perpage}");
				foreach ($produk as $key => $value) {
					$produk[$key]['deskripsi'] = html_entity_decode(htmlspecialchars_decode($value['deskripsi'], ENT_NOQUOTES));
					$produk[$key]['tanggal'] = dateFormat($value['tanggal'],'article-day');
				
					$jenis = $this->contentHelper->fetchData('jdih_jenis',0,"n_status = 1 AND id_jenis = {$value['id_jenis']}");
					$produk[$key]['jenis'] = $jenis['nama'];
					$hit_count = $this->contentHelper->statistik($value['id_produk'],1);
					$produk[$key]['hit'] = $hit_count['hit'];
				}
			// pr($produk);
			// print_r(json_encode($produk));
			print json_encode($produk);
			exit;
		}
	}
	public function searchData(){
	//param URL 
	//page : limit load data
	//first_date : range date (>=) format date Y-m-d		
	//last_date : range date (<=)  format date Y-m-d
	//tahun 
	//produk : dinamic (load database)
	//status : Rancangan/Berlaku/Perubahan/Pencabutan
	//URL : http://localhost/jdih/services/home/searchData/?page=1&first_date=2016-04-11&last_date=2016-04-27
	// pr($_GET);
	$param['tanggal'] = $_GET['first_date'];
	$param['tanggal_2'] = $_GET['last_date'];
	$param['tahun'] = $_GET['tahun'];
	$param['id_jenis'] = $_GET['produk'];
	$param['status_akhir'] = $_GET['status'];
	$page = $_GET['page'];
	$item_perpage = 50;
	$position = ($page-1) * $item_perpage;
	$searchParam = array_filter($param);
		if($searchParam){
			foreach ($searchParam as $key => $val) {
				//$tmpset[] = $key." = '{$val}'";
				if($key == 'tanggal'){
					$sign = " >= ";
				}elseif($key == 'tanggal_2'){
					$sign = " <= ";
				}else{
					$sign = " = ";
				}
				$tmpset[] = $key.$sign."'{$val}'";
			}
			$set = implode(' AND ', $tmpset);
			$set = str_replace("tanggal_2","tanggal",$set);
			// pr($set);
			$produk = $this->contentHelper->fetchData('jdih_produk',1,"n_status = 1 AND publish = 1 AND {$set}",'id_produk',"{$position},{$item_perpage}");
				foreach ($produk as $key => $value) {
					$produk[$key]['deskripsi'] = html_entity_decode(htmlspecialchars_decode($value['deskripsi'], ENT_NOQUOTES));
					$produk[$key]['tanggal'] = dateFormat($value['tanggal'],'article-day');
				
					$jenis = $this->contentHelper->fetchData('jdih_jenis',0,"n_status = 1 AND id_jenis = {$value['id_jenis']}");
					$produk[$key]['jenis'] = $jenis['nama'];
					$hit_count = $this->contentHelper->statistik($value['id_produk'],1);
					$produk[$key]['hit'] = $hit_count['hit'];
				}
		}
		// pr($produk);
		print json_encode($produk);
		exit;
	}
	
	
	
	
}

?>
