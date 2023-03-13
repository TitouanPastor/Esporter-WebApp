<?php 
    
    class TriTournois{

        private $req;
        private $sql;
        private $nbTournois;


        public function __construct(){
            require_once('../../DAO/tournoiDAO.php');
            $this->sql = new tournoiDAO();
            $this->req = $this->sql-> getTournoi();
            $this->nbTournois = $this->req->rowCount();
        }

        //function qui affiche un tournoi
        public function afficherUnTournoi($nom, $dateDebut, $dateFin, $lieu, $type,$id){
            $req = $this->sql->getJeuxTournois($id);
            $str = '<article class="main-liste-article">
                        <span class="arrow" onclick="afficherDescriptionTournoi(this)">〉</span>
                        <div class="nodescription-tournoi">
                            <span class="title-tournoi" onclick="afficherDescriptionTournoi(this)"> ['.$type.'] '.$nom.'</span>
                            <div class="article-btns">
                            ';
                            if (!$this->sql->tournoiIsClosed($id)) {
                                $str .= '<a href="modification-tournoi-controller.php?id='.$id.'">Modifier</a>';
                            } else {
                                $str .= '<span style="color: #FF0032;" >Tournoi fermé</span>';
                            }
                            if ($this->sql->tournoiIscloseable($id)) {
                                $str .= '<a style="text-decoration: underline;cursor:pointer;" value="liste-tournois-controller.php?close_id='.$id.'" onclick="openPopUp(this)">Fermer les inscriptions</a>';
                            };
                            $str .= '
                            </div>
                        </div>
                        <div class="description-tournoi">
                            <p>Le tournoi se déroulera à '.$lieu.' du '.date('d/m/Y', strtotime($dateDebut)).' au '.date('d/m/Y', strtotime($dateFin)).'.</p>
                            <p>Les jeu(x) présent(s) sont :</p>';
            
            while ($jeu = $req->fetch()) {
                $str .= '<p>- '.$jeu['Libelle'].'</p>';
            }

            $str.='</div></article>';
            return $str;
        }

        public function afficherLesTournois(){
            $html = '';
            while ($row = $this->req->fetch()){
                $html .= $this->afficherUnTournoi($row['Nom'], $row['Date_debut'],$row['Date_fin'], $row['Lieu'], $row['Type'], $row['Id_Tournoi']);
            }

            return $html;
        }

        public function getNombreTournois(): int{
            return $this->nbTournois;
        }

        //Fonction trie les tournois par type
        public function trierParType(){
            $this->req = $this->sql->tournoisByType();
            return $this->afficherLesTournois();
        }

        //Fonction trie les tournois par lieu
        public function trierParLieu(){
            $this->req = $this->sql->tournoisByLieu();
            return $this->afficherLesTournois();
        }

        //Fonction trie les tournois par nom
        public function trierParNom(){
            $this->req = $this->sql->tournoisByNom();
            return $this->afficherLesTournois();
        }

        //Fonction trie les tournois par id (filtre de base)
        public function trierParDate(){
            $this->req = $this->sql-> tournoisByDate();
            return $this->afficherLesTournois();
        }

        //Fonction trie les tournois par id (filtre de base)
        public function trierParId(){
            $this->req = $this->sql-> getTournoi();
            return $this->afficherLesTournois();
        }








    }
