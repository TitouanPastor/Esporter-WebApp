<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournois - E-Sporter</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="icon" href="../../img/esporter-icon.png">
</head>

<body>
<?php
session_start();
require_once(realpath(dirname(__FILE__) . '/../../class/header.php'));
$header = new header(2);    

if ($_SESSION['role'] == "ecurie") {
    echo $header->customize_header($_SESSION['role']);
} else {
    header('Location: ../../acces-refuse.php');
}
?>
    <main class="main-listes">
        <section class="main-listes-container">
            <h1>Liste des écuries</h1>
            <span>Filtrer par: </span>
            <div class="main-listes-tabs">
                <div class="main-listes-filters">
                    <ul>
                        <li><button type="submit" name="filter1" class="btn-filter" onclick="changerTabListe(this, 'filter1')">Nom</button></li>
                        <li><button type="submit" name="filter2" class="btn-filter" onclick="changerTabListe(this, 'filter2')">Point</button></li>

                        <li><button type="submit" name="annuler" class="btn-filter btn-filter-active" onclick="changerTabListe(this, 'filterdefault')">par défaut</button></li>
                    </ul>
                </div>

                <?php
                require_once(realpath(dirname(__FILE__) . '/tri-equipe.php'));
                require_once('../../SQL.php');
                $sql = new requeteSQL();
                $id_ecurie = $sql->getIdEcurieByMail($_SESSION['username']);
                $triEquipe = new TriEquipe($id_ecurie);
                ?>

                <div id="filter1" class="liste">
                    <?php
                    echo $triEquipe->trierParNom();
                    ?>
                </div>

                <div id="filter2" class="liste">
                    <?php
                    echo $triEquipe->trierParPoint();
                    ?>
                </div>

                <div style="display: flex;" id="filterdefault" class="liste">
                    <?php
                    echo $triEquipe->trierParId();
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