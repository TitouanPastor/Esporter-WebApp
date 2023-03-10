<?php
    session_start();
    require_once(realpath(dirname(__FILE__) .'/header-controller.php'));
    require_once(realpath(dirname(__FILE__) .'/../../model/Tournoi.php'));

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
        $req = $tournoi -> getTournoiCalendrier($param);
    }

    $getTournoi = $tournoi -> getTournoi();
    $selectTournoi = "";
    while ($donnees = $getTournoi->fetch()) {
        $selectTournoi .= "<option value=".$donnees['Nom'];
        if ($valueTournoiNom == $donnees['Nom']) {
            $selectTournoi .= ' selected >';
        } else {
            $selectTournoi .= '>';
        }
        $selectTournoi .= $donnees['Nom'];
        $selectTournoi .= '</option>';
    }

    $getJeux = $tournoi -> getJeux();
    $selectJeu = "";
    while ($donnees = $getJeux->fetch()) {
        $selectJeu .= "<option value=".$donnees['Libelle'];
        if ($valueTournoiJeu == $donnees['Libelle']) {
            $selectJeu .= ' selected >';
        } else {
            $selectJeu .= '>';
        }
        $selectJeu .= $donnees['Libelle'];
        $selectJeu .= '</option>';
    }
    
    $tableau = "";
    if ($checkValider == 1) {
        if ($req -> rowCount() == 0){
            $tableau .= "<div style='display : flex; justify-content :center; padding-top : 50px;'> Il n'y a pas de tournoi pour ces critères </div>";
        } else {
            $tableau .= "
        <div class = 'tableau-style'>
        <table>
            <thead>
                <tr>
                    <th> Nom du Tournoi </th>
                    <th> Date du tournoi</th>
                    <th> Jeu du Tournoi </th>
                </tr>
            </thead>

            <tbody>";
            while ($donnees = $req->fetch()) {
                $tableau .= '
                <tr>
                    <td>' . $donnees[0] . '</td>
                    <td>' . date('d / m / Y', strtotime($donnees[1])). '</td>
                    <td>' . $donnees[2] . '</td>
                </tr>
                ';
            }
            $tableau .= "
                </tbody>
                </table>
                </div>
            </form>
        ";
        } 
    }

    ob_start();
    require_once(realpath(dirname(__FILE__) .'/../../view/visiteur/calendrier-view.html'));
    $buffer = ob_get_clean();
    $buffer = str_replace("##valueTournoiDate##", $valueTournoiDate, $buffer);
    $buffer = str_replace("##dateMin##", $dateMin, $buffer);
    $buffer = str_replace("##dateMax##", $dateMax, $buffer);
    $buffer = str_replace("##selectTournoi##", $selectTournoi, $buffer);
    $buffer = str_replace("##selectJeu##", $selectJeu, $buffer);
    $buffer = str_replace("##tableau##", $tableau, $buffer);
    echo $buffer;
?>