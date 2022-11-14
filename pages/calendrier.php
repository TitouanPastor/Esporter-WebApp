<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/style.css">
    </head>

    <body>
        <?php
        if (!isset($_POST['valider'])){
            require_once(realpath(dirname(__FILE__) . '/../SQL.php'));
        } else {
            
        }
        ?>

        <form action="" method="post">
            <div class="container">
                <input type ="date" name ="date">

                <select name="tournoi_nom"> 
                <?php
                    $sql = new requeteSQL();
                    $tournoi = $sql -> getTournoi();
                    while ($donnees = $tournoi -> fetch()){?>
                        <option value="<?php echo $donnees['Nom'];?>"><?php echo $donnees['Nom'];?></option>
                <?php } ?>
                </select>
                
                <select name="tournoi_jeu"> 
                    <?php
                        $sql = new requeteSQL();
                        $jeu = $sql -> getJeu();
                        while ($donnees = $jeu -> fetch()){?>
                            <option value="<?php echo $donnees['Libelle'];?>"><?php echo $donnees['Libelle'];?></option>
                    <?php } ?>     
                </select>
                

                <input type="submit" value="valider">

            </div>
        </form>
    </body>
</html>