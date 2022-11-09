<?php

class Gestionnaire{

    private static $_instance = null;
    
    private function __construct(){
        $sql = new requeteSQL();
        $sql->addGestionnaire('Esporter', 'gesP123');
    }

    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new Gestionnaire();
        }
        return self::$_instance;
    }


}