<?php

class EcurieDAO
{

    private $linkpdo;

    public function __construct()
    {
        //Connexion to DB with singleton
        require_once('ConnectDB.php');
        $db = ConnectDB::getInstance();
        $this->linkpdo = $db->getConnection();
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
        $data = $req->fetch();
        return $data['Id_Ecurie'];
        
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

    public function getJeuByIdEquipe($idEquipe)
    {
        $req = $this->linkpdo->prepare('SELECT jeu.* FROM  jeu, equipe WHERE ' . $idEquipe . ' = equipe.Id_Equipe and jeu.Id_Jeu = equipe.Id_Jeu');
        $req->execute();
        return $req;
    }
    public function getEquipeByIdEcurie($id)
    {
        $req = $this->linkpdo->prepare('SELECT * FROM  equipe WHERE ' . $id . ' = equipe.Id_Ecurie');
        $req->execute();
        return $req;
    }

    public function getJoueurByIdEquipe($id)
    {
        $req = $this->linkpdo->prepare('SELECT * FROM  joueur WHERE ' . $id . ' = joueur.Id_Equipe');
        $req->execute();
        return $req;
    }

    public function equipeByPoint($idEcurie)
    {
        $req = $this->linkpdo->prepare('SELECT * FROM  equipe WHERE Id_Ecurie = :id_ecurie ORDER BY Nb_pts_Champ DESC');
        $req->execute(
            array(
                'id_ecurie' => $idEcurie
            )
        );
        return $req;
    }

    public function equipeByNom($idEcurie)
    {
        $req = $this->linkpdo->prepare('SELECT * FROM  equipe WHERE Id_Ecurie = :id_ecurie ORDER BY Nom ASC');
        $req->execute(
            array(
                'id_ecurie' => $idEcurie
            )
        );
        return $req;
    }

    public function ecuriesByNom()
    {
        $req = $this->linkpdo->prepare("SELECT * FROM ecurie order by Nom");
        $req->execute();
        return $req;
    }

    public function ecuriesByStatut()
    {
        $req = $this->linkpdo->prepare("SELECT * FROM ecurie order by Statut DESC");
        $req->execute();
        return $req;
    }
}
