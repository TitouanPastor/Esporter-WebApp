<?php

class requeteSQL
{

    private $linkpdo;


    //Fonction pour se connecter à la base de donnée PHPMyAdmin
    public function __construct()
    {
        ///Connexion au serveur MySQL avec PDO
        $server = '89.116.147.154';
        $login  = 'u743447366_admin';
        $mdp    = 'YAksklOw6qN$';
        $db     = 'u743447366_esporter';

        try {
            $this->linkpdo = new PDO("mysql:host=$server;dbname=$db", $login, $mdp);
            $this->linkpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        ///Capture des erreurs éventuelles
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    //-----------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // Sprint 1

    //Fonction qui retourne le dernier tuple de jeu
    public function getLastIDJeu()
    {
        $req = $this->linkpdo->prepare('SELECT Id_Jeu FROM jeu ORDER BY Id_Jeu DESC LIMIT 1');
        $req->execute();
        while ($data = $req->fetch()) {
            return $data['Id_Jeu'];
        }
    }

    //Fonction qui retourne toute les informations contenu dans le dernier jeu inséré
    public function jeuId($id)
    {
        $req = $this->linkpdo->prepare("SELECT * FROM jeu where Id_Jeu = :Id_Jeu");
        $req->execute(
            array(
                'Id_Jeu' => $id
            )
        );

        return $req;
    }

    //Fonction qui retourne toute les informations contenu dans la dernière association concrner insérée
    public function concernerId($id)
    {
        $req = $this->linkpdo->prepare("SELECT * FROM concerner where Id_Tournoi = :IdTournoi");
        $req->execute(
            array(
                'IdTournoi' => $id
            )
        );

        return $req;
    }


    //-----------------------------------------------------------------------------------------------------------------------------------------------------------------
    //Sprint 2 

    public function getEcurie()
    {
        $req = $this->linkpdo->prepare("SELECT * FROM ecurie");
        $req->execute();
        return $req;
    }


    //-----------------------------------------------------------------------------------------------------------------------------------------------------------------
    //Sprint 3 & (en travaux) 

    //Fonctions pour classementCM.php
    //Prend en parametre l'id du jeu
    public function getClassementCM($idJeu)
    {
        $req = $this->linkpdo->prepare('SELECT equipe.nom, equipe.nb_pts_champ FROM equipe, jeu WHERE equipe.id_jeu = jeu.id_jeu AND jeu.Id_Jeu = :idJeu ORDER BY equipe.nb_pts_champ DESC');
        $testReq = $req->execute(array("idJeu" => $idJeu));
        if ($testReq == false) {
            die('Erreur getClassementCMr (SQL.php) execute 2');
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
    public function getJeuEquipe($username)
    {
        $req = $this->linkpdo->prepare("SELECT jeu.libelle FROM jeu, equipe WHERE equipe.id_jeu = jeu.id_jeu AND equipe.mail = :username");
        $testReq = $req->execute(array("username" => $username));
        if ($testReq == false) {
            die("Erreur getJeuEquipe");
        }
        return $req;
    }

    public function getIdEquipeByMail($mail)
    {
        $req = $this->linkpdo->prepare("SELECT id_equipe from equipe WHERE equipe.mail = :mail");
        $testReq = $req->execute(array("mail" => $mail));
        if ($testReq == false) {
            die("Erreur getIdEquipe");
        }
        while ($row = $req->fetch()) {
            return $row['id_equipe'];
        }
    }

    public function getIdJeuByLibelle($libelle)
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
        while ($row = $req->fetch()) {
            return $row['id_jeu'];
        }
    }

    //Fonctiion pour récupérer l'id d'une écurie à partir de son nom
    public function getIdEcurie($mailEcurie)
    {
        $req = $this->linkpdo->prepare("SELECT id_ecurie from ecurie WHERE ecurie.mail= :mail_ecurie");
        $req = $req->execute(array("mail_ecurie" => $mailEcurie));
        if ($req == false) {
            die("Erreur getIdEcurie");
        }
        return $req;
    }

    //Fonction pour ajouter un arbitre
    public function addArbitre($login, $mdp)
    {
        $req = $this->linkpdo->prepare('INSERT INTO arbitre VALUES (NULL, :login, :mdp)');
        $req->execute(
            array(
                'login' => $login,
                'mdp' => $mdp
            )
        );
    }

    //Fonction qui retourne les arbitres
    public function getArbitre()
    {
        $req = $this->linkpdo->prepare('SELECT * FROM arbitre');
        $req->execute();
        return $req;
    }


    // Fonction pour ajouter un gestionnaire Esporter
    public function addGestionnaire($login, $mdp)
    {
        $req = $this->linkpdo->prepare('INSERT INTO gestionnaire VALUES (NULL, :login, :mdp)');
        $req->execute(
            array(
                'login' => $login,
                'mdp' => $mdp
            )
        );
    }

    //Fonction qui retourne les gestionnaires Esporter
    public function getGestionnaire()
    {
        $req = $this->linkpdo->prepare('SELECT * FROM gestionnaire');
        $req->execute();
        return $req;
    }

    // Fonction qui retourne les poules
    public function getPoule()
    {
        $req = $this->linkpdo->prepare('SELECT * FROM poule');
        $req->execute();
        return $req;
    }

    //Fonction qui retourne le premier d'une poule a partir d'un tournoi et d'un jeu donnée 
    public function getPremierPoule($idTournoi, $idJeu, $idPoule)
    {
        $req = $this->linkpdo->prepare('SELECT etre_inscrit.id_Equipe FROM etre_inscrit, poule WHERE poule.id_Tournoi = :idTournoi and poule.Id_Jeu = :idJeu and poule.id_Poule = etre_inscrit.id_poule and etre_inscrit.id_poule = :idPoule order by nb_Match_Gagne desc limit 1');
        $req->execute(
            array(
                'idTournoi' => $idTournoi,
                'idJeu' => $idJeu,
                'idPoule' => $idPoule
            )
        );
        while ($row = $req->fetch()) {
            return $row['id_Equipe'];
        }
    }

    //Retourne le nombre de point total de la poule 
    public function getNbPointPoule($idPoule)
    {
        $req = $this->linkpdo->prepare('SELECT sum(nb_Match_Gagne) as nbMatchJouer FROM etre_inscrit WHERE etre_inscrit.id_poule = :idPoule');
        $req->execute(
            array(
                'idPoule' => $idPoule
            )
        );
        while ($row = $req->fetch()) {
            return $row['nbMatchJouer'];
        }
    }

    public function getPouleFinale($idPoule)
    {
        $req = $this->linkpdo->prepare('SELECT * FROM etre_inscrit WHERE id_Poule = :idPoule');
        $req->execute(
            array(
                'idPoule' => $idPoule

            )
        );
        $equipePouleFinale = array();
        while ($row = $req->fetch()) {
            array_push($equipePouleFinale, $row['id_Equipe']);
        }
        return $equipePouleFinale;
    }

    public function getMultiplicateur($idTournoi)
    {
        $req = $this->linkpdo->prepare('SELECT Nombre_point_max FROM tournoi WHERE id_Tournoi = :idTournoi');
        $req->execute(
            array(
                'idTournoi' => $idTournoi
            )
        );

        while ($row = $req->fetch()) {
            return $row['Nombre_point_max'];
        }
    }

    // Fonction qui retourne les matchs
    public function getGame()
    {
        $req = $this->linkpdo->prepare('SELECT * FROM game');
        $req->execute();
        return $req;
    }

    public function addRegrouper($idEquipe, $idGame)
    {
        $req = $this->linkpdo->prepare('INSERT INTO regrouper VALUES (:idEquipe, :idGame)');
        $req->execute(
            array(
                'idEquipe' => $idEquipe,
                'idGame' => $idGame
            )
        );
    }

    public function deleteJeuTournoi($idT, $idJ)
    {
        $req = $this->linkpdo->prepare('DELETE FROM concerner WHERE Id_Tournoi = :idT and Id_Jeu = :idJ');
        $req->execute(
            array(
                'idT' => $idT,
                'idJ' => $idJ
            )
        );
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

    public function supprimerTournoi($idT)
    {
        $req = $this->linkpdo->prepare('DELETE FROM tournoi WHERE Id_Tournoi = :idT');
        $req->execute(
            array(
                'idT' => $idT
            )
        );
    }

    public function getEquipeByIdEcurie($id)
    {
        $req = $this->linkpdo->prepare('SELECT * FROM  equipe WHERE ' . $id . ' = equipe.Id_Ecurie');
        $req->execute();
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

    public function getEquipeByIdTournoi($id)
    {
        $req = $this->linkpdo->prepare('SELECT * FROM  equipe WHERE ' . $id . ' = equipe.Id_Tournoi');
        $req->execute();
        return $req;
    }


    public function closeTournois($id)
    {
        $req = $this->linkpdo->prepare('UPDATE tournoi SET estFerme = 1 WHERE Id_Tournoi = :id');
        $req->execute(
            array(
                'id' => $id
            )
        );
    }

    public function getIDPoule($idTournoi, $idJeu)
    {
        $req = $this->linkpdo->prepare('SELECT Id_Poule FROM poule WHERE id_Tournoi = :idTournoi AND id_jeu = :idJeu');
        $req->execute(
            array(
                'idTournoi' => $idTournoi,
                'idJeu' => $idJeu
            )
        );
        $idsPoules = array(); //Tableau qui contiendra les id des poules
        while ($datas = $req->fetch()) {
            array_push($idsPoules, $datas['Id_Poule']);
        }
        return $idsPoules;
    }

    public function getEquipeInscritesByPoule($idTournoi, $idJeu, $idPoule)
    {
        $req = $this->linkpdo->prepare('SELECT * FROM etre_inscrit WHERE id_Tournoi = :idTournoi AND id_Jeu = :idJeu AND id_poule = :idPoule');
        $req->execute(
            array(
                'idTournoi' => $idTournoi,
                'idJeu' => $idJeu,
                'idPoule' => $idPoule
            )
        );
        return $req;
    }

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

    public function getEquipeByIdPoule($idPoule)
    {
        $req = $this->linkpdo->prepare("SELECT id_equipe, nom FROM equipe, etre_inscrit WHERE equipe.id_equipe = etre_inscrit.id_equipe AND etre_inscrit.id_poule = :id_poule ");
        $testReq = $req->execute(
            array(
                "id_poule" => $idPoule
            )
        );
        if ($testReq == false) {
            die('Erreur getEquipeByIdPoule');
        }
        return $req;
    }

    public function getEquipePouleTrie1($idPoule)
    {
        $req = $this->linkpdo->prepare("SELECT equipe.nom, etre_inscrit.nb_match_gagne FROM equipe, etre_inscrit WHERE equipe.id_equipe = etre_inscrit.id_equipe ANd etre_inscrit.id_poule = :id_poule ORDER BY nb_match_gagne desc");
        $testReq = $req->execute(
            array(
                "id_poule" => $idPoule
            )
        );
        if ($testReq == false) {
            die("Error getEquipePouleTrie");
        }
        return $req;
    }

    public function getRencontrePoule($idPoule)
    {
        $req = $this->linkpdo->prepare("SELECT rencontre.id_equipe, id_equipe1 FROM rencontre, equipe WHERE id_poule = :id_poule");
        $testReq = $req->execute(
            array(
                "id_poule" => $idPoule
            )
        );
        if ($testReq == false) {
            die('Error getRencontrePoule');
        }
        return $req;
    }

    public function getEquipeRencontre($idRencontre)
    {
        $req = $this->linkpdo->prepare("SELECT nom FROM equipe, rencontre WHERE rencontre.id_rencontre = :id_rencontre");
        $testReq = $req->execute(
            array(
                "id_rencontre" => $idRencontre
            )
        );
        if ($testReq == false) {
            die('Error getEquipeRencontre');
        }
        return $req;
    }

    public function getFinalistePoule($idTournoi, $idJeu, $idPoule)
    {
        $req = $this->linkpdo->prepare("SELECT id_Equipe FROM etre_inscrit, poule WHERE etre_inscrit.id_Tournoi = :idTournoi and etre_inscrit.id_Jeu = :idJeu and etre_inscrit.id_Poule = :idPoule ORDER BY nb_Match_Gagne DESC LIMIT 1");
        $testReq = $req->execute(
            array(
                "idTournoi" => $idTournoi,
                "idJeu" => $idJeu,
                "idPoule" => $idPoule
            )
        );
        return $req;
    }

}
