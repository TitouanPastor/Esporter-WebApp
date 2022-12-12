<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inscription Tournoi</title>
        <link rel="stylesheet" href="../../css/style.css">
        <link rel="stylesheet" href="">
    </head>

    <body>
       <?php
        //Header
        session_start();
        require_once(realpath(dirname(__FILE__) . '/../../class/header.php'));
        $header = new header(2);    

        if ($_SESSION['role'] == "equipe") {
            echo $header->customize_header($_SESSION['role']);
        } else {
            header('Location: ../../acces-refuse.php');
        }

        //Sql
        require_once(realpath(dirname(__FILE__) . '/../../SQL.php'));
        $sql = new requeteSQL();
        $check_valider = 0;

        //Sauvegarde de la valeur de la liste
        if (isset($_POST["tournoi-jeu"])){
            $value_tournoi_jeu = $_POST["tournoi-jeu"];
        } else {
            $value_tournoi_jeu = "default";
        }

        $jeu_equipe = $sql -> getJeuEquipe($_SESSION["username"]);
        $param = array();
       $param[0] = null;
       $param[1] = "default";
        $param[2] = $jeu_equipe;
        $req = $sql->getTournoiCalendrier($param);
        ?>
        <main class ="main-listes">
            <section class="main-listes-container">
                <h1>Liste des tournois à venir</h1>
                <form action="post">
                    <div class ="container">

                        <select name="tournoi-jeu" id="">
                            <option value="default" selected>Sélectionner le jeu de l'équipe</option>
                            <?php
                                $sql = new requeteSQL();
                                $jeu = $sql->getJeux();
                                while ($donnees = $jeu->fetch()) { ?>
                                    <option value="<?php echo $donnees['Libelle']; ?>" <?php if ($value_tournoi_jeu == $donnees['Libelle']) echo 'selected';?>>
                                    <?php echo $donnees['Libelle']; ?>
                                    </option>
                            <?php } ?>
                        </select>

                        <table>
                            <thead>
                                <tr>
                                    <th>Nom du tournoi</th>
                                    <th>Date du tournoi</th>
                                    <th>Disponibilité</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                echo $jeu_equipe;
                                    while ($donnees = $req -> fetch()){
                                    echo "Test tournoi";
                                    echo
                                        "<tr>
                                        <td>".$donnees[0] . "</td>
                                        <td>".$donnees[1]."</td>
                                        <td>".$donnees[2]."</td>
                                        <tr>";
                                        
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