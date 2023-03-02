<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creation de tournois - E-Sporter</title>
    <link rel="icon" href="../../img/esporter-icon.png">
    <link href="bootstrap.min.css" rel="stylesheet" />
    <script src="https://unpkg.com/jquery@3.3.1/dist/jquery.min.js"></script>
    <script src="https://unpkg.com/bootstrap@3.3.2/dist/js/bootstrap.min.js"></script>
    <script src="bootstrap-multiselect.js"></script>
    <link rel="stylesheet" href="bootstrap-multiselect.css" />
    <link rel="stylesheet" href="../../css/style.css">

</head>
<?php


session_start();
require_once(realpath(dirname(__FILE__) . '/../../controller/visteur/header-controller.php'));
require_once(realpath(dirname(__FILE__) . '/../../SQL.php'));



// Initialisation des variables
$infoExecution = "";
$infoExecutionJeu = "";

$sql = new requeteSQL();
$reqJeu = $sql->getJeux();

// Ajouter un tournoi
if (isset($_POST['ajouter'])) {

    // Vérification de si nous avons le droit de créer un tounoi (si c'est avant le 1er février)
    if (date("m") < 2) {

        // Vérification de si tout les champs sont remplis
        if (!empty($_POST['nom-tournoi']) && !empty($_POST['comboboxtypetournoi']) && !empty($_POST['lieu-tournoi']) && !empty($_POST['date-debut']) && !empty($_POST['date-fin'])) {

            //Vérification de si il y a au moins un jeu séléctionner
            if (sizeof($_POST['jeuxtournoi']) > 0) {

                // Vérification de si la date de début est inferieur la date de fin   
                if (strtotime($_POST['date-debut']) <= strtotime($_POST['date-fin'])) {

                    // Vérification de si la date de début est supérieur à la date du jour
                    if (strtotime($_POST['date-debut']) > strtotime(date("Y-m-d") . ' + 2 weeks')) {

                        //Vérification de si un tournoi du même nom n'existe pas
                        $tournois = $sql->getTournoi();
                        $sameTournoi = False;
                        
                        while ($tournoi = $tournois->fetch()) {
                            if (strtoupper($tournoi['Nom']) == strtoupper($_POST['nom-tournoi'])) {
                                $sameTournoi = True;
                            }
                        }
                        if (!$sameTournoi) {
                            try {
                                //Mise à jour des points du tournoi en fonction de son type
                                if ($_POST['comboboxtypetournoi'] == "Local") {
                                    $points = 1;
                                } else if ($_POST['comboboxtypetournoi'] == "National") {
                                    $points = 2;
                                } else if ($_POST['comboboxtypetournoi'] == "International") {
                                    $points = 3;
                                } else {
                                    $points = 0;
                                }
                               
                                // Ajout d'un tournoi (les deux derniers 1 correspondent au id du gestionnaire et de l'arbitre)
                                $sql->addTournoi(htmlspecialchars($_POST['comboboxtypetournoi']), htmlspecialchars($_POST['nom-tournoi']), htmlspecialchars($_POST['date-debut']), htmlspecialchars($_POST['date-fin']), htmlspecialchars($_POST['lieu-tournoi']), htmlspecialchars($points), 1, 1);
                                // Récupération de l'ID dernier tournoi créer
                                $idTournoi = $sql->getLastIDTournoi();
                                // // Ajout des jeux du tournoi 
                                foreach ($_POST['jeuxtournoi'] as $jeu) {
                                    $sql->addConcerner($idTournoi, $jeu);
                                }
                                $infoExecution = 'Tournoi ajouté !';
                                header('Location: liste-tournois.php?createTournoi=success');
                            } catch (Exception $e) {
                                $infoExecution = "Erreur lors de l'ajout du tournoi ! Veuillez réessayer.";
                            }
                            $infoExecution = "Le tournoi a bien été ajouté";
                        } else {
                            $infoExecution = "Un tournoi avec le même nom existe déjà";
                        }
                    } else {
                        $infoExecution = "La date de début du tournoi doit être supérieur à 2 semaines";
                    }
                } else {
                    $infoExecution = "La date de début doit être inférieur à la date de fin !";
                }
            } else {
                $infoExecution = "<center> Veuillez sélectionner au moins un jeu ! <br> N'oublier pas de cliquer sur le bouton 'Valider la selection' après avoir sélectionné un jeu. <center>";
            }
        } else {
            $infoExecution = "Veuillez remplir tous les champs";
        }
    } else {
        $infoExecution = "La création de tournoi est désactivé !";
    }
}

// Ajouter un ou plusieurs jeux
if (isset($_POST['ajouterJeu'])) {
    //Vérification de si le champs n'est pas vide
    if (!empty($_POST['jeux-tournoi'])) {
        //Vérification de si le jeu n'existe pas déjà
        $jeux = $sql->getJeux();
        $sameJeu = False;
        while ($jeu = $jeux->fetch()) {
            if (strtoupper($jeu['Libelle']) == strtoupper($_POST['jeux-tournoi'])) {
                $sameJeu = True;
            }
        }
        if (!$sameJeu) {
            try {
                //Ajout du nouveau jeu
                $sql->addJeu(htmlspecialchars($_POST['jeux-tournoi']));
                $reqJeu = $sql->getJeux();
                $infoExecutionJeu = "Jeu ajouté !";
            } catch (Exception $e) {
                $infoExecutionJeu = "Erreur lors de l'ajout du jeu !";
            }
        } else {
            $infoExecutionJeu = "Le jeu existe déjà";
        }
    }
}

?>

<body>
    <main class="main-creation-tournoi">
        <section class="creation-tournoi-container">
            <form id="form" action="creation-tournoi.php" method="POST">
                <h1 class="creation-tournoi-title">Création d'un Tournoi</h1>
                <div class="creation-tournoi">
                    <div class="creation-tournoi-left">
                        <div class="creation-tournoi-input">
                            <label for="nom-tournoi">Nom du tournoi</label>
                            <input type="text" name="nom-tournoi" id="nom-tournoi" placeholder="Nom">
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="jeux-tournoi">Jeux présents</label>

                            <!-- Select caché pour récuperer les jeux dans le POST -->
                            <select name="jeuxtournoi[]" id="hiddenselect" hidden multiple></select>

                            <select name="comboboxjeutournoi" id="chkveg" multiple="multiple">
                                <?php
                                //Affichage de la liste de tout les jeux enregistrés dans la base de données
                                while ($data = $reqJeu->fetch()) {

                                    echo '<option value="' . $data['Id_Jeu'] . '">' . $data['Libelle'] . '</option>';
                                }
                                ?>
                            </select>
                            <input class="add" type="button" id="ajouterjeux" value="Valider la sélection" style="margin-bottom: 30px;">

                            <input type="text" name="jeux-tournoi" id="jeux-tournoi" placeholder="Ajouter un jeu non présent">
                            <input type="submit" value="Ajouter un jeu" class="submit add" name="ajouterJeu">
                            <span id="spaninfojeu"><?php echo $infoExecutionJeu ?> </span>
                        </div>
                    </div>

                    <div class="creation-tournoi-right">
                        <div class="creation-tournoi-input">
                            <label for="comboboxtypetournoi">Type du tournoi</label>
                            <select name="comboboxtypetournoi" id="comboboxtypetournoi">
                                <option value="Local">Local (100 points max)</option>
                                <option value="National">National (200 points max)</option>
                                <option value="International">International (300 points max)</option>
                            </select>
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="lieu-tournoi">Lieu du tournoi</label>
                            <input type="text" name="lieu-tournoi" id="lieu-tournoi" placeholder="Lieu">
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="date-debut">Début du tournoi</label>
                            <input type="date" name="date-debut" id="date-debut">
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="date-fin">Fin du tournoi</label>
                            <input type="date" name="date-fin" id="date-fin">
                        </div>
                    </div>
                </div>
                <div class="button_container" style="display: flex; flex-direction: column; align-items:center; gap: 5px;">
                    <input id="submit" class="submit-gris" type="submit" name="ajouter" value="Ajouter" disabled>
                    <span><?php echo $infoExecution ?></span>
                    <a class="return bouton" href="../../index.php">Retour</a>
                </div>
            </form>
        </section>
    </main>

    <script>
        //Script pour ajouter les jeux dans le select caché
        //cela permet de récuperer les jeux dans le POST
        $(function() {

            $('#chkveg').multiselect({
                includeSelectAllOption: true
            });

            $('#ajouterjeux').click(function() {
                var a = $('#chkveg').val();
                var spaninfojeu = document.getElementById("spaninfojeu");
                var hiddenselect = document.getElementById("hiddenselect");
                var mainsubmit = document.getElementById("submit");
                var submitselectionjeux = document.getElementById("ajouterjeux");
                while (hiddenselect.firstChild) {
                    hiddenselect.removeChild(hiddenselect.firstChild);
                }
                if (a.length == 0) {
                    spaninfojeu.innerHTML = "Aucun jeu sélectionné";
                } else {
                    mainsubmit.classList.add("submit-active");
                    mainsubmit.removeAttribute("disabled");
                    spaninfojeu.innerHTML = a.length + " jeu(x) enregistré(s) !";
                    submitselectionjeux.classList.add("ajouterjeu-valid");
                }
                for (var i = 0; i < a.length; i++) {
                    var opt = document.createElement('option');
                    opt.value = a[i];
                    opt.innerHTML = a[i];
                    opt.selected = true;
                    hiddenselect.appendChild(opt);
                }
            });
        });
    </script>

</body>


</html>