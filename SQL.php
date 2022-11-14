<?php
        
    class requeteSQL{

        private $linkpdo;

        public function __construct(){
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

        //Fonction pour ajouter un arbitre
        public function addTournoi($Type, $nom, $date_deb, $date_fin, $notoriete, $lieu, $nbPtsMax, $IdGestionnaireEsport, $idArbitre){
            $req = $this->linkpdo->prepare('INSERT INTO tournoi VALUES (NULL, :TypeT, :Nom, :Date_debut, :Date_fin, :Notoriete, :Lieu, :NbPtsMax, :IdGestionnaireEsport, :IdArbitre)');
            $req->execute(array(
                'TypeT' => $Type,
                'Nom' => $nom,
                'Date_debut' => $date_deb,
                'Date_fin' => $date_fin,
                'Notoriete' => $notoriete,
                'Lieu' => $lieu,
                'NbPtsMax' => $nbPtsMax,
                'IdGestionnaireEsport' => $IdGestionnaireEsport,
                'IdArbitre' => $idArbitre
            ));
        }

        //Fonction qui retourne les tournois
        public function getTournoi(){
            $req = $this->linkpdo->prepare('SELECT * FROM tournoi');
            $req->execute();
            return $req;
        }

        public function filtreTournoisByType(){
            
        }
        

        public function getTou

        //Fonction qui retourne le dernier tuple de tournoi
        public function getLastIDTournoi(){
            $req = $this->linkpdo->prepare('SELECT Id_Tournoi FROM tournoi ORDER BY Id_Tournoi DESC LIMIT 1');
            $req->execute();
            while ($data = $req->fetch()){
                return $data['Id_Tournoi'];
            }
        }

        //Fonction pour ajouter un arbitre
        public function addArbitre($login, $mdp){
            $req = $this->linkpdo->prepare('INSERT INTO arbitre VALUES (NULL, :login, :mdp)');
            $req->execute(array(
                'login' => $login,
                'mdp' => $mdp
            ));
        }

        //Fonction qui retourne les arbitres
        public function getArbitre(){
            $req = $this->linkpdo->prepare('SELECT * FROM arbitre');
            $req->execute();
            return $req;
        }

        // Fonction pour ajouter un gestionnaire Esporter
        public function addGestionnaire($login, $mdp){
            $req = $this->linkpdo->prepare('INSERT INTO gestionnaire VALUES (NULL, :login, :mdp)');
            $req->execute(array(
                'login' => $login,
                'mdp' => $mdp
            ));
        }

        //Fonction qui retourne les gestionnaires Esporter
        public function getGestionnaire(){
            $req = $this->linkpdo->prepare('SELECT * FROM gestionnaire');
            $req->execute();
            return $req;
        }

        //Fonction pour ajouter une ecurie
        public function addEcurie($Nom, $Statut, $login, $mdp, $mail, $id_gestionnaireEsport){
            $req = $this->linkpdo->prepare('INSERT INTO ecurie VALUES (NULL, :Nom, :Statut, :login, :mdp, :mail, :id_gestionnaireEsport)');
            $req->execute(array(
                'Nom' => $Nom,
                'Statut' => $Statut,
                'login' => $login,
                'mdp' => $mdp,
                'mail' => $mail,
                'id_gestionnaireEsport' => $id_gestionnaireEsport
            ));
        }

        //Fonction qui retourne les ecuries
        public function getEcurie(){
            $req = $this->linkpdo->prepare('SELECT * FROM ecurie');
            $req->execute();
            return $req;
        }

        //Fonction pour ajouter un jeu
        public function addJeu($libelle){
            $req = $this->linkpdo->prepare('INSERT INTO jeu VALUES (NULL, :libelle)');
            $req->execute(array(
                'libelle' => $libelle
            ));
        }

        //Fonction qui retourne les jeux
        public function getJeu(){
            $req = $this->linkpdo->prepare('SELECT * FROM jeu');
            $req->execute();
            return $req;
        }

        //Fonction pour ajouter une equipe
        public function addEquipe($nom, $login, $mdp, $mail, $nbPtsChamps, $id_ecurie, $id_jeu){
            $req = $this->linkpdo->prepare('INSERT INTO equipe VALUES (NULL, :nom, :login, :mdp, :mail, :nbPtsChamps, :id_ecurie, :id_jeu)');
            $req->execute(array(
                'nom' => $nom,
                'login' => $login,
                'mdp' => $mdp,
                'mail' => $mail,
                'nbPtsChamps' => $nbPtsChamps,
                'id_ecurie' => $id_ecurie,
                'id_jeu' => $id_jeu
            ));
        }

        // Fonction qui retourne les equipes
        public function getEquipe(){
            $req = $this->linkpdo->prepare('SELECT * FROM equipe');
            $req->execute();
            return $req;
        }

        //Fonction pour ajouter une poule 
        public function addPoule($libelle, $idTournoi){
            $req = $this->linkpdo->prepare('INSERT INTO poule VALUES (NULL, :libelle, :idTournoi)');
            $req->execute(array(
                'libelle' => $libelle,
                'idTournoi' => $idTournoi
            ));
        }

        // Fonction qui retourne les poules
        public function getPoule(){
            $req = $this->linkpdo->prepare('SELECT * FROM poule');
            $req->execute();
            return $req;
        }

        //Fonction pour ajouter un joueur
        public function addJoueur($nom, $prenom, $dateNaissance, $pseudo, $mail, $idEquipe){
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
        public function getJoueur(){
            $req = $this->linkpdo->prepare('SELECT * FROM joueur');
            $req->execute();
            return $req;
        }

        //Fonction pour ajouter un match
        public function addGame($dateMatch, $idEquipe1, $idEquipe2, $idPoule){
            $req = $this->linkpdo->prepare('INSERT INTO game VALUES (NULL, :dateMatch, :idEquipe1, :idEquipe2, :idPoule)');
            $req->execute(array(
                'dateMatch' => $dateMatch,
                'idEquipe1' => $idEquipe1,
                'idEquipe2' => $idEquipe2,
                'idPoule' => $idPoule
            ));
        }

        // Fonction qui retourne les matchs
        public function getGame(){
            $req = $this->linkpdo->prepare('SELECT * FROM game');
            $req->execute();
            return $req;
        }

        
        public function addRegrouper($idEquipe,$idGame){
            $req = $this->linkpdo->prepare('INSERT INTO regrouper VALUES (:idEquipe, :idGame)');
            $req->execute(array(
                'idEquipe' => $idEquipe,
                'idGame' => $idGame
            ));
        } 

        public function addConcerner($idTournoi, $idJeu){
            $req = $this->linkpdo->prepare('INSERT INTO concerner VALUES (:idTournoi, :idJeu)');
            $req->execute(array(
                'idTournoi' => $idTournoi,
                'idJeu' => $idJeu
            ));
        }
        
    }
?>