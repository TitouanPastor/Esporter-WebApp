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

    // DAO // 


    function addConcerner($idTournoi, $idJeu){
        $tournoiDAO = new TournoiDAO();
        return $tournoiDAO->addConcerner($idTournoi, $idJeu);
    }

    function getTournoi($idEquipe = 0){
        $tournoiDAO = new TournoiDAO();
        return $tournoiDAO->getTournoi($idEquipe);
    }

    function getJeux(){
        $tournoiDAO = new TournoiDAO();
        return $tournoiDAO->getJeux();
    }

    function addTournoi($Type, $nom, $dateDeb, $dateFin, $lieu, $nbPtsMax, $IdGestionnaireEsport, $idArbitre){
        $tournoiDAO = new TournoiDAO();
        return $tournoiDAO->addTournoi($Type, $nom, $dateDeb, $dateFin, $lieu, $nbPtsMax, $IdGestionnaireEsport, $idArbitre);
    }

    function getLastIDTournoi(){
        $tournoiDAO = new TournoiDAO();
        return $tournoiDAO->getLastIDTournoi();
    }

    function addJeu($libelle){
        $tournoiDAO = new TournoiDAO();
        return $tournoiDAO->addJeu($libelle);
    }

    function getJeuxTournois($id, $choix = "default"){
        $tournoiDAO = new TournoiDAO();
        return $tournoiDAO->getJeuxTournois($id, $choix);
    }

    function tournoiIsClosed($idTournoi){
        $tournoiDAO = new TournoiDAO();
        return $tournoiDAO->tournoiIsClosed($idTournoi);
    }

    function tournoiIscloseable($id){
        $tournoiDAO = new TournoiDAO();
        return $tournoiDAO->tournoiIscloseable($id);
    }

    function tournoiIsFull($idTournoi){
        $tournoiDAO = new TournoiDAO();
        return $tournoiDAO->tournoiIsFull($idTournoi);
    }

    function tournoisByType($idEquipe = 0){
        $tournoiDAO = new TournoiDAO();
        return $tournoiDAO->tournoisByType($idEquipe);
    }

    function tournoisByLieu($idEquipe = 0){
        $tournoiDAO = new TournoiDAO();
        return $tournoiDAO->tournoisByLieu($idEquipe);
    }

    function tournoisByNom($idEquipe = 0){
        $tournoiDAO = new TournoiDAO();
        return $tournoiDAO->tournoisByNom($idEquipe);
    }

    function tournoisByDate($idEquipe = 0){
        $tournoiDAO = new TournoiDAO();
        return $tournoiDAO->tournoisByDate($idEquipe);
    }

    function jeuNonPresentDansTournois($idT){
        $tournoiDAO = new TournoiDAO();
        return $tournoiDAO->jeuNonPresentDansTournois($idT);
    }

    function supprimerJeuxTournoi($idT){
        $tournoiDAO = new TournoiDAO();
        return $tournoiDAO->supprimerJeuxTournoi($idT);
    }

    function modifierTournoi($nom, $dateDeb, $datefin, $type, $lieu, $pointMax, $id){
        $tournoiDAO = new TournoiDAO();
        return $tournoiDAO->modifierTournoi($nom, $dateDeb, $datefin, $type, $lieu, $pointMax, $id);
    }

    function tournoiId($id){
        $tournoiDAO = new TournoiDAO();
        return $tournoiDAO->tournoiId($id);
    }









    ?>

