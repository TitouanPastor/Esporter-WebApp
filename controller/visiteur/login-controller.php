<?php
session_start();
require_once(realpath(dirname(__FILE__) . '/../../controller/visiteur/header-controller.php'));
require_once(realpath(dirname(__FILE__) . '/../../model/Login.php'));
$infoLogin = "";

//On se déconnecte
session_start();
$_SESSION['username'] = "";
$_SESSION['password'] = "";
$_SESSION['role'] = "";
$role = array("ecurie" => '', "equipe" => '', "gestionnaire" => '', "arbitre" => '');

//verification de la validation du formulaire
if (isset($_POST['submit'])) {
    //verification de la validité des champs
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        //connexion à la base de données
        $sql = new requeteSQL();
        //verification de la validité de l'email et du mot de passe
        if ($sql->checkLogin(htmlspecialchars($_POST['username']), htmlspecialchars($_POST['password']), htmlspecialchars($_POST['role']))) {
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
