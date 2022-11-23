<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se connecter - E-Sporter</title>
    <link rel="icon" href="../../img/esporter-icon.png">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/style_login.css">
</head>

<body>
    <?php
    require_once(realpath(dirname(__FILE__) . '/../../class/header.php'));
    require_once(realpath(dirname(__FILE__) . '/../../SQL.php'));
    $info_login = "";

    // Construction du header
    $header = new header(2);
    echo $header->header_login();

    //On se déconnecte
    session_start();
    $_SESSION['username'] = "";
    $_SESSION['password'] = "";
    $_SESSION['role'] = "";

    //verification de la validation du formulaire
    if (isset($_POST['submit'])) {
        //verification de la validité des champs
        if (!empty($_POST['username']) && !empty($_POST['password'])) {
            //connexion à la base de données
            $sql = new requeteSQL();
            //verification de la validité de l'email et du mot de passe
            if ($sql->checkLogin($_POST['username'], $_POST['password'], $_POST['role'])) {
                //connexion de l'utilisateur
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['password'] = $_POST['password'];
                $_SESSION['role'] = $_POST['role'];
                header('Location: ../../index.php');
            } else {
                $info_login = "Email ou mot de passe incorrect";
            }
        }
    }


    ?>
    <main class="main-login">
        <form action="" method="post">
            <h1>Se connecter</h1>
            <hr>
            <div class="container">
                <div class="role">
                    <label for="role">Votre rôle</label>
                    <select name="role" id="role" required>
                        <option value="ecurie">Ecurie</option>
                        <option value="equipe">Equipe</option>
                        <option value="gestionnaire">Gestionnaire</option>
                        <option value="arbitre">Arbitre</option>
                    </select>
                </div>
                <div class="utilisateur">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path d="M272 304h-96C78.8 304 0 382.8 0 480c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32C448 382.8 369.2 304 272 304zM48.99 464C56.89 400.9 110.8 352 176 352h96c65.16 0 119.1 48.95 127 112H48.99zM224 256c70.69 0 128-57.31 128-128c0-70.69-57.31-128-128-128S96 57.31 96 128C96 198.7 153.3 256 224 256zM224 48c44.11 0 80 35.89 80 80c0 44.11-35.89 80-80 80S144 172.1 144 128C144 83.89 179.9 48 224 48z" />
                    </svg>
                    <input type="text" name="username" required placeholder="Nom utilisateur">
                </div>

                <div class="mdp">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z" />
                    </svg>
                    <input type="password" name="password" required placeholder="Entrer le mot de passe">
                </div>
                <div class="button">
                    <!-- <input type="button" name="mdp_oublie" class="bouton" value="Mot de passe oublié"> -->
                    <span><?php echo $info_login ?></span>
                    <input type="submit" name="submit" class="submit" value="Se Connecter">
                </div>

            </div>
        </form>
    </main>
</body>

</html>