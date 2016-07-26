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
		global $basedomain;
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
		
		/* $file = $_GET['file'];
		$file = $this->contentHelper->fetchData('jdih_referensi',0,'n_status = 1 and file='.$file); 
		if (file_exists($file))
		{
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.basename($file).'"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		readfile($file);
		exit;
		} */
		
		
		$id = $_GET['id'];
		$ref = $this->contentHelper->fetchData('jdih_referensi',0,'n_status = 1 and id_ref='.$id,'id_ref DESC');
		$this->view->assign('ref',$ref);
		return $this->loadView('referensi/detail_referensi');
		
		
		
    }
	
	function referensi_buku()
	{
		$totalRef = $this->contentHelper->countData('jdih_referensi','n_status = 1 AND publish = 1');
		$this->view->assign('totalRef',$totalRef);
		
		$ref = $this->contentHelper->fetchData('jdih_referensi',1,'n_status = 1 AND publish = 1','tanggal','4');
		$this->view->assign('ref',$ref);
		//db($ref);
		return $this->loadView('referensi/referensi_buku');
	}
	
	function ajaxref()
	{
		$num = $_GET['site'];
		
		if(isset($_GET['jdl'])){
			$kondisi = "AND judul like '%{$_GET['jdl']}%' AND pengarang like '%{$_GET['author']}%'";
		} else $kondisi = "";
    	$item_perpage = 4;
    	$position = ($num-1) * $item_perpage;

    	$referensi = $this->contentHelper->fetchData('jdih_referensi',1,"n_status = 1 AND publish = 1 {$kondisi}",'tanggal',"{$position},{$item_perpage}");
		

    	foreach ($produk as $key => $value) {
    		//$produk[$key]['deskripsi'] = html_entity_decode(htmlspecialchars_decode($value['deskripsi'], ENT_NOQUOTES));
			$produk[$key]['tanggal'] = dateFormat($value['tanggal'],'article-day');
    	}

    	$this->view->assign('ref',$referensi);

    	$html = $this->loadView('modal/referensi_buku');
    	echo $html;
    	exit;
	}
	
	function filter()
	{
		$fil_ref=$_POST;
	
		$totalRef = $this->contentHelper->countData('jdih_referensi',"n_status = 1 AND publish = 1 AND judul like '%{$fil_ref['judul']}%' AND pengarang like '%{$fil_ref['pengarang']}%'");

		$this->view->assign('totalRef',$totalRef);
		
		$ref = $this->contentHelper->fetchData('jdih_referensi',1,"n_status = 1 AND publish = 1 AND judul like '%{$fil_ref['judul']}%' AND pengarang like '%{$fil_ref['pengarang']}%'",'tanggal','4');
		
		
		$this->view->assign('fil_ref', $fil_ref);
		$this->view->assign('ref', $ref);
		$this->view->assign('param', $_POST);
		
		return $this->loadView('referensi/referensi_buku');
	
	}
	


}

?>
