<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <title>Document</title>
</head>

<body>
<?php
require_once(realpath(dirname(__FILE__) . '/../../class/header.php'));
$header = new header(2);
echo $header->header_admin();
?>
    <main class="main-listes">
        <section class="main-listes-container">
            <h1>Liste des écuries</h1>
            <span>Filtrer par: </span>
            <div class="main-listes-tabs">
                <div class="main-listes-filters">
                    <ul>
                        <li><button type="submit" name="filter1" class="btn-filter" onclick="changerTabListe(this, 'filter1')">Type</button></li>
                        <li><button type="submit" name="filter2" class="btn-filter" onclick="changerTabListe(this, 'filter2')">Lieu</button></li>
                        <li><button type="submit" name="filter3" class="btn-filter" onclick="changerTabListe(this, 'filter3')">Nom</button></li>
                        <li><button type="submit" name="filter4" class="btn-filter" onclick="changerTabListe(this, 'filter4')">Jeu</button></li>
                        <li><button type="submit" name="annuler" class="btn-filter btn-filter-active" onclick="changerTabListe(this, 'filterdefault')">par défaut</button></li>
                    </ul>
                </div>

                <?php
                require_once(realpath(dirname(__FILE__) . '/tri-tournois.php'));
                $triTournois = new TriTournois();
                ?>

                <div id="filter1" class="liste">
                    <?php
                    ?>
                </div>

                <div id="filter2" class="liste">
                    <?php
                    ?>
                </div>

                <div id="filter3" class="liste">
                    <?php
                    ?>
                </div>

                <div id="filter4" class="liste">
                    <?php
                    ?>
                </div>

                <div style="display: flex;" id="filterdefault" class="liste">
                    <?php
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