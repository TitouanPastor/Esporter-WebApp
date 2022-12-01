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

        

        //function qui affiche une écurie
        public function afficherUneEcurie($nom, $statut,$id){
            $str = '<article class="main-liste-article" for="tournoicheckbox" onclick="afficherDescriptionTournoi(this)">
                        <div class="nodescription-tournoi">
                            <span class="title-tournoi"> ['.$statut.'] '.$nom.'</span>
                            <div class="article-btns">
                                <a href="liste-ecuries.php?id='.$id.'">Détails</a>
                            </div>
                        </div>
                    </article>';
            return $str;
        }

        public function afficherLesEcuries(){
            while ($row = $this->req->fetch()){
                echo $this->afficherUneEcurie($row['Nom'], $row['Statut'], $row['Id_Ecurie']);
            }
        }

        public function getNombreEcuries(): int{
            return $this->nbEcuries;
        }

        //Fonction trie les écuries par statut
        public function trierParStatut(){
            $this->req = $this->sql->ecuriesByStatut();
            $this->afficherLesEcuries();
        }


        //Fonction trie les écuries par nom
        public function trierParNom(){
            $this->req = $this->sql->ecuriesByNom();
            $this->afficherLesEcuries();
        }


        //Fonction trie les écuries par id (filtre de base)
        public function trierParId(){
            $this->req = $this->sql-> getEcurie();
            $this->afficherLesEcuries();
        }




    }
