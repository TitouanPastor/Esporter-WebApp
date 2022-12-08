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
            session_start();
            require_once(realpath(dirname(__FILE__) . '/../../class/header.php'));
            $header = new header(2);    

            if ($_SESSION['role'] == "equipe") {
                echo $header->customize_header($_SESSION['role']);
            } else {
                header('Location: ../../acces-refuse.php');
            }
        ?>
        <main class ="main-listes">
            <section class="main-listes-container">
                <h1>Liste des tournois à venir</h1>
                <form action="post">
                    <div class ="container">
                        <select name="tournoi-jeu" id="">
                            <option value="default" selected>Sélectionner un jeu</option>
                            <?php
                                $sql = new requeteSQL();
                                $jeu = $sql->getJeux();
                                while ($donnees = $jeu->fetch()) { ?>
                                <option value="<?php echo $donnees['Libelle']; ?>" <?php if ($value_tournoi_jeu == $donnees['Libelle']) echo 'selected';?>>
                                <?php echo $donnees['Libelle']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </form>

            </section>

        </main>
    </body>
</html>