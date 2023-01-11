<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassementCM - E-Sporter</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/style_calendrier.css">
    <link rel="icon" href="../../img/esporter-icon.png">
</head>

<body>
    <?php
    

        //Sql
        require_once(realpath(dirname(__FILE__) . '/../../SQL.php'));
        $sql = new requeteSQL();
        $check_valider = 0;
        
        //Exécution de la requête en fonction des paramètres fournis (liste rempli ou non)
        if (isset($_POST["valider"])) {
            if ($_POST['equipe_jeu'] != "default") {
                $check_valider = 1;
                $req = $sql -> getClassementCM($_POST["equipe_jeu"]);
            }
        }

        //Valeur et affichage d'une liste -> conserver la valeur après validation
        if (isset($_POST["equipe_jeu"])){
            $value_equipe_jeu = $_POST["equipe_jeu"];
        } else {
            $value_equipe_jeu = "default";
        }


    ?>
    <main class ="main-listes">
        <section class="main-listes-container">
        <h1>Classement Championnat du Monde</h1>
        <form action="" method="post">
            <div class="container">

                <select name="equipe_jeu" class="equipe_jeu">
                    <option value="default" selected>Sélectionner un jeu</option>
                        <?php
                        $jeu = $sql->getJeux();
                        while ($donnees = $jeu->fetch()) { ?>
                        <option value="<?php echo $donnees['Id_Jeu']; ?>" <?php if ($value_equipe_jeu == $donnees['Id_Jeu']) echo 'selected';?>>
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
                            <th> Nom de l'Équipe </th>
                            <th> Nombre de Point</th>
                        </tr>
                    </thead>
    
                    <tbody>";
                    while ($donnees = $req->fetch()) {
                        echo '
                        <tr>
                            <td>' . $donnees[0] . '</td>
                            <td>'. $donnees[1] .'</td>
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