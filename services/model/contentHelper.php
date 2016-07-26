<?php
class contentHelper extends Database {
	
	function fetchData($table,$loop=0,$where=false,$order=false,$limit=false)
    {
        if($where) $where = "WHERE ".$where;
        if($order) $order = "ORDER BY ".$order;
        if($limit) $limit = "LIMIT ".$limit;
        $sql = "SELECT * FROM {$table} {$where} {$order} {$limit}";
		// echo $sql; 
		$res = $this->fetch($sql,$loop);

        return $res;
    }
	
	function statistik($id,$type){
		$sql2 = "select count(jumlah) as hit from jdih_hit WHERE parent_id = '{$id}' and tipe = '{$type}' ";
		$res = $this->fetch($sql2);
        return $res;
	} 
	
	function getData()
	{
		$sql = "SELECT * FROM code_activity";
		$res = $this->fetch($sql,1);
		if ($res) return $res;
		return false;
	}
	
	function getMessage()
	{
		$sql = "SELECT m.*, um.name,um.email FROM my_message m LEFT JOIN user_member um ON m.receive = um.id ";
		$res = $this->fetch($sql,1);
		if ($res) return $res;
		return false;
	}
	
	function saveMessage($data)
	{
		foreach ($data as $key => $val){
			$tmpfield[] = $key;
			$tmpdata[] = "'$val'";
		}
		// from,to,subject,content,createdate,n_status
		$tmpfield[] = 'fromwho';
		$tmpfield[] = 'createdate';
		$tmpfield[] = 'n_status';
		
		$date = date('Y-m-d H:i:s');
		$tmpdata[] = 0;
		$tmpdata[] = "'{$date}'";
		$tmpdata[] = 1;
		
		$field = implode(',',$tmpfield);
		$data = implode(',',$tmpdata);
		
		$sql = "INSERT INTO my_message ({$field}) 
				VALUES ({$data})";
		// pr($sql);
		// exit;
		$res = $this->query($sql);
		if ($res) return true;
		return false;
	}
	
	function get_user($data)
	{
		$query = "SELECT * FROM user_member WHERE email = '{$data}'";
		
		$result = $this->fetch($query,1);
		
		return $result;
	}
}
?>