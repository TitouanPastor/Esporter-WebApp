<!DOCTYPE html>
<html>
    <header>
    <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Liste tournois - E-Sporter</title>
        <link rel="stylesheet" href="../../css/style.css">
        <link rel="stylesheet" href="../../css/match-poule.css">
        <link rel="icon" href="../../img/esporter-icon.png">
    </header>
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

            //Id
            $id_tournoi = $_GET["id_tournoi"];
            $id_jeu = $_GET["id_jeu"];

            //Nom tournoi par id_tournoi
            $reqNomTournoi = "";
            $reqNomTournoi = $sql -> getTournoiNomByIdTournoi($id_tournoi) -> fetch()[0];

            //Poule par id_tournoi
            $reqPoule = $sql->getPouleByIdTournoi($id_tournoi);

            //Equipe par id_poule

        ?>

        <main class="main-listes">
            
            <h1> Poule du tournoi <?php echo $reqNomTournoi ?></h1>
            
            <div class="container-poule">
                <div class="poule-gauche">
                    <?php 
                        while ($reqPoule -> fetch()){
                        echo '
                            <div class="poule">

                            </div>
                        ';
                        }
                    ?>
                </div>
            
                <div class="poule-droite">
                    <div class="poule-match">

                    </div>
                </div>
            </div>  
        </main>

        
    </body>
</html>