<?php 
    
    class TriTournois{

        private $req;
        private $nbTournoi;
        private $tournois;

        public function triTournois(){
            require_once('../../SQL.php');
            $sql = new requeteSQL();
            $this->req = $sql->getTournoi();
            $this->nbTournois = $this->req->rowCount();
            $this->tournois = '';

            
        }

        

        //function qui affiche un tournoi
        public function afficherUnTournoi($nom, $date_debut, $lieu, $jeux, $type){
            $this->tournois += '<article class="main-liste-article" for="tournoicheckbox" onclick="afficherDescriptionTournoi(this)">
                        <span class="arrow">〉</span>
                        <div class="nodescription-tournoi">
                            <span class="title-tournoi"> ['.$type.'] '.$nom.'</span>
                            <div class="article-btns">
                                <a href="">Modifier</a>
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
                echo $row['Nom'], $row['Date_debut'], $row['Lieu'], 0, $row['Type'];
                $this->afficherUnTournoi($row['Nom'], $row['Date_debut'], $row['Lieu'], '0', $row['Type']);
            }
            return $this->tournois;
        }

        public function getNombreTournois(): int{
            return $this->nbTournois;
        }


    }


?>