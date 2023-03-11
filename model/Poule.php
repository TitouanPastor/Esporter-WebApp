<?php
    class Poule {
        private $dao;

        function __construct()
        {
            require_once(realpath(dirname(__FILE__) . '/../DAO/pouleDAO.php'));
            $this->dao = new PouleDAO();
        }

        function getPouleIdTournoi($idTournoi)
        {
            return $this->dao->getPouleIdTournoi($idTournoi);
        }

        function setGagnantRencontre($idRencontre, $idEquipe){
            return $this->dao->setGagnantRencontre($idRencontre, $idEquipe);
        }
    }
?>