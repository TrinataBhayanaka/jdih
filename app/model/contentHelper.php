<?php
class contentHelper extends Database {
	
	var $prefix = "";
	var $salt = "";
	function __construct()
	{
        parent::__construct();
		// $this->db = new Database;
		$this->salt = "ovancop1234";
		$this->token = str_shuffle('cmsaj23y4ywdni237yeisa');
		$this->date = date('Y-m-d H:i:s');

	}

	function fetchData($table,$loop=0,$where=false,$order=false,$limit=false)
    {
        if($where) $where = "WHERE ".$where;
        if($order) $order = "ORDER BY ".$order;
        if($limit) $limit = "LIMIT ".$limit;
        $sql = "SELECT * FROM {$table} {$where} {$order} {$limit}";
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

	function GetData($table,$loop=0,$where=false,$order=false,$limit=0)
    {
		if($where) $where = "WHERE ".$where;
        if($order) $order = "ORDER BY ".$order;
       
		$sql = "SELECT * FROM {$table} {$where} {$order}";
		// pr($sql);
        $res = $this->fetch($sql,$loop);

        return $res;
    }
	
	function hit_count($id,$type,$date){
		$initial_val = 1;
		$sql = "insert into jdih_hit (parent_id,tipe,tanggal,jumlah) values ('{$id}','{$type}','{$date}','{$initial_val}')";
		$exec = $this->query($sql);
		
		$sql2 = "select count(jumlah) as hit from jdih_hit WHERE parent_id = '{$id}' and tipe = '{$type}' ";
		$res = $this->fetch($sql2);
        return $res;
	}
	
	function statistik($id,$type){
		$sql2 = "select count(jumlah) as hit from jdih_hit WHERE parent_id = '{$id}' and tipe = '{$type}' ";
		$res = $this->fetch($sql2);
        return $res;
	} 
	
	function ajax_count(){
		$sql2 = "select count(id_berita) as hit from jdih_berita WHERE jenis = '1' and publish = '1' and n_status = '1'";
		$res = $this->fetch($sql2);
        return $res;
	} 

	function countData($table,$condition=false)
	{
		if($where) $where = "WHERE ".$where;
        $sql = "SELECT COUNT(*) as total FROM {$table} {$where}";
		$res = $this->fetch($sql,0);

        return $res;
	}
}
?>
