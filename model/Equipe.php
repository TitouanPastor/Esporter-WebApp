<?php

class Equipe
{
    private $dao;

    public function __construct()
    {
        require_once(realpath(dirname(__FILE__) . '/../DAO/EquipeDAO.php'));
        $this->dao = new EquipeDAO();
    }

    // === DAO === //
    public function addEquipe($nom, $mdp, $mail, $nbPtsChamps, $idJeu, $idEcurie)
    {
        $this->dao = new EquipeDAO();
        $this->dao->addEquipe($nom, $mdp, $mail, $nbPtsChamps, $idJeu, $idEcurie);
    }

    public function getEquipe()
    {
        $this->dao = new EquipeDAO();
        return $this->dao->getEquipe();
    }

    public function getJeuEquipe($username)
    {
        $this->dao = new EquipeDAO();
        return $this->dao->getJeuEquipe($username);
    }

    public function getTournoiInscription($jeuLibelle)
    {
        $this->dao = new EquipeDAO();
        return $this->dao->getTournoiInscription($jeuLibelle);
    }

    public function getIdEquipe($username)
    {
        $this->dao = new EquipeDAO();
        return $this->dao->getIdEquipe($username);
    }

    public function getIdJeu($libelle)
    {
        $this->dao = new EquipeDAO();
        return $this->dao->getIdJeu($libelle);
    }

    public function getNomEquipeById($idEquipe)
    {
        return $this->dao->getNomEquipeById($idEquipe);
    }

    public function estInscritTournoi($mail, $tournoiNom)
    {
        $this->dao = new EquipeDAO();
        return $this->dao->estInscritTournoi($mail, $tournoiNom);
    }

    public function getNbEquipeTournoi($id_tournoi, $id_jeu)
    {
        $this->dao = new EquipeDAO();
        return $this->dao->getNbEquipeTournoi($id_tournoi, $id_jeu);
    }

    public function trierPar(string $by, $equipe)
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

    public function listeEquipeTrierPar(string $by, $idEcurie)
    {
        require_once('tri-equipe.php');
        $triEquipe = new TriEquipe($idEcurie);
        switch ($by) {
            case 'nom':
                return $triEquipe->trierParNom();
                break;
            case 'point':
                return $triEquipe->trierParPoint();
                break;
            default:
                return $triEquipe->trierParId();
                break;
        }
        return "Erreur de tri";
    }

    public function getLastIDEquipe()
    {
        $this->dao = new EquipeDAO();
        return $this->dao->getLastIDEquipe();
    }

    public function inscriptionTournoi($param)
    {
        $this->dao = new EquipeDAO();
        return $this->dao->inscriptionTournoi($param);
    }
}
