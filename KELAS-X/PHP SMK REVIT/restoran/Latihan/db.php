<?php

    class DB{
        // properties
        public $host = '127.0.0.1';
        private $user = 'root';
        private $password = '';
        private $database = 'mysql_dbrestoran';


        // methods
        public function selectData()
        {
            echo 'select data';
        }

        public function getDataBase(){
            return $this->database;
        }

        public function tampil(){
            $this->selectData();
        }

        public static function insertData(){
            echo 'insert data';
        }

        public function __construct(){
            echo 'construct';
        }

    }

    
    DB::insertData();
    echo '<br>';
    $db = new DB;

    // echo '<br>';
    
    // $db->selectData();
    
    // echo '<br>';
    
    // echo $db->host;
    
    // echo '<br>';
    
    // echo $db->getDataBase();
    
    // echo '<br>';

    // $db->tampil();


?>