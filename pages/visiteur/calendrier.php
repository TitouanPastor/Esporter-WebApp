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
        
        //Exécution de la requête en fonction des paramètres fournis (liste rempli ou non)
        if (isset($_POST["valider"])) {
            $check_valider = 1;
            $param = array();
            $param[0] = $_POST["tournoi_date"];
            $param[1] = $_POST["tournoi_nom"];
            $param[2] = $_POST["tournoi_jeu"];
            $req = $sql -> getTournoiCalendrier($param);
        }

        //Contrôle sur la date 01/01/2023 -> 31/12/2023
        $min = new DateTime('01-01-2023');
        $max = new DateTime('31-12-2023');    
        $date_min = $min -> format('Y-m-d');
        $date_max = $max -> format('Y-m-d');

        //Valeur et affichage d'une liste -> conserver la valeur après validation
        if (isset($_POST["tournoi_date"])){
            $value_tournoi_date = $_POST["tournoi_date"];
        } else {
            $value_tournoi_date = "2023-01-01";
        }

        if (isset($_POST["tournoi_nom"])){ 
            $value_tournoi_nom = $_POST["tournoi_nom"];
        } else {
            $value_tournoi_nom = "default";
        }

        if (isset($_POST["tournoi_jeu"])){
            $value_tournoi_jeu = $_POST["tournoi_jeu"];
        } else {
            $value_tournoi_jeu = "default";
        }


    ?>
    <main class ="main-listes">
        <section class="main-listes-container">
        <h1>Calendrier des tournois</h1>
        <form action="" method="post">
            <div class="container">

                <input type="date" name="tournoi_date" class="element" value="<?php echo $value_tournoi_date?>"min="<?php echo $date_min;?>" max="<?php echo $date_max;?>">

                <select name="tournoi_nom" class="element" class="select">
                    <option value="default" selected>Sélectionner un tournoi</option>
                    <?php
                        $tournoi = $sql->getTournoi();
                        while ($donnees = $tournoi->fetch()) { ?>
                    <option value="<?php echo $donnees['Nom']; ?>" <?php if ($value_tournoi_nom == $donnees['Nom']) echo 'selected'?>>
                        <?php echo $donnees['Nom']; ?>
                    </option>
                    <?php } ?>
                </select>

                <select name="tournoi_jeu" class="element" class="select">
                    <option value="default" selected>Sélectionner un jeu</option>
                        <?php
                        $jeu = $sql->getJeux();
                        while ($donnees = $jeu->fetch()) { ?>
                        <option value="<?php echo $donnees['Libelle']; ?>" <?php if ($value_tournoi_jeu == $donnees['Libelle']) echo 'selected';?>>
                            <?php echo $donnees['Libelle']; ?>
                        </option>
                        <?php } ?>
                </select>

                <input name="valider" type="submit" class="submit" class="element" value="valider">
            </div>
            <?php
            
            if ($check_valider == 1) {
                if ($req -> rowCount() == 0){
                    echo "<div style='display : flex; justify-content :center; padding-top : 50px;'> Il n'y a pas de tournoi pour ces critères </div>";
                } else {
                    echo "
                <div class = 'tableau-style'>
                <table>
                    <thead>
                        <tr>
                            <th> Nom du Tournoi </th>
                            <th> Date du tournoi</th>
                            <th> Jeu du Tournoi </th>
                        </tr>
                    </thead>
    
                    <tbody>";
                    while ($donnees = $req->fetch()) {
                        echo '
                        <tr>
                            <td>' . $donnees[0] . '</td>
                            <td>' . date('d / m / Y', strtotime($donnees[1])). '</td>
                            <td>' . $donnees[2] . '</td>
                        </tr>
                        ';
                    }
                    echo "
                        </tbody>
                        </table>
                        </div>
                    </form>
                ";
                } 
            }
            ?>
        </form>
        </section>
    </main>
</body>

</html>