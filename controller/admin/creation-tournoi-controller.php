<?php 

session_start();
require_once(realpath(dirname(__FILE__) . '/../../controller/visiteur/header-controller.php'));
require_once(realpath(dirname(__FILE__) . '/../../model/Tournoi.php'));

$infoExecution = "";
$infoExecutionJeu = "";

$sql = new Tournoi();
$reqJeu = $sql->getJeux();

// Ajouter un tournoi
if (isset($_POST['ajouter'])) {

    // Vérification de si nous avons le droit de créer un tounoi (si c'est avant le 1er février)
    if (date("m") < 4) {

        // Vérification de si tout les champs sont remplis
        if (!empty($_POST['nom-tournoi']) && !empty($_POST['comboboxtypetournoi']) && !empty($_POST['lieu-tournoi']) && !empty($_POST['date-debut']) && !empty($_POST['date-fin'])) {

            //Vérification de si il y a au moins un jeu séléctionner
            if (sizeof($_POST['jeuxtournoi']) > 0) {

                // Vérification de si la date de début est inferieur la date de fin   
                if (strtotime($_POST['date-debut']) <= strtotime($_POST['date-fin'])) {

                    // Vérification de si la date de début est supérieur à la date du jour
                    if (strtotime($_POST['date-debut']) > strtotime(date("Y-m-d") . ' + 2 weeks')) {

                        //Vérification de si un tournoi du même nom n'existe pas
                        $tournois = $sql->getTournoi();
                        $sameTournoi = False;
                        
                        while ($tournoi = $tournois->fetch()) {
                            if (strtoupper($tournoi['Nom']) == strtoupper($_POST['nom-tournoi'])) {
                                $sameTournoi = True;
                            }
                        }
                        if (!$sameTournoi) {
                            try {
                                //Mise à jour des points du tournoi en fonction de son type
                                if ($_POST['comboboxtypetournoi'] == "Local") {
                                    $points = 1;
                                } else if ($_POST['comboboxtypetournoi'] == "National") {
                                    $points = 2;
                                } else if ($_POST['comboboxtypetournoi'] == "International") {
                                    $points = 3;
                                } else {
                                    $points = 0;
                                }
                               
                                // Ajout d'un tournoi (les deux derniers 1 correspondent au id du gestionnaire et de l'arbitre)
                                $sql->addTournoi(htmlspecialchars($_POST['comboboxtypetournoi']), htmlspecialchars($_POST['nom-tournoi']), htmlspecialchars($_POST['date-debut']), htmlspecialchars($_POST['date-fin']), htmlspecialchars($_POST['lieu-tournoi']), htmlspecialchars($points), 1, 1);
                                // Récupération de l'ID dernier tournoi créer
                                $idTournoi = $sql->getLastIDTournoi();
                                // // Ajout des jeux du tournoi 
                                foreach ($_POST['jeuxtournoi'] as $jeu) {
                                    $sql->addConcerner($idTournoi, $jeu);
                                }
                                $infoExecution = 'Tournoi ajouté !';
                                header('Location: liste-tournois-controller.php?createTournoi=success');
                            } catch (Exception $e) {
                                $infoExecution = "Erreur lors de l'ajout du tournoi ! Veuillez réessayer.";
                            }
                            $infoExecution = "Le tournoi a bien été ajouté";
                        } else {
                            $infoExecution = "Un tournoi avec le même nom existe déjà";
                        }
                    } else {
                        $infoExecution = "La date de début du tournoi doit être supérieur à 2 semaines";
                    }
                } else {
                    $infoExecution = "La date de début doit être inférieur à la date de fin !";
                }
            } else {
                $infoExecution = "<center> Veuillez sélectionner au moins un jeu ! <br> N'oublier pas de cliquer sur le bouton 'Valider la selection' après avoir sélectionné un jeu. <center>";
            }
        } else {
            $infoExecution = "Veuillez remplir tous les champs";
        }
    } else {
        $infoExecution = "La création de tournoi est désactivé !";
    }
}

// Ajouter un ou plusieurs jeux
if (isset($_POST['ajouterJeu'])) {
    //Vérification de si le champs n'est pas vide
    if (!empty($_POST['jeux-tournoi'])) {
        //Vérification de si le jeu n'existe pas déjà
        $jeux = $sql->getJeux();
        $sameJeu = False;
        while ($jeu = $jeux->fetch()) {
            if (strtoupper($jeu['Libelle']) == strtoupper($_POST['jeux-tournoi'])) {
                $sameJeu = True;
            }
        }
        if (!$sameJeu) {
            try {
                //Ajout du nouveau jeu
                $sql->addJeu(htmlspecialchars($_POST['jeux-tournoi']));
                $reqJeu = $sql->getJeux();
                $infoExecutionJeu = "Jeu ajouté !";
            } catch (Exception $e) {
                $infoExecutionJeu = "Erreur lors de l'ajout du jeu !";
            }
        } else {
            $infoExecutionJeu = "Le jeu existe déjà";
        }
    }
}

function afficherListeJeux($reqJeu){
    $html = '';
    while ($data = $reqJeu->fetch()) {

        $html .= '<option value="' . $data['Id_Jeu'] . '">' . $data['Libelle'] . '</option>';
    }

    return $html;
}

ob_start();
require_once(realpath(dirname(__FILE__) . '/../../view/admin/creation-tournoi-view.html'));
$buffer = ob_get_clean();
$buffer = str_replace("##infoExecution##", $infoExecution, $buffer);
$buffer = str_replace("##infoExecutionJeu##", $infoExecutionJeu, $buffer);
$buffer = str_replace('##ListeJeu##', afficherListeJeux($reqJeu), $buffer);
echo $buffer;
