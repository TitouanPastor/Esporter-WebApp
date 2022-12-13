<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes tournois - E-Sporter</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="icon" href="../../img/esporter-icon.png">
</head>

<body>
<?php
session_start();
require_once(realpath(dirname(__FILE__) . '/../../class/header.php'));
$header = new header(2);    

if ($_SESSION['role'] == "equipe") {
    echo $header->customize_header($_SESSION['role']);
} else {
    header('Location: ../../acces-refuse.php');
}
?>
    <main class="main-listes">
        <section class="main-listes-container">
            <h1>Mes tournois</h1>
            <span>Filtrer par: </span>
            <div class="main-listes-tabs">
                <div class="main-listes-filters">
                    <ul>
                        <li><button type="submit" name="filter3" class="btn-filter" onclick="changerTabListe(this, 'filter3')">Nom</button></li>
                        <li><button type="submit" name="filter1" class="btn-filter" onclick="changerTabListe(this, 'filter1')">Type</button></li>
                        <li><button type="submit" name="filter4" class="btn-filter" onclick="changerTabListe(this, 'filter4')">Date</button></li>
                        <li><button type="submit" name="filter2" class="btn-filter" onclick="changerTabListe(this, 'filter2')">Lieu</button></li>
                    
                        <li><button type="submit" name="annuler" class="btn-filter btn-filter-active" onclick="changerTabListe(this, 'filterdefault')">par défaut</button></li>
                    </ul>
                </div>

                <?php
                require_once(realpath(dirname(__FILE__) . '/tri-tournois-equipe.php'));
                $triTournoisEquipe = new TriTournoisEquipe($_SESSION['username']);
                ?>

                <div id="filter1" class="liste">
                    <?php
                    echo $triTournoisEquipe->trierParTypeTournoisEquipe();
                    ?>
                </div>

                <div id="filter2" class="liste">
                    <?php
                    echo $triTournoisEquipe->trierParLieuTournoisEquipe();
                    ?>
                </div>

                <div id="filter3" class="liste">
                    <?php
                    echo $triTournoisEquipe->trierParNomTournoisEquipe();
                    ?>
                </div>

                <div id="filter4" class="liste">
                    <?php
                    echo $triTournoisEquipe->trierParDateTournoisEquipe();
                    ?>
                </div>

                <div style="display: flex;" id="filterdefault" class="liste">
                    <?php
                    echo $triTournoisEquipe->trierParIdTournoisEquipe();
                    ?>
                </div>
            </div>
        </section>
    </main>

    <script type="text/javascript" src="../../main.js"></script>
    <script>
    </script>
</body>

</html>