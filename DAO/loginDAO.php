<?php
class LoginDAO
{

    private $linkpdo;

    public function __construct()
    {
        //Connexion to DB with singleton
        require_once('ConnectDB.php');
        $db = ConnectDB::getInstance();
        $this->linkpdo = $db->getConnection();
    }

    // vérifie si le login et le mot de passe sont corrects
    public function checkLogin($login, $mdp, $role)
    {
        $req = $this->linkpdo->prepare('SELECT count(*) FROM ' . $role . ' WHERE mail = :login AND Mot_de_passe = :mdp');
        $req->execute(
            array(
                'login' => $login,
                'mdp' => $mdp
            )
        );

        $result = $req->fetch();
        //condition si il y a un résultat
        if ($result[0] != 0) {
            return true;
        } else {
            return false;
        }
    }
}
