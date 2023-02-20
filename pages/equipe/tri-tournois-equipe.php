<?php

class TriTournoisEquipe
{
    private $idEquipe;
    private $req;
    private $sql;
    private $nbTournois;


    public function __construct($idEquipe)
    {
        require_once('../../SQL.php');
        $this->sql = new requeteSQL();
        $this->idEquipe = $this->sql->getIdEquipe($idEquipe);
    }



    # Fonction qui permet d'afficher un tournoi
    # Paramètres : $nom : nom du tournoi
    #              $dateDebut : date de début du tournoi (superieur à la date du jour)
    #              $dateFin : date de fin du tournoi (superieur à la date du debut)
    #              $lieu : lieu du tournoi
    #              $type : type du tournoi (Local, National, International)
    #              $id : id du tournoi
    # Retour : $str : chaine de caractère contenant le code html de l'affichage du tournoi

    public function afficherUnTournoi($nom, $dateDebut, $dateFin, $lieu, $type, $id)
    {
        $req = $this->sql->getJeuxTournois($id);
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

    # Fonction qui permet d'afficher tous les tournois
    # Paramètres : aucun
    # Retour : aucun (echo)
    public function afficherLesTournois()
    {
        while ($row = $this->req->fetch()) {
            echo $this->afficherUnTournoi($row['Nom'], $row['Date_debut'], $row['Date_fin'], $row['Lieu'], $row['Type'], $row['Id_Tournoi']);
        }
    }

    # Fonction qui permet de récupérer le nombre de tournois
    # Paramètres : aucun
    # Retour : nombre de tournois
    public function getNombreTournois(): int
    {
        return $this->nbTournois;
    }

    # Fonction qui affiche les tournois triés par type
    # Paramètres : aucun
    # Retour : aucun (echo)
    public function trierParTypeTournoisEquipe()
    {
        $this->req = $this->sql->tournoisByType($this->idEquipe);
        $this->afficherLesTournois();
    }

    # Fonction qui affiche les tournois triés par lieu
    # Paramètres : aucun
    # Retour : aucun (echo)
    public function trierParLieuTournoisEquipe()
    {
        $this->req = $this->sql->tournoisByLieu($this->idEquipe);
        $this->afficherLesTournois();
    }

    # Fonction qui affiche les tournois triés par equipe
    # Paramètres : aucun
    # Retour : aucun (echo)
    public function trierParNomTournoisEquipe()
    {
        $this->req = $this->sql->tournoisByNom($this->idEquipe);
        $this->afficherLesTournois();
    }

    # Fonction qui affiche les tournois triés par date
    # Paramètres : aucun
    # Retour : aucun (echo)
    public function trierParDateTournoisEquipe()
    {
        $this->req = $this->sql->tournoisByDate($this->idEquipe);
        $this->afficherLesTournois();
    }

    # Fonction qui affiche les tournois triés par id (filtre de base)
    # Paramètres : aucun
    # Retour : aucun (echo)
    public function trierParIdTournoisEquipe()
    {
        $this->req = $this->sql->getTournoi($this->idEquipe);
        $this->afficherLesTournois();
    }

}
