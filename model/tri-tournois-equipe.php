<?php

class TriTournoisEquipe
{
    private $idEquipe;
    private $req;
    private $TournoiDAO;
    private $EquipeDAO;
    private $nbTournois;


    public function __construct($idEquipe)
    {
        require_once('../../DAO/TournoiDAO.php');
        $this->TournoiDAO = new TournoiDAO();
        require_once('../../DAO/EcurieDAO.php');
        $this->EquipeDAO = new EquipeDAO();
        $this->idEquipe = $this->EquipeDAO->getIdEquipe($idEquipe);
    }



    //function qui affiche un tournoi
    public function afficherUnTournoi($nom, $dateDebut, $dateFin, $lieu, $type, $id)
    {
        $req = $this->TournoiDAO->getJeuxTournois($id);
        $str = '<article class="main-liste-article">
                        <span class="arrow" onclick="afficherDescriptionTournoi(this)">〉</span>
                        <div class="nodescription-tournoi">
                            <span class="title-tournoi" onclick="afficherDescriptionTournoi(this)"> [' . $type . '] ' . $nom . '</span>
                        </div>
                        <div class="description-tournoi">
                        <p>Le tournoi se déroulera à '.$lieu.' du '.date('d/m/Y', strtotime($dateDebut)).' au '.date('d/m/Y', strtotime($dateFin)).'.</p>';

        while ($jeu = $req->fetch()) {
            $str .= '<p>- ' . $jeu['Libelle'] . '</p>';
        }

        $str .= '</div></article>';
        return $str;
    }

    public function afficherLesTournois()
    {
        $html = '';
        while ($row = $this->req->fetch()) {
            $html .= $this->afficherUnTournoi($row['Nom'], $row['Date_debut'], $row['Date_fin'], $row['Lieu'], $row['Type'], $row['Id_Tournoi']);
        }

        return $html;
    }

    public function getNombreTournois(): int
    {
        return $this->nbTournois;
    }

    //Fonction trie les tournois par type
    public function trierParTypeTournoisEquipe()
    {
        $this->req = $this->TournoiDAO->tournoisByType($this->idEquipe);
        return $this->afficherLesTournois();
    }

    //Fonction trie les tournois par lieu
    public function trierParLieuTournoisEquipe()
    {
        $this->req = $this->TournoiDAO->tournoisByLieu($this->idEquipe);
        return $this->afficherLesTournois();
    }

    //Fonction trie les tournois par nom
    public function trierParNomTournoisEquipe()
    {
        $this->req = $this->TournoiDAO->tournoisByNom($this->idEquipe);
        return $this->afficherLesTournois();
    }

    //Fonction trie les tournois par id (filtre de base)
    public function trierParDateTournoisEquipe()
    {
        $this->req = $this->TournoiDAO->tournoisByDate($this->idEquipe);
        return $this->afficherLesTournois();
    }

    //Fonction trie les tournois par id (filtre de base)
    public function trierParIdTournoisEquipe()
    {
        $this->req = $this->TournoiDAO->getTournoi($this->idEquipe);
        return $this->afficherLesTournois();
    }

}
