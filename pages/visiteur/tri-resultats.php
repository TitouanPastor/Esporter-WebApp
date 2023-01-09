<?php 
    
    class TriResultats{

        private $req;
        private $sql;
        private $nbTournois;


        public function __construct(){
            require_once('../../SQL.php');
            $this->sql = new requeteSQL();
            $this->req = $this->sql-> getTournoi();
            $this->nbTournois = $this->req->rowCount();
            $this->tournois = '';

            
        }

        

        //function qui affiche les résultat du championnat du monde
        public function afficherResultatCM($nom, $date_debut, $date_fin, $lieu, $type,$id){
            $req = $this->sql->getJeuxTournois($id);
            $str = '<article class="main-liste-article">
                        <span class="arrow" onclick="afficherDescriptionTournoi(this)">〉</span>
                        <div class="nodescription-tournoi">
                            <span class="title-tournoi" onclick="afficherDescriptionTournoi(this)"> ['.$type.'] '.$nom.'</span>
                        </div>
                        <div class="description-tournoi">
                            <p>Le tournoi se déroulera à '.$lieu.' du '.date('d/m/Y', strtotime($date_debut)).' au '.date('d/m/Y', strtotime($date_fin)).'.</p>
                            <p>Les jeu(x) présent(s) sont :</p>';
            
            while ($jeu = $req->fetch()) {
                $str .= '<p>- '.$jeu['Libelle'].'</p>';
            }

            $str.='</div></article>';
            return $str;
        }

        //function qui affiche les résultat du championnat du monde
        public function afficherResultatTournoi($nom, $date_debut, $date_fin, $lieu, $type,$id){
            $req = $this->sql->getJeuxTournois($id);
            $str = '<article class="main-liste-article">
                        <span class="arrow" onclick="afficherDescriptionTournoi(this)">〉</span>
                        <div class="nodescription-tournoi">
                            <span class="title-tournoi" onclick="afficherDescriptionTournoi(this)"> ['.$type.'] '.$nom.'</span>
                        </div>
                        <div class="description-tournoi">
                            <p>Le tournoi se déroulera à '.$lieu.' du '.date('d/m/Y', strtotime($date_debut)).' au '.date('d/m/Y', strtotime($date_fin)).'.</p>
                            <p>Les jeu(x) présent(s) sont :</p>';
            
            while ($jeu = $req->fetch()) {
                $str .= '<p>- '.$jeu['Libelle'].'</p>';
            }

            $str.='</div></article>';
            return $str;
        }

        public function afficherResultatsCM(){
            echo '<h1>Résultats du Championnat du Monde</h1>';
            while ($row = $this->req->fetch()){
                echo $this->afficherResultatCM($row['Nom'], $row['Date_debut'],$row['Date_fin'], $row['Lieu'], $row['Type'], $row['Id_Tournoi']);
            }
        }

        public function afficherResultatsTournois(){
            echo '<h1>Résultats de Tournois</h1>';
            while ($row = $this->req->fetch()){
                echo $this->afficherResultatTournoi($row['Nom'], $row['Date_debut'],$row['Date_fin'], $row['Lieu'], $row['Type'], $row['Id_Tournoi']);
            }
        }

        public function getNombreTournois(): int{
            return $this->nbTournois;
        }

        //Fonction trie les tournois par type
        public function trierParType(){
            $this->req = $this->sql->tournoisByType();
            $this->afficherResultatsCM();
        }

        //Fonction trie les tournois par lieu
        public function trierParLieu(){
            $this->req = $this->sql->tournoisByLieu();
            $this->afficherResultatsTournois();
        }

        //Fonction trie les tournois par nom
        public function trierParNom(){
            $this->req = $this->sql->tournoisByNom();
            $this->afficherResultatsCM();
        }

        //Fonction trie les tournois par id (filtre de base)
        public function trierParDate(){
            $this->req = $this->sql-> tournoisByDate();
            $this->afficherResultatsTournois();
        }

        //Fonction trie les tournois par id (filtre de base)
        public function trierParId(){
            $this->req = $this->sql-> getTournoi();
            $this->afficherResultatsCM();
        }






    }