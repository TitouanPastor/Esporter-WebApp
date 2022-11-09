<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>[Test] Test Requete</title>
</head>
<body>
    <?php

        require_once('SQL.php');

        $test = new requeteSQL();
        //$test->addArbitre('arbitre1', '123456');
        $req = $test->getArbitre();
        while ($data = $req->fetch()){
            echo$data[1].' '.$data['Login'].' '.$data['Mot_de_passe'].'<br>';
        }

  

    ?>
</body>
</html>