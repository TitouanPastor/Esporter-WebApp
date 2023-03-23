<?php

class PouleDAO
{

    private $linkpdo;

    public function __construct()
    {
        //Connexion to DB with singleton
        require_once('ConnectDB.php');
        $db = ConnectDB::getInstance();
        $this->linkpdo = $db->getConnection();
    }

    /**Getter */
    public function getPouleIdTournoi($idTournoi, $idJeu)
    {
        $req = $this->linkpdo->prepare("SELECT Id_Poule FROM poule WHERE id_tournoi = :id_tournoi AND id_jeu = :id_jeu");
        $testReq = $req->execute(
            array(
                "id_tournoi" => $idTournoi,
                "id_jeu" => $idJeu
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

    public function getPouleByIdTournoiIdJeu($idTournoi, $idJeu)
    {
        $req = $this->linkpdo->prepare("SELECT id_poule, libelle FROM poule WHERE id_tournoi = :id_tournoi AND id_jeu = :id_jeu");
        $testReq = $req->execute(
            array(
                "id_tournoi" => $idTournoi,
                "id_jeu" => $idJeu
            )
        );
        if ($testReq == false) {
            die('Erreur getPouleByIdTournoi');
        }
        return $req;
    }

    public function getIDPouleFinale($idTournoi, $idJeu)
    {
        $req = $this->linkpdo->prepare('SELECT id_Poule from poule where Id_Tournoi = :idTournoi and id_jeu = :idJeu and libelle = "Finale"');
        $testReq = $req->execute(
            array(
                "idTournoi" => $idTournoi,
                "idJeu" => $idJeu
            )
        );

        $datas = $req->fetchAll(PDO::FETCH_ASSOC);
        return $datas[0]['id_Poule'];
    }

    public function getNomPoule($idPoule)
    {
        $req = $this->linkpdo->prepare("SELECT libelle FROM poule WHERE id_poule = :id_poule");
        $testReq = $req->execute(
            array(
                "id_poule" => $idPoule
            )
        );
        if ($testReq == false) {
            die("Error getNomPoule");
        }
        return $req;
    }

    public function getRencontre($idPoule)
    {
        $req = $this->linkpdo->prepare("SELECT * FROM rencontre WHERE id_poule = :id_poule");
        $testReq = $req->execute(
            array(
                "id_poule" => $idPoule
            )
        );
        return $req;
    }

    public function getGagnantRencontre($idRencontre)
    {
        $req = $this->linkpdo->prepare("SELECT nom FROM rencontre, equipe WHERE equipe.id_equipe = rencontre.gagnant AND rencontre.id_rencontre = :id_rencontre");
        $testReq = $req->execute(
            array(
                "id_rencontre" => $idRencontre
            )
        );
        return $req;
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

        $testReq = $req->execute(
            array(
                "id_poule" => $idPoule
            )
        );
        return $req;
    }

    public function getPouleFinale($idTournoi, $idJeu)
    {
        $req = $this->linkpdo->prepare("SELECT id_Poule FROM poule WHERE id_tournoi = :id_tournoi AND id_jeu = :id_jeu AND libelle = 'Finale'");
        $testReq = $req->execute(
            array(
                "id_tournoi" => $idTournoi,
                "id_jeu" => $idJeu
            )
        );
        return $req->fetch();
    }



    /**SETTER */
    public function setGagnantRencontre($idRencontre, $idEquipe)
    {
        $req = $this->linkpdo->prepare("UPDATE rencontre SET gagnant = :id_equipe WHERE id_rencontre = :id_rencontre ");
        $testReq = $req->execute(
            array(
                "id_equipe" => $idEquipe,
                "id_rencontre" => $idRencontre
            )
        );
        if ($testReq == false) {
            die("erreur setGagnantRencontre");
            exit(2);
        }
        $this->addMatchGagne($idRencontre, $idEquipe);
        return $req;
    }

    public function setGagnantRencontreFinale($idRencontre, $idEquipe): void
    {
        $req = $this->linkpdo->prepare("UPDATE rencontre SET gagnant = :id_equipe WHERE id_rencontre = :id_rencontre ");
        $testReq = $req->execute(
            array(
                "id_equipe" => $idEquipe,
                "id_rencontre" => $idRencontre
            )
        );
        $this->addMatchGagne($idRencontre, $idEquipe);
    }

    /**ADD */
    public function addMatchGagne($idRencontre, $idEquipe)
    {
        $reqIdPoule = $this->linkpdo->prepare("SELECT id_poule FROM rencontre WHERE gagnant = :id_equipe and id_rencontre = :id_rencontre");
        $testReqIdPoule = $reqIdPoule->execute(
            array(
                "id_equipe" => $idEquipe,
                "id_rencontre" => $idRencontre
            )
        );
        $idPoule = $reqIdPoule->fetch()[0];

        $req = $this->linkpdo->prepare("UPDATE etre_inscrit SET nb_match_gagne = nb_match_gagne + 1 WHERE id_equipe = :id_equipe AND id_poule = :id_poule");
        $req->execute(
            array(
                "id_equipe" => $idEquipe,
                "id_poule" => $idPoule
            )
        );
    }

    public function getPouleBydIdTournoi($idTournoi)
    {
        $req = $this->linkpdo->prepare("SELECT id_poule FROM poule WHERE id_tournoi = :id_tournoi");
        $testReq = $req->execute(
            array(
                "id_tournoi" => $idTournoi
            )
        );
        if ($testReq == false) {
            die('Erreur getPouleByIdTournoi');
        }
        return $req;
    }

    public function isTournoiTermine($idTournoi)
    {
        $req = $this->getPouleBydIdTournoi($idTournoi)->fetchAll();
        foreach ($req as $poule) {
            if ($this->isPouleTermine($poule['id_poule']) == false) {
                return false;
            }
        }
        return true;
    }

    /**Boolean */
    public function isPouleTermine($idPoule)
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

    //fonction qui récupère les équipes d'une poule en triant par le nombre de match gagné   DESC
    public function getEquipesPoule($idPoule)
    {
        $req = $this->linkpdo->prepare("SELECT equipe.id_Equipe, etre_inscrit.nb_Match_Gagne FROM etre_inscrit, equipe WHERE etre_inscrit.id_equipe = equipe.id_equipe AND etre_inscrit.id_poule = :idPoule ORDER BY etre_inscrit.nb_match_gagne DESC");
        $testReq = $req->execute(
            array(
                "idPoule" => $idPoule
            )
        );
        return $req;
    }
}
