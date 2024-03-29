<?php

 ## Importation des fichiers ##
 session_start();
 require_once(realpath(dirname(__FILE__) . '/../../controller/visiteur/header-controller.php'));
 require_once(realpath(dirname(__FILE__) . '/../../model/Equipe.php'));

$equipe = new Equipe();
 //Sauvegarde de la valeur de la liste
 if (isset($_POST["tournoi-jeu"])) {
     $valueTournoiJeu = $_POST["tournoi-jeu"];
 } else {
     $valueTournoiJeu = "default";
 }
 $req = $equipe->getJeuEquipe($_SESSION['username']);
 $tabJeu = $req->fetch();
 $jeuEquipe = $tabJeu[0];
 $id_jeu = $tabJeu[1];
 $req = $equipe->getTournoiInscription($id_jeu);

 //Requête d'inscription au tournoi cliqué
 if (isset($_GET['id'])) {
     $param = [];
     $param[0] = $equipe->getIdEquipe($_SESSION['username']);
     $param[1] = htmlspecialchars($_GET['id']);
     $param[2] = $equipe->getIdJeu($jeuEquipe);
     $reqInscription = $equipe->inscriptionTournoi($param);
 }


function listeTournoiDisponible($req, $id_jeu)
{
    $equipe = new Equipe();
    $html = '';
    while ($donnees = $req->fetch()) {
        if ($equipe->estInscritTournoi($_SESSION['username'], $donnees[0]) == 0) {
            $reqNbEquipe = $equipe->getNbEquipeTournoi($donnees[2], $id_jeu);
            $nbEquipe = $reqNbEquipe->fetchColumn();
            $idTournoi = $donnees[2];
            $html .= 
            '<tr>
                        <td>' . $donnees[0] . '</td>
                        <td>' . date('d / m / Y', strtotime($donnees[1])) . '</td>
                        <td>';
                        $html .=  $nbEquipe . ' / 16';
                        $html .=  '<td>';
            if ((16 - $nbEquipe) > 0) {
                $html .=  "<a style='text-decoration: underline;cursor:pointer;color:blue;' value='inscription-tournoi-controller.php?id=$idTournoi' onclick='openPopUp(this)' >S'inscrire</a>";
                
            } else {
                $html .=  "<input type = 'button' class = 'bouton' title = 'Complet' disabled>";
            }
            $html .=  '</td>
                    </tr>';
        }
    }

    return $html;
}

ob_start();
require_once(realpath(dirname(__FILE__) . '/../../view/equipe/inscription-tournoi-view.html'));
$buffer = ob_get_clean();
$buffer = str_replace("##jeuEquipe##", $jeuEquipe, $buffer);
$buffer = str_replace("##ListeTournoiDispo##", listeTournoiDisponible($req, $id_jeu) , $buffer);
echo $buffer;
