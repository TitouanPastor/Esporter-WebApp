<?php 
    
    class TriEcuries{

        private $req;
        private $sql;
        private $nbEcuries;


        public function triEcuries(){
            require_once('../../SQL.php');
            $this->sql = new requeteSQL();
            $this->req = $this->sql-> getEcurie();
            $this->nbEcuries = $this->req->rowCount();
            $this->ecuries = '';

            
        }

        

        //function qui affiche un tournoi
        public function afficherUneEcurie($nom, $type){
            $str = '<article class="main-liste-article" for="tournoicheckbox" onclick="afficherDescriptionTournoi(this)">
                        <span class="arrow">〉</span>
                        <div class="nodescription-tournoi">
                            <span class="title-tournoi"> ['.$type.'] '.$nom.'</span>
                            <div class="article-btns">
                                <a href="modification-tournoi.php?id='.$id.'">Modifier</a>
                                <a href="">Supprimer</a>
                            </div>
                        </div>
                    </article>';
        }

        public function afficherLesEcuries(){
            while ($row = $this->req->fetch()){
                echo $this->afficherUneEcurie($row['Nom'], $row['Statut']);
            }
        }

        public function getNombreEcuries(): int{
            return $this->nbEcuries;
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
