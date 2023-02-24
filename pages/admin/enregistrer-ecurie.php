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

# Démarrage de la session
session_start();

# Importation des fichiers 
require_once(realpath(dirname(__FILE__) . '/../../class/header.php'));
require_once(realpath(dirname(__FILE__) . '/../../SQL.php'));

# Initialisation des classes
$header = new header(2);
$sql = new requeteSQL();

# Affichage du header
if ($_SESSION['role'] == "gestionnaire") {
    echo $header->customizeHeader($_SESSION['role']);
} else {
    header('Location: ../../acces-refuse.php');
}

# Initialisation des variables
$infoExecution = "";



// Ajouter une écurie
if (isset($_POST['ajouter'])) {
    // Vérification de si tout les champs sont remplis
    if (!empty($_POST['nom-ecurie']) && !empty($_POST['combobox-statut']) && !empty($_POST['email-ecurie']) && !empty($_POST['mdp-ecurie'])) {
        //Vérification de si une écurie du même nom ou même adresse mail n'existe pas
        $ecuries = $sql->getEcurie();
        $sameEcurie = False;
        $sameMail = False;
        # Vérification de si une écurie du même nom ou même adresse mail n'existe pas
        while ($ecurie = $ecuries->fetch()) {
            if (strtoupper($ecurie['Nom']) == strtoupper($_POST['nom-ecurie'])) {
                $sameEcurie = True;
            }
            if (strtoupper($ecurie['Mail']) == strtoupper($_POST['email-ecurie'])) {
                $sameMail = True;
            }
        }
        if (!$sameEcurie) {
            if (!$sameMail) {
                try {
                    // Ajout d'une écurie (le dernier 1 correspond à l'id gestionnaire)
                    $sql->addEcurie($_POST['nom-ecurie'], $_POST['combobox-statut'], $_POST['mdp-ecurie'], $_POST['email-ecurie'], 1);
                    $infoExecution = 'Ecurie enregistrée !';
                    header('Location: liste-ecuries.php?createEcurie=success');
                } catch (Exception $e) {
                    $infoExecution = "Erreur lors de l'ajout de l'écurie ! Veuillez réessayer.";
                }
                $infoExecution = "L'écurie a bien été ajoutée";
            } else {
                $infoExecution = "Une écurie avec la même adresse mail existe déjà";
            }
        } else {
            $infoExecution = "Une écurie avec le même nom existe déjà";
        }
    } else {
        $infoExecution = "Veuillez remplir tous les champs";
    }
}

?>

<body>
    <main class="main-creation-tournoi">
        <section class="creation-tournoi-container">
            <form action="enregistrer-ecurie.php" method="POST">

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