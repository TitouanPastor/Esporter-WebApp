<?php

class TriTournoisEquipe
{
    private $idEquipe;
    private $req;
    private $sql;
    private $nbTournois;


    public function TriTournoisEquipe($idEquipe)
    {
        require_once('../../SQL.php');
        $this->sql = new requeteSQL();
        $this->idEquipe = $this->sql->getIdEquipe($idEquipe);
    }



    //function qui affiche un tournoi
    public function afficherUnTournoi($nom, $date_debut, $date_fin, $lieu, $type, $id)
    {
        $req = $this->sql->getJeuxTournois($id);
        $str = '<article class="main-liste-article">
                        <span class="arrow" onclick="afficherDescriptionTournoi(this)">〉</span>
                        <div class="nodescription-tournoi">
                            <span class="title-tournoi" onclick="afficherDescriptionTournoi(this)"> [' . $type . '] ' . $nom . '</span>
                        </div>
                        <div class="description-tournoi">
                            <p>Le tournoi se déroulera à ' . $lieu . ' du ' . $date_debut . ' au ' . $date_fin . '.</p>';

        while ($jeu = $req->fetch()) {
            $str .= '<p>- ' . $jeu['Libelle'] . '</p>';
        }

        $str .= '</div></article>';
        return $str;
    }

    public function afficherLesTournois()
    {
        while ($row = $this->req->fetch()) {
            echo $this->afficherUnTournoi($row['Nom'], $row['Date_debut'], $row['Date_fin'], $row['Lieu'], $row['Type'], $row['Id_Tournoi']);
        }
    }

    public function getNombreTournois(): int
    {
        return $this->nbTournois;
    }

    //Fonction trie les tournois par type
    public function trierParTypeTournoisEquipe()
    {
        $this->req = $this->sql->tournoisByType($this->idEquipe);
        $this->afficherLesTournois();
    }

    //Fonction trie les tournois par lieu
    public function trierParLieuTournoisEquipe()
    {
        $this->req = $this->sql->tournoisByLieu($this->idEquipe);
        $this->afficherLesTournois();
    }

    //Fonction trie les tournois par nom
    public function trierParNomTournoisEquipe()
    {
        $this->req = $this->sql->tournoisByNom($this->idEquipe);
        $this->afficherLesTournois();
    }

    //Fonction trie les tournois par id (filtre de base)
    public function trierParDateTournoisEquipe()
    {
        $this->req = $this->sql->tournoisByDate($this->idEquipe);
        $this->afficherLesTournois();
    }

    //Fonction trie les tournois par id (filtre de base)
    public function trierParIdTournoisEquipe()
    {
        $this->req = $this->sql->getTournoi($this->idEquipe);
        $this->afficherLesTournois();
    }

}
