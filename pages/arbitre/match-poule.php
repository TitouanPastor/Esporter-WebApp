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

            require_once(realpath(dirname(__FILE__) . '/../admin/bracket.php'));
            $bracket = new bracket();

            //Id
            $id_tournoi = $_GET["id_tournoi"];
            $id_jeu = $_GET["id_jeu"];

            //Nom tournoi par id_tournoi
            $reqNomTournoi = "";
            $reqNomTournoi = $sql -> getTournoiNomByIdTournoi($id_tournoi) -> fetch()[0];

            //Poule par id_tournoi
            $reqPoule = $sql->getPouleByIdTournoi($id_tournoi);

            //Valider les resultats
            if (isset($_POST["valider"])){
                if (isset($_POST["match1"])){
                    $req = $sql->setGagnantRencontre($_POST["idMatch1"], $_POST["match1"]);
                }

                if (isset($_POST["match2"])){
                    $req = $sql->setGagnantRencontre($_POST["idMatch2"], $_POST["match2"]);
                }

                if (isset($_POST["match3"])){
                    $req = $sql->setGagnantRencontre($_POST["idMatch3"], $_POST["match3"]);
                }

                if (isset($_POST["match4"])){
                    $req = $sql->setGagnantRencontre($_POST["idMatch4"], $_POST["match4"]);
                }

                if (isset($_POST["match5"])){
                    $req = $sql->setGagnantRencontre($_POST["idMatch5"], $_POST["match5"]);
                }

                if (isset($_POST["match6"])){
                    $req = $sql->setGagnantRencontre($_POST["idMatch6"], $_POST["match6"]);
                }

                $checkPouleTermine = 0;
                while ($donnees = $reqPoule -> fetch()){
                    echo $donnees[0];
                    if ($bracket -> pouleTerminer($donnees[0]) == false){
                        $checkPouleTermine = -1;
                        break;
                    }
                }

                if ($checkPouleTermine == 0){
                    $bracket->genererPouleFinale();
                }
            }

            $reqPoule = $sql->getPouleByIdTournoi($id_tournoi);

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
                                            $num_match = 1;
                                
                                            while ($rencontre = $reqRecontre -> fetch()){
                                                $nomEquipe1 = $sql -> getNomEquipeById($rencontre[1]) -> fetch()[0];
                                                $nomEquipe2 = $sql->getNomEquipeById($rencontre[2])->fetch()[0];
                                                
                                                if ($rencontre[4] == null){
                                                    echo '
                                                    <div class="match">
                                                        <h2 class="equipe-match">Match '.$num_match.'</h2>
                                                        <div class="radioEquipe">
                                                            <input type="hidden" name="idMatch'.$num_match.'" value="'.$rencontre[0].'">
                                                            <div class="radioEquipe1">
                                                                <input type="radio" class="radio" id="choixEquipe'.$num_match.'" name="match'.$num_match.'" value="'.$rencontre[1].'" >
                                                                <label for="choixEquipe"'.$num_match.'">'.$nomEquipe1.'</label>
                                                            </div>
                                                            <div class="radioEquipe2">
                                                                <input type="radio" class="radio" id="choixEquipe'.$num_match.'" name="match'.$num_match.'" value="'.$rencontre[2].'" >
                                                                <label for="choixEquipe"'.$num_match.'">'.$nomEquipe2.'</label>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    ';
                                                } else {
                                                    $gagnant = $sql->getGagnantRencontre($rencontre[0]) -> fetch()[0];
                                                    if ($nomEquipe1 = $gagnant){
                                                        $perdant = $nomEquipe2;
                                                    } else {
                                                        $perdant = $nomEquipe1;
                                                    }
                                                    echo '
                                                        <div class="match">
                                                            <h2 class="equipe-match">Match '.$num_match.'</h2>
                                                            <div class="container-equipe">
                                                                <div class="gagnantRencontre">

                                                                    <h3>'.$gagnant.'</h3>
                                                                    <svg width="20px" height="20px" viewBox="0 -6 34 34" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><title>crown</title>
                                                                        <desc>Created with Sketch.</desc>
                                                                        <defs>
                                                                            <linearGradient x1="50%" y1="0%" x2="50%" y2="100%" id="linearGradient-1">
                                                                                <stop stop-color="#FFC923" offset="0%"></stop>
                                                                                <stop stop-color="#FFAD41" offset="100%"></stop>
                                                                            </linearGradient>
                                                                        </defs>
                                                                        <g id="icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <g id="ui-gambling-website-lined-icnos-casinoshunter" transform="translate(-1513.000000, -2041.000000)" fill="url(#linearGradient-1)" fill-rule="nonzero">
                                                                                <g id="4" transform="translate(50.000000, 1871.000000)">
                                                                                    <path d="M1480.91651,170.219311 C1481.3389,170.433615 1481.67193,170.790192 1481.85257,171.227002 L1485.64818,180.405177 L1493.44429,170.905749 C1494.13844,170.059929 1495.39769,169.928221 1496.25688,170.61157 C1496.72686,170.98536 1497,171.548271 1497,172.143061 L1497,189.04671 C1497,190.677767 1495.65685,192 1494,192 L1466,192 C1464.34315,192 1463,190.677767 1463,189.04671 L1463,172.142612 C1463,171.055241 1463.89543,170.173752 1465,170.173752 C1465.60413,170.173752 1466.17588,170.442575 1466.55559,170.905145 L1474.35377,180.405143 L1478.1477,171.227264 C1478.54422,170.268054 1479.62151,169.783179 1480.60701,170.093228 L1480.75404,170.145737 L1480.91651,170.219311 Z" id="crown"></path>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </svg>

                                                                </div>
                                                                <div class="perdantRencontre">
                                                                    <span>'.$perdant.'</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                ';
                                                }
                                                $num_match += 1;
                                            }
                                            echo '<button type="submit" class="submit submit-valider" name="valider">Valider</button>';
                                    echo' </div>
                                        </div>
                                    ';
                                }
                            ?>
            </form>
                
            </section>
        </main>
    </body>
</html>