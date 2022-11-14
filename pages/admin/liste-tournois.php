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
            <div class="main-listes-filters">
                <ul>
                    <li><a href="" class="btn-filter">filtre 1</a></li>
                    <li><a href="" class="btn-filter">filtre 2</a></li>
                    <li><a href="" class="btn-filter">filtre 3</a></li>
                    <li><a href="" class="btn-filter">filtre 4</a></li>
                </ul>
            </div>
            <div class="liste">
                <?php
                    require_once('tri-tournois.php');
                    $triTournois = new TriTournois();
                    echo $triTournois->afficherLesTournois();

                    


                ?>
            </div>
        </section>
    </main>
</body>

<script src="../../main.js"></script>
</html>