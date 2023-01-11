<?php

class requeteSQL
{

    private $linkpdo;


    //Fonction pour se connecter à la base de donnée PHPMyAdmin
    public function __construct()
    {
        ///Connexion au serveur MySQL avec PDO
        $server = '54.37.31.19';
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

    //-------------Page Créer un Tournoi


    //Fonction pour ajouter un jeu
    public function addJeu($libelle)
    {
        $req = $this->linkpdo->prepare('INSERT INTO jeu VALUES (NULL, :libelle)');
        $req->execute(array(
            'libelle' => $libelle
        ));
    }


    //Fonction qui retourne les jeux
    public function getJeux()
    {
        $req = $this->linkpdo->prepare('SELECT * FROM jeu');
        $req->execute();
        return $req;
    }


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
        $req->execute(array(
            'Id_Jeu' => $id
        ));

        return $req;
    }


    //Fonction pour ajouter un tournoi
    public function addTournoi($Type, $nom, $date_deb, $date_fin, $lieu, $nbPtsMax, $IdGestionnaireEsport, $idArbitre)
    {
        $req = $this->linkpdo->prepare('INSERT INTO tournoi VALUES (NULL, :TypeT, :Nom, :Date_debut, :Date_fin, :Lieu, :NbPtsMax, :IdGestionnaireEsport, :IdArbitre)');
        $req->execute(array(
            'TypeT' => $Type,
            'Nom' => $nom,
            'Date_debut' => $date_deb,
            'Date_fin' => $date_fin,
            'Lieu' => $lieu,
            'NbPtsMax' => $nbPtsMax,
            'IdGestionnaireEsport' => $IdGestionnaireEsport,
            'IdArbitre' => $idArbitre
        ));
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

    //Fonction qui retourne toute les informations contenu dans le dernier tournoi inséré
    public function tournoiId($id)
    {
        $req = $this->linkpdo->prepare("SELECT * FROM tournoi where Id_Tournoi = :IdTournoi");
        $req->execute(array(
            'IdTournoi' => $id
        ));

        return $req;
    }


    //Fonction qui permet de remplir l'association concerner
    public function addConcerner($idTournoi, $idJeu)
    {
        $req = $this->linkpdo->prepare('INSERT INTO concerner VALUES (:idTournoi, :idJeu)');
        $req->execute(array(
            'idTournoi' => $idTournoi,
            'idJeu' => $idJeu
        ));
    }


    //Fonction qui retourne toute les informations contenu dans la dernière association concrner insérée
    public function concernerId($id)
    {
        $req = $this->linkpdo->prepare("SELECT * FROM concerner where Id_Tournoi = :IdTournoi");
        $req->execute(array(
            'IdTournoi' => $id
        ));

        return $req;
    }


    //-------------Page Login


    // vérifie si le login et le mot de passe sont corrects
    public function checkLogin($login, $mdp, $role)
    {
        $req = $this->linkpdo->prepare('SELECT count(*) FROM ' . $role . ' WHERE mail = :login AND Mot_de_passe = :mdp');
        $req->execute(array(
            'login' => $login,
            'mdp' => $mdp
        ));

        $result = $req->fetch();
        //condition si il y a un résultat
        if ($result[0] != 0) {
            return true;
        } else {
            return false;
        }
    }


    //-----------------------------------------------------------------------------------------------------------------------------------------------------------------
    //Sprint 2 

    //-------------Page Enregistrer une écurie


    //Fonction pour ajouter une ecurie
    public function addEcurie($nom, $statut, $mdp, $mail, $id_gestionnaireEsport)
    {
        $req = $this->linkpdo->prepare('INSERT INTO ecurie VALUES (NULL, :Nom, :Statut, :mdp, :mail, :id_gestionnaireEsport)');
        $req->execute(array(
            'Nom' => $nom,
            'Statut' => $statut,
            'mdp' => $mdp,
            'mail' => $mail,
            'id_gestionnaireEsport' => $id_gestionnaireEsport
        ));
    }


    //Fonction qui retourne les ecuries
    public function getEcurie()
    {
        $req = $this->linkpdo->prepare("SELECT * FROM ecurie");
        $req->execute();
        return $req;
    }

    //Fonction qui retourne une écurie en fonction de son mail
    public function getIdEcurieByMail($mail)
    {
        $req = $this->linkpdo->prepare('SELECT Id_Ecurie FROM ecurie where Mail = :mail');
        $req->execute(array(
            'mail' => $mail
        ));
        while ($data = $req->fetch()) {
            return $data['Id_Ecurie'];
        }
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


    //-------------Page Enregistrer une équipe


    //Fonction pour ajouter une equipe
    public function addEquipe($nom, $mdp, $mail, $nbPtsChamps, $id_jeu, $id_ecurie)
    {
        $req = $this->linkpdo->prepare('INSERT INTO equipe VALUES (NULL, :nom, :mdp, :mail, :nbPtsChamps, :id_jeu, :id_ecurie)');
        $req->execute(array(
            'nom' => $nom,
            'mdp' => $mdp,
            'mail' => $mail,
            'nbPtsChamps' => $nbPtsChamps,
            'id_ecurie' => $id_ecurie,
            'id_jeu' => $id_jeu
        ));
    }


    // Fonction qui retourne les equipes d'une Ecurie
    public function getEquipeEcurie($id)
    {
        $req = $this->linkpdo->prepare("SELECT * FROM equipe where Id_Ecurie = :IdEcurie");
        $req->execute(array(
            'IdEcurie' => $id
        ));
        return $req;
    }


    // Fonction qui retourne les equipes 
    public function getEquipe()
    {
        $req = $this->linkpdo->prepare("SELECT * FROM equipe");
        $req->execute();
        return $req;
    }


    //Fonction qui retourne le dernier tuple de equipe
    public function getLastIDEquipe()
    {
        $req = $this->linkpdo->prepare('SELECT Id_Equipe FROM equipe ORDER BY Id_Equipe DESC LIMIT 1');
        $req->execute();
        while ($data = $req->fetch()) {
            return $data['Id_Equipe'];
        }
    }


    //-----------------------------------------------------------------------------------------------------------------------------------------------------------------
    //Sprint 3 & (en travaux) 

    public function getTournoi($idequipe = 0)
    {
        if ($idequipe == 0) {
            $req = $this->linkpdo->prepare("SELECT * FROM tournoi");
            $req->execute();
            return $req;
        } else {
            $req = $this->linkpdo->prepare("SELECT tournoi.* FROM tournoi, etre_inscrit WHERE tournoi.Id_Tournoi = etre_inscrit.Id_Tournoi AND etre_inscrit.Id_Equipe = :IdEquipe");
            $req->execute(array(
                'IdEquipe' => $idequipe
            ));
            return $req;
        }
    }

    public function tournoisByType($idequipe = 0)
    {
        if ($idequipe == 0) {
            $req = $this->linkpdo->prepare("SELECT * FROM tournoi order by Type");
            $req->execute();
            return $req;
        } else {
            $req = $this->linkpdo->prepare("SELECT tournoi.* FROM tournoi, etre_inscrit WHERE tournoi.Id_Tournoi = etre_inscrit.Id_Tournoi AND etre_inscrit.Id_Equipe = :IdEquipe order by Type");
            $req->execute(array(
                'IdEquipe' => $idequipe
            ));
            return $req;
        }
    }

    public function tournoisByLieu($idequipe = 0)
    {
        if ($idequipe == 0) {
            $req = $this->linkpdo->prepare("SELECT * FROM tournoi order by lieu");
            $req->execute();
            return $req;
        } else {
            $req = $this->linkpdo->prepare("SELECT tournoi.* FROM tournoi, etre_inscrit WHERE tournoi.Id_Tournoi = etre_inscrit.Id_Tournoi AND etre_inscrit.Id_Equipe = :IdEquipe order by lieu");
            $req->execute(array(
                'IdEquipe' => $idequipe
            ));
            return $req;
        }
    }

    public function tournoisByNom($idequipe = 0)
    {
        if ($idequipe == 0) {
            $req = $this->linkpdo->prepare("SELECT * FROM tournoi order by Nom");
            $req->execute();
            return $req;
        } else {
            $req = $this->linkpdo->prepare("SELECT tournoi.* FROM tournoi, etre_inscrit WHERE tournoi.Id_Tournoi = etre_inscrit.Id_Tournoi AND etre_inscrit.Id_Equipe = :IdEquipe order by Nom");
            $req->execute(array(
                'IdEquipe' => $idequipe
            ));
            return $req;
        }
    }

    public function tournoisByDate($idequipe = 0)
    {
        if ($idequipe == 0) {
            $req = $this->linkpdo->prepare("SELECT * FROM tournoi order by Date_Debut");
            $req->execute();
            return $req;
        } else {
            $req = $this->linkpdo->prepare("SELECT tournoi.* FROM tournoi, etre_inscrit WHERE tournoi.Id_Tournoi = etre_inscrit.Id_Tournoi AND etre_inscrit.Id_Equipe = :IdEquipe order by Date_Debut");
            $req->execute(array(
                'IdEquipe' => $idequipe
            ));
            return $req;
        }
    }

    public function getTournoiCommence(){
        $req = $this->linkpdo->prepare("SELECT nom, date_debut, id_tournoi FROM tournoi where tournoi.date_debut < curdate()");
        $testreq = $req -> execute();
        if ($testreq == false){
            die('Erreur getTournoiCommence');
        }
        return $req;
    }

    //Fonctions pour calendrier.php
    //Prend en parametre un array, si les valeurs sont null ou "default" alors les requêtes changent
    public function getTournoiCalendrier($param)
    {
        // $param[0] = tournoi.date (null)
        // $param[1] = tournoi.nom ('default')
        // $param[2] = tournoi.jeu ('default')
        if ($param[0] == null and $param[1] == 'default') { // jeu
            $req = $this->linkpdo->prepare('SELECT tournoi.nom, tournoi.date_debut, jeu.libelle FROM tournoi, concerner, jeu WHERE tournoi.id_tournoi = concerner.id_tournoi AND concerner.id_jeu = jeu.id_jeu AND jeu.libelle = :libelle ORDER BY tournoi.date_debut');
            $testreq = $req->execute(array("libelle" => $param[2]));
            if ($testreq == false) {
                die('Erreur getTournoiCalendrier (SQL.php) execute 1');
            }
        } elseif ($param[0] == null and $param[2] == 'default') { // nom
            $req = $this->linkpdo->prepare('SELECT tournoi.nom, tournoi.date_debut, jeu.libelle FROM tournoi, jeu, concerner WHERE tournoi.id_tournoi = concerner.id_tournoi AND concerner.id_jeu = jeu.id_jeu AND tournoi.nom = :nom ORDER BY tournoi.date_debut');
            $testreq = $req->execute(array("nom" => $param[1]));
            if ($testreq == false) {
                die('Erreur getTournoiCalendrier (SQL.php) execute 2');
            }
        } elseif ($param[1] == 'default' and $param[2] == 'default') { //date
            $req = $this->linkpdo->prepare('SELECT tournoi.nom, tournoi.date_debut, jeu.libelle FROM tournoi, jeu, concerner WHERE tournoi.id_tournoi = concerner.id_tournoi AND concerner.id_jeu = jeu.id_jeu AND tournoi.date_debut > :date_tournoi ORDER BY tournoi.date_debut');
            $testreq = $req->execute(array("date_tournoi" => $param[0]));
            if ($testreq == null) {
                die('Erreur getTournoiCalendrier (SQL.php) execute 3');
            }
        } elseif ($param[0] == null) { // nom + jeu
            $req = $this->linkpdo->prepare('SELECT tournoi.nom, tournoi.date_debut, jeu.libelle from tournoi, jeu, concerner where tournoi.id_tournoi = concerner.id_tournoi and concerner.id_jeu = jeu.id_jeu and jeu.libelle = :libelle and tournoi.nom = :nom ORDER BY tournoi.date_debut');
            $testreq = $req->execute(array("libelle" => $param[2], "nom" => $param[1]));
            if ($testreq == false) {
                die('Erreur getTournoiCalendrier (SQL.php) execute 4');
            }
        } elseif ($param[1] == 'default') { // date + jeu
            $req = $this->linkpdo->prepare('SELECT tournoi.nom, tournoi.date_debut, jeu.libelle from tournoi, jeu, concerner where tournoi.id_tournoi = concerner.id_tournoi and concerner.id_jeu = jeu.id_jeu and jeu.libelle = :libelle and tournoi.date_debut > :date_tournoi ORDER BY tournoi.date_debut');
            $testreq = $req->execute(array("libelle" => $param[2], "date_tournoi" => $param[0]));
            if ($testreq == false) {
                die('Erreur getTournoiCalendrier (SQL.php) execute 5');
            }
        } elseif ($param[2] == 'default') { // date + nom
            $req = $this->linkpdo->prepare('SELECT tournoi.nom, tournoi.date_debut, jeu.libelle from tournoi, jeu, concerner where tournoi.id_tournoi = concerner.id_tournoi and concerner.id_jeu = jeu.id_jeu and tournoi.nom = :nom and tournoi.date_debut > :date_tournoi ORDER BY tournoi.date_debut');
            $testreq = $req->execute(array("nom" => $param[1], "date_tournoi" => $param[0]));
            if ($testreq == false) {
                die('Erreur getTournoiCalendrier (SQL.php) execute 6');
            }
        } else { // date + nom + jeu
            $req = $this->linkpdo->prepare('SELECT tournoi.nom, tournoi.date_debut, jeu.libelle from tournoi, jeu, concerner where tournoi.id_tournoi = concerner.id_tournoi and concerner.id_jeu = jeu.id_jeu and tournoi.nom = :nom and tournoi.date_debut > :date_tournoi and jeu.libelle = :libelle ORDER BY tournoi.date_debut');
            $testreq = $req->execute(array("date_tournoi" => $param[0], "nom" => $param[1], "libelle" => $param[2]));
            if ($testreq == false) {
                die('Erreur getTournoiCalendrier (SQL.php) execute 7');
            }
        }
        return $req;
    }

    //Fonction qui renvoie tournoi.nom, tournoi.date, nb de place disponible
    public function getTournoiInscription($jeu_libelle)
    {
        $req = $this->linkpdo->prepare('SELECT tournoi.nom, tournoi.date_debut,tournoi.id_tournoi FROM tournoi, concerner, jeu WHERE tournoi.id_tournoi = concerner.id_tournoi AND concerner.id_jeu = jeu.id_jeu AND jeu.libelle = :libelle ORDER BY tournoi.date_debut');
        $testreq = $req->execute(array("libelle" => $jeu_libelle));
        if ($testreq == false) {
            die('Erreur getTournoiInscription');
        }
        return $req;
    }
    //Fonction pour récupérer le jeu d'une équipe à partir de l'username
    public function getJeuEquipe($username)
    {
        $req = $this->linkpdo->prepare("SELECT jeu.libelle FROM jeu, equipe WHERE equipe.id_jeu = jeu.id_jeu AND equipe.mail = :username");
        $testreq = $req->execute(array("username" => $username));
        if ($testreq == false) {
            die("Erreur getJeuEquipe");
        }
        return $req;
    }

    //Renvoie le nombre de
    public function estInscritTournoi($mail, $tournoi_nom)
    {
        $req = $this->linkpdo->prepare("SELECT count(*) FROM equipe, etre_inscrit, tournoi WHERE equipe.id_equipe = etre_inscrit.id_equipe AND etre_inscrit.id_tournoi = tournoi.id_tournoi AND equipe.mail = :equipe_mail AND tournoi.nom = :tournoi_nom");
        $testreq = $req->execute(array("equipe_mail" => $mail, "tournoi_nom" => $tournoi_nom));
        if ($testreq == false) {
            die('Erreur estInscritTournoi');
        }
        $req = $req->fetchColumn();
        return $req;
    }

    //Inscription Tournoi
    public function inscriptionTournoi($param)
    {
        //$param[0] = id_equipe
        //$param[1] = id_tournoi
        //$param[2] = id_jeu 
        $req = $this->linkpdo->prepare("INSERT INTO etre_inscrit VALUE (:id_equipe,:id_tournoi,:id_jeu, :id_poule)");
        $testreq = $req->execute(array(
            "id_equipe" => $param[0],
            "id_tournoi" => $param[1],
            "id_jeu" => $param[2],
            "id_poule" => NULL
        ));
        if ($testreq == false) {
            die('Erreur inscriptionTournoi');
        }
        return $req;
    }

    //Fonction pour récupérer le jeu d'une équipe à partir de l'username
    public function getIdEquipe($username)
    {
        $req = $this->linkpdo->prepare("SELECT id_equipe from equipe WHERE equipe.mail = :username");
        $testreq = $req->execute(array("username" => $username));
        if ($testreq == false) {
            die("Erreur getIdEquipe");
        }
        return $req->fetchColumn();
    }

    public function getIdJeu($libelle)
    {
        $req = $this->linkpdo->prepare("SELECT id_jeu FROM jeu where libelle = :libelle");
        $testreq = $req->execute(
            array(
                "libelle" => $libelle
            )
        );
        if ($testreq == false) {
            die('Erreur getIDJeu');
        }
        return $req->fetchColumn();
    }

    //Fonctiion pour récupérer l'id d'une écurie à partir de son nom
    public function getIdEcurie($mail_ecurie)
    {
        $req = $this->linkpdo->prepare("SELECT id_ecurie from ecurie WHERE ecurie.mail= :mail_ecurie");
        $req = $req->execute(array("mail_ecurie" => $mail_ecurie));
        if ($req == false) {
            die("Erreur getIdEcurie");
        }
        return $req;
    }

    //Fonction qui renvoie le nombre d'équipe participant à un tournoi
    public function getNbEquipeTournoi($nom_tournoi)
    {
        $req = $this->linkpdo->prepare("SELECT count(*) FROM tournoi,etre_inscrit WHERE etre_inscrit.id_tournoi = tournoi.id_tournoi AND tournoi.nom = :nom_tournoi");
        $testreq = $req->execute(array("nom_tournoi" => $nom_tournoi));
        if ($testreq == false) {
            die("Erreur getNbEquipeTournoi");
        }
        return $req;
    }

    //Fonction pour ajouter un arbitre
    public function addArbitre($login, $mdp)
    {
        $req = $this->linkpdo->prepare('INSERT INTO arbitre VALUES (NULL, :login, :mdp)');
        $req->execute(array(
            'login' => $login,
            'mdp' => $mdp
        ));
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
        $req->execute(array(
            'login' => $login,
            'mdp' => $mdp
        ));
    }


    //Fonction qui retourne les gestionnaires Esporter
    public function getGestionnaire()
    {
        $req = $this->linkpdo->prepare('SELECT * FROM gestionnaire');
        $req->execute();
        return $req;
    }

    //Fonction qui retourne les jeux d'un tournois
    public function getJeuxTournois($id, $choix = "default")
    {
        if ($choix == "libelle"){
            $req = $this -> linkpdo -> prepare('SELECT jeu.libelle FROM jeu, concerner, tournoi WHERE tournoi.Id_tournoi = concerner.id_tournoi AND jeu.id_jeu = concerner.id_jeu AND concerner.Id_Tournoi = :IdTournoi ');
        } else {
            $req = $this -> linkpdo -> prepare('SELECT jeu.* FROM jeu, concerner, tournoi where tournoi.Id_Tournoi = concerner.Id_Tournoi and jeu.Id_Jeu = concerner.Id_Jeu and concerner.Id_Tournoi = :IdTournoi');
        }

        $req->execute(array("IdTournoi" => $id));
        return $req;
    }





    // Fonction qui retourne les poules
    public function getPoule()
    {
        $req = $this->linkpdo->prepare('SELECT * FROM poule');
        $req->execute();
        return $req;
    }


    //Fonction pour ajouter un joueur
    public function addJoueur($nom, $prenom, $dateNaissance, $pseudo, $mail, $idEquipe)
    {
        $req = $this->linkpdo->prepare('INSERT INTO joueur VALUES (NULL, :nom, :prenom, :dateNaissance, :pseudo, :mail, :idEquipe)');
        $req->execute(array(
            'nom' => $nom,
            'prenom' => $prenom,
            'dateNaissance' => $dateNaissance,
            'pseudo' => $pseudo,
            'mail' => $mail,
            'idEquipe' => $idEquipe
        ));
    }


    // Fonction qui retourne les joueurs
    public function getJoueur()
    {
        $req = $this->linkpdo->prepare('SELECT * FROM joueur');
        $req->execute();
        return $req;
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
        $req->execute(array(
            'idEquipe' => $idEquipe,
            'idGame' => $idGame
        ));
    }

    public function deleteJeuTournoi($idT, $idJ)
    {
        $req = $this->linkpdo->prepare('DELETE FROM concerner WHERE Id_Tournoi = :idT and Id_Jeu = :idJ');
        $req->execute(array(
            'idT' => $idT,
            'idJ' => $idJ
        ));
    }

    public function jeuNonPresentDansTournois($idT)
    {
        $req = $this->linkpdo->prepare('SELECT * FROM jeu WHERE Id_Jeu NOT IN (SELECT Id_Jeu FROM concerner WHERE Id_Tournoi = :idT)');
        $req->execute(array(
            'idT' => $idT
        ));
        return $req;
    }

    public function modifierTournoi($nom, $datedeb, $datefin, $type, $lieu, $pointMax, $id)
    {
        $req = $this->linkpdo->prepare('UPDATE tournoi SET Nom = :nom, Date_debut = :datedeb, Date_fin = :datefin, Type = :type, Lieu = :lieu, Nombre_point_max = :npm  WHERE Id_Tournoi = :idT');
        $req->execute(array(
            'nom' => $nom,
            'datedeb' => $datedeb,
            'datefin' => $datefin,
            'type' => $type,
            'lieu' => $lieu,
            'npm' => $pointMax,
            'idT' => $id
        ));
    }

    public function supprimerJeuxTournoi($idT)
    {
        $req = $this->linkpdo->prepare('DELETE FROM concerner WHERE Id_Tournoi = :idT');
        $req->execute(array(
            'idT' => $idT
        ));
    }

    public function supprimerTournoi($idT)
    {
        $req = $this->linkpdo->prepare('DELETE FROM tournoi WHERE Id_Tournoi = :idT');
        $req->execute(array(
            'idT' => $idT
        ));
    }

    public function getEquipeByIdEcurie($id)
    {
        $req = $this->linkpdo->prepare('SELECT * FROM  equipe WHERE ' . $id . ' = equipe.Id_Ecurie');
        $req->execute();
        return $req;
    }

    public function equipeByNom($id_ecurie)
    {
        $req = $this->linkpdo->prepare('SELECT * FROM  equipe WHERE Id_Ecurie = :id_ecurie ORDER BY Nom ASC');
        $req->execute(array(
            'id_ecurie' => $id_ecurie
        ));
        return $req;
    }

    public function equipeByPoint($id_ecurie)
    {
        $req = $this->linkpdo->prepare('SELECT * FROM  equipe WHERE Id_Ecurie = :id_ecurie ORDER BY Nb_pts_Champ DESC');
        $req->execute(array(
            'id_ecurie' => $id_ecurie
        ));
        return $req;
    }

    public function getEquipeByIdTournoi($id)
    {
        $req = $this->linkpdo->prepare('SELECT * FROM  equipe WHERE ' . $id . ' = equipe.Id_Tournoi');
        $req->execute();
        return $req;
    }


    public function getJoueurByIdEquipe($id)
    {
        $req = $this->linkpdo->prepare('SELECT * FROM  joueur WHERE ' . $id . ' = joueur.Id_Equipe');
        $req->execute();
        return $req;
    }

    public function getJeuByIdEquipe($idEquipe)
    {
        $req = $this->linkpdo->prepare('SELECT jeu.* FROM  jeu, equipe WHERE ' . $idEquipe . ' = equipe.Id_Equipe and jeu.Id_Jeu = equipe.Id_Jeu');
        $req->execute();
        return $req;
    }

    public function closeTournois($id)
    {
        $req = $this->linkpdo->prepare('UPDATE tournoi SET estFerme = 1 WHERE Id_Tournoi = :id');
        $req->execute(array(
            'id' => $id
        ));
    }

    public function addPoule($nom, $idTournoi, $idJeu)
    {
        $req = $this->linkpdo->prepare('INSERT INTO poule VALUES (NULL, :nom, :idTournoi, :idJeu)');
        $req->execute(array(
            'nom' => $nom,
            'idTournoi' => $idTournoi,
            'idJeu' => $idJeu
        ));
    }

    public function assignerPoule($idTournoi, $idPoule, $idEquipe)
    {
        $req = $this->linkpdo->prepare('UPDATE etre_inscrit SET id_poule = :idPoule WHERE id_Tournoi = :idTournoi AND id_Equipe = :idEquipe');
        $req->execute(array(
            'idPoule' => $idPoule,
            'idTournoi' => $idTournoi,
            'idEquipe' => $idEquipe
        ));
    }

    public function getIDPoule($idTournoi, $idJeu)
    {
        $req = $this->linkpdo->prepare('SELECT Id_Poule FROM poule WHERE id_Tournoi = :idTournoi AND id_jeu = :idJeu');
        $req->execute(array(
            'idTournoi' => $idTournoi,
            'idJeu' => $idJeu
        ));
        $idsPoules = array(); //Tableau qui contiendra les id des poules
        while ($datas = $req->fetch()) {
            array_push($idsPoules, $datas['Id_Poule']);
        }
        return $idsPoules;
    }

    //Equipe inscrites sur un tournoi en fonction d'un jeu
    public function getEquipeInscrites($idTournoi, $idJeu)
    {
        $req = $this->linkpdo->prepare('SELECT etre_inscrit.id_equipe FROM etre_inscrit, equipe WHERE id_Tournoi = :idTournoi AND etre_inscrit.id_Equipe = equipe.id_Equipe AND etre_inscrit.id_Jeu = :idJeu order by Nb_pts_Champ DESC');
        $req->execute(array(
            'idTournoi' => $idTournoi,
            'idJeu' => $idJeu
        ));
        $idsEquipes = array(); //Tableau qui contiendra les id des poules
        while ($datas = $req->fetch()) {
            array_push($idsEquipes, $datas['id_equipe']);
        }
        return $idsEquipes;
    }

    public function getIDJeuxTournoi($idTournoi)
    {
        $req = $this->linkpdo->prepare('SELECT Id_Jeu FROM concerner where id_Tournoi = :id');
        $req->execute(array(
            'id' => $idTournoi
        ));
        $idsJeux = array(); //Tableau qui contiendra les id des jeux
        while ($datas = $req->fetch()) {
            array_push($idsJeux, $datas['Id_Jeu']);
        }
        return $idsJeux;
    }



    public function getEquipeInscritesByPoule($idTournoi, $idJeu, $idPoule)
    {
        $req = $this->linkpdo->prepare('SELECT * FROM etre_inscrit WHERE id_Tournoi = :idTournoi AND id_Jeu = :idJeu AND id_poule = :idPoule');
        $req->execute(array(
            'idTournoi' => $idTournoi,
            'idJeu' => $idJeu,
            'idPoule' => $idPoule
        ));
        return $req;
    }

    public function addRencontre($idEquipe1, $idEquipe2, $idPoule)
    {
        $req = $this->linkpdo->prepare('INSERT INTO rencontre VALUES (NULL, :idEquipe1, :idEquipe2, :idPoule)');
        $req->execute(array(
            'idEquipe1' => $idEquipe1,
            'idEquipe2' => $idEquipe2,
            'idPoule' => $idPoule
        ));
    }

    public function tournoiIsClosed($idtournoi) {
        $req = $this->linkpdo->prepare('SELECT estFerme FROM tournoi WHERE Id_Tournoi = :id');
        $req->execute(array(
            'id' => $idtournoi
        ));
        $data = $req->fetch();
        if ($data['estFerme'] == 1) {
            return true;
        }
        return false;
    }

    public function tournoiIsFull($idtournoi) {
        // On récupère le nombre de jeux du tournoi
        $nbjeux = $this->linkpdo->prepare('SELECT count(*) FROM concerner WHERE id_Tournoi = :idTournoi');
        $nbjeux->execute(array(
            'idTournoi' => $idtournoi
        ));
        $nbjeux = $nbjeux->fetch();
        // On récupère le nombre d'équipe inscrite au tournoi
        $nbequipes = $this->linkpdo->prepare('SELECT count(*) FROM etre_inscrit WHERE id_Tournoi = :idTournoi');
        $nbequipes->execute(array(
            'idTournoi' => $idtournoi
        ));
        $nbequipes = $nbequipes->fetch();

        if ($nbjeux[0]*16 == $nbequipes[0]) {
            return true;
        }
        return false;
    }

    public function tournoiIscloseable($id) {
        $isClosed = $this->tournoiIsClosed($id);
        $isFull = $this->tournoiIsFull($id);
        if (!$isClosed && $isFull) {
            return true;
        }
        return false;
    }
}
