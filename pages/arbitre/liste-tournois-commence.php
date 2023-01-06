<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Liste tournois - E-Sporter</title>
        <link rel="stylesheet" href="../../css/style.css">
        <link rel="stylesheet" href="../../css/style-inscription.css">
        <link rel="icon" href="../../img/esporter-icon.png">
    </head>
    <body>
        <?php
        session_start();
        require_once(realpath(dirname(__FILE__) . '/../../class/header.php'));
        $header = new header(2);
        if ($_SESSION['role'] == "arbitre") {
            echo $header->customize_header($_SESSION['role']);
        } else {
            header('Location: ../../acces-refuse.php');
        }

        //Sql
       require_once(realpath(dirname(__FILE__) . '/../../SQL.php'));
       $sql = new requeteSQL();
        $req = $sql->getTournoiCommence();

        ?>

        <main class="main-listes">
            <section class="main-listes-container">
                <h1>Liste des tournois commencés</h1>
                <form action="" method="post">
                    <div class="container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nom du tournoi</th>
                                    <th>Date du tournoi</th>
                                    <th>Jeu(x) présent</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    while ($donnees = $req -> fetch()){
                                    echo "
                                        <tr>
                                            <th>$donnees[0]</th>
                                            <th>$donnees[1]</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        ";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </section>
        </main>

    </body>
</html>