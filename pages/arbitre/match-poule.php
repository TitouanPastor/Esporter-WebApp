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
            $pouleAffichage = $reqPoule -> fetch();
        ?>

        <main class="main-listes">
            <section class="main-listes-container">
                <h1> Poule du tournoi <?php echo $reqNomTournoi ?></h1>

                    <form action="" method="post">
                        <div class="container-poule">

                            

                            <div class="poule-gauche">
                                <?php
                                    while ($poule = $reqPoule -> fetch()){
                                        $reqEquipePouleTrie = $sql -> getEquipePouleTrie($poule[0]);
                                        echo '
                                            <button type ="submit" class="poule">
                                        ';
                                        $clair = 0;
                                        while ($equipe = $reqEquipePouleTrie -> fetch()){
                                            $equipe_nom = $equipe[0];
                                            $equipe_nb_match_gagne = $equipe[1];
                                            if ($clair % 2 == 0) {
                                                echo '
                                                    <div class="equipe">
                                                        <span>' . $equipe_nom . '</span>
                                                        <div>' . $equipe_nb_match_gagne . ' </div>
                                                    </div>
                                                ';
                                            } else {
                                                 echo '
                                                    <div class="equipe clair">
                                                        <span>' . $equipe_nom . '</span>
                                                        <div>' . $equipe_nb_match_gagne . ' </div>
                                                    </div>
                                                ';
                                            }
                                        $clair += 1;
                                        }
                                        echo '
                                            </button>
                                        ';
                                    }
                                ?>
                            </div>
                        
                            <div class="poule-droite">
                                <h1>Poule A</h1>
                                <div class="tout-match">
                                    <div class="match">
                                        <span class="equipe-match">Vitality - Solary</span>
                                        <input type="button" name="button-score" value="Entrer le score">
                                    </div>

                                    <div class="match">
                                        <span class="equipe-match"> France - Espagne</span>
                                        <input type="button" name="button-score" value="Entrer le score">
                                    </div>

                                    <div class="match">
                                        <span class="equipe-match">Vitality - France</span>
                                        <input type="button" name="button-score" value="Entrer le score">
                                    </div>

                                    <div class="match">
                                        <span class="equipe-match">Solary - Espagne</span>
                                        <input type="button" name="button-score" value="Entrer le score">
                                    </div>

                                    <div class="match">
                                        <span class="equipe-match">Vitality - Espagne</span>
                                        <input type="button" name="button-score" value="Entrer le score">
                                    </div>

                                    <div class="match">
                                        <span class="equipe-match">Solary - France</span>
                                        <input type="button" name="button-score" value="Entrer le score">
                                    </div>
                                </div>
                                <span class="gagnant"><h2>Vitality</h2></span>
                            </div>
                        </div>
                </form>
            </section>
        </main>

        
    </body>
</html>