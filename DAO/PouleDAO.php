<?php

    class PouleDAO {

        private $linkpdo;

        public function __construct()
        {
            //Connexion to DB
            require_once('connectDB.php');
            $sql = new connectDB();
            $this->linkpdo = $sql->getConnection();
        }
        
        public function getPouleIdTournoi($idTournoi)
        {
            $req = $this->linkpdo->prepare("SELECT Id_Poule FROM poule WHERE id_tournoi = :id_tournoi");
            $testReq = $req->execute(
                array(
                    "id_tournoi" => $idTournoi
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

        public function addMatchGagne($idRencontre, $idEquipe)
        {
            $reqIdPoule = $this->linkpdo->prepare("SELECT id_poule FROM rencontre WHERE gagnant = :id_equipe");
            $testReqIdPoule = $reqIdPoule->execute(
                array(
                    "id_equipe" => $idEquipe
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


    }   

?>