<?php
// classe php qui genere des bracket de tournois
class bracket
{

    private $sql;
    private $pouleModel;

    public function __construct()
    {
        require_once('../../DAO/TournoiDAO.php');
        require_once('../../model/Poule.php');
        $this->sql = new TournoiDAO();
        $this->pouleModel = new Poule();
    }

    public function genererBracket($idTournoi)
    {
        if ($this->sql->tournoiIsClosed($idTournoi) == false) {
            $this->sql->closeTournois($idTournoi);
            $IDsjeux = $this->sql->getIDJeuxTournoi($idTournoi);
            for ($i = 0; $i < count($IDsjeux); $i++) {
                for ($j = 0; $j < 4; $j++) {
                    $this->sql->addPoule(chr($j + 65), $idTournoi, $IDsjeux[$i]);
                }
            }
            for ($i = 0; $i < count($IDsjeux); $i++) {
                $idsPoule = array();
                $idsEquipe = array();
                $idsPoule = $this->sql->getIDPoule($idTournoi, $IDsjeux[$i]);
                $idsEquipe = $this->sql->getEquipeInscrites($idTournoi, $IDsjeux[$i]);
                $bracket = array();

                for ($j = 0; $j < 4; $j++) {
                    $bracket[] = array_splice($idsEquipe, 0, 4);
                    if ($j % 2 == 1) {
                        $bracket[$j] = array_reverse($bracket[$j]);
                    }
                }
                for ($j = 0; $j < 4; $j++) {
                    for ($k = 0; $k < 4; $k++) {
                        $this->sql->assignerPoule($idTournoi, $idsPoule[$j], $bracket[$j][$k]);
                    }
                }
                for ($j = 0; $j < 4; $j++) {
                    for ($k = 0; $k < 3; $k++) {
                        for ($l = $k; $l < 4; $l++) {
                            if ($bracket[$j][$k] != $bracket[$j][$l]) {
                                $this->sql->addRencontre($bracket[$j][$k], $bracket[$j][$l], $idsPoule[$j]);
                            }
                        }
                    }
                }
            }
        }
    }


    //Genere la poule finale avec le vainqueur de chaque poule
    public function genererPouleFinale($idTournoi, $idJeu, $tabPoule)
    {
        $finaliste  = array();
        $this->sql->addPoule( "Finale", $idTournoi, $idJeu);
        $lastIdPoule = $this->sql->getLastIDPoule();
        foreach ($tabPoule as $idPoule){
            array_push($finaliste,  $this->sql->getPremierPoule($idTournoi, $idJeu, $idPoule));
        }
        
        //Ajouter les rencontres
        $adversaire = $finaliste;
        $adversaire = array_reverse($adversaire);
        for ($i = 0; $i < 3 ; $i++ ){
            array_pop($adversaire);
            for ($j = 0; $j < count($adversaire) ; $j++){
                $this->sql->addRencontre($finaliste[$i], $adversaire[$j], $lastIdPoule);
            }   
        }

        return $lastIdPoule;
        
        
    }

    public function pouleTerminer($tabPoule)
    {
        foreach($tabPoule as $idPoule){
            $nbMatchTerm = $this->sql->getNbPointPoule($idPoule);
            echo $nbMatchTerm;
            if ($nbMatchTerm < 6) {
                return False;
            }
        }
        return true;
    }

    public function updateClassementGeneral($idTournoi)
    {
        $idPoulesFinalesTournoi = $this->pouleModel->getPoulesFinalesByIdTournoi($idTournoi)[0];

        foreach ($idPoulesFinalesTournoi as $idPoule) {
            $pouleFinale = $this->sql->getPerdantFinale($idPoule);
            $resultatFinaux = $this->sql->getResultatFinaux($idPoule);
            $multiplicateur = $this->sql->getMultiplicateur($idTournoi);
            $points = [100, 60, 30, 10];
            $i = 0;
            while ($row = $resultatFinaux->fetch()) {
                $this->sql->updateClassementEquipe($row["id_equipe"], $row["count(gagnant)"] * 5 + $points[$i] * $multiplicateur);
                $i++;
            }
            
            foreach ($pouleFinale as $idEquipe) {
                $this->sql->updateClassementEquipe($idEquipe, $points[$i] * $multiplicateur);
                $i++;
            }
        }
    }

   

}
