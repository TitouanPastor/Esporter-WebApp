<?php

class Gestionnaire{

    private static $_instance;
    private $test;
    
    private function __construct(){
        require_once('SQL.php');
        $sql = new requeteSQL();
        $sql->addGestionnaire('Esporter', 'gesP123');
        
    }

    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new Gestionnaire();
        }
        return self::$_instance;
    }

    public function getTest(){
        return $this->test;
    }


}