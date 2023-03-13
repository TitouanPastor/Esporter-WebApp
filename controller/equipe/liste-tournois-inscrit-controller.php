<?php 

    ## Importation des fichiers ##
    session_start();
    require_once(realpath(dirname(__FILE__) . '/../../controller/visiteur/header-controller.php'));
    require_once(realpath(dirname(__FILE__) .'/../../model/Equipe.php'));

    $equipe = new Equipe();

    

    ob_start();
    require_once(realpath(dirname(__FILE__) . '/../../view/equipe/liste-tournois-inscrit-view.html'));
    $buffer = ob_get_clean();
    $buffer = str_replace("##typeEquipe##", $equipe->trierPar("type", $_SESSION['username'] ), $buffer);
    $buffer = str_replace("##lieuEquipe##", $equipe->trierPar("lieu", $_SESSION['username'] ), $buffer);
    $buffer = str_replace("##nomEquipe##", $equipe->trierPar("nom", $_SESSION['username'] ), $buffer);
    $buffer = str_replace("##dateEquipe##", $equipe->trierPar("date", $_SESSION['username'] ), $buffer);
    $buffer = str_replace("##idEquipe##", $equipe->trierPar("ID", $_SESSION['username'] ), $buffer);

    echo $buffer;



?>