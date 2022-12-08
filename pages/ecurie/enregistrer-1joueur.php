<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<?php
session_start();
require_once(realpath(dirname(__FILE__) . '/../../class/header.php'));
$header = new header(2);

if ($_SESSION['role'] == "ecurie") {
    echo $header->customize_header($_SESSION['role']);
} else {
    header('Location: ../../acces-refuse.php');
}

$info_execution = "Joueur non enregistré";
require_once(realpath(dirname(__FILE__) . '/../../SQL.php'));
if (!empty($_POST['nom-joueur'])  && !empty($_POST['prenom-joueur']) && !empty($_POST['dtn_joueur']) && !empty($_POST['pseudo_joueur']) && !empty($_POST['email_joueur'])) {
    try {
        // $sql = new requeteSQL();
        // Ajout d'une écurie (le dernier 1 correspond à l'id gestionnaire)
        // $sql->addEquipe($_POST['nom-equipe'],$_POST['jeu-equipe'],$_POST['mdp-equipe'],$_POST['email-equipe'],1);
        $info_execution = 'Joueur enregistré !';
        header("Refresh: 2;URL=enregistrer-joueurs.php");
    } catch (Exception $e) {
        $info_execution = "Erreur : " . $e->getMessage();
    }
}
?>

<body>
    <main class="main-creation-tournoi">
        <section class="creation-tournoi-container">
            <form class="form-ajout-joueur" action="enregistrer-1joueur.php" method="POST">
                <h1 class="creation-tournoi-title">Enregistrer 4 joueurs</h1>
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
                                        <input type="date" name="dtn_joueur1" id="dtn_joueur1">
                                    </div>
                                    <div class="creation-tournoi-input">
                                        <label for="pseudo_joueur1">Pseudo</label>
                                        <input type="text" name="pseudo_joueur1" id="pseudo_joueur1">
                                    </div>
                                    <div class="creation-tournoi-input">
                                        <label for="email_joueur1">Email</label>
                                        <input type="text" name="email_joueur1" id="email_joueur1">
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
                                        <input type="date" name="dtn_joueur2" id="dtn_joueur2">
                                    </div>
                                    <div class="creation-tournoi-input">
                                        <label for="pseudo_joueur2">Pseudo</label>
                                        <input type="text" name="pseudo_joueur2" id="pseudo_joueur2">
                                    </div>
                                    <div class="creation-tournoi-input">
                                        <label for="email_joueur2">Email</label>
                                        <input type="text" name="email_joueur2" id="email_joueur2">
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
                                        <input type="date" name="dtn_joueur3" id="dtn_joueur3">
                                    </div>
                                    <div class="creation-tournoi-input">
                                        <label for="pseudo_joueur3">Pseudo</label>
                                        <input type="text" name="pseudo_joueur3" id="pseudo_joueur3">
                                    </div>
                                    <div class="creation-tournoi-input">
                                        <label for="email_joueur3">Email</label>
                                        <input type="text" name="email_joueur3" id="email_joueur3">
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
                                        <input type="date" name="dtn_joueur4" id="dtn_joueur4">
                                    </div>
                                    <div class="creation-tournoi-input">
                                        <label for="pseudo_joueur4">Pseudo</label>
                                        <input type="text" name="pseudo_joueur4" id="pseudo_joueur4">
                                    </div>
                                    <div class="creation-tournoi-input">
                                        <label for="email_joueur4">Email</label>
                                        <input type="text" name="email_joueur4" id="email_joueur4">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input class="submit" type="submit" name="ajouter" value="Ajouter">
                <span><?php echo $info_execution ?> </span>
            </form>
        </section>
    </main>
</body>


</html>