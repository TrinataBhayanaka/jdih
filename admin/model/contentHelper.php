<?php
class contentHelper extends Database {
	

	function fetchData($table,$loop=0,$where=false,$order=false)
    {
        if($where) $where = "WHERE ".$where;
        if($order) $order = "ORDER BY ".$order;
        $sql = "SELECT * FROM {$table} {$where} {$order}";
        $res = $this->fetch($sql,$loop);

        return $res;
    }

    function insertData($data,$table)
    {
        $this->insert($data,$table);

        return true;
    }

    function deleteData($id,$index_id,$table)
    {
        $sql = "UPDATE {$table} SET n_status = 2 WHERE {$index_id} = {$id}";
        $exec = $this->query($sql);

        return true;
    }

    function updateData($data,$table,$cond)
    {

       $this->update($data,$table,$cond);

       return true; 
    }
	
	function hit_count($id,$param){
		$sql = "select count(id_produk) as jml from jdih_produk WHERE id_jenis = '{$id}' and n_status = '1' {$param}";
		$res = $this->fetch($sql);

        return $res;
	}
	
	function hit($id){
		$years = date("Y");
		$where = "and YEAR(tanggal) = '{$years}'";
		$sql = "select count(id_produk) as jml from jdih_produk WHERE id_jenis = '{$id}' and n_status = '1' {$where}";
		$res = $this->fetch($sql);

        return $res;
	
	}
	
	function hit_cond($id,$start,$end){
		$sql = "select count(id_produk) as jml from jdih_produk WHERE id_jenis = '{$id}' and tanggal >= '{$start}' and tanggal <= '{$end}'   
				and n_status = '1' ";
        $res = $this->fetch($sql);

        return $res;
	
	}
	
	function bar_chart(){
		$years = date("Y");
		$where = "and YEAR(tanggal) = '{$years}'";
		$sql = "SELECT count(jumlah) as jml, parent_id FROM `jdih_hit` WHERE tipe = '1' {$where} group by parent_id order by jml desc limit 5";
		$res = $this->fetch($sql,1);
		if($res){
			foreach ($res as $key=>$val){
				$temp[] = $val;
				$cndtn = "SELECT id_jenis FROM `jdih_produk` WHERE id_produk = '{$val[parent_id]}'";
				$res2 = $this->fetch($cndtn);
				
				$get = "SELECT nama FROM `jdih_jenis` WHERE id_jenis = '{$res2[id_jenis]}'";
				$res3 = $this->fetch($get);
				
				$temp[$key]['jns_produk']= $res3['nama'];
			}
		}
		
		if($temp)return $temp;
	}
	
	function donut_chart_cdtn_def($id){
		$years = date("Y");
		$where = "and YEAR(tanggal) = '{$years}'";
		
		//get parent_id  
		$sql = "SELECT parent_id FROM `jdih_hit` WHERE tipe = '1' {$where} group by parent_id order by jumlah desc";
		$res = $this->fetch($sql,1);
		foreach ($res as $arr) {
			$str .= $arr["parent_id"] . ",";
		}
		$id_produk = trim($str, ',');
		
		//get data detail
		$sql_dt = "SELECT id_produk,id_jenis,judul FROM `jdih_produk` WHERE `id_produk` in ({$id_produk}) and id_jenis = {$id} ORDER BY id_produk desc limit 5";
		$res_dt = $this->fetch($sql_dt,1);
		if($res_dt){
			foreach ($res_dt as $key=>$val){
				$temp[] = $val;
				$cndtn = "SELECT count(jumlah) as jml FROM `jdih_hit` WHERE parent_id = '{$val[id_produk]}'";
				$res2 = $this->fetch($cndtn);
				
				$temp[$key]['jml']= $res2['jml'];
			}
		}
		
		if($temp)return $temp;
	}
	
	
	function donut_chart_cdtn($tgl_start_fix,$tgl_end_fix){
		$sql = "SELECT count(jumlah) as jml, parent_id FROM `jdih_hit` WHERE tipe = '1' and tanggal >= '{$tgl_start_fix}' and tanggal <= '{$tgl_end_fix}'  group by parent_id order by jml desc limit 3 ";
		// pr($sql);
		$res = $this->fetch($sql,1);
		if($res){
			foreach ($res as $key=>$val){
				$temp[] = $val;
				$cndtn = "SELECT id_jenis FROM `jdih_produk` WHERE id_produk = '{$val[parent_id]}'";
				$res2 = $this->fetch($cndtn);
				
				$get = "SELECT nama FROM `jdih_jenis` WHERE id_jenis = '{$res2[id_jenis]}'";
				$res3 = $this->fetch($get);
				
				$temp[$key]['jns_produk']= $res3['nama'];
			}
		}
		
		if($temp)return $temp;
	}
	
    
}
?>