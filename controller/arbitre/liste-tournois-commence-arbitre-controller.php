<?php

## Importation des fichiers ##
session_start();
require_once(realpath(dirname(__FILE__) . '/../visiteur/header-controller.php'));
require_once(realpath(dirname(__FILE__) . '/../../model/Arbitre.php'));

$arbitre = new Arbitre();
$req = $arbitre->getTournoiCommence();

function afficherTableau($req, $arbitre)
{
    $pair = 0;
    $html = '';
    while ($donnees = $req->fetch()) {
        if ($pair % 2 == 0) {
            $bg = "white";
        } else {
            $bg = "grey";
        }
        $pair += 1;
        $idTournoi = strval($donnees[2]);
        $reqJeux = $arbitre->getJeuxTournois($idTournoi, "libelle");
        $listeJeu = array();
        while ($nomJeu = $reqJeux->fetch()) {
            array_push($listeJeu, $nomJeu['libelle']);
        }
        $nbJeu = count($listeJeu);
        $html .= "
        <tr class=" . $bg . ">
            <td>$donnees[0]</td>
            <td>" . date('d / m / Y', strtotime($donnees[1])) . "</td>
            <td>$listeJeu[0]</td>
            <td>
                <label>" . '
                <a href="match-poule-controller.php?id_tournoi=' . $idTournoi . '&id_jeu=' . $listeJeu[0] . '">
                    <svg width="30px" height="30px" viewBox="0 -2 20 20" xmlns="http://www.w3.org/2000/svg">
                    <g id="basketball-field-2" transform="translate(-2 -4)">
                    <path id="secondary" fill="#2ca9bc" d="M21,15H19a3,3,0,0,1,0-6h2V5H3V9H5a3,3,0,0,1,0,6H3v4H21Z"/>
                    <line id="primary-upstroke" y1="0.1" transform="translate(12 11.95)" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"/>
                    <path id="primary" d="M12,19V5M5,15a3,3,0,0,0,3-3H8A3,3,0,0,0,5,9H3v6Zm16,0V9H19a3,3,0,0,0-3,3h0a3,3,0,0,0,3,3Zm0,4V5H3V19Z" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                    </g>
                    </svg>
                    </a>
                ' . "</label>
            </td>
        </tr>
    ";
        //Si le tournoi a plusieurs jeux
        if ($nbJeu > 1) {
            for ($i = 1; $i < $nbJeu - 1; $i++) {
                $idTournoi = strval($donnees[2]);
                $html .= "
            <tr class=" . $bg . ">
                <td></td>
                <td></td>
                <td>$listeJeu[$i]</td>
                <td>
                    <label>" . '
                        <a href="match-poule-controller.php?id_tournoi=' . $idTournoi . '&id_jeu=' . $idTournoi . '">
                        <svg width="30px" height="30px" viewBox="0 -2 20 20" xmlns="http://www.w3.org/2000/svg">
                        <g id="basketball-field-2" transform="translate(-2 -4)">
                        <path id="secondary" fill="#2ca9bc" d="M21,15H19a3,3,0,0,1,0-6h2V5H3V9H5a3,3,0,0,1,0,6H3v4H21Z"/>
                        <line id="primary-upstroke" y1="0.1" transform="translate(12 11.95)" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"/>
                        <path id="primary" d="M12,19V5M5,15a3,3,0,0,0,3-3H8A3,3,0,0,0,5,9H3v6Zm16,0V9H19a3,3,0,0,0-3,3h0a3,3,0,0,0,3,3Zm0,4V5H3V19Z" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                        </g>
                        </svg>
                        </a>
                    ' . "</label>
                </td>
            </tr>
        ";
            }
        }

        
    }
    return $html;
}

ob_start();
require_once(realpath(dirname(__FILE__) . '/../../view/visiteur/liste-tournois-commence-view.html'));
$buffer = ob_get_clean();
$buffer = str_replace("##afficherTableau##", afficherTableau($req, $arbitre), $buffer);
echo $buffer;

?>