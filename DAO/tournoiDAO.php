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

    public function getTournoiNomByIdTournoi($idTournoi)
    {
        $req = $this->linkpdo->prepare("SELECT nom FROM tournoi WHERE id_tournoi = :id_tournoi");
        $testReq = $req->execute(
            array(
                "id_tournoi" => $idTournoi
            )
        );
        if ($testReq == false) {
            die("Erreur getTournoiNomByIdTournoi");
        }
        return $req;
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
        $data = $req->fetch();  
        return $data['Id_Tournoi'];
        
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

    public function closeTournois($id)
    {
        $req = $this->linkpdo->prepare('UPDATE tournoi SET estFerme = 1 WHERE Id_Tournoi = :id');
        $req->execute(
            array(
                'id' => $id
            )
        );
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

    public function getIdJeu($libelle)
    {
        $req = $this -> linkpdo -> prepare("SELECT id_jeu FROM jeu where libelle = :libelle");
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

    public function getLastIDPoule()
    {
        $req = $this->linkpdo->prepare("SELECT MAX(Id_Poule) FROM poule");
        $req->execute();
        $datas = $req->fetch();
        return $datas['MAX(Id_Poule)'];
        
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
        $row = $req->fetch();
        return $row['id_Equipe'];
        
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
        $row = $req->fetch();
        return $row['nbMatchJouer'];
        
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

    public function getMultiplicateur($idTournoi)
    {
        $req = $this->linkpdo->prepare('SELECT Nombre_point_max FROM tournoi WHERE id_Tournoi = :idTournoi');
        $req->execute(
            array(
                'idTournoi' => $idTournoi
            )
        );

        $row = $req->fetch();
        return $row['Nombre_point_max'];
        
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

    public function terminerTournoi($idTournoi)
    {
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

}
