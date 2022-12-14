<?php

class TriEquipe
{

    private $req;
    private $sql;
    private $nbEcuries;
    private $id_ecurie;


    public function __construct($idEcurie)
    {
        require_once('../../SQL.php');
        $this->sql = new requeteSQL();
        $this->id_ecurie = $idEcurie;
        $this->req = $this->sql->getEquipeEcurie($this->id_ecurie);
        $this->nbEcuries = $this->req->rowCount();
        $this->ecuries = '';
    }



    //function qui affiche une écurie
    public function afficherUneEcurie($nom, $point, $id_equipe)
    {
        
        
        $str = '<article class="main-liste-article">    
            <span class="arrow" onclick="afficherDescriptionTournoi(this)">〉</span>
            <div class="nodescription-tournoi">
                <span class="title-tournoi" onclick="afficherDescriptionTournoi(this)"> ['.$nom.'] - '.$point.' points</span>
            </div>
            <div class="description-tournoi">';
            $str.='<div class=equipe_container>';
            $jeu = $this->sql->getJeuByIdEquipe($id_equipe);
            while ($je = $jeu->fetch()){
                $str .= '<p> L\'équipe joue sur le jeu : <strong>' . $je['Libelle'].'</strong></p><br><p> Les joueurs de l\'équipe : ';
            }
            $joueur  = $this->sql->getJoueurByIdEquipe($id_equipe);
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
        return $this->id_ecurie;
    }

    //Fonction trie les écuries par statut
    public function trierParPoint()
    {
        $this->req = $this->sql->equipeByPoint($this->id_ecurie);
        $this->afficherLesEcuries();
    }


    //Fonction trie les écuries par nom
    public function trierParNom()
    {
        $this->req = $this->sql->equipeByNom($this->id_ecurie);
        $this->afficherLesEcuries();
    }


    //Fonction trie les écuries par id (filtre de base)
    public function trierParId()
    {

        $this->req = $this->sql->getEquipeEcurie($this->id_ecurie);
        $this->afficherLesEcuries();
    }
}
