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

        <table>
            <tr>
                <th> Nom du Tournoi </th>
                <th> Date du tournoi</th>
                <th> Jeu du Tournoi </th>
            </tr>
             <?php
                if ($check_valider == 1) {
                    if ($req != null){
                        echo 'REQ NON null';
                    }
                    $donnees = $req -> fetch();
                    while ($donnees) {
                        echo 'test fetch';
                        echo $donnees[0];
                        echo '
                        <tr>
                            <td>'.$donnees[1].'</td>
                            <td>'.$donnees[2].'</td>
                            <td>'.$donnees[].'</td>
                        </tr>
                        ';
                    }
                }
            ?>

        </table>

    </form>
</body>

</html>