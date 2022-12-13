<?php 
    
    class TriTournois{

        private $req;
        private $sql;
        private $nbTournois;


        public function triTournois(){
            require_once('../../SQL.php');
            $this->sql = new requeteSQL();
            $this->req = $this->sql-> getTournoi();
            $this->nbTournois = $this->req->rowCount();
            $this->tournois = '';

            
        }

        

        //function qui affiche un tournoi
        public function afficherUnTournoi($nom, $date_debut, $date_fin, $lieu, $type,$id){
            $req = $this->sql->getJeuxTournois($id);
            $str = '<article class="main-liste-article">
                        <span class="arrow" onclick="afficherDescriptionTournoi(this)">〉</span>
                        <div class="nodescription-tournoi">
                            <span class="title-tournoi" onclick="afficherDescriptionTournoi(this)"> ['.$type.'] '.$nom.'</span>
                            <div class="article-btns">
                                <a href="modification-tournoi.php?id='.$id.'">Modifier</a>
                                <a href="fermer-tournoi.php?id='.$id.'">Fermer les inscriptions</a>
                            </div>
                        </div>
                        <div class="description-tournoi">
                            <p>Le tournoi se déroulera à '.$lieu.' du '.$date_debut.' au '.$date_fin.'.</p>
                            <p>Les jeu(x) présent(s) sont :</p>';
            
            while ($jeu = $req->fetch()) {
                $str .= '<p>- '.$jeu['Libelle'].'</p>';
            }

            $str.='</div></article>';
            return $str;
        }

        public function afficherLesTournois(){
            while ($row = $this->req->fetch()){
                echo $this->afficherUnTournoi($row['Nom'], $row['Date_debut'],$row['Date_fin'], $row['Lieu'], $row['Type'], $row['Id_Tournoi']);
            }
        }

        public function getNombreTournois(): int{
            return $this->nbTournois;
        }

        //Fonction trie les tournois par type
        public function trierParType(){
            $this->req = $this->sql->tournoisByType();
            $this->afficherLesTournois();
        }

        //Fonction trie les tournois par lieu
        public function trierParLieu(){
            $this->req = $this->sql->tournoisByLieu();
            $this->afficherLesTournois();
        }

        //Fonction trie les tournois par nom
        public function trierParNom(){
            $this->req = $this->sql->tournoisByNom();
            $this->afficherLesTournois();
        }

        //Fonction trie les tournois par id (filtre de base)
        public function trierParDate(){
            $this->req = $this->sql-> tournoisByDate();
            $this->afficherLesTournois();
        }

        //Fonction trie les tournois par id (filtre de base)
        public function trierParId(){
            $this->req = $this->sql-> getTournoi();
            $this->afficherLesTournois();
        }






    }
