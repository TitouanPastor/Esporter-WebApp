<?php 

require_once(realpath(dirname(__FILE__) . '/../DAO/EquipeDAO.php'));


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


?>