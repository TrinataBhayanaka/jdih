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
	
	function hit($id){
		$sql = "select count(id_produk) as jml from jdih_produk WHERE id_jenis = '{$id}' and n_status = '1' ";
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
		$sql = "SELECT count(jumlah) as jml, parent_id FROM `jdih_hit` WHERE tipe = '1' group by parent_id order by jml desc limit 3 ";
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