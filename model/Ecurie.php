<?php
class Ecurie
{
    private $dao;

    function __construct()
    {
        require_once(realpath(dirname(__FILE__) . '/../DAO/EcurieDAO.php'));
        $this->dao = new EcurieDAO();
    }

    public function getEcurie()
    {
        return $this->dao->getEcurie();
    }

    public function addEcurie($nom, $statut, $mdp, $mail, $idGestionnaire)
    {
        $this->dao->addEcurie($nom, $statut, $mdp, $mail, $idGestionnaire);
    }

    public function getIdEcurieByMail($mail)
    {
        return $this->dao->getIdEcurieByMail($mail);
    }

    public function getEquipeEcurie($id)
    {
        return $this->dao->getEquipeEcurie($id);
    }
}