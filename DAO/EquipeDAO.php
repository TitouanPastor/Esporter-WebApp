<?php

class EquipeDAO
{

    private $linkpdo;

    public function __construct()
    {
        //Connexion to DB with singleton
        require_once('ConnectDB.php');
        $db = ConnectDB::getInstance();
        $this->linkpdo = $db->getConnection();
    }

    //Fonction pour ajouter une equipe
    public function addEquipe($nom, $mdp, $mail, $nbPtsChamps, $idJeu, $idEcurie)
    {
        $req = $this->linkpdo->prepare('INSERT INTO equipe VALUES (NULL, :nom, :mdp, :mail, :nbPtsChamps, :id_jeu, :id_ecurie)');
        $req->execute(
            array(
                'nom' => $nom,
                'mdp' => $mdp,
                'mail' => $mail,
                'nbPtsChamps' => $nbPtsChamps,
                'id_ecurie' => $idEcurie,
                'id_jeu' => $idJeu
            )
        );
    }

    // Fonction qui retourne les equipes 
    public function getEquipe()
    {
        $req = $this->linkpdo->prepare("SELECT * FROM equipe");
        $req->execute();
        return $req;
    }

    //Fonction pour récupérer le jeu d'une équipe à partir de l'username
    public function getJeuEquipe($username)
    {
        $req = $this->linkpdo->prepare("SELECT jeu.libelle, jeu.id_jeu FROM jeu, equipe WHERE equipe.id_jeu = jeu.id_jeu AND equipe.mail = :username");
        $testReq = $req->execute(array("username" => $username));
        if ($testReq == false) {
            die("Erreur getJeuEquipe");
        }
        return $req;
    }

    //Fonction qui renvoie tournoi.nom, tournoi.date, nb de place disponible
    public function getTournoiInscription($idJeu)
    {
        $req = $this->linkpdo->prepare('SELECT tournoi.nom, tournoi.date_debut,tournoi.id_tournoi FROM tournoi, concerner, jeu WHERE tournoi.id_tournoi = concerner.id_tournoi AND concerner.id_jeu = jeu.id_jeu AND jeu.id_jeu = :id_jeu ORDER BY tournoi.date_debut');
        $testReq = $req->execute(array("id_jeu" => $idJeu));
        if ($testReq == false) {
            die('Erreur getTournoiInscription');
        }
        return $req;
    }

    //Fonction pour récupérer le jeu d'une équipe à partir de l'username
    public function getIdEquipe($username)
    {
        $req = $this->linkpdo->prepare("SELECT id_equipe from equipe WHERE equipe.mail = :username");
        $testReq = $req->execute(array("username" => $username));
        if ($testReq == false) {
            die("Erreur getIdEquipe");
        }
        return $req->fetchColumn();
    }


    public function getIdJeu($libelle)
    {
        $req = $this->linkpdo->prepare("SELECT id_jeu FROM jeu where libelle = :libelle");
        $testReq = $req->execute(
            array(
                "libelle" => $libelle
            )
        );
        if ($testReq == false) {
            die('Erreur getIDJeu');
        }
        return $req->fetchColumn();
    }

    public function getNomEquipeById($idEquipe)
    {
        $req = $this->linkpdo->prepare("SELECT nom FROM equipe WHERE id_equipe = :id_equipe");
        $testReq = $req->execute(
            array(
                "id_equipe" => $idEquipe
            )
        );
        if ($testReq == false) {
            die("Erreur getNomEquipeById");
        }
        return $req;
    }

    //Inscription Tournoi
    public function inscriptionTournoi($param)
    {
        //$param[0] = id_equipe
        //$param[1] = id_tournoi
        //$param[2] = id_jeu 
        $req = $this->linkpdo->prepare("INSERT INTO etre_inscrit VALUE (:id_equipe,:id_tournoi,:id_jeu, :id_poule, 0)");
        $testReq = $req->execute(
            array(
                "id_equipe" => $param[0],
                "id_tournoi" => $param[1],
                "id_jeu" => $param[2],
                "id_poule" => NULL
            )
        );
        if ($testReq == false) {
            die('Erreur inscriptionTournoi');
        }
        return $req;
    }

    //Renvoie le nombre de
    public function estInscritTournoi($mail, $tournoiNom)
    {
        $req = $this->linkpdo->prepare("SELECT count(*) FROM equipe, etre_inscrit, tournoi WHERE equipe.id_equipe = etre_inscrit.id_equipe AND etre_inscrit.id_tournoi = tournoi.id_tournoi AND equipe.mail = :equipe_mail AND tournoi.nom = :tournoi_nom");
        $testReq = $req->execute(array("equipe_mail" => $mail, "tournoi_nom" => $tournoiNom));
        if ($testReq == false) {
            die('Erreur estInscritTournoi');
        }
        $req = $req->fetchColumn();
        return $req;
    }

    //Fonction qui renvoie le nombre d'équipe participant à un tournoi
    public function getNbEquipeTournoi($id_tournoi, $id_jeu)
    {
        $req = $this->linkpdo->prepare("SELECT count(*) FROM tournoi,etre_inscrit WHERE etre_inscrit.id_tournoi = tournoi.id_tournoi AND etre_inscrit.id_tournoi = :id_tournoi AND etre_inscrit.id_jeu = :id_jeu");
        $testReq = $req->execute(array(
            "id_tournoi" => $id_tournoi,
            "id_jeu" => $id_jeu
        ));
        if ($testReq == false) {
            die("Erreur getNbEquipeTournoi");
        }
        return $req;
    }

    //Fonction qui retourne le dernier tuple de equipe
    public function getLastIDEquipe()
    {
        $req = $this->linkpdo->prepare('SELECT Id_Equipe FROM equipe ORDER BY Id_Equipe DESC LIMIT 1');
        $req->execute();
        $data = $req->fetch();
        $data['Id_Equipe'];
        
    }
}
