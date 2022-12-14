<?php

class TriEcuries
{

    private $req;
    private $sql;
    private $nbEcuries;


    public function __construct()
    {
        require_once('../../SQL.php');
        $this->sql = new requeteSQL();
        $this->req = $this->sql->getEcurie();
        $this->nbEcuries = $this->req->rowCount();
        $this->ecuries = '';
    }



    //function qui affiche une écurie
    public function afficherUneEcurie($nom, $statut, $id)
    {
        $req = $this->sql->getEquipeByIdEcurie($id);

        $str = '<article class="main-liste-article">    
            <span class="arrow" onclick="afficherDescriptionTournoi(this)">〉</span>
            <div class="nodescription-tournoi">
                <span class="title-tournoi" onclick="afficherDescriptionTournoi(this)">['.$statut.'] '.$nom.'</span>
            </div>
            <div class="description-tournoi">';
            while ($idEq = $req->fetch()) {
                $str.='<div class=equipe_container>';
                $id_equipe = $idEq['Id_Equipe'];
                $str.='<p>Nom de l\'équipe : <strong>' . $idEq['Nom'] . '</strong></p>';
                $jeu = $this->sql->getJeuByIdEquipe($id_equipe);
                while ($je = $jeu->fetch()){
                    $str .= '<p> Jeu de l\'équipe: <strong>' . $je['Libelle'].'</strong></p><br><p> Joueurs : ';
                }
                $joueur  = $this->sql->getJoueurByIdEquipe($id_equipe);
                while ($j = $joueur->fetch()){
                    $str .=  '<p class="liste-joueur"> - '. $j["Pseudo"].' </p> ';
                }
                $str .='</p></br></div>   ';
            }
                

        

        $str .= '</div></article>';
        return $str;
    }
    

    public function afficherLesEcuries()
    {
        while ($row = $this->req->fetch()) {
            echo $this->afficherUneEcurie($row['Nom'], $row['Statut'], $row['Id_Ecurie']);
        }
    }

    public function getNombreEcuries(): int
    {
        return $this->nbEcuries;
    }

    //Fonction trie les écuries par statut
    public function trierParStatut()
    {
        $this->req = $this->sql->ecuriesByStatut();
        $this->afficherLesEcuries();
    }


    //Fonction trie les écuries par nom
    public function trierParNom()
    {
        $this->req = $this->sql->ecuriesByNom();
        $this->afficherLesEcuries();
    }


    //Fonction trie les écuries par id (filtre de base)
    public function trierParId()
    {
        $this->req = $this->sql->getEcurie();
        $this->afficherLesEcuries();
    }
}
