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

    //Fonction qui retourne les jeux d'un tournois
    public function getJeuxTournois($id, $choix = "default")
    {
        if ($choix == "libelle") {
            $req = $this->linkpdo->prepare('SELECT jeu.libelle FROM jeu, concerner, tournoi WHERE tournoi.Id_tournoi = concerner.id_tournoi AND jeu.id_jeu = concerner.id_jeu AND concerner.Id_Tournoi = :IdTournoi ');
        } else {
            $req = $this->linkpdo->prepare('SELECT jeu.* FROM jeu, concerner, tournoi where tournoi.Id_Tournoi = concerner.Id_Tournoi and jeu.Id_Jeu = concerner.Id_Jeu and concerner.Id_Tournoi = :IdTournoi');
        }

        $req->execute(array("IdTournoi" => $id));
        return $req;
    }

    //Retourne vrai si le tournoi est fermé ou faux sinon
    public function tournoiIsClosed($idTournoi)
    {
        $req = $this->linkpdo->prepare('SELECT estFerme FROM tournoi WHERE Id_Tournoi = :id');
        $req->execute(
            array(
                'id' => $idTournoi
            )
        );
        $data = $req->fetch();
        if ($data['estFerme'] == 1) {
            return true;
        }
        return false;
    }

    //Retourne vrai si le tournoi peut être fermé ou faux sinon
    public function tournoiIscloseable($id)
    {
        $isClosed = $this->tournoiIsClosed($id);
        $isFull = $this->tournoiIsFull($id);
        if (!$isClosed && $isFull) {
            return true;
        }
        return false;
    }

    //Retourne vrai si le tournoi est plein ou faux sinon
    public function tournoiIsFull($idTournoi)
    {
        // On récupère le nombre de jeux du tournoi
        $nbJeux = $this->linkpdo->prepare('SELECT count(*) FROM concerner WHERE id_Tournoi = :idTournoi');
        $nbJeux->execute(
            array(
                'idTournoi' => $idTournoi
            )
        );
        $nbJeux = $nbJeux->fetch();
        // On récupère le nombre d'équipe inscrite au tournoi
        $nbEquipes = $this->linkpdo->prepare('SELECT count(*) FROM etre_inscrit WHERE id_Tournoi = :idTournoi');
        $nbEquipes->execute(
            array(
                'idTournoi' => $idTournoi
            )
        );
        $nbEquipes = $nbEquipes->fetch();

        if ($nbJeux[0] * 16 == $nbEquipes[0]) {
            return true;
        }
        return false;
    }

    public function tournoisByType($idEquipe = 0)
    {
        if ($idEquipe == 0) {
            $req = $this->linkpdo->prepare("SELECT * FROM tournoi order by Type");
            $req->execute();
            return $req;
        } else {
            $req = $this->linkpdo->prepare("SELECT tournoi.* FROM tournoi, etre_inscrit WHERE tournoi.Id_Tournoi = etre_inscrit.Id_Tournoi AND etre_inscrit.Id_Equipe = :IdEquipe order by Type");
            $req->execute(
                array(
                    'IdEquipe' => $idEquipe
                )
            );
            return $req;
        }
    }

    public function tournoisByLieu($idEquipe = 0)
    {
        if ($idEquipe == 0) {
            $req = $this->linkpdo->prepare("SELECT * FROM tournoi order by lieu");
            $req->execute();
            return $req;
        } else {
            $req = $this->linkpdo->prepare("SELECT tournoi.* FROM tournoi, etre_inscrit WHERE tournoi.Id_Tournoi = etre_inscrit.Id_Tournoi AND etre_inscrit.Id_Equipe = :IdEquipe order by lieu");
            $req->execute(
                array(
                    'IdEquipe' => $idEquipe
                )
            );
            return $req;
        }
    }

    public function tournoisByNom($idEquipe = 0)
    {
        if ($idEquipe == 0) {
            $req = $this->linkpdo->prepare("SELECT * FROM tournoi order by Nom");
            $req->execute();
            return $req;
        } else {
            $req = $this->linkpdo->prepare("SELECT tournoi.* FROM tournoi, etre_inscrit WHERE tournoi.Id_Tournoi = etre_inscrit.Id_Tournoi AND etre_inscrit.Id_Equipe = :IdEquipe order by Nom");
            $req->execute(
                array(
                    'IdEquipe' => $idEquipe
                )
            );
            return $req;
        }
    }

    public function tournoisByDate($idEquipe = 0)
    {
        if ($idEquipe == 0) {
            $req = $this->linkpdo->prepare("SELECT * FROM tournoi order by Date_Debut");
            $req->execute();
            return $req;
        } else {
            $req = $this->linkpdo->prepare("SELECT tournoi.* FROM tournoi, etre_inscrit WHERE tournoi.Id_Tournoi = etre_inscrit.Id_Tournoi AND etre_inscrit.Id_Equipe = :IdEquipe order by Date_Debut");
            $req->execute(
                array(
                    'IdEquipe' => $idEquipe
                )
            );
            return $req;
        }
    }

    
    public function jeuNonPresentDansTournois($idT)
    {
        $req = $this->linkpdo->prepare('SELECT * FROM jeu WHERE Id_Jeu NOT IN (SELECT Id_Jeu FROM concerner WHERE Id_Tournoi = :idT)');
        $req->execute(
            array(
                'idT' => $idT
            )
        );
        return $req;
    }

    public function supprimerJeuxTournoi($idT)
    {
        $req = $this->linkpdo->prepare('DELETE FROM concerner WHERE Id_Tournoi = :idT');
        $req->execute(
            array(
                'idT' => $idT
            )
        );
    }

    public function modifierTournoi($nom, $dateDeb, $datefin, $type, $lieu, $pointMax, $id)
    {
        $req = $this->linkpdo->prepare('UPDATE tournoi SET Nom = :nom, Date_debut = :datedeb, Date_fin = :datefin, Type = :type, Lieu = :lieu, Nombre_point_max = :npm  WHERE Id_Tournoi = :idT');
        $req->execute(
            array(
                'nom' => $nom,
                'datedeb' => $dateDeb,
                'datefin' => $datefin,
                'type' => $type,
                'lieu' => $lieu,
                'npm' => $pointMax,
                'idT' => $id
            )
        );
    }

    public function tournoiId($id)
    {
        $req = $this->linkpdo->prepare("SELECT * FROM tournoi where Id_Tournoi = :IdTournoi");
        $req->execute(
            array(
                'IdTournoi' => $id
            )
        );

        return $req;
    }

    //Fonctions pour classementCM.php
    //Prend en parametre l'id du jeu
    public function getClassementCM($idJeu)
    {
        $req = $this->linkpdo->prepare('SELECT equipe.nom, equipe.nb_pts_champ FROM equipe, jeu WHERE equipe.id_jeu = jeu.id_jeu AND jeu.Id_Jeu = :idJeu ORDER BY equipe.nb_pts_champ DESC');
        $testReq = $req->execute(array("idJeu" => $idJeu));
        if ($testReq == false) {
            die('Erreur getClassementCM (SQL.php) execute 2');
        }

        return $req;
    }

}
