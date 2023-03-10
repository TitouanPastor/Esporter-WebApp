<?php

class EquipeDAO
{

    private $linkpdo;

    public function __construct()
    {
        //Connexion to DB
        require_once('connectDB.php');
        $sql = new connectDB();
        $this->linkpdo = $sql->getConnection();
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
        $req = $this->linkpdo->prepare("SELECT jeu.libelle FROM jeu, equipe WHERE equipe.id_jeu = jeu.id_jeu AND equipe.mail = :username");
        $testReq = $req->execute(array("username" => $username));
        if ($testReq == false) {
            die("Erreur getJeuEquipe");
        }
        return $req;
    }

    //Fonction qui renvoie tournoi.nom, tournoi.date, nb de place disponible
    public function getTournoiInscription($jeuLibelle)
    {
        $req = $this->linkpdo->prepare('SELECT tournoi.nom, tournoi.date_debut,tournoi.id_tournoi FROM tournoi, concerner, jeu WHERE tournoi.id_tournoi = concerner.id_tournoi AND concerner.id_jeu = jeu.id_jeu AND jeu.libelle = :libelle ORDER BY tournoi.date_debut');
        $testReq = $req->execute(array("libelle" => $jeuLibelle));
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
    public function getNbEquipeTournoi($nom_tournoi)
    {
        $req = $this->linkpdo->prepare("SELECT count(*) FROM tournoi,etre_inscrit WHERE etre_inscrit.id_tournoi = tournoi.id_tournoi AND tournoi.nom = :nom_tournoi");
        $testReq = $req->execute(array("nom_tournoi" => $nom_tournoi));
        if ($testReq == false) {
            die("Erreur getNbEquipeTournoi");
        }
        return $req;
    }


}
