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
            // $pouleAffichage = $reqPoule -> fetch();

        ?>

        <main class="main-listes">

        <div class="popup popup-">
                <div class="popup-content">
                    <div class="popup-header">
                        <h2>Choix du gagnant</h2>
                    </div>
                    <div class="popup-body">
                        <hr>
                        <div class="popup-button">
                            <input type="button" class="button-equipe1" name="popupnon" value="Non" onclick='popUpNon()'>
                            <input type="button" class="button-equipe2" name="popupoui" value="Oui" onclick='popUpOui()'>
                        </div>
                    </div>
                </div>
            </div>
            <section class="main-listes-container">
                <h1> Poule du tournoi <?php echo $reqNomTournoi ?></h1>

                    <form action="" method="post">
                        <div class="container-poule">

                            <div class="poule-gauche">
                                <?php
                                    while ($poule = $reqPoule -> fetch()){
                                        $reqEquipePouleTrie = $sql -> getEquipePouleTrie($poule[0]);
                                        $clair = 0;
                                        echo '
                                            <button type ="submit" class="poule" name="submitPoule" value ='.$poule[0].'>
                                                <div class="pouleLibelle">
                                                    <span>'.$poule[1].'</span>
                                                </div>
                                            ';
                                        while ($equipe = $reqEquipePouleTrie -> fetch()){
                                            $equipe_nom = $equipe[0];
                                            $equipe_nb_match_gagne = $equipe[1];
                                            if ($clair % 2 == 0) {
                                                echo '
                                                    <div class="equipe violet-fonce">
                                                        <span>' . $equipe_nom . '</span>
                                                        <div>' . $equipe_nb_match_gagne . ' </div>
                                                    </div>
                                                ';
                                            } else {
                                                 echo '
                                                    <div class="equipe violet-clair">
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

                            <?php
                                $idPouleAffiche;
                                if (isset($_POST["submitPoule"])) {
                                    $idPouleAffiche = $_POST["submitPoule"];
                                    $nomPouleAffiche = $sql->getNomPoule($idPouleAffiche)->fetch()[0];
                                    $reqRecontre = $sql -> getRencontre($idPouleAffiche);
                                    echo '
                                        <div class="poule-droite">
                                            <h1>Poule ' . $nomPouleAffiche . '</h1>
                                            <div class="tout-match">';
                                            while ($rencontre = $reqRecontre -> fetch()){
                                                //Faire un if sur l'affichage soit du score soit du bouton rentrer le socre en fonction de si un resultat est rentré ou non
                                                $nomEquipe1 = $sql -> getNomEquipeById($rencontre[1]) -> fetch()[0];
                                                $nomEquipe2 = $sql->getNomEquipeById($rencontre[2])->fetch()[0];
                                                if ($rencontre[4] == null){
                                                    echo '
                                                        <div class="match">
                                                            <span class="equipe-match">'.$nomEquipe1.' - '.$nomEquipe2.'</span>
                                                            <input type="button" name="button-score" value="Entrer le score" onclick="showPopUpResultat()">
                                                        </div>
                                                    ';
                                                }
                                                
                                            }
                                    echo' </div>
                                        </div>
                                    ';
                                }
                            ?>

                </form>
            </section>
        </main>
        <script>
            function showPopUpResultat(){
                document.querySelector('.popUpResultat').style.display ='flex';
                
            }
        </script>                         
        
    </body>
</html>