<?php
// classe php qui genere des bracket de tournois
class bracket
{

    private $sql;

    // idées de fonctionnalités:

    // Niveau UI

    // - afficher les jeux dans lesquels on peut créer un bracket pour chaque tournoi

    // <div class="left-jeux">
    //     <span class="libellejeu">Jeux 1</span>
    //     <input type="button" value="Selectionner">
    // </div>

    public function __construct()
    {
        require_once('../../SQL.php');
        $this->sql = new requeteSQL();
    }

    public function display_games($idtournoi)
    {
        $html = "";
        // On récupère les jeux du tournoi
        $games = $this->sql->getJeuxTournois($idtournoi);
        while ($game = $games->fetch()) {
            $html .= '<div class="left-jeux">
                            <span class="libellejeu">' . $game['Libelle'] . '</span>
                            <input type="button" value="Selectionner">
                        </div>';
        }
        return $html;
    }

    public function genererBracket($idTournoi)
    {
        // echo "On ferme le tournoi : ".$idTournoi."</br></br>";
        if ($this->sql->tournoiIsClosed($idTournoi) == false) {
            $this->sql->closeTournois($idTournoi);
            $IDsjeux = $this->sql->getIDJeuxTournoi($idTournoi);
            // echo "Tableau idsPoule</br>";
            // foreach ($IDsjeux as $id) {
            //     echo "Id : ".$id."</br>";
            // }

            // echo "Boucle d'ajout de poules suivant le nombre de jeux du tournoi : ".count($IDsjeux)."</br></br>";
            for ($i = 0; $i < count($IDsjeux); $i++) {
                for ($j = 0; $j < 4; $j++) {
                    // echo "addPoule( 'Poule".($j+1)."', ".$idTournoi.", ".$IDsjeux[$i].")</br>";
                    $this->sql->addPoule(chr($j + 65), $idTournoi, $IDsjeux[$i]);
                }
            }
            for ($i = 0; $i < count($IDsjeux); $i++) {
                $idsPoule = array();
                $idsEquipe = array();
                $idsPoule = $this->sql->getIDPoule($idTournoi, $IDsjeux[$i]);
                // echo "Tableau idsPoule</br>";
                // foreach ($idsPoule as $id) {
                //     echo "Id : ".$id."</br>";
                // }
                $idsEquipe = $this->sql->getEquipeInscrites($idTournoi, $IDsjeux[$i]);
                // echo "Tableau idsEquipe</br>";
                // foreach ($idsEquipe as $id) {
                //     echo "Id : ".$id."</br>";
                // }
                $bracket = array();

                for ($j = 0; $j < 4; $j++) {
                    $bracket[] = array_splice($idsEquipe, 0, 4);
                    if ($j % 2 == 1) {
                        $bracket[$j] = array_reverse($bracket[$j]);
                    }
                }

                // echo "Tableau idsEquipe transformé</br>";
                // foreach ($bracket as $ids) {
                //     foreach($ids as $id) {
                //         echo "Id : ".$id."</br>";
                //     }
                // }

                // echo "</br> Boucle d'assignation des équipes aux poules </br>";
                for ($j = 0; $j < 4; $j++) {
                    for ($k = 0; $k < 4; $k++) {
                        // echo "Assignation poule : equipe : ".$bracket[$j][$k]." Poule : ".$idsPoule[$j]."</br>";
                        $this->sql->assignerPoule($idTournoi, $idsPoule[$j], $bracket[$j][$k]);
                    }
                }
                // echo "Assignation rencontre </br>";
                for ($j = 0; $j < 4; $j++) {
                    for ($k = 0; $k < 3; $k++) {
                        for ($l = $k; $l < 4; $l++) {
                            if ($bracket[$j][$k] != $bracket[$j][$l]) {
                                // echo "Equipe 1 : ".$bracket[$j][$k]." Equipe 2 : ".$bracket[$j][$l]." poule : ".$idsPoule[$j]."<br>";
                                $this->sql->addRencontre($bracket[$j][$k], $bracket[$j][$l], $idsPoule[$j]);
                            }
                        }
                    }
                }
            }
        }
    }


    //Genere la poule finale avec le vainqueur de chaque poule
    public function genererPouleFinale($idTournoi, $idJeu, $tabPoule)
    {
        $finaliste  = array();
        $this->sql->addPoule( "Finale", $idTournoi, $idJeu);
        $lastIdPoule = $this->sql->getLastIDPoule();
        print_r($tabPoule);
        foreach ($tabPoule as $idPoule){
            array_push($finaliste,  $this->sql->getPremierPoule($idTournoi, $idJeu, $idPoule));
        }
      
        //Ajouter les rencontres
        $adversaire = $finaliste;
        $adversaire = array_reverse($adversaire);
        for ($i = 0; $i < 3 ; $i++ ){
            array_pop($adversaire);
            for ($j = 0; $j < count($adversaire) ; $j++){
                $this->sql->addRencontre($finaliste[$i], $adversaire[$j], $lastIdPoule);
            }
            
            
        }
        
        
    }

    public function pouleTerminer($idPoule)
    {
        $nbMatchTerm = $this->sql->getNbPointPoule($idPoule);
        echo $nbMatchTerm;
        if ($nbMatchTerm != 6) {
            return False;
        } else {
            return True;
        }
    }

    public function updateClassementGeneral($idPoule, $idTournoi)
    {
        $pouleFinale = $this->sql->getPouleFinale($idPoule);
        $multiplicateur = $this->sql->getMultiplicateur($idTournoi);
        $points = [100, 60, 30, 10];
        $i = 0;
        while ($row = $pouleFinale->fetch()) {
            $this->sql->updateClassementEquipe($row["Id_Equipe"], $row["nb_Match_Gagne"] * 5 + $points[$i] * $multiplicateur);
            $i++;
        }
    }










    // - afficher les équipes inscrites dans un tournoi pour le jeu selectionné
    // - afficher les poules du bracket pour le jeu selectionné

    //  question : est-ce qu'on drop les données dans etre_inscrit quand on créer le lien de la poule ? ou alors on give up le lien
    // entre la poule et l'équipe et on fait un lien entre la poule et l'equipe_inscrite ?

    // premiere fonction :
    // fonction qui prend en parametre un tableau d'équipes et qui genere un bracket de tournoi d'un jeu particulier
    // Quand ? : quand l'admin clic sur "créer le bracket"
    // Condition : il faut que le nombre d'équipes soit égal à 16
    //niveau bdd : insere les quatres poules dans la bdd ainsi que le lien entre les poules et le tournoi, et poule et équipe



    // deuxieme fonction :
    // fonction qui prend en entrée quatres tableaux des poules et qui génère une poule finale
    // Quand ? : quand l'arbitre clic sur "créer la poule finale"
    // Condition : il faut que tout les résultats des poules soient entrés
    // niveau bdd : insere la poule finale dans la bdd ainsi que le lien entre la poule finale et le tournoi, et poule finale et équipe



    // troisième fonction :
    // Fonction qui prend en entrée toutes les poules d'un tournoi (qualificative et finale) et qui retourne le classement final du tournoi
    // Quand ? : quand l'arbitre clic sur "Génerer classement final"
    // Condition : il faut que tout les résultats des poules soient entrés
    // niveau bdd : insere le classement final dans la bdd ainsi que le lien entre le classement final et le tournoi, et classement final et équipe

}
