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
   

}
?>
