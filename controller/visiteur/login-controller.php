<?php
session_start();
require_once(realpath(dirname(__FILE__) . '/../visiteur/header-controller.php'));
require_once(realpath(dirname(__FILE__) . '/../../model/Login.php'));
$login = new Login();
$infoLogin = "";

//On se déconnecte
$_SESSION['username'] = "";
$_SESSION['password'] = "";
$_SESSION['role'] = "";
$role = array("ecurie" => '', "equipe" => '', "gestionnaire" => '', "arbitre" => '');

//verification de la validation du formulaire
if (isset($_POST['submit'])) {
    //verification de la validité des champs
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        
        //verification de la validité de l'email et du mot de passe
        if ($login->checkLogin(htmlspecialchars($_POST['username']), htmlspecialchars($_POST['password']), htmlspecialchars($_POST['role']))) {
            //connexion de l'utilisateur
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['password'] = $_POST['password'];
            $_SESSION['role'] = $_POST['role'];
            header('Location: ../../index.php');
        } else {
            $infoLogin = "Email ou mot de passe incorrect";
            $role[$_POST['role']] = "selected";
        }
    }
}
ob_start();
require_once(realpath(dirname(__FILE__) . '/../../view/visiteur/login-view.html'));
$buffer = ob_get_clean();
$buffer = str_replace("##infoLogin##", $infoLogin, $buffer);
$buffer = str_replace("##header##", $headerHTML, $buffer);
$buffer = str_replace("##roleEcurie##", $role['ecurie'], $buffer);
$buffer = str_replace("##roleEquipe##", $role['equipe'], $buffer);
$buffer = str_replace("##roleGestionnaire##", $role['gestionnaire'], $buffer);
$buffer = str_replace("##roleArbitre##", $role['arbitre'], $buffer);
echo $buffer;
