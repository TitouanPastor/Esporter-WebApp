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
    <main class="main-listes">
        <section class="main-listes-container">
            <h1>Liste des tournois</h1>
            <span>Filtrer par: </span>
            <div class="main-listes-filters">
                <ul>
                    <li><button type="submit" name="filter1" class="btn-filter" onclick="changerTabListeTournoi(this, 'filter1')">Type</button></li>
                    <li><button type="submit" name="filter2" class="btn-filter" onclick="changerTabListeTournoi(this, 'filter2')">Lieu</button></li>
                    <li><button type="submit" name="filter3" class="btn-filter" onclick="changerTabListeTournoi(this, 'filter3')">Nom</button></li>
                    <li><button type="submit" name="filter4" class="btn-filter" onclick="changerTabListeTournoi(this, 'filter4')">Jeu</button></li>
                    <li><button type="submit" name="annuler" class="btn-filter" onclick="changerTabListeTournoi(this)">Réinitialiser</button></li>
                </ul>
            </div>
            <div id="filter1" class="liste">
                <h2>test1</h2>
                <?php
                // require_once(realpath(dirname(__FILE__) . '/tri-tournois.php'));
                // $triTournois = new TriTournois();
                // if (!isset($_GET['filter1']) && !isset($_GET['filter2']) && !isset($_GET['filter3']) && !isset($_GET['filter4']) && !isset($_GET['annuler'])) {
                //     echo $triTournois->afficherLesTournois();
                // }

                // if (isset($_GET['filter1'])) {                       
                //     echo $triTournois->trierParType();
                // }
                // elseif (isset($_GET['filter2'])) {
                //     echo $triTournois->trierParLieu();
                // }
                // elseif (isset($_GET['filter3'])) {
                //     echo $triTournois->trierParNom();
                // }
                // elseif (isset($_GET['filter4'])) {
                //     //echo $triTournois->trierParJeu();
                // }
                // elseif (isset($_GET['annuler'])) {
                //     echo $triTournois->trierParId();
                // }
                ?>

            </div>
            <div id="filter2" class="liste">
                <h2>test2</h2>
            </div>
            <div id="filter3" class="liste">
                <h2>test3</h2>
            </div>
            <div id="filter4" class="liste">
                <h2>test4</h2>
            </div>
        </section>
    </main>

    <script type="text/javascript" src="../../main.js"></script>
    <script>
        function changerTabListeTournoi(obj, tabId) {

            // on enleve la classe active de tous les elements de la liste
            var listetournoi = document.querySelectorAll('.liste');
            console.log(listetournoi);
            for (var i = 0; i < listetournoi.length; i++) {
                listetournoi[i].classList.remove('liste-tab-active');
            }

            var liste = document.getElementById(tabId) ;
            liste.classList.add('liste-tab-active');
        }
    </script>
</body>

</html>