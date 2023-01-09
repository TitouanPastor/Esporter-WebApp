<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultats - E-Sporter</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="icon" href="../../img/esporter-icon.png">
</head>

<body>
<?php
session_start();
require_once(realpath(dirname(__FILE__) . '/../../class/header.php'));
$header = new header(2);    

if ($_SESSION['role'] == "gestionnaire") {
    echo $header->customize_header($_SESSION['role']);
} else {
    header('Location: ../../acces-refuse.php');
}
?>


    <main class="main-listes">
        <section class="main-listes-container">
            <div class="main-listes-tabs">
                <div class="main-listes-filters">
                    <ul>
                        <li><button type="submit" name="filter1" class="btn-filter btn-filter-active" onclick="changerTabListe(this, 'filter1')">Résultat du championnat</button></li>
                        <li><button type="submit" name="filter2" class="btn-filter" onclick="changerTabListe(this, 'filter2')">Résultat par tournois</button></li>
                    </ul>
                </div>

                <?php
                require_once(realpath(dirname(__FILE__) . '/tri-resultats.php'));
                $triTournois = new TriResultats();
                ?>

                <div id="filter1" class="liste">
                    <?php
                    echo $triTournois->trierParType();
                    ?>
                </div>

                <div id="filter2" class="liste">
                    <?php
                    echo $triTournois->trierParLieu();
                    ?>
                </div>

                <div id="filter3" class="liste">
                    <?php
                    echo $triTournois->trierParNom();
                    ?>
                </div>

                <div id="filter4" class="liste">
                    <?php
                    echo $triTournois->trierParDate();
                    ?>
                </div>

                <div style="display: flex;" id="filterdefault" class="liste">
                    <?php
                    echo $triTournois->trierParId();
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