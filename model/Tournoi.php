<?php

class Tournoi
{

    private $dao;

    function __construct()
    {
        require_once(realpath(dirname(__FILE__) . '/../DAO/tournoiDAO.php'));
        $this->dao = new tournoiDAO();
    }

    // ==== Creation Tournoi ===
    //Fonction pour afficher les jeux sous forme de liste déroulante


    function trierPar(string $by)
    {
        require_once('tri-tournois.php');
        $triTournois = new TriTournois();
        switch ($by) {
            case 'type':
                return $triTournois->trierParType();
                break;
            case 'lieu':
                return $triTournois->trierParLieu();
                break;
            case 'nom':
                return $triTournois->trierParNom();
                break;
            case 'date':
                return $triTournois->trierParDate();
                break;
            default:
                return $triTournois->trierParId();
                break;
        }
        return "Erreur de tri";
    }

    // DAO // 


    function addConcerner($idTournoi, $idJeu)
    {
        return $this->dao->addConcerner($idTournoi, $idJeu);
    }

    function getTournoi($idEquipe = 0)
    {
        return $this->dao->getTournoi($idEquipe);
    }

    function getJeux()
    {
        return $this->dao->getJeux();
    }

    function getClassementCM($idJeu)
    {
        $tournoiDAO = new TournoiDAO();
        return $tournoiDAO->getClassementCM($idJeu);
    }

    function addTournoi($Type, $nom, $dateDeb, $dateFin, $lieu, $nbPtsMax, $IdGestionnaireEsport, $idArbitre)
    {
        return $this->dao->addTournoi($Type, $nom, $dateDeb, $dateFin, $lieu, $nbPtsMax, $IdGestionnaireEsport, $idArbitre);
    }

    function getLastIDTournoi()
    {
        return $this->dao->getLastIDTournoi();
    }

    function addJeu($libelle)
    {
        return $this->dao->addJeu($libelle);
    }

    function getJeuxTournois($id, $choix = "default")
    {
        return $this->dao->getJeuxTournois($id, $choix);
    }

    function tournoiIsClosed($idTournoi)
    {
        return $this->dao->tournoiIsClosed($idTournoi);
    }

    function tournoiIscloseable($id)
    {
        return $this->dao->tournoiIscloseable($id);
    }

    function tournoiIsFull($idTournoi)
    {
        return $this->dao->tournoiIsFull($idTournoi);
    }

    function tournoisByType($idEquipe = 0)
    {
        return $this->dao->tournoisByType($idEquipe);
    }

    function tournoisByLieu($idEquipe = 0)
    {
        return $this->dao->tournoisByLieu($idEquipe);
    }

    function tournoisByNom($idEquipe = 0)
    {
        return $this->dao->tournoisByNom($idEquipe);
    }

    function tournoisByDate($idEquipe = 0)
    {
        return $this->dao->tournoisByDate($idEquipe);
    }

    function jeuNonPresentDansTournois($idT)
    {
        return $this->dao->jeuNonPresentDansTournois($idT);
    }

    function supprimerJeuxTournoi($idT)
    {
        return $this->dao->supprimerJeuxTournoi($idT);
    }

    function modifierTournoi($nom, $dateDeb, $datefin, $type, $lieu, $pointMax, $id)
    {
        return $this->dao->modifierTournoi($nom, $dateDeb, $datefin, $type, $lieu, $pointMax, $id);
    }

    function tournoiId($id)
    {
        return $this->dao->tournoiId($id);
    }

    function tournoiIdNom($idTournoi)
    {
        return $this->dao->tournoiId($idTournoi)->fetch()['Nom'];
    }
}
