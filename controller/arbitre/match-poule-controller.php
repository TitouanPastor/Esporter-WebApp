<?php
    session_start();
    require_once(realpath(dirname(__FILE__) .'/../visiteur/header-controller.php'));
    require_once(realpath(dirname(__FILE__) .'/../../model/Tournoi.php'));
    require_once(realpath(dirname(__FILE__) .'/../../model/Poule.php'));

    $tournoi = new Tournoi();
    $bracket = new bracket();
    $poule = new Poule();

    $afficherBoutonFermerResultat  = False;

    $idTournoi = $_GET["id_tournoi"];
    $idJeu = $_GET["id_jeu"];

    //Nom tournoi par id_tournoi
    $reqNomTournoi = $tournoi -> getTournoiNomByIdTournoi($idTournoi) -> fetch()[0];
    $poulesTermines = false;
    $pouleFinaleCreer = false;
    $idPouleFinale = 0;

    //Poule par id_tournoi
    $reqPoule = $poule->getPouleIdTournoi($idTournoi);

    if (isset($_POST["valider"])){
        if (!$bracket->pouleTerminer(array_slice($reqPoule, 0, 4)))
            if (isset($_POST["match1"])){
                $req = $poule->setGagnantRencontre($_POST["idMatch1"], $_POST["match1"]);
            }

            if (isset($_POST["match2"])){
                $req = $poule->setGagnantRencontre($_POST["idMatch2"], $_POST["match2"]);
            }

            if (isset($_POST["match3"])){
                $req = $poule->setGagnantRencontre($_POST["idMatch3"], $_POST["match3"]);
            }

            if (isset($_POST["match4"])){
                $req = $poule->setGagnantRencontre($_POST["idMatch4"], $_POST["match4"]);
            }

            if (isset($_POST["match5"])){
                $req = $poule->setGagnantRencontre($_POST["idMatch5"], $_POST["match5"]);
            }

            if (isset($_POST["match6"])){
                $req = $poule->setGagnantRencontre($_POST["idMatch6"], $_POST["match6"]);
            }

            //Verifier que tout les matchs sont terminer
            $poulesTermines = true;
            
            if ($bracket->pouleTerminer(array_slice($reqPoule, 0, 4))){
                echo "Toute les poules sont terminées";
                $idPouleFinale = $bracket->genererPouleFinale($idTournoi,$tournoi->getIdJeu($idJeu),array_slice($reqPoule, 0, 4));
                
            }else{
                echo "Toute les poules ne sont pas terminées";
            }
                

        } else if ($pouleFinaleCreer){// Si poule terminée
            print_r ($reqPoule);
        }

        if (isset($_POST["valider_finale"])){
        
        if (isset($_POST["match1"])){
            $req = $poule->setGagnantRencontreFinale($_POST["idMatch1"], $_POST["match1"]);
        }

        if (isset($_POST["match2"])){
            $req = $poule->setGagnantRencontreFinale($_POST["idMatch2"], $_POST["match2"]);
        }

        if (isset($_POST["match3"])){
            $req = $poule->setGagnantRencontreFinale($_POST["idMatch3"], $_POST["match3"]);
        }

        if (isset($_POST["match4"])){
            $req = $poule->setGagnantRencontreFinale($_POST["idMatch4"], $_POST["match4"]);
        }

        if (isset($_POST["match5"])){
            $req = $poule->setGagnantRencontreFinale($_POST["idMatch5"], $_POST["match5"]);
        }

        if (isset($_POST["match6"])){
            $req = $poule->setGagnantRencontreFinale($_POST["idMatch6"], $_POST["match6"]);
        }
        $idPouleFinale = $sql->getIDPouleFinale($idTournoi,$sql->getIdJeu($idJeu));
        
        if ($sql->pouleFinaleTerminer($idPouleFinale)){
        $sql->terminerTournoi($idTournoi);
            
            $bracket->updateClassementGeneral($idPouleFinale,$idTournoi);
        }else{
            
        }
        }

        $reqPoule = $sql->getPouleByIdTournoi($idTournoi);
?>