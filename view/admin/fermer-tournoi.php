<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <title>Fermer les inscriptions - E-Sporter</title>
</head>

<body>
    <?php

    ?>

    <main class="fermer-tournoi">
        <form action="fermer-tournoi.php">
            <h1>Fermer les inscriptions</h1>
            <h2><?php echo $sql->tournoiId($idTournoi)->fetch()['Nom'];?></h2>
            <section class="fermer-tournoi-container">
                <div class="fermer-tournoi-left-container">
                    <?php

                    echo $bracket->display_games($idTournoi);

                    ?>
                </div>

                <div class="fermer-tournoi-right-container">
                </div>
            </section>
            <input type="button" name="valider" value="Valider">
        </form>
    </main>
</body>

</html>