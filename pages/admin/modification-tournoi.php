<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
    <?php 
        require_once(realpath(dirname(__FILE__) . '/../../SQL.php'));
        $sql = new requeteSQL();
        $req = $sql->tournoiId($_GET['id']);
        while($row = $req->fetch()){
            $nom = $row['Nom'];
            $nb_pts_max = $row['Nombre_point_max'];
            $type = $row['Type'];
            $dateTournoisDeb = $row['Date_debut'];
            $dateTournoisFin = $row['Date_fin'];
            $lieu = $row['Lieu'];
        }


    ?>

<body>
    <main class="main-creation-tournoi">
        <section class="creation-tournoi-container">
            <form action="creation-tournoi.php" method="POST">

                <h1 class="creation-tournoi-title">Modifier un tournoi</h1>
                <div class="creation-tournoi">
                    <div class="creation-tournoi-left">
                        <div class="creation-tournoi-input">
                            <label for="nom-tournoi">Nom du tournoi</label>
                            <input type="text" name="nom-tournoi" id="nom-tournoi" value="<?php echo $nom ?>">
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="type-tournoi">Type du tournoi</label>
                            <input type="text" name="type-tournoi" id="type-tournoi" value="<?php echo $type ?>">
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="jeux-tournoi">Jeux présents</label>
                            <input type="text" name="jeux-tournoi" id="jeux-tournoi">
                        </div>
                    </div>

                    <div class="creation-tournoi-right">
                        <div class="creation-tournoi-input">
                            <label for="date-tournoi_deb">Nombre de points distribués</label>
                            <input type="date" name="date-tournoi_deb" id="date-tournoi_deb" value="<?php echo $dateTournoisDeb ?>">
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="date-tournoi-fin">Date du tournoi</label>
                            <input type="date" name="date-tournoi-fin" id="date-tournoi-fin" value="<?php echo $dateTournoisFin ?>">
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="lieu-tournoi">Lieu du tournoi</label>
                            <input type="text" name="lieu-tournoi" id="lieu-tournoi" value="<?php echo $lieu ?>">
                        </div>
                    </div>
                </div>
                <input class="update" type="submit" name="modifier" value="Modifier">
            </form>
        </section>
    </main>
</body>

</html>