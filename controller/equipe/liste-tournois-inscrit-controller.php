<?php 

    ## Importation des fichiers ##
    session_start();
    require_once(realpath(dirname(__FILE__) . '/../../controller/visiteur/header-controller.php'));
    require_once(realpath(dirname(__FILE__) .'/../../model/Equipe.php'));

    

    ob_start();
    require_once(realpath(dirname(__FILE__) . '/../../view/equipe/liste-tournois-inscrit.php'));
    $buffer = ob_get_clean();
    $buffer = str_replace("##typeEquipe##", $triTournoisEquipe->triePar("lieu", $_SESSION['username'] ), $buffer);
    $buffer = str_replace("##lieuEquipe##", $triTournoisEquipe->triePar("type", $_SESSION['username'] ), $buffer);
    $buffer = str_replace("##nomEquipe##", $triTournoisEquipe->triePar("nom", $_SESSION['username'] ), $buffer);
    $buffer = str_replace("##dateEquipe##", $triTournoisEquipe->triePar("date", $_SESSION['username'] ), $buffer);

    echo $buffer;



?>