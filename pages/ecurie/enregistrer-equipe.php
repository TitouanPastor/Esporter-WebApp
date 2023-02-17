<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrer équipe - E-Sporter</title>
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
$reqJeu = $sql->getJeux();

// Ajouter une équipe
if (isset($_POST['ajouter'])) {
    // Vérification de si tout les champs sont remplis
    if (!empty($_POST['nom-equipe']) && !empty($_POST['jeu_equipe']) && !empty($_POST['email-equipe']) && !empty($_POST['mdp-equipe'])) {
        //Vérification de si une équipe dans l'écurie n'a pas ce jeu
        $id = $sql->getIdEcurieByMail($_SESSION['username']);
        $equipes = $sql->getEquipeEcurie($id);
        $sameJeu = False;
        while ($equipe = $equipes->fetch()) {
            if ($equipe['Id_Jeu'] == $_POST['jeu_equipe']) {
                $sameJeu = True;
            }
        }
        if (!$sameJeu) {
            //Vérification de si une équipe du même nom n'existe pas déjà
            $equipes = $sql->getEquipe();
            $sameEquipe = False;
            $sameMail = False;
            while ($equipe = $equipes->fetch()) {
                if (strtoupper($equipe['Nom']) == strtoupper($_POST['nom-equipe'])) {
                    $sameEquipe = True;
                }
                if (strtoupper($equipe['Mail']) == strtoupper($_POST['email-equipe'])) {
                    $sameMail = True;
                }
            }
            if (!$sameEquipe) {
                if (!$sameMail) {
                    try {
                        //Ajout d'une équipe (le 0 correspond au nombre de point au championnat initialisé à 0)
                        $sql->addEquipe($_POST['nom-equipe'],$_POST['mdp-equipe'],$_POST['email-equipe'],0,$_POST['jeu_equipe'],$id);
                        $infoExecution = 'Equipe enregistrée !';
                        header("Refresh: 3;URL=enregistrer-joueurs.php");
                    } catch (Exception $e) {
                        $infoExecution = "Erreur : " . $e->getMessage();
                    }
                } else {
                    $infoExecution = "Une équipe avec la même adresse mail existe déjà";
                }
            } else {
                $infoExecution = "Une équipe avec le même nom existe déjà !";
            }
        } else {
            $infoExecution = "Une équipe dans l'écurie avec le même jeu existe déjà !";
        }
    } else {
        $infoExecution = "Veuillez remplir tous les champs";
    }
}

?>


<body>
    <main class="main-creation-tournoi">
        <section class="creation-tournoi-container">
            <form action="enregistrer-equipe.php" method="POST">

                <h1 class="creation-tournoi-title">Enregistrer une Équipe</h1>
                <div class="creation-tournoi">
                    <div class="creation-tournoi-left">
                        <div class="creation-tournoi-input">
                            <label for="nom-equipe">Nom de l'équipe</label>
                            <input type="text" name="nom-equipe" id="nom-equipe">
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="jeu-equipe">Jeu</label>
                            <select name="jeu_equipe" id="jeu-equipe">
                                <?php
                                //Affichage de la liste de tout les jeux enregistrés dans la base de données
                                while ($data = $reqJeu->fetch()) {
                                    echo '<option value="' . $data['Id_Jeu'] . '">' . $data['Libelle'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="email-equipe">Email</label>
                            <input type="text" name="email-equipe" id="email-equipe">
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="mdp-equipe">Mot de Passe</label>
                            <input type="password" name="mdp-equipe" id="mdp-equipe">
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