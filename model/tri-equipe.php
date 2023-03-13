<?php

class TriEquipe
{

    private $req;
    private $ecurieModel;
    private $nbEcuries;
    private $idEcurie;


    public function __construct($idEcurie)
    {
        require_once('../../DAO/EcurieDAO.php');
        $this->ecurieModel = new Ecurie();
        $this->idEcurie = $idEcurie;
        $this->req = $this->ecurieModel->getEquipeEcurie($this->idEcurie);
        $this->nbEcuries = $this->req->rowCount();
    }



    //function qui affiche une écurie
    public function afficherUneEcurie($nom, $point, $idEquipe)
    {
        $str = '<article class="main-liste-article">    
            <span class="arrow" onclick="afficherDescriptionTournoi(this)">〉</span>
            <div class="nodescription-tournoi">
                <span class="title-tournoi" onclick="afficherDescriptionTournoi(this)"> [' . $nom . '] - ' . $point . ' points</span>
            </div>
            <div class="description-tournoi">';
        $str .= '<div class=equipe_container>';
        $jeu = $this->ecurieModel->getJeuByIdEquipe($idEquipe);
        while ($je = $jeu->fetch()) {
            $str .= '<p> L\'équipe joue sur le jeu : <strong>' . $je['Libelle'] . '</strong></p><br><p> Les joueurs de l\'équipe : ';
        }
        $joueur  = $this->ecurieModel->getJoueurByIdEquipe($idEquipe);
        while ($j = $joueur->fetch()) {
            $str .=  '<p class="liste-joueur"> - ' . $j["Pseudo"] . ' </p> ';
        }
        $str .= '</p></br></div>   ';
        $str .= '</div></article>';
        return $str;
    }


    public function afficherLesEcuries()
    {
        $str = '';
        while ($row = $this->req->fetch()) {
            $str .=  $this->afficherUneEcurie($row['Nom'], $row['Nb_pts_Champ'], $row['Id_Equipe']);
        }
        return $str;
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
        $this->req = $this->ecurieModel->equipeByPoint($this->idEcurie);
        return $this->afficherLesEcuries();
    }


    //Fonction trie les écuries par nom
    public function trierParNom()
    {
        $this->req = $this->ecurieModel->equipeByNom($this->idEcurie);
        return $this->afficherLesEcuries();
    }


    //Fonction trie les écuries par id (filtre de base)
    public function trierParId()
    {

        $this->req = $this->ecurieModel->getEquipeEcurie($this->idEcurie);
        return $this->afficherLesEcuries();
    }
}
