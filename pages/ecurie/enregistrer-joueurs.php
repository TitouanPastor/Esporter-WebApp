<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrer joueurs - E-Sporter</title>
    <link rel="icon" href="../../img/esporter-icon.png">
    <link rel="stylesheet" href="../../css/style.css">
</head>



<?php
## Importation des fichiers ##
session_start();
require_once(realpath(dirname(__FILE__) . '/../../class/header.php'));
require_once(realpath(dirname(__FILE__) . '/../../SQL.php'));

$header = new header(2);

if ($_SESSION['role'] == "ecurie") {
    echo $header->customizeHeader($_SESSION['role']);
} else {
    header('Location: ../../acces-refuse.php');
}

// Initialisation des variables
$infoExecution = "";

$sql = new requeteSQL();


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
                                    $joueurs = $sql->getJoueur();
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
                                                                        $sql->addJoueur(htmlspecialchars($_POST['nom-joueur1']), htmlspecialchars($_POST['prenom-joueur1']), htmlspecialchars($_POST['dtn-joueur1']), htmlspecialchars($_POST['pseudo-joueur1']), htmlspecialchars($_POST['email-joueur1']), $idEquipe);
                                                                        //Ajout du joueur2 
                                                                        $sql->addJoueur(htmlspecialchars($_POST['nom-joueur2']), htmlspecialchars($_POST['prenom-joueur2']), htmlspecialchars($_POST['dtn-joueur2']), htmlspecialchars($_POST['pseudo-joueur2']), htmlspecialchars($_POST['email-joueur2']), $idEquipe);
                                                                        //Ajout du joueur3 
                                                                        $sql->addJoueur(htmlspecialchars($_POST['nom-joueur3']), htmlspecialchars($_POST['prenom-joueur3']), htmlspecialchars($_POST['dtn-joueur3']), htmlspecialchars($_POST['pseudo-joueur3']), htmlspecialchars($_POST['email-joueur3']), $idEquipe);
                                                                        //Ajout du joueur4 
                                                                        $sql->addJoueur(htmlspecialchars($_POST['nom-joueur4']), htmlspecialchars($_POST['prenom-joueur4']), htmlspecialchars($_POST['dtn-joueur4']), htmlspecialchars($_POST['pseudo-joueur4']), htmlspecialchars($_POST['email-joueur4']), $idEquipe);
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

?>

<body>
    <main class="main-creation-tournoi">
        <section class="creation-tournoi-container">
            <form class="form-ajout-joueur" action="enregistrer-joueurs.php" method="POST">
                <h1 class="creation-tournoi-title">Enregistrer 4 Joueurs</h1>
                <div class="container-ajout-joueurs">
                    <div class="container-ajout-joueurs-duo">
                        <div class="form-un-joueur">
                            <span class="titre-un-joueur">Joueur 1</span>
                            <div class="creation-tournoi">
                                <div class="creation-tournoi-left">
                                    <div class="creation-tournoi-input">
                                        <label for="nom-joueur1">Nom du joueur</label>
                                        <input type="text" name="nom-joueur1" id="nom-joueur1">
                                    </div>
                                    <div class="creation-tournoi-input">
                                        <label for="prenom-joueur1">Prenom du joueur</label>
                                        <input type="text" name="prenom-joueur1" id="prenom-joueur1">
                                    </div>
                                    <div class="creation-tournoi-input">
                                        <label for="dtn_joueur1">Date de naissance</label>
                                        <input type="date" name="dtn-joueur1" id="dtn-joueur1">
                                    </div>
                                    <div class="creation-tournoi-input">
                                        <label for="pseudo_joueur1">Pseudo</label>
                                        <input type="text" name="pseudo-joueur1" id="pseudo-joueur1">
                                    </div>
                                    <div class="creation-tournoi-input">
                                        <label for="email_joueur1">Email</label>
                                        <input type="text" name="email-joueur1" id="email-joueur1">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-un-joueur">
                            <span class="titre-un-joueur">Joueur 2</span>
                            <div class="creation-tournoi">
                                <div class="creation-tournoi-left">
                                    <div class="creation-tournoi-input">
                                        <label for="nom-joueur2">Nom du joueur</label>
                                        <input type="text" name="nom-joueur2" id="nom-joueur2">
                                    </div>
                                    <div class="creation-tournoi-input">
                                        <label for="prenom-joueur2">Prenom du joueur</label>
                                        <input type="text" name="prenom-joueur2" id="prenom-joueur2">
                                    </div>
                                    <div class="creation-tournoi-input">
                                        <label for="dtn_joueur2">Date de naissance</label>
                                        <input type="date" name="dtn-joueur2" id="dtn-joueur2">
                                    </div>
                                    <div class="creation-tournoi-input">
                                        <label for="pseudo_joueur2">Pseudo</label>
                                        <input type="text" name="pseudo-joueur2" id="pseudo-joueur2">
                                    </div>
                                    <div class="creation-tournoi-input">
                                        <label for="email_joueur2">Email</label>
                                        <input type="text" name="email-joueur2" id="email-joueur2">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container-ajout-joueurs-duo">
                        <div class="form-un-joueur">
                            <span class="titre-un-joueur">Joueur 3</span>
                            <div class="creation-tournoi">
                                <div class="creation-tournoi-left">
                                    <div class="creation-tournoi-input">
                                        <label for="nom-joueur3">Nom du joueur</label>
                                        <input type="text" name="nom-joueur3" id="nom-joueur3">
                                    </div>
                                    <div class="creation-tournoi-input">
                                        <label for="prenom-joueur3">Prenom du joueur</label>
                                        <input type="text" name="prenom-joueur3" id="prenom-joueur3">
                                    </div>
                                    <div class="creation-tournoi-input">
                                        <label for="dtn_joueur3">Date de naissance</label>
                                        <input type="date" name="dtn-joueur3" id="dtn-joueur3">
                                    </div>
                                    <div class="creation-tournoi-input">
                                        <label for="pseudo_joueur3">Pseudo</label>
                                        <input type="text" name="pseudo-joueur3" id="pseudo-joueur3">
                                    </div>
                                    <div class="creation-tournoi-input">
                                        <label for="email_joueur3">Email</label>
                                        <input type="text" name="email-joueur3" id="email-joueur3">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-un-joueur">
                            <span class="titre-un-joueur">Joueur 4</span>
                            <div class="creation-tournoi">
                                <div class="creation-tournoi-left">
                                    <div class="creation-tournoi-input">
                                        <label for="nom-joueur4">Nom du joueur</label>
                                        <input type="text" name="nom-joueur4" id="nom-joueur4">
                                    </div>
                                    <div class="creation-tournoi-input">
                                        <label for="prenom-joueur4">Prenom du joueur</label>
                                        <input type="text" name="prenom-joueur4" id="prenom-joueur4">
                                    </div>
                                    <div class="creation-tournoi-input">
                                        <label for="dtn_joueur4">Date de naissance</label>
                                        <input type="date" name="dtn-joueur4" id="dtn-joueur4">
                                    </div>
                                    <div class="creation-tournoi-input">
                                        <label for="pseudo_joueur4">Pseudo</label>
                                        <input type="text" name="pseudo-joueur4" id="pseudo-joueur4">
                                    </div>
                                    <div class="creation-tournoi-input">
                                        <label for="email_joueur4">Email</label>
                                        <input type="text" name="email-joueur4" id="email-joueur4">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input class="submit" type="submit" name="ajouter" value="Ajouter">
                <span><?php echo $infoExecution ?> </span>
            </form>
        </section>
    </main>
</body>


</html>