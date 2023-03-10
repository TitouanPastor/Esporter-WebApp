<?php
session_start();
require_once(realpath(dirname(__FILE__) . '/../../controller/visiteur/header-controller.php'));
require_once(realpath(dirname(__FILE__) . '/../../model/Joueur.php'));
$infoExecution = "";

$joueurModel = new Joueur();

// Ajouter une équipe
if (isset($_POST['ajouter'])) {
    // Vérification de si tout les champs du joueur1 sont remplis
    if (!empty($_POST['nom-joueur1']) && !empty($_POST['prenom-joueur1']) && !empty($_POST['dtn-joueur1']) && !empty($_POST['pseudo-joueur1'])  && !empty($_POST['email-joueur1'])) {
        // Vérification de si tout les champs du joueur2 sont remplis
        if (!empty($_POST['nom-joueur2']) && !empty($_POST['prenom-joueur2']) && !empty($_POST['dtn-joueur2']) && !empty($_POST['pseudo-joueur2'])  && !empty($_POST['email-joueur2'])) {
            // Vérification de si tout les champs du joueur3 sont remplis
            if (!empty($_POST['nom-joueur3']) && !empty($_POST['prenom-joueur3']) && !empty($_POST['dtn-joueur3']) && !empty($_POST['pseudo-joueur3'])  && !empty($_POST['email-joueur3'])) {
                // Vérification de si tout les champs du joueur4 sont remplis
                if (!empty($_POST['nom-joueur4']) && !empty($_POST['prenom-joueur4']) && !empty($_POST['dtn-joueur4']) && !empty($_POST['pseudo-joueur4'])  && !empty($_POST['email-joueur4'])) {
                    // Vérification de si le joueur1 à plus de 12ans
                    if (strtotime($_POST['dtn-joueur1']) <= strtotime(date("Y-m-d") . ' - 12 years')) {
                        // Vérification de si le joueur2 à plus de 12ans
                        if (strtotime($_POST['dtn-joueur2']) <= strtotime(date("Y-m-d") . ' - 12 years')) {
                            // Vérification de si le joueur3 à plus de 12ans
                            if (strtotime($_POST['dtn-joueur3']) <= strtotime(date("Y-m-d") . ' - 12 years')) {
                                // Vérification de si le joueur4 à plus de 12ans
                                if (strtotime($_POST['dtn-joueur4']) <= strtotime(date("Y-m-d") . ' - 12 years')) {
                                    //Vérification de si le pseudo et le mail du joueur1 sont déjà utilisés
                                    $joueurs = $joueurModel->getJoueur();
                                    $samePseudo1 = False;
                                    $sameMail1 = False;
                                    while ($joueur1 = $joueurs->fetch()) {
                                        if (strtoupper($joueur1['Pseudo']) == strtoupper($_POST['pseudo-joueur1'])) {
                                            $samePseudo1 = True;
                                        }
                                        if (strtoupper($joueur1['Mail']) == strtoupper($_POST['email-joueur1'])) {
                                            $sameMail1 = True;
                                        }
                                    }
                                    //Vérification de si le pseudo et le mail du joueur2 sont déjà utilisés
                                    $samePseudo2 = False;
                                    $sameMail2 = False;
                                    while ($joueur2 = $joueurs->fetch()) {
                                        if (strtoupper($joueur2['Pseudo']) == strtoupper($_POST['pseudo-joueur2'])) {
                                            $samePseudo2 = True;
                                        }
                                        if (strtoupper($joueur2['Mail']) == strtoupper($_POST['email-joueur2'])) {
                                            $sameMail2 = True;
                                        }
                                    }
                                    //Vérification de si le pseudo et le mail du joueur3 sont déjà utilisés
                                    $samePseudo3 = False;
                                    $sameMail3 = False;
                                    while ($joueur3 = $joueurs->fetch()) {
                                        if (strtoupper($joueur3['Pseudo']) == strtoupper($_POST['pseudo-joueur3'])) {
                                            $samePseudo3 = True;
                                        }
                                        if (strtoupper($joueur3['Mail']) == strtoupper($_POST['email-joueur3'])) {
                                            $sameMail3 = True;
                                        }
                                    }
                                    //Vérification de si le pseudo et le mail du joueur4 sont déjà utilisés
                                    $samePseudo4 = False;
                                    $sameMail4 = False;
                                    while ($joueur4 = $joueurs->fetch()) {
                                        if (strtoupper($joueur4['Pseudo']) == strtoupper($_POST['pseudo-joueur4'])) {
                                            $samePseudo4 = True;
                                        }
                                        if (strtoupper($joueur4['Mail']) == strtoupper($_POST['email-joueur4'])) {
                                            $sameMail4 = True;
                                        }
                                    }
                                    //Message d'erreur si une des conditions est fausse
                                    if (!$sameMail1) {
                                        if (!$samePseudo1) {
                                            if (!$sameMail2) {
                                                if (!$samePseudo2) {
                                                    if (!$sameMail3) {
                                                        if (!$samePseudo3) {
                                                            if (!$sameMail4) {
                                                                if (!$samePseudo4) {
                                                                    try {
                                                                        // Récupération de l'ID dernier équipe créer
                                                                        $idEquipe = $sql->getLastIDEquipe();
                                                                        //Ajout du joueur1 
                                                                        $sql->joueurModel(htmlspecialchars($_POST['nom-joueur1']), htmlspecialchars($_POST['prenom-joueur1']), htmlspecialchars($_POST['dtn-joueur1']), htmlspecialchars($_POST['pseudo-joueur1']), htmlspecialchars($_POST['email-joueur1']), $idEquipe);
                                                                        //Ajout du joueur2 
                                                                        $sql->joueurModel(htmlspecialchars($_POST['nom-joueur2']), htmlspecialchars($_POST['prenom-joueur2']), htmlspecialchars($_POST['dtn-joueur2']), htmlspecialchars($_POST['pseudo-joueur2']), htmlspecialchars($_POST['email-joueur2']), $idEquipe);
                                                                        //Ajout du joueur3 
                                                                        $sql->joueurModel(htmlspecialchars($_POST['nom-joueur3']), htmlspecialchars($_POST['prenom-joueur3']), htmlspecialchars($_POST['dtn-joueur3']), htmlspecialchars($_POST['pseudo-joueur3']), htmlspecialchars($_POST['email-joueur3']), $idEquipe);
                                                                        //Ajout du joueur4 
                                                                        $sql->joueurModel(htmlspecialchars($_POST['nom-joueur4']), htmlspecialchars($_POST['prenom-joueur4']), htmlspecialchars($_POST['dtn-joueur4']), htmlspecialchars($_POST['pseudo-joueur4']), htmlspecialchars($_POST['email-joueur4']), $idEquipe);
                                                                        $infoExecution = 'Joueurs enregistrés !';
                                                                        header('Location: liste-equipes.php?createEquipe=success');
                                                                    } catch (Exception $e) {
                                                                        $infoExecution = "Erreur : " . $e->getMessage();
                                                                    }
                                                                } else {
                                                                    $infoExecution = "Un Joueur avec le même pseudo que le Joueur4 existe déjà";
                                                                }
                                                            } else {
                                                                $infoExecution = "Un Joueur avec la même adresse mail que le Joueur4 existe déjà ";
                                                            }
                                                        } else {
                                                            $infoExecution = "Un Joueur avec le même pseudo que le Joueur3 existe déjà";
                                                        }
                                                    } else {
                                                        $infoExecution = "Un Joueur avec la même adresse mail que le Joueur3 existe déjà ";
                                                    }
                                                } else {
                                                    $infoExecution = "Un Joueur avec le même pseudo que le Joueur2 existe déjà";
                                                }
                                            } else {
                                                $infoExecution = "Un Joueur avec la même adresse mail que le Joueur2 existe déjà ";
                                            }
                                        } else {
                                            $infoExecution = "Un Joueur avec le même pseudo que le Joueur1 existe déjà";
                                        }
                                    } else {
                                        $infoExecution = "Un Joueur avec la même adresse mail que le Joueur1 existe déjà ";
                                    }
                                } else {
                                    $infoExecution = "Le Joueur4 doit avoir plus de 12 ans pour s'inscrire à une équipe d'e-sport";
                                }
                            } else {
                                $infoExecution = "Le Joueur3 doit avoir plus de 12 ans pour s'inscrire à une équipe d'e-sport";
                            }
                        } else {
                            $infoExecution = "Le Joueur2 doit avoir plus de 12 ans pour s'inscrire à une équipe d'e-sport";
                        }
                    } else {
                        $infoExecution = "Le Joueur1 doit avoir plus de 12 ans pour s'inscrire à une équipe d'e-sport";
                    }
                } else {
                    $infoExecution = "Veuillez remplir tous les champs du Joueur4";
                }
            } else {
                $infoExecution = "Veuillez remplir tous les champs du Joueur3";
            }
        } else {
            $infoExecution = "Veuillez remplir tous les champs du Joueur2";
        }
    } else {
        $infoExecution = "Veuillez remplir tous les champs du Joueur1";
    }
}

ob_start();
require_once(realpath(dirname(__FILE__) . '/../../view/ecurie/enregistrer-joueurs-view.html'));
$buffer = ob_get_clean();
$buffer = str_replace("##infoExecution##", $infoExecution, $buffer);
echo $buffer;
