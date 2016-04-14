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

    function updateData($data,$table)
    {
       $this->update($data,$table,"id_produk = {$data['id_produk']}");

       return true; 
    }

    
}
?>