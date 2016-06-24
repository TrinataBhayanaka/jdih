<?php

class kegiatan extends Controller {
	
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
		//start sidebar
		global $basedomain;
		$produk = $this->contentHelper->GetData('jdih_produk',1,'n_status = 1 and publish = 1 and posisi =1','id_produk desc LIMIT 3');
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
		$berita = $this->contentHelper->GetData('jdih_berita',1,'n_status = 1 and publish = 1 and jenis = 1 and posisi =1','id_berita desc LIMIT 3');
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
		//content
		// pr($_POST);
		if($_POST['tanggal']){
			$tmp_tgl_start =$_POST['tanggal'];
			$ex_1 = explode('/',$tmp_tgl_start);
			$tgl_start_fix = $ex_1['2'].'-'.$ex_1['1'].'-'.$ex_1['0']; 
			
			$ext = "and tanggal = '{$tgl_start_fix}'";
			$param = $tgl_start_fix;
			$where = "n_status = 1 and publish = 1 and jenis = 1 {$ext}";
			$where_ext = "n_status = 1 and publish = 1 and jenis = 1 {$ext}";
		}else{
			$param = '';
			$where = "n_status = 1 and publish = 1 and jenis = 1 ";
			$where_ext = "n_status = 1 and publish = 1 and jenis = 1 ";
		}
		$berita2 = $this->contentHelper->GetData('jdih_berita',1,$where,'tanggal LIMIT 3');
		if(berita2){
			foreach ($berita2 as $keys2=> $value){
				$tmp3[] = $value;
				$hit_count_3 = $this->contentHelper->statistik($value['id_berita'],2);
				$tmp3[$keys2]['hit'] = $hit_count_3['hit'];
			}
		}
		
		$this->view->assign('content',$tmp3);
		//param ajax
		$this->view->assign('param',$param);
		$param_berita2 = 'berita2';
		$count_berita2 = 'ref_berita2';
		$this->view->assign('param_berita2',$param_berita2);
		$this->view->assign('count_berita2',$count_berita2);
		// exit;
		//paging
		$totalProduk = $this->contentHelper->countData('jdih_berita',$where_ext);
		// pr($totalProduk);
		$this->view->assign('totalProduk',$totalProduk);
		return $this->loadView('berita/kegiatan');
    }
	
	function ajaxBeritaHukum()
    {
		global $basedomain;
    	$num = $_GET['site'];
    	$item_perpage = 3;
    	$position = ($num-1) * $item_perpage;
		if($_GET['condt']){
			$ext = "and tanggal = '{$_GET['condt']}'";
			$where = "n_status = 1 and publish = 1 and jenis = 1 {$ext}";
		}else{
			$where = "n_status = 1 and publish = 1 and jenis = 1";
		}
		$berita2 = $this->contentHelper->fetchData('jdih_berita',1,$where,'tanggal',"{$position},{$item_perpage}");

    	if($berita2){
			foreach ($berita2 as $keys2=> $value){
				$tmp3[] = $value;
				$hit_count_3 = $this->contentHelper->statistik($value['id_berita'],2);
				$tmp3[$keys2]['hit'] = $hit_count_3['hit'];
			}
		}

    	$this->view->assign('content',$tmp3);
		$param_berita2 = 'berita2';
		$count_berita2 = 'ref_berita2';
		$this->view->assign('param_berita2',$param_berita2);
		$this->view->assign('count_berita2',$count_berita2);
    	$html = $this->loadView('modal/beritahukum');
    	echo $html;
    	exit;
    }

	
	function ajax_select(){
		$produk = $this->contentHelper->GetData('jdih_produk',1,'n_status = 1 and publish = 1 and posisi =1','id_produk desc LIMIT 3');
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
		// pr($tmp);
		echo json_encode($tmp);
		exit;
	}
	
	function detail(){
		//start sidebar
		global $basedomain;
		$produk = $this->contentHelper->GetData('jdih_produk',1,'n_status = 1 and publish = 1 and posisi =1','id_produk desc LIMIT 3');
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
		$berita = $this->contentHelper->GetData('jdih_berita',1,'n_status = 1 and publish = 1 and jenis = 1 and posisi =1','id_berita desc LIMIT 3');
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
		$id = $_GET['id'];
		$where = "n_status = 1 and publish = 1 and posisi =1 and id_berita = {$id}";
		$berita = $this->contentHelper->GetData('jdih_berita',1,$where,'id_berita asc');
		if($berita){
			foreach ($berita as $keys=> $value){
				$tmp2[] = $value;
				$hit_count_2 = $this->contentHelper->statistik($value['id_berita'],2);
				$tmp2[$keys]['hit'] = $hit_count_2['hit'];
				$tmp2[$keys]['content'] =html_entity_decode(htmlspecialchars_decode($value['isi'], ENT_NOQUOTES));
				
			}
		}
		// pr($tmp2);
		$this->view->assign('content',$tmp2);
		return $this->loadView('berita/detail');
	}
	
	function kajian(){
	//start sidebar
		global $basedomain;
		$produk = $this->contentHelper->GetData('jdih_produk',1,'n_status = 1 and publish = 1 and posisi =1','id_produk desc LIMIT 4');
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
		$berita = $this->contentHelper->GetData('jdih_berita',1,'n_status = 1 and publish = 1 and jenis = 1 and posisi =1','id_berita desc LIMIT 4');
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
		
		if($_POST['tanggal']){
			$tmp_tgl_start =$_POST['tanggal'];
			$ex_1 = explode('/',$tmp_tgl_start);
			$tgl_start_fix = $ex_1['2'].'-'.$ex_1['1'].'-'.$ex_1['0']; 
			
			$ext = "and tanggal = '{$tgl_start_fix}'";
			$param = $tgl_start_fix;
			$where = "n_status = 1 and publish = 1 and jenis = 2 {$ext}";
			$where_ext = "n_status = 1 and publish = 1 and jenis = 2 {$ext}";
		}else{
			$param = '';
			$where = "n_status = 1 and publish = 1 and jenis = 2 ";
			$where_ext ="n_status = 1 and publish = 1 and jenis = 2";
		}
		$berita2 = $this->contentHelper->GetData('jdih_berita',1,$where,'tanggal LIMIT 3');
			if(berita2){
				foreach ($berita2 as $keys2=> $value){
					$tmp3[] = $value;
					$hit_count_3 = $this->contentHelper->statistik($value['id_berita'],2);
					$tmp3[$keys2]['hit'] = $hit_count_3['hit'];
				}
			}
		// pr($tmp3);
		$this->view->assign('content',$tmp3);
		$this->view->assign('param',$param);
		$totalProduk = $this->contentHelper->countData('jdih_berita',$where_ext);
		$this->view->assign('totalProduk',$totalProduk);
		return $this->loadView('berita/kajian2');
	}
	
	function ajaxKajianHukum()
    {
		global $basedomain;
    	$num = $_GET['site'];
    	$item_perpage = 3;
    	$position = ($num-1) * $item_perpage;
		if($_GET['condt']){
			$ext = "and tanggal = '{$_GET['condt']}'";
			$where = "n_status = 1 and publish = 1 and jenis = 2 {$ext}";
		}else{
			$where = "n_status = 1 and publish = 1 and jenis = 2";
		}
		$berita2 = $this->contentHelper->fetchData('jdih_berita',1,$where,'tanggal',"{$position},{$item_perpage}");

    	if($berita2){
			foreach ($berita2 as $keys2=> $value){
				$tmp3[] = $value;
				$hit_count_3 = $this->contentHelper->statistik($value['id_berita'],2);
				$tmp3[$keys2]['hit'] = $hit_count_3['hit'];
			}
		}

    	$this->view->assign('content',$tmp3);
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
		
    	$html = $this->loadView('modal/beritahukum');
    	echo $html;
    	exit;
    }
	
	function details(){
	//start sidebar
		global $basedomain;
		$produk = $this->contentHelper->GetData('jdih_produk',1,'n_status = 1 and publish = 1 and posisi =1','id_produk desc LIMIT 4');
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
		$berita = $this->contentHelper->GetData('jdih_berita',1,'n_status = 1 and publish = 1 and jenis = 1 and posisi =1','id_berita desc LIMIT 4');
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
		
		$id =$_GET['id'];
		$where = "n_status = 1 and publish = 1 and jenis = 2 and id_berita = '{$id}'";
		$berita2 = $this->contentHelper->GetData('jdih_berita',1,$where,'id_berita desc LIMIT 5');
				if(berita2){
					foreach ($berita2 as $keys2=> $value){
						$tmp3[] = $value;
						$hit_count_3 = $this->contentHelper->statistik($value['id_berita'],2);
						$tmp3[$keys2]['hit'] = $hit_count_3['hit'];
					}
				}
		$this->view->assign('content',$tmp3);
		return $this->loadView('berita/detail2');		
	}
}

?>
