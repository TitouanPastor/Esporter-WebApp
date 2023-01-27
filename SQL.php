<?php

class requeteSQL
{

    private $linkpdo;


    //Fonction pour se connecter à la base de donnée PHPMyAdmin
    public function __construct()
    {
        ///Connexion au serveur MySQL avec PDO
        $server = '54.37.31.19';
        $login = 'u743447366_admin';
        $mdp = 'YAksklOw6qN$';
        $db = 'u743447366_esporter';

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
        $req->execute(
            array(
                'libelle' => $libelle
            )
        );
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
        $req->execute(
            array(
                'Id_Jeu' => $id
            )
        );

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

    //Fonction qui retourne toute les informations contenu dans le dernier tournoi inséré
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


    //Fonction qui permet de remplir l'association concerner
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


    //-------------Page Login


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


    //-----------------------------------------------------------------------------------------------------------------------------------------------------------------
    //Sprint 2 

    //-------------Page Enregistrer une écurie


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
        $req->execute(
            array(
                'mail' => $mail
            )
        );
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

    public function getTournoiCommence()
    {
        $req = $this->linkpdo->prepare("SELECT nom, date_debut, id_tournoi FROM tournoi where tournoi.date_debut < curdate()");
        $testReq = $req->execute();
        if ($testReq == false) {
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
            $testReq = $req->execute(array("libelle" => $param[2]));
            if ($testReq == false) {
                die('Erreur getTournoiCalendrier (SQL.php) execute 1');
            }
        } elseif ($param[0] == null and $param[2] == 'default') { // nom
            $req = $this->linkpdo->prepare('SELECT tournoi.nom, tournoi.date_debut, jeu.libelle FROM tournoi, jeu, concerner WHERE tournoi.id_tournoi = concerner.id_tournoi AND concerner.id_jeu = jeu.id_jeu AND tournoi.nom = :nom ORDER BY tournoi.date_debut');
            $testReq = $req->execute(array("nom" => $param[1]));
            if ($testReq == false) {
                die('Erreur getTournoiCalendrier (SQL.php) execute 2');
            }
        } elseif ($param[1] == 'default' and $param[2] == 'default') { //date
            $req = $this->linkpdo->prepare('SELECT tournoi.nom, tournoi.date_debut, jeu.libelle FROM tournoi, jeu, concerner WHERE tournoi.id_tournoi = concerner.id_tournoi AND concerner.id_jeu = jeu.id_jeu AND tournoi.date_debut > :date_tournoi ORDER BY tournoi.date_debut');
            $testReq = $req->execute(array("date_tournoi" => $param[0]));
            if ($testReq == null) {
                die('Erreur getTournoiCalendrier (SQL.php) execute 3');
            }
        } elseif ($param[0] == null) { // nom + jeu
            $req = $this->linkpdo->prepare('SELECT tournoi.nom, tournoi.date_debut, jeu.libelle from tournoi, jeu, concerner where tournoi.id_tournoi = concerner.id_tournoi and concerner.id_jeu = jeu.id_jeu and jeu.libelle = :libelle and tournoi.nom = :nom ORDER BY tournoi.date_debut');
            $testReq = $req->execute(array("libelle" => $param[2], "nom" => $param[1]));
            if ($testReq == false) {
                die('Erreur getTournoiCalendrier (SQL.php) execute 4');
            }
        } elseif ($param[1] == 'default') { // date + jeu
            $req = $this->linkpdo->prepare('SELECT tournoi.nom, tournoi.date_debut, jeu.libelle from tournoi, jeu, concerner where tournoi.id_tournoi = concerner.id_tournoi and concerner.id_jeu = jeu.id_jeu and jeu.libelle = :libelle and tournoi.date_debut > :date_tournoi ORDER BY tournoi.date_debut');
            $testReq = $req->execute(array("libelle" => $param[2], "date_tournoi" => $param[0]));
            if ($testReq == false) {
                die('Erreur getTournoiCalendrier (SQL.php) execute 5');
            }
        } elseif ($param[2] == 'default') { // date + nom
            $req = $this->linkpdo->prepare('SELECT tournoi.nom, tournoi.date_debut, jeu.libelle from tournoi, jeu, concerner where tournoi.id_tournoi = concerner.id_tournoi and concerner.id_jeu = jeu.id_jeu and tournoi.nom = :nom and tournoi.date_debut > :date_tournoi ORDER BY tournoi.date_debut');
            $testReq = $req->execute(array("nom" => $param[1], "date_tournoi" => $param[0]));
            if ($testReq == false) {
                die('Erreur getTournoiCalendrier (SQL.php) execute 6');
            }
        } else { // date + nom + jeu
            $req = $this->linkpdo->prepare('SELECT tournoi.nom, tournoi.date_debut, jeu.libelle from tournoi, jeu, concerner where tournoi.id_tournoi = concerner.id_tournoi and concerner.id_jeu = jeu.id_jeu and tournoi.nom = :nom and tournoi.date_debut > :date_tournoi and jeu.libelle = :libelle ORDER BY tournoi.date_debut');
            $testReq = $req->execute(array("date_tournoi" => $param[0], "nom" => $param[1], "libelle" => $param[2]));
            if ($testReq == false) {
                die('Erreur getTournoiCalendrier (SQL.php) execute 7');
            }
        }
        return $req;
    }


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

    public function updateClassementEquipe($idEquipe, $nbPoint)
    {
        $req = $this->linkpdo->prepare('UPDATE equipe SET Nb_pts_Champ = Nb_pts_Champ + :nbPoint  WHERE id_Equipe = :idEquipe');
        $req->execute(
            array(
                'idEquipe' => $idEquipe,
                'nbPoint' => $nbPoint
            )
        );
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

    public function modifierTournoi($nom, $datedeb, $datefin, $type, $lieu, $pointMax, $id)
    {
        $req = $this->linkpdo->prepare('UPDATE tournoi SET Nom = :nom, Date_debut = :datedeb, Date_fin = :datefin, Type = :type, Lieu = :lieu, Nombre_point_max = :npm  WHERE Id_Tournoi = :idT');
        $req->execute(
            array(
                'nom' => $nom,
                'datedeb' => $datedeb,
                'datefin' => $datefin,
                'type' => $type,
                'lieu' => $lieu,
                'npm' => $pointMax,
                'idT' => $id
            )
        );
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
        $req->execute(
            array(
                'id' => $id
            )
        );
    }

    public function addPoule($nom, $idTournoi, $idJeu)
    {
        $req = $this->linkpdo->prepare('INSERT INTO poule VALUES (NULL, :nom, :idTournoi, :idJeu)');
        $req->execute(
            array(
                'nom' => $nom,
                'idTournoi' => $idTournoi,
                'idJeu' => $idJeu
            )
        );
    }

    public function assignerPoule($idTournoi, $idPoule, $idEquipe)
    {
        $req = $this->linkpdo->prepare('UPDATE etre_inscrit SET id_poule = :idPoule WHERE id_Tournoi = :idTournoi AND id_Equipe = :idEquipe');
        $req->execute(
            array(
                'idPoule' => $idPoule,
                'idTournoi' => $idTournoi,
                'idEquipe' => $idEquipe
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

    //Equipe inscrites sur un tournoi en fonction d'un jeu
    public function getEquipeInscrites($idTournoi, $idJeu)
    {
        $req = $this->linkpdo->prepare('SELECT etre_inscrit.id_equipe FROM etre_inscrit, equipe WHERE id_Tournoi = :idTournoi AND etre_inscrit.id_Equipe = equipe.id_Equipe AND etre_inscrit.id_Jeu = :idJeu order by Nb_pts_Champ DESC');
        $req->execute(
            array(
                'idTournoi' => $idTournoi,
                'idJeu' => $idJeu
            )
        );
        $idsEquipes = array(); //Tableau qui contiendra les id des poules
        while ($datas = $req->fetch()) {
            array_push($idsEquipes, $datas['id_equipe']);
        }
        return $idsEquipes;
    }

    public function getIDJeuxTournoi($idTournoi)
    {
        $req = $this->linkpdo->prepare('SELECT Id_Jeu FROM concerner where id_Tournoi = :id');
        $req->execute(
            array(
                'id' => $idTournoi
            )
        );
        $idsJeux = array(); //Tableau qui contiendra les id des jeux
        while ($datas = $req->fetch()) {
            array_push($idsJeux, $datas['Id_Jeu']);
        }
        return $idsJeux;
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

    public function addRencontre($idEquipe1, $idEquipe2, $idPoule)
    {
        $req = $this->linkpdo->prepare('INSERT INTO rencontre VALUES (NULL, :idEquipe1, :idEquipe2, :idPoule, NULL)');
        $req->execute(
            array(
                'idEquipe1' => $idEquipe1,
                'idEquipe2' => $idEquipe2,
                'idPoule' => $idPoule
            )
        );
    }

    public function tournoiIsClosed($idtournoi)
    {
        $req = $this->linkpdo->prepare('SELECT estFerme FROM tournoi WHERE Id_Tournoi = :id');
        $req->execute(
            array(
                'id' => $idtournoi
            )
        );
        $data = $req->fetch();
        if ($data['estFerme'] == 1) {
            return true;
        }
        return false;
    }

    public function tournoiIsFull($idtournoi)
    {
        // On récupère le nombre de jeux du tournoi
        $nbjeux = $this->linkpdo->prepare('SELECT count(*) FROM concerner WHERE id_Tournoi = :idTournoi');
        $nbjeux->execute(
            array(
                'idTournoi' => $idtournoi
            )
        );
        $nbjeux = $nbjeux->fetch();
        // On récupère le nombre d'équipe inscrite au tournoi
        $nbequipes = $this->linkpdo->prepare('SELECT count(*) FROM etre_inscrit WHERE id_Tournoi = :idTournoi');
        $nbequipes->execute(
            array(
                'idTournoi' => $idtournoi
            )
        );
        $nbequipes = $nbequipes->fetch();

        if ($nbjeux[0] * 16 == $nbequipes[0]) {
            return true;
        }
        return false;
    }

    public function tournoiIscloseable($id)
    {
        $isClosed = $this->tournoiIsClosed($id);
        $isFull = $this->tournoiIsFull($id);
        if (!$isClosed && $isFull) {
            return true;
        }
        return false;
    }

    public function getTournoiNomByIdTournoi($id_tournoi)
    {
        $req = $this->linkpdo->prepare("SELECT nom FROM tournoi WHERE id_tournoi = :id_tournoi");
        $testReq = $req->execute(
            array(
                "id_tournoi" => $id_tournoi
            )
        );
        if ($testReq == false) {
            die("Erreur getTournoiNomByIdTournoi");
        }
        return $req;

    }


    //renvoie les id et libelle des poule correspondant au tournoi voulu (id_tournoi)
    public function getPouleByIdTournoi($id_tournoi)
    {
        $req = $this->linkpdo->prepare("SELECT id_poule, libelle FROM poule WHERE id_tournoi = :id_tournoi");
        $testReq = $req->execute(
            array(
                "id_tournoi" => $id_tournoi
            )
        );
        if ($testReq == false) {
            die('Erreur getPouleByIdTournoi');
        }
        return $req;
    }

    public function getPouleIdTournoi($id_tournoi)
    {
        $req = $this->linkpdo->prepare("SELECT Id_Poule FROM poule WHERE id_tournoi = :id_tournoi");
        $testReq = $req->execute(
            array(
                "id_tournoi" => $id_tournoi
            )
        );
        if ($testReq == false) {
            die('Erreur getPouleByIdTournoi');
        }
        $idsPoule = array();
        while ($datas = $req->fetch()) {
            array_push($idsPoule, $datas['Id_Poule']);
        }
        return $idsPoule;
    }

    public function getNomPoule($id_poule)
    {
        $req = $this->linkpdo->prepare("SELECT libelle FROM poule WHERE id_poule = :id_poule");
        $testReq = $req->execute(
            array(
                "id_poule" => $id_poule
            )
        );
        if ($testReq == false) {
            die("Error getNomPoule");
        }
        return $req;
    }

    public function getRencontre($id_poule)
    {
        $req = $this->linkpdo->prepare("SELECT * FROM rencontre WHERE id_poule = :id_poule");
        $testReq = $req->execute(
            array(
                "id_poule" => $id_poule
            )
        );
        return $req;
    }

    public function getNomEquipeById($id_equipe)
    {
        $req = $this->linkpdo->prepare("SELECT nom FROM equipe WHERE id_equipe = :id_equipe");
        $testReq = $req->execute(
            array(
                "id_equipe" => $id_equipe
            )
        );
        if ($testReq == false) {
            die("Erreur getNomEquipeById");
        }
        return $req;
    }

    public function getEquipeByIdPoule($id_poule)
    {
        $req = $this->linkpdo->prepare("SELECT id_equipe, nom FROM equipe, etre_inscrit WHERE equipe.id_equipe = etre_inscrit.id_equipe AND etre_inscrit.id_poule = :id_poule ");
        $testReq = $req->execute(
            array(
                "id_poule" => $id_poule
            )
        );
        if ($testReq == false) {
            die('Erreur getEquipeByIdPoule');
        }
        return $req;
    }

    public function getEquipePouleTrie1($id_poule)
    {
        $req = $this->linkpdo->prepare("SELECT equipe.nom, etre_inscrit.nb_match_gagne FROM equipe, etre_inscrit WHERE equipe.id_equipe = etre_inscrit.id_equipe ANd etre_inscrit.id_poule = :id_poule ORDER BY nb_match_gagne desc");
        $testReq = $req->execute(
            array(
                "id_poule" => $id_poule
            )
        );
        if ($testReq == false) {
            die("Error getEquipePouleTrie");
        }
        return $req;
    }

    public function getRencontrePoule($id_poule)
    {
        $req = $this->linkpdo->prepare("SELECT rencontre.id_equipe, id_equipe1 FROM rencontre, equipe WHERE id_poule = :id_poule");
        $testReq = $req->execute(
            array(
                "id_poule" => $id_poule
            )
        );
        if ($testReq == false) {
            die('Error getRencontrePoule');
        }
        return $req;
    }

    public function getEquipeRencontre($id_rencontre)
    {
        $req = $this->linkpdo->prepare("SELECT nom FROM equipe, rencontre WHERE rencontre.id_rencontre = :id_rencontre");
        $testReq = $req->execute(
            array(
                "id_rencontre" => $id_rencontre
            )
        );
        if ($testReq == false) {
            die('Error getEquipeRencontre');
        }
        return $req;
    }

    public function addMatchGagne($id_rencontre, $id_equipe)
    {
        $reqIdPoule = $this->linkpdo->prepare("SELECT id_poule FROM rencontre WHERE gagnant = :id_equipe");
        $testReqIdPoule = $reqIdPoule->execute(
            array(
                "id_equipe" => $id_equipe
            )
        );

        $idPoule = $reqIdPoule->fetch()[0];

        $req = $this->linkpdo->prepare("UPDATE etre_inscrit SET nb_match_gagne = nb_match_gagne + 1 WHERE id_equipe = :id_equipe AND id_poule = :id_poule");
        $testReq = $req->execute(
            array(
                "id_equipe" => $id_equipe,
                "id_poule" => $idPoule
            )
        );
    }

    public function setGagnantRencontre($id_rencontre, $id_equipe)
    {
        $req = $this->linkpdo->prepare("UPDATE rencontre SET gagnant = :id_equipe WHERE id_rencontre = :id_rencontre ");
        $testReq = $req->execute(
            array(
                "id_equipe" => $id_equipe,
                "id_rencontre" => $id_rencontre
            )
        );
        if ($testReq == false) {
            die("erreur setGagnantRencontre");
            exit(2);
        }
        $this->addMatchGagne($id_rencontre, $id_equipe);
        return $req;
    }

    public function setGagnantRencontreFinale($id_rencontre, $id_equipe)
    {
        $req = $this->linkpdo->prepare("UPDATE rencontre SET gagnant = :id_equipe WHERE id_rencontre = :id_rencontre ");
        $testReq = $req->execute(
            array(
                "id_equipe" => $id_equipe,
                "id_rencontre" => $id_rencontre
            )
        );
    }

    public function getGagnantRencontre($id_rencontre)
    {
        $req = $this->linkpdo->prepare("SELECT nom FROM rencontre, equipe WHERE equipe.id_equipe = rencontre.gagnant AND rencontre.id_rencontre = :id_rencontre");
        $testReq = $req->execute(
            array(
                "id_rencontre" => $id_rencontre
            )
        );
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

    public function getLastIDPoule()
    {
        $req = $this->linkpdo->prepare("SELECT MAX(Id_Poule) FROM poule");
        $req->execute();
        while ($datas = $req->fetch()) {
            return $datas['MAX(Id_Poule)'];
        }
    }

    public function getResultatFinaux($idPoule)
    {
        $req = $this->linkpdo->prepare("SELECT equipe.id_equipe, count(gagnant), nom FROM rencontre, equipe WHERE rencontre.id_equipe = equipe.id_equipe AND id_Poule = :idPoule group by gagnant order by 2 desc");
        $testReq = $req->execute(
            array(
                "idPoule" => $idPoule
            )
        );
        return $req;
    }

    public function pouleFinaleTerminer($idPoule)
    {
        $req = $this->linkpdo->prepare("SELECT count(*) FROM rencontre WHERE id_Poule = :idPoule and gagnant is null");
        $testReq = $req->execute(
            array(
                "idPoule" => $idPoule
            )
        );
        $datas = $req->fetch();
        if ($datas['count(*)'] == 0) {
            return true;
        }
        return false;
    }

    public function getIDPouleFinale($idTournoi, $idJeu)
    {
        $req = $this->linkpdo->prepare('SELECT Id_Poule from poule where Id_Tournoi = :idTournoi and id_jeu = :idJeu and libelle = "Finale"');
        $testReq = $req->execute(
            array(
                "idTournoi" => $idTournoi,
                "idJeu" => $idJeu
            )
        );

        while ($datas = $req->fetch()) {
            print_r($datas['Id_Poule']);
            return $datas['Id_Poule'];
        }
    }


    public function terminerTournoi($idTournoi){
        $req = $this->linkpdo->prepare("UPDATE tournoi SET estFerme = 2 WHERE id_tournoi = :idTournoi");
        $req->execute(array(
            'idTournoi' => $idTournoi
        ));
    }

    public function isTournoiTermine($idTournoi)
    {
        $req = $this->linkpdo->prepare("SELECT estFerme FROM tournoi WHERE id_Tournoi = :idTournoi");
        $testReq = $req->execute(
            array(
                "idTournoi" => $idTournoi
            )
        );
        $datas = $req->fetch();
        if ($datas['estFerme'] == 2) {
            return true;
        }
        return false;
    }

    public function getPerdantFinale($idPoule)
    {
        $req = $this->linkpdo->prepare('select distinct id_Equipe from rencontre where Id_Poule = :idPoule and id_Equipe not in ( SELECT id_Equipe FROM rencontre WHERE id_Poule = :idPoule group by gagnant) union select DISTINCT Id_Equipe_1 from rencontre where Id_Poule = :idPoule and Id_Equipe_1 not in ( SELECT id_equipe FROM rencontre WHERE id_Poule = :idPoule group by gagnant);');
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

    public function getEquipePouleTrie($idPoule)
    {
        $req = $this->linkpdo->prepare("
        SELECT 
            e.nom as nom_equipe,
            SUM(CASE WHEN r.gagnant = e.id_equipe THEN 1 ELSE 0 END) as matchs_gagnes
        FROM 
            equipe e
            LEFT JOIN rencontre r ON e.id_equipe = r.id_equipe OR e.id_equipe = r.id_equipe_1
        WHERE 
            r.id_poule = :id_poule
        GROUP BY
            e.nom
        Order by 
            matchs_gagnes
        DESC");

        $testReq = $req -> execute(
            array(
                "id_poule" => $idPoule
            )
        );
        return $req;
    }


}