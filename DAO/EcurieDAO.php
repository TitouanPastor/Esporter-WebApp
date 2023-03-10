<?php

class EcurieDAO
{

    private $linkpdo;

    public function __construct()
    {
        //Connexion to DB
        require_once('connectDB.php');
        $sql = new connectDB();
        $this->linkpdo = $sql->getConnection();
    }

    //Fonction qui retourne les ecuries
    public function getEcurie()
    {
        $req = $this->linkpdo->prepare("SELECT * FROM ecurie");
        $req->execute();
        return $req;
    }

    //Fonction pour ajouter une ecurie
    public function addEcurie($nom, $statut, $mdp, $mail, $idGestionnaireEsport)
    {
        $req = $this->linkpdo->prepare('INSERT INTO ecurie VALUES (NULL, :Nom, :Statut, :mdp, :mail, :id_gestionnaireEsport)');
        $req->execute(
            array(
                'Nom' => $nom,
                'Statut' => $statut,
                'mdp' => $mdp,
                'mail' => $mail,
                'id_gestionnaireEsport' => $idGestionnaireEsport
            )
        );
    }

    //Fonction qui retourne une écurie en fonction de son mail
    public function getIdEcurieByMail($mail)
    {
        $req = $this->linkpdo->prepare('SELECT Id_Ecurie FROM ecurie where Mail = :mail');
        $req->execute(
            array(
                'mail' => $mail
            )
        );
        while ($data = $req->fetch()) {
            return $data['Id_Ecurie'];
        }
    }

    // Fonction qui retourne les equipes d'une Ecurie
    public function getEquipeEcurie($id)
    {
        $req = $this->linkpdo->prepare("SELECT * FROM equipe where Id_Ecurie = :IdEcurie");
        $req->execute(
            array(
                'IdEcurie' => $id
            )
        );
        return $req;
    }
}
