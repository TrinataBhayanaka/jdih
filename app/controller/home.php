<?php

class home extends Controller {
	
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
		global $basedomain;
		$produk = $this->contentHelper->GetData('jdih_produk',1,'n_status = 1 and publish = 1 ','id_produk desc LIMIT 3');
		$jns_produk = $this->contentHelper->GetData('jdih_jenis',1,'n_status =1','id_jenis');
		if($produk){
			foreach ($produk as $key=> $values){
				$tmp[] = $values;
				$thn = explode('-',$values['tanggal']);
				$tmp[$key]['Tahun'] = $thn['0'];
				
				foreach ($jns_produk as $val){
					if($values['id_jenis'] == $val['id_jenis']){
						$ket_jns_produk = $val['nama'];
					}
				}
				$tmp[$key]['jns_produk'] = $ket_jns_produk;
				$new_format_tgl = dateFormat($values['tanggal'],'article-day');
				$tmp[$key]['new_fomat_tgl'] = $new_format_tgl;
				$tmp[$key]['ref_deskripsi'] = html_entity_decode(htmlspecialchars_decode($values['deskripsi'], ENT_NOQUOTES));
				$hit_count = $this->contentHelper->statistik($values['id_produk'],1);
				$tmp[$key]['hit'] = $hit_count['hit'];
			}
		}
		$berita = $this->contentHelper->GetData('jdih_berita',1,'n_status = 1 and publish = 1 and jenis = 1 ','id_berita desc LIMIT 3');
		if($berita){
			foreach ($berita as $keys=> $value){
				$tmp2[] = $value;
				$hit_count_2 = $this->contentHelper->statistik($value['id_berita'],2);
				$tmp2[$keys]['hit'] = $hit_count_2['hit'];
			}
		}
		// pr($tmp);
		// pr($tmp2);
		$this->view->assign('produk',$tmp);
		$this->view->assign('berita',$tmp2);
		
		//param ajax
		//produk
		$param_produk = 'produk';
		$count_produk = 'ref_produk';
		$this->view->assign('param_produk',$param_produk);
		$this->view->assign('count_produk',$count_produk);
		
		//berita
		$param_berita = 'berita';
		$count_berita = 'ref_berita';
		$this->view->assign('param_berita',$param_berita);
		$this->view->assign('count_berita',$count_berita);
		
		$ref = $this->contentHelper->fetchData('jdih_referensi',1,'n_status = 1  AND publish = 1 ','id_ref DESC',5);
		$this->view->assign('ref',$ref);
		return $this->loadView('home');
    }
	
	function details(){
	
		$ref = $this->contentHelper->fetchData('jdih_referensi',1,'n_status = 1','id_ref DESC',8);
		// pr($ref);
		$this->view->assign('ref',$ref);
		return $this->loadView('home');
    }
	
	function ajax_count(){
	 // pr($_POST);
	 $id =$_POST['id']; 
	 $type =$_POST['type']; 
	 $date = date('y-m-d');
	 $hit_count =$this->contentHelper->hit_count($id,$type,$date);
	 // pr($hit_count);
	 $newformat = array('hit'=>$hit_count['hit']);
	 print json_encode($newformat);
	 exit;
	}
	
	
	function filter(){
		global $basedomain;
		$searchParam = array_filter($_POST);
		if(isset($searchParam['tanggal'])){
    		$searchParam['tanggal'] = changeFormatDate($searchParam['tanggal'],'d/m/Y','Y-m-d');
    	}
		
		if(isset($searchParam['tanggal_2'])){
    		$searchParam['tanggal_2'] = changeFormatDate($searchParam['tanggal_2'],'d/m/Y','Y-m-d');
    	}
		$flag ="";
		foreach ($searchParam as $key => $val) {
			if($key == 'tanggal'){
				$sign = " >= ";
				$flag ="";
			}elseif($key == 'tanggal_2'){
				$sign = " <= ";
				$flag ="";
			}elseif($key == 'judul'){
				$sign = " like ";
				$flag ="%";
			}else{
				$sign = " = ";
				$flag ="";
			}
			if($key != 'select_jenis'){
				$tmpset[] = $key.$sign."'{$val}{$flag}'";
			}
        }
		if($tmpset){
			$set = implode(' AND ', $tmpset);
			$set = str_replace("tanggal_2","tanggal",$set);
		}
		// pr($set);
		// exit;
		if($_POST['select_jenis'] == 1){
			if($tmpset){
				$data = $this->contentHelper->fetchData('jdih_produk',1,"n_status = 1 AND publish = 1 AND {$set}",'tanggal',3);
				$totalProduk = $this->contentHelper->countData('jdih_produk',"n_status = 1 AND publish = 1 AND {$set}");
			}else{
				$data = $this->contentHelper->fetchData('jdih_produk',1,"n_status = 1 AND publish = 1",'tanggal',3);
				$totalProduk = $this->contentHelper->countData('jdih_produk',"n_status = 1 AND publish = 1");
			}
			
			if($data){
				foreach ($data as $key => $value) {
					$data[$key]['deskripsi'] = html_entity_decode(htmlspecialchars_decode($value['deskripsi'], ENT_NOQUOTES));
					$data[$key]['tanggal'] = dateFormat($value['tanggal'],'article-day');
				
					$jenis = $this->contentHelper->fetchData('jdih_jenis',0,"n_status = 1 AND id_jenis = {$value['id_jenis']}");
					$data[$key]['jenis'] = $jenis['nama'];
					$hit_count = $this->contentHelper->statistik($value['id_produk'],1);
					$data[$key]['hit'] = $hit_count['hit'];
				}
			}
			$ket="Produk Hukum";
		}elseif($_POST['select_jenis'] == 2){
			if($tmpset){
				$berita = $this->contentHelper->GetData("jdih_berita",1,"n_status = 1 and publish = 1 and jenis = 1 and {$set}" ,'tanggal asc LIMIT 3');
				$totalProduk = $this->contentHelper->countData('jdih_berita',"n_status = 1 AND publish = 1 AND jenis = 1 AND {$set}");
			}else{
				$berita = $this->contentHelper->GetData("jdih_berita",1,"n_status = 1 and publish = 1 and jenis = 1" ,'tanggal asc LIMIT 3');
				$totalProduk = $this->contentHelper->countData('jdih_berita',"n_status = 1 AND publish = 1 AND jenis = 1");
			}
			if($berita){
				foreach ($berita as $keys=> $value){
					$data[] = $value;
					$hit_count_2 = $this->contentHelper->statistik($value['id_berita'],2);
					$data[$keys]['hit'] = $hit_count_2['hit'];
				}
			}
			
			$ket="Berita Hukum";
		}elseif($_POST['select_jenis'] == 3){
			if($tmpset){
				$data = $this->contentHelper->fetchData('jdih_berita',1,"n_status = 1  AND publish = 1 AND jenis = 2  AND {$set}",'tanggal',3);
				$totalProduk = $this->contentHelper->countData('jdih_berita',"n_status = 1 AND publish = 1  AND jenis = 2 AND {$set}");
			}else{
				$data = $this->contentHelper->fetchData('jdih_berita',1,"n_status = 1  AND publish = 1 AND jenis = 2 ",'tanggal',3);
				$totalProduk = $this->contentHelper->countData('jdih_berita',"n_status = 1 AND publish = 1 AND jenis = 2");
			}
			$ket="Kajian Hukum";
		}elseif($_POST['select_jenis'] == 4){
			if($tmpset){
				$data = $this->contentHelper->fetchData('jdih_referensi',1,"n_status = 1  AND publish = 1 AND {$set}",'tanggal',3);
				$totalProduk = $this->contentHelper->countData('jdih_referensi',"n_status = 1 AND publish = 1  AND {$set}");
			}else{
				$data = $this->contentHelper->fetchData('jdih_referensi',1,"n_status = 1  AND publish = 1",'tanggal',3);
				$totalProduk = $this->contentHelper->countData('jdih_referensi',"n_status = 1 AND publish = 1");
			}
			
			$ket="Referensi Buku";
		}
		
		$this->view->assign('param',$searchParam);
		$this->view->assign('totalProduk',$totalProduk);
		$this->view->assign('ket',$ket);
		$this->view->assign('data',$data);
		
		//start sidebar
		$produk = $this->contentHelper->GetData('jdih_produk',1,'n_status = 1 and publish = 1','id_produk desc LIMIT 3');
		$jns_produk = $this->contentHelper->GetData('jdih_jenis',1,'n_status =1','id_jenis');
		if($produk){
			foreach ($produk as $key=> $values){
				$tmp[] = $values;
				$thn = explode('-',$values['tanggal']);
				$tmp[$key]['Tahun'] = $thn['0'];
				
				foreach ($jns_produk as $val){
					if($values['id_jenis'] == $val['id_jenis']){
						$ket_jns_produk = $val['nama'];
					}
				}
				$tmp[$key]['jns_produk'] = $ket_jns_produk;
				$new_format_tgl = dateFormat($values['tanggal'],'article-day');
				$tmp[$key]['new_fomat_tgl'] = $new_format_tgl;
				$tmp[$key]['ref_deskripsi'] = html_entity_decode(htmlspecialchars_decode($values['deskripsi'], ENT_NOQUOTES));
				$hit_count = $this->contentHelper->statistik($values['id_produk'],1);
				$tmp[$key]['hit'] = $hit_count['hit'];
			}
		}
		$berita = $this->contentHelper->GetData('jdih_berita',1,'n_status = 1 and publish = 1 and jenis = 1','id_berita desc LIMIT 3');
		if($berita){
			foreach ($berita as $keys=> $value){
				$tmp2[] = $value;
				$hit_count_2 = $this->contentHelper->statistik($value['id_berita'],2);
				$tmp2[$keys]['hit'] = $hit_count_2['hit'];
			}
		}
		// pr($tmp);
		// pr($tmp2);
		$this->view->assign('produk',$tmp);
		$this->view->assign('berita',$tmp2);
		
		//param ajax
		//produk
		$param_produk = 'produk';
		$count_produk = 'ref_produk';
		$this->view->assign('param_produk',$param_produk);
		$this->view->assign('count_produk',$count_produk);
		
		//berita
		$param_berita = 'berita';
		$count_berita = 'ref_berita';
		$this->view->assign('param_berita',$param_berita);
		$this->view->assign('count_berita',$count_berita);
		//end sidebar
		
		if($_POST['select_jenis'] == 1){
			return $this->loadView('filter/produk');
		}elseif($_POST['select_jenis'] == 2){
			return $this->loadView('filter/berita');
		}elseif($_POST['select_jenis'] == 3){
			return $this->loadView('filter/kajian');
		}elseif($_POST['select_jenis'] == 4){
			return $this->loadView('filter/referensi');
		}
	}
	
	 function ajaxSearchProduk()
    {
    	$num = $_GET['site'];
    	$param['tanggal'] = $_GET['tgl'];
    	$param['tanggal_2'] = $_GET['tgl2'];
    	$param['tahun'] = $_GET['thn'];
    	$param['nomor'] = $_GET['no'];
    	$param['status_akhir'] = $_GET['sts'];
    	$param['judul'] = $_GET['jdl'];

    	$searchParam = array_filter($param);

    	foreach ($searchParam as $key => $val) {
            //$tmpset[] = $key." = '{$val}'";
			if($key == 'tanggal'){
				$sign = " >= ";
				$flag ="";
			}elseif($key == 'tanggal_2'){
				$sign = " <= ";
				$flag ="";
			}elseif($key == 'judul'){
				$sign = " like ";
				$flag ="%";
			}else{
				$sign = " = ";
				$flag ="";
			}
			if($key != 'select_jenis'){
				$tmpset[] = $key.$sign."'{$val}{$flag}'";
			}
        }

        $item_perpage = 3;
    	$position = ($num-1) * $item_perpage;

    	if($tmpset){
			$set = implode(' AND ', $tmpset);
			$set = str_replace("tanggal_2","tanggal",$set);
			$produk = $this->contentHelper->fetchData('jdih_produk',1,"n_status = 1 AND publish = 1 AND {$set}",'tanggal',"{$position},{$item_perpage}");
		}else{
			$produk = $this->contentHelper->fetchData('jdih_produk',1,"n_status = 1 AND publish = 1 ",'tanggal',"{$position},{$item_perpage}");
		}
		if($produk){
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
    	$this->view->assign('produk',$produk);
		//param ajax
		//berita
		$param_produk = 'produk';
		$count_produk = 'ref_produk';
		$this->view->assign('param_produk',$param_produk);
		$this->view->assign('count_produk',$count_produk);
		$param_berita = 'berita';
		$count_berita = 'ref_berita';
		$this->view->assign('param_berita',$param_berita);
		$this->view->assign('count_berita',$count_berita);
    	$html = $this->loadView('modal/produk');
    	echo $html;
    	exit;
    }
	
	function ajaxSearchBerita()
    {
    	$num = $_GET['site'];
    	$param['tanggal'] = $_GET['tgl'];
    	$param['tanggal_2'] = $_GET['tgl2'];
    	$param['judul'] = $_GET['jdl'];
    	
		$searchParam = array_filter($param);

    	foreach ($searchParam as $key => $val) {
            //$tmpset[] = $key." = '{$val}'";
			if($key == 'tanggal'){
				$sign = " >= ";
				$flag ="";
			}elseif($key == 'tanggal_2'){
				$sign = " <= ";
				$flag ="";
			}elseif($key == 'judul'){
				$sign = " like ";
				$flag ="%";
			}else{
				$sign = " = ";
				$flag ="";
			}
			if($key != 'select_jenis'){
				$tmpset[] = $key.$sign."'{$val}{$flag}'";
			}
        }

       if($tmpset){
			$set = implode(' AND ', $tmpset);
			$set = str_replace("tanggal_2","tanggal",$set);
			$where = " and n_status = 1 and publish = 1 and jenis = 1";
		}else{
			$where = " n_status = 1 and publish = 1 and jenis = 1";
		}
		$item_perpage = 3;
    	$position = ($num-1) * $item_perpage;

    	$berita2 = $this->contentHelper->fetchData('jdih_berita',1,$set.$where,'tanggal',"{$position},{$item_perpage}");

    	if($berita2){
			foreach ($berita2 as $keys2=> $value){
				$content[] = $value;
				$hit_count_3 = $this->contentHelper->statistik($value['id_berita'],2);
				$content[$keys2]['hit'] = $hit_count_3['hit'];
			}
		}
		// pr($produk);
    	$this->view->assign('content',$content);
		//param ajax
		//berita
		$param_produk = 'produk';
		$count_produk = 'ref_produk';
		$this->view->assign('param_produk',$param_produk);
		$this->view->assign('count_produk',$count_produk);
		$param_berita = 'berita';
		$count_berita = 'ref_berita';
		$this->view->assign('param_berita',$param_berita);
		$this->view->assign('count_berita',$count_berita);
    	$html = $this->loadView('modal/beritahukum');
    	echo $html;
    	exit;
    }
	
	function ajaxSearchRef()
    {
    	$num = $_GET['site'];
    	$param['tanggal'] = $_GET['tgl'];
    	$param['tanggal_2'] = $_GET['tgl2'];
    	$param['judul'] = $_GET['jdl'];
    	
		$searchParam = array_filter($param);

    	foreach ($searchParam as $key => $val) {
            //$tmpset[] = $key." = '{$val}'";
			if($key == 'tanggal'){
				$sign = " >= ";
				$flag ="";
			}elseif($key == 'tanggal_2'){
				$sign = " <= ";
				$flag ="";
			}elseif($key == 'judul'){
				$sign = " like ";
				$flag ="%";
			}else{
				$sign = " = ";
				$flag ="";
			}
			if($key != 'select_jenis'){
				$tmpset[] = $key.$sign."'{$val}{$flag}'";
			}
        }

        if($tmpset){
			$set = implode(' AND ', $tmpset);
			$set = str_replace("tanggal_2","tanggal",$set);
			$where = " and n_status = 1 and publish = 1";
		}else{
			$where = " n_status = 1 and publish = 1";
		}
		$item_perpage = 3;
    	$position = ($num-1) * $item_perpage;

    	$content = $this->contentHelper->fetchData('jdih_referensi',1,$set.$where,'tanggal',"{$position},{$item_perpage}");
		// pr($produk);
    	$this->view->assign('content',$content);
		//param ajax
		//berita
		$param_produk = 'produk';
		$count_produk = 'ref_produk';
		$this->view->assign('param_produk',$param_produk);
		$this->view->assign('count_produk',$count_produk);
		$param_berita = 'berita';
		$count_berita = 'ref_berita';
		$this->view->assign('param_berita',$param_berita);
		$this->view->assign('count_berita',$count_berita);
    	$html = $this->loadView('modal/referensi');
    	echo $html;
    	exit;
    }

	function ajaxSearchKajian()
    {
    	$num = $_GET['site'];
    	$param['tanggal'] = $_GET['tgl'];
    	$param['tanggal_2'] = $_GET['tgl2'];
    	$param['judul'] = $_GET['jdl'];
    	
		$searchParam = array_filter($param);

    	foreach ($searchParam as $key => $val) {
            //$tmpset[] = $key." = '{$val}'";
			if($key == 'tanggal'){
				$sign = " >= ";
				$flag ="";
			}elseif($key == 'tanggal_2'){
				$sign = " <= ";
				$flag ="";
			}elseif($key == 'judul'){
				$sign = " like ";
				$flag ="%";
			}else{
				$sign = " = ";
				$flag ="";
			}
			if($key != 'select_jenis'){
				$tmpset[] = $key.$sign."'{$val}{$flag}'";
			}
        }
		
		if($tmpset){
			$set = implode(' AND ', $tmpset);
			$set = str_replace("tanggal_2","tanggal",$set);
			$where = " and n_status = 1 and publish = 1 and jenis = 2";
		}else{
			$where = " n_status = 1 and publish = 1 and jenis = 2";
		}
     
		$item_perpage = 3;
    	$position = ($num-1) * $item_perpage;

    	$content = $this->contentHelper->fetchData('jdih_berita',1,$set.$where,'tanggal',"{$position},{$item_perpage}");
		$this->view->assign('content',$content);
		//param ajax
		//berita
		$param_produk = 'produk';
		$count_produk = 'ref_produk';
		$this->view->assign('param_produk',$param_produk);
		$this->view->assign('count_produk',$count_produk);
		$param_berita = 'berita';
		$count_berita = 'ref_berita';
		$this->view->assign('param_berita',$param_berita);
		$this->view->assign('count_berita',$count_berita);
    	$html = $this->loadView('modal/kajianhukum');
    	echo $html;
    	exit;
    }
	
	function filter_produk(){
		global $basedomain;
		$searchParam = array_filter($_POST);
		$flag ="";
		foreach ($searchParam as $key => $val) {
			$sign = " like ";
			$flag ="%";
			
			$tmpset[] = $key.$sign."'{$val}{$flag}'";
			
        }
		if($tmpset){
			$set = implode(' AND ', $tmpset);
		}
		// exit;
			if($tmpset){
				$data = $this->contentHelper->fetchData('jdih_produk',1,"n_status = 1 AND publish = 1 AND {$set}",'tanggal',3);
				$totalProduk = $this->contentHelper->countData('jdih_produk',"n_status = 1 AND publish = 1 AND {$set}");
			}else{
				$data = $this->contentHelper->fetchData('jdih_produk',1,"n_status = 1 AND publish = 1",'tanggal',3);
				$totalProduk = $this->contentHelper->countData('jdih_produk',"n_status = 1 AND publish = 1");
			}
			
			if($data){
				foreach ($data as $key => $value) {
					$data[$key]['deskripsi'] = html_entity_decode(htmlspecialchars_decode($value['deskripsi'], ENT_NOQUOTES));
					$data[$key]['tanggal'] = dateFormat($value['tanggal'],'article-day');
				
					$jenis = $this->contentHelper->fetchData('jdih_jenis',0,"n_status = 1 AND id_jenis = {$value['id_jenis']}");
					$data[$key]['jenis'] = $jenis['nama'];
					$hit_count = $this->contentHelper->statistik($value['id_produk'],1);
					$data[$key]['hit'] = $hit_count['hit'];
				}
			}
			$ket="Produk Hukum";
		
		$this->view->assign('param',$searchParam);
		$this->view->assign('totalProduk',$totalProduk);
		$this->view->assign('ket',$ket);
		$this->view->assign('data',$data);
		
		//start sidebar
		$produk = $this->contentHelper->GetData('jdih_produk',1,'n_status = 1 and publish = 1','id_produk desc LIMIT 3');
		$jns_produk = $this->contentHelper->GetData('jdih_jenis',1,'n_status =1','id_jenis');
		if($produk){
			foreach ($produk as $key=> $values){
				$tmp[] = $values;
				$thn = explode('-',$values['tanggal']);
				$tmp[$key]['Tahun'] = $thn['0'];
				
				foreach ($jns_produk as $val){
					if($values['id_jenis'] == $val['id_jenis']){
						$ket_jns_produk = $val['nama'];
					}
				}
				$tmp[$key]['jns_produk'] = $ket_jns_produk;
				$new_format_tgl = dateFormat($values['tanggal'],'article-day');
				$tmp[$key]['new_fomat_tgl'] = $new_format_tgl;
				$tmp[$key]['ref_deskripsi'] = html_entity_decode(htmlspecialchars_decode($values['deskripsi'], ENT_NOQUOTES));
				$hit_count = $this->contentHelper->statistik($values['id_produk'],1);
				$tmp[$key]['hit'] = $hit_count['hit'];
			}
		}
		$berita = $this->contentHelper->GetData('jdih_berita',1,'n_status = 1 and publish = 1 and jenis = 1','id_berita desc LIMIT 3');
		if($berita){
			foreach ($berita as $keys=> $value){
				$tmp2[] = $value;
				$hit_count_2 = $this->contentHelper->statistik($value['id_berita'],2);
				$tmp2[$keys]['hit'] = $hit_count_2['hit'];
			}
		}
		// pr($tmp);
		// pr($tmp2);
		$this->view->assign('produk',$tmp);
		$this->view->assign('berita',$tmp2);
		
		//param ajax
		//produk
		$param_produk = 'produk';
		$count_produk = 'ref_produk';
		$this->view->assign('param_produk',$param_produk);
		$this->view->assign('count_produk',$count_produk);
		
		//berita
		$param_berita = 'berita';
		$count_berita = 'ref_berita';
		$this->view->assign('param_berita',$param_berita);
		$this->view->assign('count_berita',$count_berita);
		//end sidebar
		
		return $this->loadView('filter/produk');
		
	}
}

?>
