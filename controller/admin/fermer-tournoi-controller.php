<?php


    ## Importation des fichiers ##
    session_start();
    require_once(realpath(dirname(__FILE__) . '/../../controller/visiteur/header-controller.php'));
    require_once(realpath(dirname(__FILE__) . '/../../model/bracket.php'));

    $idTournoi = $_GET['id'];

    $bracket = new bracket();
    
    



?>