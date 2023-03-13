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
// Importation des controllers
session_start();
require_once(realpath(dirname(__FILE__) . '/controller/visiteur/header-controller.php'));

?>

<body>
    <main>
        <div class="home-title">
            <h1>Vivez votre passion</h1>
            <span>E-Sporter centralise tous les résultats de vos équipes préférées dans une seule et même application. Ne perdez plus de temps à chercher, informez vous rapidement sur les différents classements, les matchs et les tournois à venir !</span>
            <div class="home-btns">
                <a href="controller/visiteur/liste-tournois-commence-controller.php" class="main-btn">Résultats</a>
                <a href="controller/visiteur/classementCM-controller.php" class="main-btn">Classement</a>
                <a href="controller/visiteur/calendrier-controller.php" class="main-btn">Calendrier</a>
            </div>
        </div>

    </main>
</body>

</html>