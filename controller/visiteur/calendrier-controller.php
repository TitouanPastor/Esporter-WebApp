<?php
    session_start();
    require_once(realpath(dirname(__FILE__) .'/header-controller.php'));
    require_once(realpath(dirname(__FILE__) .))

    $checkValider = 0;
    $tournoi = new Tournoi();

    //Contrôle sur la date 01/01/2023 -> 31/12/2023
    $min = new DateTime('01-01-2023');
    $max = new DateTime('31-12-2023');    
    $dateMin = $min -> format('Y-m-d');
    $dateMax = $max -> format('Y-m-d');

    //Valeur et affichage d'une liste -> conserver la valeur après validation
    if (isset($_POST["tournoi_date"])){
        $valueTournoiDate = $_POST["tournoi_date"];
    } else {
        $valueTournoiDate = "2023-01-01";
    }

    if (isset($_POST["tournoi_nom"])){ 
        $valueTournoiNom = $_POST["tournoi_nom"];
    } else {
        $valueTournoiNom = "default";
    }

    if (isset($_POST["tournoi_jeu"])){
        $valueTournoiJeu = $_POST["tournoi_jeu"];
    } else {
        $valueTournoiJeu = "default";
    }
    
    //Exécution de la requête en fonction des paramètres fournis (liste rempli ou non)
    if (isset($_POST["valider"])) {
        $checkValider = 1;
        $param = array();
        $param[0] = $_POST["tournoi_date"];
        $param[1] = $_POST["tournoi_nom"];
        $param[2] = $_POST["tournoi_jeu"];
        $req = $sql -> getTournoiCalendrier($param);
    }

    $tournoi = $sql->getTournoi();
    $selectTournoi = "";
    while ($donnees = $tournoi->fetch()) {
        // echo "<option value='.$donnees['Nom'];
        $selectTournoi .= "<option value=".$donnees['Nom'];
        if ($valueTournoiNom == $donnees['Nom']) {
            $selectTournoi .= ' selected >';
        } else {
            $selectTournoi .= '>';
        }
        $selectTournoi .= $donnees['Nom'];
        $selectTournoi .= '</option>';
    }

    ob_start();
    realpath(dirname(__FILE__) .'../../view/visiteur/calendrier-view.php');
    $buffer = ob_clean();
    $buffer = str_replace("##valueTournoiDate##", $valueTournoiDate, $buffer);
    $buffer = str_replace("##dateMin##", $dateMin, $buffer);
    $buffer = str_replace("##dateMax##", $dateMax, $buffer);
    $buffer = str_replace("##selectTournoi##", $selectTournoi, $buffer);
?>