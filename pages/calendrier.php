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
            require_once(realpath(dirname(__FILE__) . '/../SQL.php'));
        ?>

        <form action="" method="post">
            <div class="container">
                <input type ="date" name ="date">

                <select name="tournoi_nom"> 

                </select>
                
                <select name="tournoi_jeu"> 
                    
                </select>

            </div>
        </form>
    </body>
</html>

