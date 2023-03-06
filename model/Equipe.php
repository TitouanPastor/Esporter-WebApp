<?php

class Equipe
{
    private $dao;

    function __construct()
    {
        require_once(realpath(dirname(__FILE__) . '/../DAO/EquipeDAO.php'));
        $this->dao = new EquipeDAO();
    }

    // === DAO === //
    function getJeuEquipe($username)
    {
        $this->dao = new EquipeDAO();
        return $this->dao->getJeuEquipe($username);
    }

    function getTournoiInscription($jeuLibelle)
    {
        $this->dao = new EquipeDAO();
        return $this->dao->getTournoiInscription($jeuLibelle);
    }

    function getIdEquipe($username)
    {
        $this->dao = new EquipeDAO();
        return $this->dao->getIdEquipe($username);
    }

    function getIdJeu($libelle)
    {
        $this->dao = new EquipeDAO();
        return $this->dao->getIdJeu($libelle);
    }

    function estInscritTournoi($mail, $tournoiNom)
    {
        $this->dao = new EquipeDAO();
        return $this->dao->estInscritTournoi($mail, $tournoiNom);
    }

    function getNbEquipeTournoi($nom_tournoi)
    {
        $this->dao = new EquipeDAO();
        return $this->dao->getNbEquipeTournoi($nom_tournoi);
    }

    function trierPar(string $by, $equipe)
    {
        require_once("tri-tournois-equipe.php");
        $triTournois = new TriTournoisEquipe($equipe);
        switch ($by) {
            case 'type':
                return $triTournois->trierParTypeTournoisEquipe();
                break;
            case 'lieu':
                return $triTournois->trierParLieuTournoisEquipe();
                break;
            case 'nom':
                return $triTournois->trierParNomTournoisEquipe();
                break;
            case 'date':
                return $triTournois->trierParDateTournoisEquipe();
                break;
            default:
                return $triTournois->trierParIdTournoisEquipe();
                break;
        }
        return "Erreur de tri";
    }
}
