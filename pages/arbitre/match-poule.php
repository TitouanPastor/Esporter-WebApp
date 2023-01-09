<!DOCTYPE html>
<html>
    <header>
    <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Liste tournois - E-Sporter</title>
        <link rel="stylesheet" href="../../css/style.css">
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
            $id_tournoi = $GET_['id_tournoi'];
            $id_jeu = $GET_['id_jeu'];
            
        ?>
        
        


        

        
    </body>
</html>