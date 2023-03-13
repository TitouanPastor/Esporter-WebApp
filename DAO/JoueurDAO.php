<?php

class JoueurDAO
{

    private $linkpdo;

    public function __construct()
    {
        //Connexion to DB
        require_once('connectDB.php');
        $sql = new connectDB();
        $this->linkpdo = $sql->getConnection();
    }

    //Fonction pour ajouter un joueur
    public function addJoueur($nom, $prenom, $dateNaissance, $pseudo, $mail, $idEquipe)
    {
        $req = $this->linkpdo->prepare('INSERT INTO joueur VALUES (NULL, :nom, :prenom, :dateNaissance, :pseudo, :mail, :idEquipe)');
        $req->execute(
            array(
                'nom' => $nom,
                'prenom' => $prenom,
                'dateNaissance' => $dateNaissance,
                'pseudo' => $pseudo,
                'mail' => $mail,
                'idEquipe' => $idEquipe
            )
        );
    }


    // Fonction qui retourne les joueurs
    public function getJoueur()
    {
        $req = $this->linkpdo->prepare('SELECT * FROM joueur');
        $req->execute();
        return $req;
    }
}
