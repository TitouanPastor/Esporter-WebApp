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
                <form action="liste-tournois.php" method="get">
                    <ul>
                        <button type="submit" name="filter1"><li><a href="" class="btn-filter">Type</a></li></button>
                        <button type="submit" name="filter2"><li><a href="" class="btn-filter">Lieu</a></li></button>
                        <button type="submit" name="filter3"><li><a href="" class="btn-filter">Nom</a></li></button>
                        <button type="submit" name="filter4"><li><a href="" class="btn-filter">Jeu</a></li></button>
                        <button type="submit" name="annuler"><li><a href="" class="btn-filter">Supprimer les filtres</a></li></button>
                    </ul>
                </form>
            </div>
            <div class="liste">
                <?php
                    require_once('tri-tournois.php');
                    $triTournois = new TriTournois();
                    if (!isset($_GET['filter1']) && !isset($_GET['filter2']) && !isset($_GET['filter3']) && !isset($_GET['filter4']) && !isset($_GET['annuler'])) {
                        echo $triTournois->afficherLesTournois();
                    }

                    if (isset($_GET['filter1'])) {                       
                        echo $triTournois->trierParType();
                    }
                    elseif (isset($_GET['filter2'])) {
                        echo $triTournois->trierParLieu();
                    }
                    elseif (isset($_GET['filter3'])) {
                        echo $triTournois->trierParNom();
                    }
                    elseif (isset($_GET['filter4'])) {
                        //echo $triTournois->trierParJeu();
                    }
                    elseif (isset($_GET['annuler'])) {
                        echo $triTournois->trierParId();
                    }
                    


                ?>
            </div>
        </section>
    </main>
</body>

<script src="../../main.js"></script>
</html>