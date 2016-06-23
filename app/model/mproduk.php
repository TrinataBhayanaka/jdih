<?php
class mproduk extends Database {
	
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

	function getAllTahun()
	{
		$sql = "SELECT DISTINCT(tahun) FROM jdih_produk WHERE n_status = 1";
		$res = $this->fetch($sql,1);

		return $res;
	}
}
?>
