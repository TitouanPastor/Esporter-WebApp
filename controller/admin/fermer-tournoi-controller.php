<?php


    ## Importation des fichiers ##
    session_start();
    require_once(realpath(dirname(__FILE__) . '/../../controller/visiteur/header-controller.php'));
    require_once(realpath(dirname(__FILE__) . '/../../model/Tournoi.php'));

    $idTournoi = $_GET['id'];

  


    function display_games($idtournoi)
    {
        $html = "";
        // On récupère les jeux du tournoi
        $games = getJeuxTournois($idtournoi);
        while ($game = $games->fetch()) {
            $html .= '<div class="left-jeux">
                            <span class="libellejeu">' . $game['Libelle'] . '</span>
                            <input type="button" value="Selectionner">
                        </div>';
        }
        return $html;
    }
    
    ob_start();
    require_once(realpath(dirname(__FILE__) . '/../../view/admin/fermer-tournoi-view.html'));
    $buffer = ob_get_clean();
    $buffer = str_replace("##nomTournoi##", tournoiIdNom($idTournoi) , $buffer);
    $buffer = str_replace("##games##", display_games($idTournoi) , $buffer);
    echo $buffer; 


?>