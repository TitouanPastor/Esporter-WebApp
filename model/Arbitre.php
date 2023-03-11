<?php 
    class Arbitre{

        private $dao;

        function __construct()
        {
            require_once(realpath(dirname(__FILE__) . '/../DAO/ArbitreDAO.php'));
            $this->dao = new ArbitreDAO();
        }

        public function getJeuxTournois($id, $choix = "default"){
            return $this->dao->getJeuxTournois($id, $choix);
        }

        function getTournoiCommence(){
            return $this->dao->getTournoiCommence();
        }

    }


?>