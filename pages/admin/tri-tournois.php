<?php 
    
    class TriTournois{

        private $req;
        private $sql;
        private $nbTournoi;


        public function triTournois(){
            require_once('../../SQL.php');
            $this->sql = new requeteSQL();
            $this->req = $this->sql-> getTournoi();
            $this->nbTournois = $this->req->rowCount();
            $this->tournois = '';

            
        }

        

        //function qui affiche un tournoi
        public function afficherUnTournoi($nom, $date_debut, $lieu, $jeux, $type,$id){
            return 
                    '<article class="main-liste-article" for="tournoicheckbox" onclick="afficherDescriptionTournoi(this)">
                        <span class="arrow">〉</span>
                        <div class="nodescription-tournoi">
                            <span class="title-tournoi"> ['.$type.'] '.$nom.'</span>
                            <div class="article-btns">
                                <a href="modification-tournoi.php?id='.$id.'">Modifier</a>
                                <a href="">Supprimer</a>
                            </div>
                        </div>
                        <div class="description-tournoi">
                            <p>Le tournoi se déroulera le '.$date_debut.'</p>
                            <p>Le tournoi se déroulera à '.$lieu.'</p>
                            <p>Le tournoi se déroulera sur le jeu de société "Le jeu de la vie"</p>
                        </div>
                    </article>';
        }

        public function afficherLesTournois(){
            while ($row = $this->req->fetch()){
                echo $this->afficherUnTournoi($row['Nom'], $row['Date_debut'], $row['Lieu'], '0', $row['Type'], $row['Id_Tournoi']);
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
        public function trierParId(){
            $this->req = $this->sql-> getTournoi();
            $this->afficherLesTournois();
        }


    }


?>