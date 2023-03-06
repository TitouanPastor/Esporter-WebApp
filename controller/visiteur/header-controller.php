<?php

require_once(realpath(dirname(__FILE__) . '/../../model/Header.php'));

$header = new header();

//On prend le nom de la page en coupant le chemin d'accès
$nomPage = explode("/", $_SERVER["PHP_SELF"]);
$nomPage = $nomPage[count($nomPage) - 1];

//On affiche le header en fonction de la page
switch ($nomPage) {
    case "index.php":
        echo $header->customizeHeader($_SESSION['role']);
        break; 
    case "login-controller.php":
        echo $header->headerLogin();
        break;
    case "classementCM-controller.php":
        echo $header->customizeHeader($_SESSION['role']);
        break;
    case "liste-tournois-controller.php":
    case "enregistrer-ecurie-view.php":
    case "creation-tournoi-controller.php":
    case "modification-tournoi-controller.php":
    case "fermer-tournoi-controller.php":
        if ($_SESSION['role'] == "gestionnaire") {
            echo $header->customizeHeader($_SESSION['role']);
        } else {
            header("Location: ../../acces-refuse.php");
        }
        break;
    case "inscription-tournoi-controller.php":
           
        if ($_SESSION['role'] == "equipe") {
            echo $header->customizeHeader($_SESSION['role']);
        } else {
            header("Location: ../../index.php");
        }
        break;

}


