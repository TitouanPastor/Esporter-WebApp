<!DOCTYPE html>
<html lang="en">

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
session_start();
require_once(realpath(dirname(__FILE__) . '/class/header.php'));
$header = new header(0);
echo $header->customize_header($_SESSION['role']);
?>

<body>
    <main>
        <div class="home-title">
            <h1>Vivez votre passion</h1>
            <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Animi, blanditiis qui? Necessitatibus nihil numquam nemo dolor, perferendis exercitationem optio quis? Eveniet culpa magnam ipsam pariatur laudantium aperiam ipsum dolore laboriosam?</span>
            <div class="home-btns">
                <a href="pages/visiteur/resultats.php" class="main-btn">Résultats</a>
                <a href="pages/visiteur/login.php" class="main-btn">Rejoindre</a>
            </div>
        </div>

    </main>
</body>

</html>