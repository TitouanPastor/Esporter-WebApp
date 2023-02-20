<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - E-Sporter</title>
    <link rel="icon" href="img/esporter-icon.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
</head>
<?php

# Initualisation de la session
session_start();
# Inclusion des fichiers nécessaires 
require_once(realpath(dirname(__FILE__) . '/class/header.php'));

# Création de l'header
$header = new header(0);

# Affichage de l'header suivant le rôle de connexion 
if (isset($_SESSION['role'])) {
    echo $header->customizeHeader($_SESSION['role']);
} else {
    # Affichage de l'header par défaut (visiteur) 
    echo $header->customizeHeader();
}
?>

<body>
    <main>
        <div class="home-title">
            <h1>Vivez votre passion</h1>
            <span>E-Sporter centralise tous les résultats de vos équipes préférées dans une seule et même application. Ne perdez plus de temps à chercher, informez vous rapidement sur les différents classements, les matchs et les tournois à venir !</span>
            <div class="home-btns">
                <a href="pages/visiteur/liste-tournois-commence.php" class="main-btn">Résultats</a>
                <a href="pages/visiteur/classementCM.php" class="main-btn">Classement</a>
                <a href="pages/visiteur/calendrier.php" class="main-btn">Calendrier</a>
            </div>
        </div>

    </main>
</body>

</html>