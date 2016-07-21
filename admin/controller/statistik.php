<?php
// defined ('TATARUANG') or exit ( 'Forbidden Access' );

class statistik extends Controller {
	
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
		$jns_produk = $this->contentHelper->fetchData('jdih_jenis',1,'n_status = 1','id_jenis asc');
		$default = "UUD NRI Tahun 1945";
		$this->view->assign('default',$default);
		$this->view->assign('jns_produk',$jns_produk);
		return $this->loadView('statistik/statistik');

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
		$select = $this->contentHelper->fetchData('jdih_jenis',1,'n_status = 1','id_jenis asc');
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
	
	public function chart_bar2(){
		// pr($_POST);
		$tmp_tgl_start =$_POST['start'];
		$ex_1 = explode('/',$tmp_tgl_start);
		$tgl_start_fix = $ex_1['2'].'-'.$ex_1['1'].'-'.$ex_1['0']; 
		// pr($tgl_start_fix);
		$tmp_tgl_end =$_POST['end'];
		$ex_2 = explode('/',$tmp_tgl_end);
		$tgl_end_fix = $ex_2['2'].'-'.$ex_2['1'].'-'.$ex_2['0']; 
		// pr($tgl_end_fix);
		
		// EXIT;
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
		$select = $this->contentHelper->fetchData('jdih_jenis',1,'n_status = 1','id_jenis asc');
		// pr($select);
		foreach($select as $val){
			$count = $this->contentHelper->hit_cond($val['id_jenis'],$tgl_start_fix,$tgl_end_fix);
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
	
	public function chart_donut_cdtn(){
		// pr($_POST);
		$tmp_tgl_start =$_POST['start'];
		$ex_1 = explode('/',$tmp_tgl_start);
		$tgl_start_fix = $ex_1['2'].'-'.$ex_1['1'].'-'.$ex_1['0']; 
		$tmp_tgl_end =$_POST['end'];
		$ex_2 = explode('/',$tmp_tgl_end);
		$tgl_end_fix = $ex_2['2'].'-'.$ex_2['1'].'-'.$ex_2['0']; 
		
		$select = $this->contentHelper->donut_chart_cdtn($tgl_start_fix,$tgl_end_fix);
		// pr($select);
		if($select){
			$data_1 = $select[0];
			$data_2 = $select[1];
			$data_3 = $select[2];
		}else{
			$data_1 = $select[0];
			$data_2 = $select[1];
			$data_3 = $select[2];
		}
		//pr($data_1);
		$newformat = array('data_1'=>$data_1,'data_2'=>$data_2,'data_3'=>$data_3);
		print json_encode($newformat);
		exit;
		
	}	
	
	//donut chart default
	public function chart_donut(){
		// pr($_POST);
		$id_jenis = $_POST['idj']; 
		$select = $this->contentHelper->donut_chart_cdtn_def($id_jenis);
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
				$param = $sign_first."label : ".$sign.$val[judul].$sign.", value : ".$val[jml].$sign_last; 
				$data[] = $param;
			} 
			$key   = implode(',',$data);
			$key_fix = $newSignStart.$key.$newSignEnd;
		}
		$newformat = array('data'=>$key_fix);
		print json_encode($newformat);
		exit;
	}
	
	//report 
	public function report(){
		//param
		//tgl awal 
		$tmp_tgl_start =$_GET['start'];
		$ex_1 = explode('/',$tmp_tgl_start);
		$tgl_start_fix = $ex_1['2'].'-'.$ex_1['1'].'-'.$ex_1['0']; 
		
		//tgl akhir
		$tmp_tgl_end =$_GET['end'];
		$ex_2 = explode('/',$tmp_tgl_end);
		$tgl_end_fix = $ex_2['2'].'-'.$ex_2['1'].'-'.$ex_2['0']; 
		
		if($tmp_tgl_start != '' && $tmp_tgl_end !=''){
			$ket = "<h4>Tanggal {$tmp_tgl_start} s/d {$tmp_tgl_end} </h4>";
		}
		//flag 1: pdf, 2 : xls
		$flag = $_GET['flag'];
		
		$param_sql ="n_status = 1";
		if($tmp_tgl_start){
			$param_sql_dt.= " AND tanggal >= '{$tgl_start_fix}'";
		}
		if($tmp_tgl_end){
			$param_sql_dt.= " AND tanggal <= '{$tgl_end_fix}'";
		}
		$where = $param_sql;
		$select = $this->contentHelper->fetchData('jdih_jenis',1,$where,'id_jenis asc');
		// pr($select);
		foreach($select as $key=>$val){
			$data[] = $val;
			$count = $this->contentHelper->hit_count($val['id_jenis'],$param_sql_dt);
			$data[$key]['jml'] = $count['jml'];
		}
		// pr($data);
		//$this->view->assign('data',$data);
		//$html = $this->loadView('statistik/print');
		if($flag == 1){
			//write report pdf
			$this->reportHelper =$this->loadModel('reportHelper');
			$html = "<div style=\"width: ; text-align: center;\">
						<h4>List Produk Hukum : </h4>
						{$ket}
						 <table style=\"border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">
							<thead>
								<tr class=\"\" >
									<td align=\"center\">No</td>
									<td align=\"center\">Produk Hukum</td>
									<td align=\"center\">Jumlah</td>
								</tr>
								</thead>
								<tbody>";
								$no = 1;
									foreach ($data as $value){
										$html.="<tr>
											<td align=\"center\">{$no}</td>
											<td align=\"\">{$value['nama']}</td>
											<td align=\"center\">{$value['jml']}</td>	
										</tr>";
										$no++;
									}
								$html.="
								</tbody>
							</table>
						</div>";
			// echo $html;
			// exit;
			$generate = $this->reportHelper->loadMpdf($html, 'list');
		}else{
				//write report xls
				$waktu=date("d-m-y_h:i:s");
				$filename ="list_$waktu.xls";
				header('Content-type: application/ms-excel');
				header('Content-Disposition: attachment; filename='.$filename);
				$html = "<div style=\"width: ; text-align: center;\">
						<h4>List Produk Hukum : </h4>
						{$ket}
						 <table style=\"border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">
							<thead>
								<tr class=\"\" >
									<td align=\"center\">No</td>
									<td align=\"center\">Produk Hukum</td>
									<td align=\"center\">Jumlah</td>
								</tr>
								</thead>
								<tbody>";
								$no = 1;
									foreach ($data as $value){
										$html.="<tr>
											<td align=\"center\">{$no}</td>
											<td align=\"\">{$value['nama']}</td>
											<td align=\"center\">{$value['jml']}</td>	
										</tr>";
										$no++;
									}
								$html.="
								</tbody>
							</table>
						</div>";
				echo $html;
				exit;
		}	
	}
}

?>
