<?php 

    require_once(realpath(dirname(__FILE__) . '/../../DAO/tournoiDAO.php'));
    require_once('tri-tournois.php');

    // ==== Creation Tournoi ===
    //Fonction pour afficher les jeux sous forme de liste déroulante
    function afficherListeJeux($reqJeu){
        $html = '';
        while ($data = $reqJeu->fetch()) {

            $html .= '<option value="' . $data['Id_Jeu'] . '">' . $data['Libelle'] . '</option>';
        }

        return $html;
    }

    function trierPar(string $by){
        $triTournois = new TriTournois();
        switch($by){
            case 'type':
                return $triTournois->trierParType();
                break;
            case 'lieu':
                return $triTournois->trierParLieu();
                break;
            case 'nom':
                return $triTournois->trierParNom();
                break;
            case 'date':
                return $triTournois->trierParDate();
                break;
            default:
                return $triTournois->trierParId();
                break;
        }
        return "Erreur de tri";
        
    }

    // ==== Modification Tournoi ===
    
    //Affichage de la liste de tout les jeux enregistrés dans la base de données
    function afficherListeJeuxTournoi($reqJeuduTournois, $reqNonPresentTurnois){
    $html = '';
    while ($data = $reqJeuduTournois->fetch()) {

        $html .= '<option selected value="' . $data['Id_Jeu'] . '">' . $data['Libelle'] . '</option>';
    }
    while ($data = $reqNonPresentTurnois->fetch()) {

        $html .= '<option value="' . $data['Id_Jeu'] . '">' . $data['Libelle'] . '</option>';
    }

    return $html;
    }

    //
    function afficherListeTypeTournoi($type){   
        $html = '';                           
    if ($type == "Local") {
        $html .=  '<option value="Local" selected>Local (100 points max)</option>';
    }else{
        $html .= '<option value="Local">Local (100 points max)</option>';
    }
    if ($type == "National") {
        $html .= '<option value="National" selected>National (200 points max)</option>';
    }else{
        $html .= '<option value="National">National (200 points max)</option>';
    }
    if ($type == "International") {
        $html .= '<option value="International" selected>International (300 points max)</option>';
    }else{
        $html .= '<option value="International">International (300 points max)</option>';
    }

    return $html;
    }
    ?>

