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
	//bar chart
	public function chart(){
		/*create format like 
			{"label":"['Penyalahgunaan Wewenang','Regulasi','SDM Aparatur','Pengawasan','tes']","key":"[{ y: 'Ruang
			Lingkup Laporan', a:2,b:1,c:0,d:0,e:0},]","flag":"['a','b','c','d','e']"}
		1. label
		2.key
		3.flag
		*/
		//sample
		
		//create dinamic label
		$sign="'";
		$where = "n_status = 1 and nama not like 'Surat Edaran Kepala BSN%'
							   and nama not like 'Perpu%'
							   and nama not like 'Rancangan%'
                               and nama not like 'Instruksi Presiden (Inpres)%'";
		// $select = $this->contentHelper->fetchData('jdih_jenis',1,'n_status = 1','id_jenis asc');
		$select = $this->contentHelper->fetchData('jdih_jenis',1,$where,'id_jenis asc');
		// pr($select);
		foreach($select as $val){
			$count = $this->contentHelper->hit($val['id_jenis']);
			$dataKet[] = $sign.$val['nama'].$sign; 
			$dataJml[] = $count['jml']; 
		}
		$label = implode(',',$dataKet);
		$newSignStart="[";
		$newSignEnd="]";
		$Newlabel = $newSignStart.$label.$newSignEnd;
		// pr($Newlabel);
		$count =count($dataKet);
		$x= 0;
		for ($i=97; $i<=122; $i++) {
		$Letter[] = chr($i);
		$frmt [] = $sign.$Letter[$x].$sign;
		$x++;
		}
		$newArrayLetter = array_slice($Letter, 0, $count);
		//create dinamic and key
		$q=0;
		foreach($newArrayLetter as $value){
			$newkey[]= $value.":".$dataJml[$q];
		$q++;
		}
		$key   = implode(',',$newkey);
		$NewKey ="[{ y: 'Produk Hukum', $key},]"; 
		// pr($NewKey);
		//create dinamic flag 
		
		foreach($newArrayLetter as $new){
			$newArrayLtr[] = $sign.$new.$sign;
		}
		$flaglabel=implode(",", $newArrayLtr);
		$Newflaglabel = $newSignStart.$flaglabel.$newSignEnd;
		// pr($Newflaglabel);
		$newformat = array('label'=>$Newlabel,'key'=>$NewKey,'flag'=>$Newflaglabel);
		print json_encode($newformat);
		exit;
	}	
	
	//bar chart
	public function chart_bar(){
		$select = $this->contentHelper->bar_chart();
		// pr($select);
		/*result expected
			 [
            {label: 'Download Sales', value: '12'},
            {label: 'In-Store Sales', value: '30'},
            {label: 'Mail-Order Sales', value: '20'}
          ]*/
		//custome json
		if($select){
			$sign_first ="{";
			$sign_last ="}";
			$newSignStart="[";
			$newSignEnd="]";
			$sign = "'";
			foreach ($select as $val){
				$param = $sign_first."label : ".$sign.$val[jns_produk].$sign.", value : ".$val[jml].$sign_last; 
				$data[] = $param;
			} 
			$key   = implode(',',$data);
			$key_fix = $newSignStart.$key.$newSignEnd;
		}
		$newformat = array('data'=>$key_fix);
		print json_encode($newformat);
		exit;
	}
	
	
	
	
}

?>
