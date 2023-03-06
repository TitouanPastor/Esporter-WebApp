<?php 

require_once(realpath(dirname(__FILE__) . '/../DAO/EquipeDAO.php'));
require_once("tri-tournois-equipe.php");


// === DAO === //
function getJeuEquipe($username){
    $equipeDAO = new EquipeDAO();
    return $equipeDAO->getJeuEquipe($username);
   
}

function getTournoiInscription($jeuLibelle){
    $equipeDAO = new EquipeDAO();
    return $equipeDAO->getTournoiInscription($jeuLibelle);
}

function getIdEquipe($username){
    $equipeDAO = new EquipeDAO();
    return $equipeDAO->getIdEquipe($username);
}

function getIdJeu($libelle){
    $equipeDAO = new EquipeDAO();
    return $equipeDAO->getIdJeu($libelle);
}

function estInscritTournoi($mail, $tournoiNom){
    $equipeDAO = new EquipeDAO();
    return $equipeDAO->estInscritTournoi($mail, $tournoiNom);
}

function getNbEquipeTournoi($nom_tournoi){
    $equipeDAO = new EquipeDAO();
    return $equipeDAO->getNbEquipeTournoi($nom_tournoi);
}

function trierPar(string $by, $equipe){
    $triTournois = new TriTournoisEquipe($equipe);
    switch($by){
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


?>