<?php
    require_once("data.php");
    
    class Koneksi{
        protected $mysqli;
        public function __construct()
        {
            $this->mysqli = new mysqli(SERVER_NAME, USERNAME, PASSWORD, DB_NAME);
        }
    }
?>