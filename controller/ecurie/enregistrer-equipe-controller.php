<?php

    session_start();
    require_once(realpath(dirname(__FILE__) . '/../visiteur/header-controller.php'));
    require_once(realpath(dirname(__FILE__) . '/../../model/Tournoi.php'));
    require_once(realpath(dirname(__FILE__) . '/../../model/Ecurie.php'));
    require_once(realpath(dirname(__FILE__) . '/../../model/Equipe.php'));

    $tournoi = new Tournoi();
    $ecurieModel = new Ecurie();
    $equipeModel = new Equipe();

    // Initialisation des variables
    $infoExecution = "";
    $reqJeu = $tournoi->getJeux();

    // Ajouter une équipe
    if (isset($_POST['ajouter'])) {
        // Vérification de si tout les champs sont remplis
        if (!empty($_POST['nom-equipe']) && !empty($_POST['jeu_equipe']) && !empty($_POST['email-equipe']) && !empty($_POST['mdp-equipe'])) {
            //Vérification de si une équipe dans l'écurie n'a pas ce jeu
            $id = $ecurieModel->getIdEcurieByMail($_SESSION['username']);
            $equipes = $ecurieModel->getEquipeEcurie($id);
            $sameJeu = False;
            while ($equipe = $equipes->fetch()) {
                if ($equipe['Id_Jeu'] == $_POST['jeu_equipe']) {
                    $sameJeu = True;
                }
            }
            if (!$sameJeu) {
                //Vérification de si une équipe du même nom n'existe pas déjà
                $equipes = $equipeModel->getEquipe();
                $sameEquipe = False;
                $sameMail = False;
                while ($equipe = $equipes->fetch()) {
                    if (strtoupper($equipe['Nom']) == strtoupper($_POST['nom-equipe'])) {
                        $sameEquipe = True;
                    }
                    if (strtoupper($equipe['Mail']) == strtoupper($_POST['email-equipe'])) {
                        $sameMail = True;
                    }
                }
                if (!$sameEquipe) {
                    if (!$sameMail) {
                        try {
                            //Ajout d'une équipe (le 0 correspond au nombre de point au championnat initialisé à 0)
                           
                            $infoExecution = 'Equipe enregistrée !';
                            header("Refresh: 3;URL=enregistrer-joueurs-controller.php?nom=" . $_POST['nom-equipe'] . "&jeu=" . 
                            $_POST['jeu_equipe'] . "&email=" . $_POST['email-equipe'] . "&mdp=" . $_POST['mdp-equipe']);
                        } catch (Exception $e) {
                            $infoExecution = "Erreur : " . $e->getMessage();
                        }
                    } else {
                        $infoExecution = "Une équipe avec la même adresse mail existe déjà";
                    }
                } else {
                    $infoExecution = "Une équipe avec le même nom existe déjà !";
                }
            } else {
                $infoExecution = "Une équipe dans l'écurie avec le même jeu existe déjà !";
            }
        } else {
            $infoExecution = "Veuillez remplir tous les champs";
        }
    }

    $affichageJeux = "";
    //Affichage de la liste de tout les jeux enregistrés dans la base de données
    while ($data = $reqJeu->fetch()) {
        $affichageJeux .= '<option value="' . $data['Id_Jeu'] . '">' . $data['Libelle'] . '</option>';
    }

    ob_start();
    require_once(realpath(dirname(__FILE__) . '/../../view/ecurie/enregistrer-equipe-view.html'));
    $buffer = ob_get_clean();
    $buffer = str_replace("##infoExecution##", $infoExecution, $buffer);
    $buffer = str_replace("##affichageJeux##", $affichageJeux, $buffer);
    echo $buffer;

?>


   