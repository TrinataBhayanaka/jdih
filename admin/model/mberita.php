<?php
class mberita extends Database {
	
    function __construct()
    {

        parent::__construct();
        $session = new Session;
        $getSessi = $session->get_session();
        $this->user = $getSessi['ses_user']['login'];
    }
	
	



}
?>