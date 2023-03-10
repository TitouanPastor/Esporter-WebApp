<?php

require_once(realpath(dirname(__FILE__) . '/../../model/Header.php'));

$header = new header();

//On prend le nom de la page en coupant le chemin d'accès
$nomPage = explode("/", $_SERVER["PHP_SELF"]);
$nomPage = $nomPage[count($nomPage) - 1];

//On affiche le header en fonction de la page
switch ($nomPage) {
    case "index.php":
    case "liste-tournois-commence-controller.php":
    case "classementCM-controller.php":
    case "calendrier-controller.php":
        echo $header->customizeHeader($_SESSION['role']);
        break; 
    case "login-controller.php":
        echo $header->headerLogin();
        break;
    
    // Gestionnaire
    case "liste-tournois-controller.php":
    case "enregistrer-ecurie-view.php":
    case "creation-tournoi-controller.php":
    case "liste-ecuries-controller.php":
    case "modification-tournoi-controller.php":
    case "fermer-tournoi-controller.php":
        if ($_SESSION['role'] == "gestionnaire") {
            echo $header->customizeHeader($_SESSION['role']);
        } else {
            header("Location: ../../acces-refuse.php");
        }
        break;

    // Equipe
    case "inscription-tournoi-controller.php":
    case "liste-tournois-inscrit-controller.php":
        if ($_SESSION['role'] == "equipe") {
            echo $header->customizeHeader($_SESSION['role']);
        } else {
            header("Location: ../../acces-refuse.php");
        }
        break;
    // Arbitre
    case "liste-tournois-commence-arbitre-controller.php":
        if ($_SESSION['role'] == "arbitre") {
            echo $header->customizeHeader($_SESSION['role']);
        } else {
            header("Location: ../../index.php");
        }
        break;

    
    // Ecurie
    case 'enregistrer-joueurs-controller.php':
    case 'enregistrer-equipe-controller.php':
    if ($_SESSION['role'] == "ecurie") {
        echo $header->customizeHeader($_SESSION['role']);
    } else {
        header("Location: ../../acces-refuse.php");
    }
    break;
}


