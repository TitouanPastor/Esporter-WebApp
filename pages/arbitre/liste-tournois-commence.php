<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Liste tournois - E-Sporter</title>
        <link rel="stylesheet" href="../../css/style.css">
        <link rel="stylesheet" href="../../css/style_calendrier.css">
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
                                    $pair = 0;
                                    while ($donnees = $req -> fetch()){
                                        if ($pair % 2 == 0){
                                            $bg = "white";
                                        } else {
                                            $bg = "grey";
                                        }
                                        $pair += 1;
                                        $id_tournoi = strval($donnees[2]);
                                        $reqJeux = $sql -> getJeuxTournois($id_tournoi, "libelle");
                                        $liste_jeu = array();
                                        while ($nomJeu = $reqJeux -> fetch()){ 
                                            array_push($liste_jeu, $nomJeu['libelle']);
                                        }
                                        $nb_jeu = count($liste_jeu);
                                        echo "
                                            <tr class=".$bg.">
                                                <td>$donnees[0]</td>
                                                <td>".date('d / m / Y', strtotime($donnees[1]))."</td>
                                                <td>$liste_jeu[0]</td>
                                                <td>
                                                    <label>".'
                                                    <a href="match-poule.php?id_tournoi='.$id_tournoi.'&id_jeu='.$liste_jeu[0].'">
                                                        <svg width="30px" height="30px" viewBox="0 -2 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <g id="basketball-field-2" transform="translate(-2 -4)">
                                                        <path id="secondary" fill="#2ca9bc" d="M21,15H19a3,3,0,0,1,0-6h2V5H3V9H5a3,3,0,0,1,0,6H3v4H21Z"/>
                                                        <line id="primary-upstroke" y1="0.1" transform="translate(12 11.95)" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"/>
                                                        <path id="primary" d="M12,19V5M5,15a3,3,0,0,0,3-3H8A3,3,0,0,0,5,9H3v6Zm16,0V9H19a3,3,0,0,0-3,3h0a3,3,0,0,0,3,3Zm0,4V5H3V19Z" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                                        </g>
                                                        </svg>
                                                        </a>
                                                    '."</label>
                                                </td>
                                            </tr>
                                        ";
                                        //Si le tournoi a plusieurs jeux
                                        if ($nb_jeu > 1){
                                            for ($i = 1; $i < $nb_jeu-1; $i++){
                                            $id_tournoi = strval($donnees[2]);
                                            echo "
                                                <tr class=".$bg.">
                                                    <td></td>
                                                    <td></td>
                                                    <td>$liste_jeu[$i]</td>
                                                    <td>
                                                        <label>".'
                                                            <a href="match-poule.php?id_tournoi='.$id_tournoi.'&id_jeu='.$id_tournoi.'">
                                                            <svg width="30px" height="30px" viewBox="0 -2 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <g id="basketball-field-2" transform="translate(-2 -4)">
                                                            <path id="secondary" fill="#2ca9bc" d="M21,15H19a3,3,0,0,1,0-6h2V5H3V9H5a3,3,0,0,1,0,6H3v4H21Z"/>
                                                            <line id="primary-upstroke" y1="0.1" transform="translate(12 11.95)" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"/>
                                                            <path id="primary" d="M12,19V5M5,15a3,3,0,0,0,3-3H8A3,3,0,0,0,5,9H3v6Zm16,0V9H19a3,3,0,0,0-3,3h0a3,3,0,0,0,3,3Zm0,4V5H3V19Z" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                                            </g>
                                                            </svg>
                                                            </a>
                                                        '."</label>
                                                    </td>
                                                </tr>
                                            ";
                                            }
                                        }
                                        
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