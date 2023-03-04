<?php

class TournoiDAO
{

    private $linkpdo;

    public function __construct()
    {
        //Connexion to DB
        require_once('connectDB.php');
        $sql = new connectDB();
        $this->linkpdo = $sql->getConnection();
    }

    // Ajouter un jeu à un tournoi
    public function addConcerner($idTournoi, $idJeu)
    {
        $req = $this->linkpdo->prepare('INSERT INTO concerner VALUES (:idTournoi, :idJeu)');
        $req->execute(
            array(
                'idTournoi' => $idTournoi,
                'idJeu' => $idJeu
            )
        );
    }

    //Recuperer tout les tournois si ($idEquipe == 0) sinon recuperer les tournois d'une equipe
    public function getTournoi($idEquipe = 0)
    {
        if ($idEquipe == 0) {
            $req = $this->linkpdo->prepare("SELECT * FROM tournoi order by estFerme desc, id_tournoi");
            $req->execute();
            return $req;
        } else {
            $req = $this->linkpdo->prepare("SELECT tournoi.* FROM tournoi, etre_inscrit WHERE tournoi.Id_Tournoi = etre_inscrit.Id_Tournoi AND etre_inscrit.Id_Equipe = :IdEquipe");
            $req->execute(
                array(
                    'IdEquipe' => $idEquipe
                )
            );
            return $req;
        }
    }

    //Jeux renseigné dans la BDD
    public function getJeux()
    {
        $req = $this->linkpdo->prepare('SELECT * FROM jeu');
        $req->execute();
        return $req;
    }

    //Fonction pour ajouter un tournoi
    public function addTournoi($Type, $nom, $dateDeb, $dateFin, $lieu, $nbPtsMax, $IdGestionnaireEsport, $idArbitre)
    {
        $req = $this->linkpdo->prepare('INSERT INTO tournoi VALUES (NULL, :TypeT, :Nom, :Date_debut, :Date_fin, :Lieu, :NbPtsMax, :IdGestionnaireEsport, :IdArbitre,0)');
        $req->execute(
            array(
                'TypeT' => $Type,
                'Nom' => $nom,
                'Date_debut' => $dateDeb,
                'Date_fin' => $dateFin,
                'Lieu' => $lieu,
                'NbPtsMax' => $nbPtsMax,
                'IdGestionnaireEsport' => $IdGestionnaireEsport,
                'IdArbitre' => $idArbitre
            )
        );
    }

    //Fonction qui retourne le dernier tuple de tournoi
    public function getLastIDTournoi()
    {
        $req = $this->linkpdo->prepare('SELECT Id_Tournoi FROM tournoi ORDER BY Id_Tournoi DESC LIMIT 1');
        $req->execute();
        while ($data = $req->fetch()) {
            return $data['Id_Tournoi'];
        }
    }

    //Fonction pour ajouter un jeu
    public function addJeu($libelle)
    {
        $req = $this->linkpdo->prepare('INSERT INTO jeu VALUES (NULL, :libelle)');
        $req->execute(
            array(
                'libelle' => $libelle
            )
        );
    }
}
