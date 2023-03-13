<?php
    session_start();
    require_once(realpath(dirname(__FILE__) .'/../visiteur/header-controller.php'));
    require_once(realpath(dirname(__FILE__) .'/../../model/Tournoi.php'));
    require_once(realpath(dirname(__FILE__) .'/../../model/bracket.php'));
    require_once(realpath(dirname(__FILE__) .'/../../model/Poule.php'));
    require_once(realpath(dirname(__FILE__) .'/../../model/Equipe.php'));

    $tournoiModel = new Tournoi();
    $bracketModel = new bracket();
    $pouleModel = new Poule();
    $equipeModel = new Equipe();

    $afficherBoutonFermerResultat  = False;

    //Id
    $idTournoi = $_GET["id_tournoi"];
    $idJeu = $_GET["id_jeu"];

    //Nom tournoi par id_tournoi
    $reqNomTournoi = $tournoiModel -> getTournoiNomByIdTournoi($idTournoi) -> fetch()[0];
    $poulesTermines = false;
    $pouleFinaleCreer = false;
    $idPouleFinale = 0;

    $reqPoule = $pouleModel->getPouleByIdTournoi($idTournoi);

    //pouleGauche
    $pouleGauche = "";
    $num_poule = 0;
    while ($poule = $reqPoule -> fetch()){
        $num_poule++;
        $reqEquipePouleTrie = $pouleModel -> getEquipePouleTrie($poule[0]);
        $clair = 0;
        $pouleGauche .= '
            <button type ="submit" class="poule" name="submitPoule" value ='.$poule[0].'>
                <div class="pouleLibelle">
                    <span>'.$poule[1].'</span>
                </div>
            ';
        while ($equipe = $reqEquipePouleTrie -> fetch()){
            $equipeNom = $equipe[0];
            $equipeNbMatchGagne = $equipe[1];
            if ($clair % 2 == 0) {
                $pouleGauche .= '
                    <div class="equipe violet-fonce">
                        <span>' . $equipeNom . '</span>
                        <div>' . $equipeNbMatchGagne . ' </div>
                    </div>
                ';
            } else {
                $pouleGauche .= '
                    <div class="equipe violet-clair">
                        <span>' . $equipeNom . '</span>
                        <div>' . $equipeNbMatchGagne . ' </div>
                    </div>
                ';
            }
        $clair += 1;
        }
        $pouleGauche .= '
            </button>
        ';
    }

    //pouleDroite
    $pouleDroite = "";
    $idPouleAffiche;
    if (isset($_POST["submitPoule"])) {
        $idPouleAffiche = $_POST["submitPoule"];
        $nomPouleAffiche = $pouleModel->getNomPoule($idPouleAffiche)->fetch()[0];
        $reqRecontre = $pouleModel -> getRencontre($idPouleAffiche);
        $pouleDroite .= '
            <div class="poule-droite">
                <h1>Poule ' . $nomPouleAffiche . '</h1>
                <div class="tout-match">';
                $numMatch = 1;
                
    
                while ($rencontre = $reqRecontre -> fetch()){
                    $nomEquipe1 = $equipeModel -> getNomEquipeById($rencontre[1]) -> fetch()[0];
                    $nomEquipe2 = $equipeModel -> getNomEquipeById($rencontre[2])->fetch()[0];
                    
                    if ($rencontre[4] == null){
                        $pouleDroite .= '
                        <div class="match">
                            <h2 class="equipe-match">Match '.$numMatch.'</h2>
                            <div class="rencontre-equipe">
                                <div class="Equipe1">
                                    <span">'.$nomEquipe1.'</span>
                                </div>
                                <div class="Equipe2">
                                    <span>'.$nomEquipe2.'</span>
                                </div>
                            </div>
                            
                        </div>
                        ';
                    } else {
                        $gagnant = $pouleModel -> getGagnantRencontre($rencontre[0]) -> fetch()[0];
                        if ($nomEquipe1 == $gagnant){
                            $perdant = $nomEquipe2;
                        } else {
                            $perdant = $nomEquipe1;
                        }
                        
                        $pouleDroite .= '
                            <div class="match">
                                <h2 class="equipe-match">Match '.$numMatch.'</h2>
                                <div class="container-equipe">
                                    <div class="gagnantRencontre">

                                        <h3>'.$gagnant.'</h3>
                                        <svg width="20px" height="20px" viewBox="0 -6 34 34" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><title>crown</title>
                                            <desc>Created with Sketch.</desc>
                                            <defs>
                                                <linearGradient x1="50%" y1="0%" x2="50%" y2="100%" id="linearGradient-1">
                                                    <stop stop-color="#FFC923" offset="0%"></stop>
                                                    <stop stop-color="#FFAD41" offset="100%"></stop>
                                                </linearGradient>
                                            </defs>
                                            <g id="icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <g id="ui-gambling-website-lined-icnos-casinoshunter" transform="translate(-1513.000000, -2041.000000)" fill="url(#linearGradient-1)" fill-rule="nonzero">
                                                    <g id="4" transform="translate(50.000000, 1871.000000)">
                                                        <path d="M1480.91651,170.219311 C1481.3389,170.433615 1481.67193,170.790192 1481.85257,171.227002 L1485.64818,180.405177 L1493.44429,170.905749 C1494.13844,170.059929 1495.39769,169.928221 1496.25688,170.61157 C1496.72686,170.98536 1497,171.548271 1497,172.143061 L1497,189.04671 C1497,190.677767 1495.65685,192 1494,192 L1466,192 C1464.34315,192 1463,190.677767 1463,189.04671 L1463,172.142612 C1463,171.055241 1463.89543,170.173752 1465,170.173752 C1465.60413,170.173752 1466.17588,170.442575 1466.55559,170.905145 L1474.35377,180.405143 L1478.1477,171.227264 C1478.54422,170.268054 1479.62151,169.783179 1480.60701,170.093228 L1480.75404,170.145737 L1480.91651,170.219311 Z" id="crown"></path>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>

                                    </div>
                                    <div class="perdantRencontre">
                                        <span>'.$perdant.'</span>
                                    </div>
                                </div>
                            </div>
                    ';
                    }
                    $numMatch += 1;
                    
                }
            $pouleDroite .=' </div>
            </div>
        ';
    }

    ob_start();
    require_once(realpath(dirname(__FILE__) .'/../../view/visiteur/match-poule-resultats-view.php'));
    $buffer = ob_get_clean();
    $buffer = str_replace("##pouleGauche##", $pouleGauche, $buffer);
    $buffer = str_replace("##pouleDroite##", $pouleDroite, $buffer);
    echo $buffer;
?>