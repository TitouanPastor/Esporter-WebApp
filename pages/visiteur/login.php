<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/style_login.css">
</head>

<body>
    <form action="" method="post">

        <div class="container">

            <label for="username">Nom d'utilisateur : </label>
            <input type="text" name="username" required placeholder="Entrer le nom d'utilisateur">

            <label for="mdp">Mot de passe :</label>
            <input type="password" name="mdp" required placeholder="Entrer le mot de passe">   

            <hr>

            <div class="button">
                <input type="button" name="mdp_oublie" value="Mot de passe oublié">
                <input type="submit" name="login" value="Se Connecter">
            </div>

        </div>
    </form>


</body>

</html>