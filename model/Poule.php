<?php
    class Poule {
        private $dao;

        public function __construct()
        {
            require_once(realpath(dirname(__FILE__) . '/../DAO/pouleDAO.php'));
            $this->dao = new PouleDAO();
        }

        public function getPouleIdTournoi($idTournoi)
        {
            return $this->dao->getPouleIdTournoi($idTournoi);
        }

        public function getPouleByIdTournoi($idTournoi)
        {
            return $this -> dao -> getPouleByIdTournoi($idTournoi);
        }

        public function getIDPouleFinale($idTournoi, $idJeu)
        {
            return $this -> dao -> getIDPouleFinale($idTournoi, $idJeu);
        }
        
        public function getNomPoule($idPoule)
        {
            return $this -> dao -> getNomPoule($idPoule);
        }

        public function getRencontre($idPoule)
        {
            return $this -> dao -> getRencontre($idPoule);
        }

        public function getGagnantRencontre($idRencontre)
        {
            return $this -> dao -> getGagnantRencontre($idRencontre);
        }
        public function getEquipePouleTrie($idPoule)
        {
            return $this -> dao -> getEquipePouleTrie($idPoule);
        }

        public function pouleFinaleTermine($idPoule){
            return $this->dao->pouleFinaleTermine($idPoule);
        }

        public function setGagnantRencontre($idRencontre, $idEquipe){
            return $this->dao->setGagnantRencontre($idRencontre, $idEquipe);
        }

        public function setGagnantRencontreFinale($idRencontre, $idEquipe) : void
        {
           $this -> dao -> setGagnantRencontreFinale($idRencontre, $idEquipe);
        }
    }
?>