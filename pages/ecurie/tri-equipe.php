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



    # Fonction qui permet d'afficher une écurie
    # Paramètres : $nom : nom de l'écurie
    #              $point : nombre de point de l'écurie
    #              $idEquipe : id de l'équipe
    # Retour : $str : chaine de caractère contenant le code html de l'affichage de l'écurie
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
    
    # Fonction qui permet d'afficher toutes les écuries
    # Paramètres : aucun
    # Retour : aucun
    public function afficherLesEcuries()
    {
        while ($row = $this->req->fetch()) {
            echo $this->afficherUneEcurie($row['Nom'], $row['Nb_pts_Champ'], $row['Id_Equipe']);
        }
    }

    # Fonction qui permet de récupérer le nombre d'écurie
    # Paramètres : aucun
    # Retour : nombre d'écurie
    public function getNombreEcuries(): int
    {
        return $this->nbEcuries;
    }

    # Fonction qui permet de récupérer l'id de l'écurie
    # Paramètres : aucun
    # Retour : id de l'écurie
    public function getIdEcure(): int
    {
        return $this->idEcurie;
    }

    # Fonction qui permet d'afficher les écuries triées par point
    # Paramètres : aucun
    # Retour : aucun (echo)
    public function trierParPoint()
    {
        $this->req = $this->sql->equipeByPoint($this->idEcurie);
        $this->afficherLesEcuries();
    }


    # Fonction qui permet d'afficher les écuries triées par nom
    # Paramètres : aucun
    # Retour : aucun (echo)
    public function trierParNom()
    {
        $this->req = $this->sql->equipeByNom($this->idEcurie);
        $this->afficherLesEcuries();
    }


    # Fonction qui permet d'afficher les écuries triées par id (filtre de base)
    # Paramètres : aucun
    # Retour : aucun (echo)
    public function trierParId()
    {

        $this->req = $this->sql->getEquipeEcurie($this->idEcurie);
        $this->afficherLesEcuries();
    }
}
