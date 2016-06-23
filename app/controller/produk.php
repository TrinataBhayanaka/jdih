<?php

class produk extends Controller {
	
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
		$berita = $this->contentHelper->GetData('jdih_berita',1,'n_status = 1 and publish = 1 and jenis = 1 and posisi =1','id_berita desc LIMIT 3');
		if($berita){
			foreach ($berita as $keys=> $value){
				$tmp2[] = $value;
				$hit_count_2 = $this->contentHelper->statistik($value['id_berita'],2);
				$tmp2[$keys]['hit'] = $hit_count_2['hit'];
			}
		}
		$this->view->assign('berita',$tmp2);
		//param ajax
		//berita
		$param_berita = 'berita';
		$count_berita = 'ref_berita';
		$this->view->assign('param_berita',$param_berita);
		$this->view->assign('count_berita',$count_berita);
		//end sidebar
		
		return $this->loadView('produk/produk');
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
		
		//content
		$id = $_GET['id'];
		$where = "n_status = 1 and publish = 1 and posisi =1 and id_produk = {$id}";
		$produk2 = $this->contentHelper->GetData('jdih_produk',1,$where,'id_produk ');
		// pr($produk2);
		// exit;
		$jns_produk2 = $this->contentHelper->GetData('jdih_jenis',1,'n_status =1','id_jenis');
		if($produk2){
			foreach ($produk2 as $keys=> $values2){
				$tmp3[] = $values2;
				$thn = explode('-',$values2['tanggal']);
				$tmp3[$keys]['Tahun'] = $thn['0'];
				if($jns_produk2){
					foreach ($jns_produk2 as $val2){
						if($values2['id_jenis'] == $val2['id_jenis']){
							$ket_jns_produk = $val2['nama'];
						}
					}
				}
				$tmp3[$keys]['jns_produk'] = $ket_jns_produk;
				$new_format_tgl2 = dateFormat($values2['tanggal'],'article-day');
				$tmp3[$keys]['new_fomat_tgl'] = $new_format_tgl2;
				$tmp3[$keys]['ref_deskripsi'] = html_entity_decode(htmlspecialchars_decode($values2['deskripsi'], ENT_NOQUOTES));
				$hit_count2 = $this->contentHelper->statistik($values2['id_produk'],1);
				$tmp3[$keys]['hit'] = $hit_count2['hit'];
			}
		}
		$this->view->assign('content',$tmp3);
		$param_produk2 = 'produk2';
		$count_produk2 = 'ref_produk2';
		$this->view->assign('param_produk2',$param_produk2);
		$this->view->assign('count_produk2',$count_produk2);
		
		return $this->loadView('produk/detail');
    }

}

?>
