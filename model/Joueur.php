<?php

class Joueur
{
    private $dao;

    function __construct()
    {
        require_once(realpath(dirname(__FILE__) . '/../DAO/JoueurDAO.php'));
        $this->dao = new JoueurDAO();
    }

    // === DAO === //
    public function getJoueur()
    {
        return $this->dao->getJoueur();
    }

    public function addJoueur($nom, $prenom, $dateNaissance, $pseudo, $mail, $idEquipe)
    {
        $this->dao->addJoueur($nom, $prenom, $dateNaissance, $pseudo, $mail, $idEquipe);
    }
}
