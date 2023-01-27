<?php

class TriEquipe
{

    private $req;
    private $sql;
    private $nbEcuries;
    private $idEcurie;


    public function __construct($idEcurie)
    {
        require_once('../../SQL.php');
        $this->sql = new requeteSQL();
        $this->idEcurie = $idEcurie;
        $this->req = $this->sql->getEquipeEcurie($this->idEcurie);
        $this->nbEcuries = $this->req->rowCount();
        
    }



    //function qui affiche une écurie
    public function afficherUneEcurie($nom, $point, $idEquipe)
    {
        
        
        $str = '<article class="main-liste-article">    
            <span class="arrow" onclick="afficherDescriptionTournoi(this)">〉</span>
            <div class="nodescription-tournoi">
                <span class="title-tournoi" onclick="afficherDescriptionTournoi(this)"> ['.$nom.'] - '.$point.' points</span>
            </div>
            <div class="description-tournoi">';
            $str.='<div class=equipe_container>';
            $jeu = $this->sql->getJeuByIdEquipe($idEquipe);
            while ($je = $jeu->fetch()){
                $str .= '<p> L\'équipe joue sur le jeu : <strong>' . $je['Libelle'].'</strong></p><br><p> Les joueurs de l\'équipe : ';
            }
            $joueur  = $this->sql->getJoueurByIdEquipe($idEquipe);
            while ($j = $joueur->fetch()){
                $str .=  '<p class="liste-joueur"> - '. $j["Pseudo"].' </p> ';
            }
            $str .='</p></br></div>   ';

           
                

        

        $str .= '</div></article>';
        return $str;
    }
    

    public function afficherLesEcuries()
    {
        while ($row = $this->req->fetch()) {
            echo $this->afficherUneEcurie($row['Nom'], $row['Nb_pts_Champ'], $row['Id_Equipe']);
        }
    }

    public function getNombreEcuries(): int
    {
        return $this->nbEcuries;
    }

    

    public function getIdEcure(): int
    {
        return $this->idEcurie;
    }

    //Fonction trie les écuries par statut
    public function trierParPoint()
    {
        $this->req = $this->sql->equipeByPoint($this->idEcurie);
        $this->afficherLesEcuries();
    }


    //Fonction trie les écuries par nom
    public function trierParNom()
    {
        $this->req = $this->sql->equipeByNom($this->idEcurie);
        $this->afficherLesEcuries();
    }


    //Fonction trie les écuries par id (filtre de base)
    public function trierParId()
    {

        $this->req = $this->sql->getEquipeEcurie($this->idEcurie);
        $this->afficherLesEcuries();
    }
}
