<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrer écurie - E-Sporter</title>
    <link rel="icon" href="../../img/esporter-icon.png">
    <link rel="stylesheet" href="../../css/style.css">
</head>

<?php

// Importation des fichiers
session_start();

// On récupère les différents controllers
require_once(realpath(dirname(__FILE__) . '/../../controller/admin/enregistrer-ecurie-controller.php'));
require_once(realpath(dirname(__FILE__) . '/../../controller/visiteur/header-controller.php'));

?>

<!-- vue -->
<body>
    <main class="main-creation-tournoi">
        <section class="creation-tournoi-container">
            <form action="enregistrer-ecurie-view.php" method="POST">

                <h1 class="creation-tournoi-title">Enregistrer une Écurie</h1>
                <div class="creation-tournoi">
                    <div class="creation-tournoi-left">
                        <div class="creation-tournoi-input">
                            <label for="nom-ecurie">Nom de l'écurie</label>
                            <input type="text" name="nom-ecurie" id="nom-ecurie">
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="statut-ecurie">Statut</label>
                            <select name="combobox-statut" id="combobox-statut">
                                <option value="Professionnelle">Professionnelle</option>
                                <option value="Associative">Associative</option>
                            </select>
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="email-ecurie">Email</label>
                            <input type="text" name="email-ecurie" id="email-ecurie">
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="mdp-ecurie">Mot de Passe</label>
                            <input type="password" name="mdp-ecurie" id="mdp-ecurie">
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