<?php

class Tournoi
{

    private $dao;

    public function __construct()
    {
        require_once(realpath(dirname(__FILE__) . '/../DAO/tournoiDAO.php'));
        $this->dao = new tournoiDAO();
    }

    // ==== Creation Tournoi ===
    //Fonction pour afficher les jeux sous forme de liste déroulante


    public function trierPar(string $by)
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


    public function addConcerner($idTournoi, $idJeu)
    {
        return $this->dao->addConcerner($idTournoi, $idJeu);
    }

    public function getTournoi($idEquipe = 0)
    {
        return $this->dao->getTournoi($idEquipe);
    }
    
    public function getTournoiCalendrier($param){
        return $this->dao->getTournoiCalendrier($param);
    }
    
    public function getTournoiNomByIdTournoi($idTournoi){
        return $this->dao->getTournoiNomByIdTournoi($idTournoi);
    }

    public function getJeux()
    {
        return $this->dao->getJeux();
    }

    public function getClassementCM($idJeu)
    {
        $tournoiDAO = new TournoiDAO();
        return $tournoiDAO->getClassementCM($idJeu);
    }

    public function addTournoi($Type, $nom, $dateDeb, $dateFin, $lieu, $nbPtsMax, $IdGestionnaireEsport, $idArbitre)
    {
        return $this->dao->addTournoi($Type, $nom, $dateDeb, $dateFin, $lieu, $nbPtsMax, $IdGestionnaireEsport, $idArbitre);
    }

    public function getLastIDTournoi()
    {
        return $this->dao->getLastIDTournoi();
    }

    public function addJeu($libelle)
    {
        return $this->dao->addJeu($libelle);
    }

    public function getJeuxTournois($id, $choix = "default")
    {
        return $this->dao->getJeuxTournois($id, $choix);
    }

    public function tournoiIsClosed($idTournoi)
    {
        return $this->dao->tournoiIsClosed($idTournoi);
    }

    public function tournoiIscloseable($id)
    {
        return $this->dao->tournoiIscloseable($id);
    }

    public function tournoiIsFull($idTournoi)
    {
        return $this->dao->tournoiIsFull($idTournoi);
    }

    public function tournoisByType($idEquipe = 0)
    {
        return $this->dao->tournoisByType($idEquipe);
    }

    public function tournoisByLieu($idEquipe = 0)
    {
        return $this->dao->tournoisByLieu($idEquipe);
    }

    public function tournoisByNom($idEquipe = 0)
    {
        return $this->dao->tournoisByNom($idEquipe);
    }

    public function tournoisByDate($idEquipe = 0)
    {
        return $this->dao->tournoisByDate($idEquipe);
    }

    public function getIdJeu($libelle)
    {
       return $this -> dao -> getIdJeu($libelle);
    }

    public function jeuNonPresentDansTournois($idT)
    {
        return $this->dao->jeuNonPresentDansTournois($idT);
    }

    public function supprimerJeuxTournoi($idT)
    {
        return $this->dao->supprimerJeuxTournoi($idT);
    }

    public function modifierTournoi($nom, $dateDeb, $datefin, $type, $lieu, $pointMax, $id)
    {
        return $this->dao->modifierTournoi($nom, $dateDeb, $datefin, $type, $lieu, $pointMax, $id);
    }

    public function tournoiId($id)
    {
        return $this->dao->tournoiId($id);
    }

    public function tournoiIdNom($idTournoi)
    {
        return $this->dao->tournoiId($idTournoi)->fetch()['Nom'];
    }

    public function terminerTournoi($idTournoi)
    {
        $this -> dao -> terminerTournoi($idTournoi);
    }
    
    public function isTournoiTermine($idTournoi)
    {
        return $this -> dao -> isTournoiTermine($idTournoi);
    }

    
}
