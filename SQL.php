<?php
        
    class requeteSQL{

        private $linkpdo;

        public function __construct(){
            ///Connexion au serveur MySQL avec PDO
            $server = '54.37.31.19';
            $login  = 'u743447366_admin';
            $mdp    = 'YAksklOw6qN$';
            $db     = 'u743447366_esporter';
            
            try {
                $this->linkpdo = new PDO("mysql:host=$server;dbname=$db", $login, $mdp);
                $this->linkpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo 'cooucou bebe';
                
            }
            ///Capture des erreurs éventuelles
            catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
        }
    }
?>