<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/style_calendrier.css">
</head>

<body>
    <?php
        // création du header
        session_start();
        require_once(realpath(dirname(__FILE__) . '/../../class/header.php'));
        $header = new header(2);
        echo $header->customize_header($_SESSION['role']);

        //Sql
        require_once(realpath(dirname(__FILE__) . '/../../SQL.php'));
        $sql = new requeteSQL();
        $check_valider = 0;
        
        if (isset($_POST["valider"])) {
            $check_valider = 1;
            $param = array();
            $param[0] = $_POST["tournoi_date"];
            $param[1] = $_POST["tournoi_nom"];
            $param[2] = $_POST["tournoi_jeu"];
            $req = $sql -> getTournoiCalendrier($param);
        }
    ?>
    <main class ="main-calendrier">
        <form action="" method="post">
            <div class="container">
                <input type="date" name="tournoi_date" class="element">

                <select name="tournoi_nom" class="element" class="select">
                    <option value="default" selected>Sélectionner un nom de tournoi</option>
                    <?php
                        $tournoi = $sql->getTournoi();
                        while ($donnees = $tournoi->fetch()) { ?>
                    <option value="<?php echo $donnees['Nom']; ?>">
                        <?php echo $donnees['Nom']; ?>
                    </option>
                    <?php } ?>
                </select>

                <select name="tournoi_jeu" class="element" class="select" value="Sélectionner un nom de jeu">
                    <option value="default" selected>Sélectionner un nom de jeu</option>
                        <?php
                        $sql = new requeteSQL();
                        $jeu = $sql->getJeux();
                        while ($donnees = $jeu->fetch()) { ?>
                        <option value="<?php echo $donnees['Libelle']; ?>">
                            <?php echo $donnees['Libelle']; ?>
                        </option>
                        <?php } ?>
                </select>


                <input name="valider" type="submit" class="submit" class="element" value="valider">

            </div>
            
            <table class = "tableau-style">
                <thead>
                    <tr>
                        <th> Nom du Tournoi </th>
                        <th> Date du tournoi</th>
                        <th> Jeu du Tournoi </th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        if ($check_valider == 1) {
                            if ($req -> rowCount() > 0) {
                                while ($donnees = $req -> fetch()) {
                                    echo '
                                    <tr>
                                        <td>'.$donnees[0].'</td>
                                        <td>'.$donnees[1].'</td>
                                        <td>'.$donnees[2].'</td>
                                    </tr>
                                    ';
                                }
                            } else {
                                echo "Il n'existe pas de tournois pour ces critères";
                            }
                        }
                    ?>
                </tbody>
            </table>

        </form>
    </main>
</body>

</html>