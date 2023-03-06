<?php

## Importation des fichiers ##
session_start();
require_once(realpath(dirname(__FILE__) . '/../../controller/visiteur/header-controller.php'));
require_once(realpath(dirname(__FILE__) . '/../../model/Tournoi.php'));





$sql = new TournoiDAO();
$idTournois = $_GET['id'];
$reqTournoisId = $sql->tournoiId($idTournois);
$infoExecutionJeu = "";
$infoExecution = "";
while ($row = $reqTournoisId->fetch()) {
    $nom = $row['Nom'];
    $nbPtsMax = $row['Nombre_point_max'];
    $type = $row['Type'];
    $dateTournoisDeb = $row['Date_debut'];
    $dateTournoisFin = $row['Date_fin'];
    $lieu = $row['Lieu'];
}
if (isset($_POST['modifier'])) {

    // Vérification de si nous avons le droit de modifier un tounoi (si c'est avant le 1er Avril)
    if (strtotime("2023-04-01") > strtotime(date("Y-m-d"))) {

        // Vérification de si les champs sont remplis
        if (!empty($_POST['nom-tournoi']) && !empty($_POST['type-tournoi']) && !empty($_POST['date-tournoi-deb']) && !empty($_POST['date-tournoi-fin']) && !empty($_POST['lieu-tournoi'])) {

            if (sizeof($_POST['jeuxtournoi']) > 0) {

                // Vérification de si la date de début est inferieur la date de fin   
                if (strtotime($_POST['date-tournoi-deb']) <= strtotime($_POST['date-tournoi-fin'])) {

                    // Vérification de si la date de début est supérieur à la date du jour + 2 semaines
                    if (strtotime($_POST['date-tournoi-deb']) > strtotime(date("Y-m-d") . ' + 2 weeks')) {

                        // Vérification de si la date de début est supérieur à la date du jour
                        if (strtotime($_POST['date-tournoi-deb']) > strtotime(date("Y-m-d"))) {
                            //Vérification de si un tournoi du même nom n'existe pas
                            $sameTournoi = False;
                            $tournoisId = $sql->tournoiId($idTournois);


                            $tournois = $sql->getTournoi();
                            while ($tournoi = $tournois->fetch()) {
                                if (strtoupper($tournoi['Nom']) == strtoupper($_POST['nom-tournoi'])) {
                                    $sameTournoi = True;
                                }
                            }


                            while ($row = $tournoisId->fetch()) {
                                if ($row['Nom'] == $_POST['nom-tournoi']) {
                                    $sameTournoi = False;
                                }
                            }
                            if (!$sameTournoi) {
                                try {
                                    switch ($_POST['type-tournoi']) {
                                        case "Local":
                                            $ptsMAX = 1;
                                            break;
                                        case "National":
                                            $ptsMAX = 2;
                                            break;
                                        case "International":
                                            $ptsMAX = 3;
                                            break;
                                        default:
                                            $ptsMAX = 0;
                                            break;
                                    }

                                    //Modification tu tournoi
                                    $reqModifier = $sql->modifierTournoi(htmlspecialchars($_POST['nom-tournoi']), htmlspecialchars($_POST['date-tournoi-deb']), htmlspecialchars($_POST['date-tournoi-fin']), htmlspecialchars($_POST['type-tournoi']), htmlspecialchars($_POST['lieu-tournoi']), $ptsMAX, $idTournois);

                                    //Suppression des jeux du tournoi
                                    $reqSupprimerJeuxTournois = $sql->supprimerJeuxTournoi($idTournois);

                                    //Ajout des nouveau jeux du tournoi
                                    foreach ($_POST['jeuxtournoi'] as $jeu) {
                                        $sql->addConcerner($idTournois, $jeu);
                                    }
                                    $infoExecution = 'Tournoi modifié !';
                                    header('Location: liste-tournois.php?modifyTournoi=success');
                                } catch (Exception $e) {
                                    $infoExecution = "Erreur lors de la modification du tournoi ! Veuillez réessayer.";
                                }
                                $infoExecution = "Le tournoi a bien été modifié";
                            } else {
                                $infoExecution = "Un tournoi avec le même nom existe déjà";
                            }
                        } else {
                            $infoExecution = "La date que vous avez entrez est inférieur à la date d'aujoud'hui !";
                        }
                    } else {
                        $infoExecution = "La date de début doit être supérieur à la date du jour !";
                    }
                } else {
                    $infoExecution = "La date de début doit être inférieur à la date de fin !";
                }
            } else {
                $infoExecution = "<center> Veuillez sélectionner au moins un jeu ! <br> N'oublier pas de cliquer sur le bouton 'Valider la selection' après avoir sélectionné un jeu. <center>";
            }
        } else {
            $infoExecutionJeu = "Veuillez remplir tous les champs";
        }
    } else {
        $infoExecutionJeu = "Vous ne pouvez plus modifier de tournoi l(max : 1 février) !";
    }
}
$reqJeuduTournois = $sql->getJeuxTournois($idTournois);
$reqNonPresentTournois = $sql->jeuNonPresentDansTournois($idTournois);
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
                $sql->addJeu($_POST['jeux-tournoi']);
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

ob_start();
require_once(realpath(dirname(__FILE__) . '/../../view/admin/modification-tournoi-view.html'));
$buffer = ob_get_clean();
$buffer = str_replace("##idTournoi##", $idTournois, $buffer);
$buffer = str_replace("##nom##", $nom, $buffer);
$buffer = str_replace("##jeu##", afficherListeJeuxTournoi($reqJeuduTournois, $reqNonPresentTournois), $buffer);
$buffer = str_replace("##infoExecutionJeu##", $infoExecutionJeu, $buffer);
$buffer = str_replace("##dateTournoisDeb##", $dateTournoisDeb, $buffer);
$buffer = str_replace("##dateTournoisFin##", $dateTournoisFin, $buffer);
$buffer = str_replace("##lieu##", $lieu, $buffer);
$buffer = str_replace("##infoExecution##", $infoExecution, $buffer);
$buffer = str_replace("##typeTournoi##", afficherListeTypeTournoi($type), $buffer);
echo $buffer;