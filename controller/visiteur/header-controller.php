<?php


require_once(realpath(dirname(__FILE__) . '/../../model/visiteur/Header.php'));

$header = new header();

//On prend le nom de la page en coupant le chemin d'accès
$nomPage = explode("/", $_SERVER["PHP_SELF"]);
$nomPage = $nomPage[count($nomPage) - 1];

//On affiche le header en fonction de la page
if ($nomPage == "index.php") {
    echo $header->customizeHeader($_SESSION['role']);
} else if ($nomPage == "enregistrer-ecurie-view.php") {
    if ($_SESSION['role'] == "gestionnaire") {
        echo $header->customizeHeader($_SESSION['role']);
    } else {
        header("Location: ../../index.php");
    }
}
