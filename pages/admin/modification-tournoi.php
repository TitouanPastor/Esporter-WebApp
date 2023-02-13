<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <title>Modification de tournois - E-Sporter</title>
    <link rel="icon" href="../../img/esporter-icon.png">
    <link href="bootstrap.min.css" rel="stylesheet" />
    <script src="https://unpkg.com/jquery@3.3.1/dist/jquery.min.js"></script>
    <script src="https://unpkg.com/bootstrap@3.3.2/dist/js/bootstrap.min.js"></script>
    <script src="bootstrap-multiselect.js"></script>
    <link href="bootstrap-multiselect.css" rel="stylesheet" />

</head>
<?php
session_start();
require_once(realpath(dirname(__FILE__) . '/../../class/header.php'));
$header = new header(2);    

if ($_SESSION['role'] == "gestionnaire") {
    echo $header->customizeHeader($_SESSION['role']);
} else {
    header('Location: ../../acces-refuse.php');
}

require_once(realpath(dirname(__FILE__) . '/../../SQL.php'));
$sql = new requeteSQL();
$idTournois = $_GET['id'];
$reqTournoisId = $sql->tournoiId($idTournois);
$infoExecutionJeu = "";
$infoExecution = "" ;
while ($row = $reqTournoisId->fetch()) {
    $nom = $row['Nom'];
    $nbPtsMax = $row['Nombre_point_max'];
    $type = $row['Type'];
    $dateTournoisDeb = $row['Date_debut'];
    $dateTournoisFin = $row['Date_fin'];
    $lieu = $row['Lieu'];
}
if (isset($_POST['modifier'])){
    // Vérification de si nous avons le droit de créer un tounoi (si c'est avant le 1er Avril)
    if(strtotime("2023-04-01") > strtotime(date("Y-m-d"))) {
        if (!empty($_POST['nom-tournoi']) && !empty($_POST['type-tournoi']) && !empty($_POST['date-tournoi-deb']) && !empty($_POST['date-tournoi-fin']) && !empty($_POST['lieu-tournoi'])) {
            if (sizeof($_POST['jeuxtournoi']) > 0) { 
                // Vérification de si la date de début est inferieur la date de fin   
                if (strtotime($_POST['date-tournoi-deb']) <= strtotime($_POST['date-tournoi-fin'])) { 
                    if (strtotime($_POST['date-tournoi-deb']) > strtotime(date("Y-m-d") . ' + 2 weeks')) {
                        // Vérification de si la date de début est supérieur à la date du jour
                        if (strtotime($_POST['date-tournoi-deb']) > strtotime(date("Y-m-d"))) {
                            //Vérification de si un tournoi du même nom n'existe pas
                            $sameTournoi = False;
                            $tournoisId = $sql->tournoiId($idTournois);


                            $tournois = $sql->getTournoi(); 
                            while($tournoi = $tournois->fetch()) {
                                if (strtoupper($tournoi['Nom']) == strtoupper($_POST['nom-tournoi'])) {
                                    $sameTournoi = True;
                                }
                            }
                            

                            while ($row = $tournoisId->fetch()) {
                                if ($row['Nom'] == $_POST['nom-tournoi']) {
                                $sameTournoi = False;
                                } 
                            }
                            if(!$sameTournoi){
                                try {
                                    if ($_POST['type-tournoi'] == "Local" ) {
                                        $ptsMAX = 1;
                                    } else if ($_POST['type-tournoi'] == "National" ) {
                                        $ptsMAX = 2;
                                    } else if ($_POST['type-tournoi'] == "International") {
                                        $ptsMAX = 3;
                                    } else {
                                        $ptsMAX = 0;
                                    }
                                    //Modification tu tournoi
                                    $reqModifier = $sql->modifierTournoi($_POST['nom-tournoi'], $_POST['date-tournoi-deb'], $_POST['date-tournoi-fin'], $_POST['type-tournoi'], $_POST['lieu-tournoi'],$ptsMAX,$idTournois);
                                    //Suppression des jeux du tournoi
                                    $reqSupprimerJeuxTournois = $sql->supprimerJeuxTournoi($idTournois);
                                    //Ajout des nouveau jeux du tournoi
                                    foreach ($_POST['jeuxtournoi'] as $jeu) {
                                        $sql->addConcerner($idTournois, $jeu);
                                    }
                                        $infoExecution = 'Tournoi modifié !';
                                        header('Location: liste-tournois.php?modifyTournoi=success');
                                    } catch (Exception $e) {
                                        $infoExecution = "Erreur lors de la modification du tournoi ! Veuillez réessayer.";
                                    }
                                        $infoExecution = "Le tournoi a bien été modifié";
                                }else{
                                    $infoExecution = "Un tournoi avec le même nom existe déjà";
                                }
                            } else {
                                $infoExecution = "La date que vous avez entrez est inférieur à la date d'aujoud'hui !";
                            }
                        } else {
                            $infoExecution = "La date de début doit être supérieur à la date du jour !";
                        }
                        
                    }else{
                        $infoExecution = "La date de début doit être inférieur à la date de fin !";
                    }
                    
                }else{
                    $infoExecution = "<center> Veuillez sélectionner au moins un jeu ! <br> N'oublier pas de cliquer sur le bouton 'Valider la selection' après avoir sélectionné un jeu. <center>";
                }
            }else {
            $infoExecutionJeu = "Veuillez remplir tous les champs";
        }
    }else{
        $infoExecutionJeu = "Vous ne pouvez plus modifier de tournoi l(max : 1 février) !";
    }

}   
$reqJeuduTournois = $sql->getJeuxTournois($idTournois);
$reqNonPresentTurnois = $sql->jeuNonPresentDansTournois($idTournois);
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
                $sql->addJeu($_POST['jeux-tournoi']);
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
            <form action="<?php echo "modification-tournoi.php?id=" . $idTournois ?>" method="POST">

                <h1 class="creation-tournoi-title">Modifier un Tournoi</h1>
                <div class="creation-tournoi">
                    <div class="creation-tournoi-left">
                        <div class="creation-tournoi-input">
                            <label for="nom-tournoi">Nom du tournoi</label>
                            <input type="text" name="nom-tournoi" id="nom-tournoi" value="<?php echo $nom ?>">
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="type-tournoi">Type du tournoi</label>
                            <select name="type-tournoi" id="type-tournoi">
                                <?php
                                if ($type == "Local") {
                                    echo '<option value="Local" selected>Local (100 points max)</option>';
                                }else{
                                    echo '<option value="Local">Local (100 points max)</option>';
                                }
                                if ($type == "National") {
                                    echo '<option value="National" selected>National (200 points max)</option>';
                                }else{
                                    echo '<option value="National">National (200 points max)</option>';
                                }
                                if ($type == "International") {
                                    echo '<option value="International" selected>International (300 points max)</option>';
                                }else{
                                    echo '<option value="International">International (300 points max)</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="jeux-tournoi">Jeux présents</label>

                            <!-- Select caché pour récuperer les jeux dans le POST -->
                            <select name="jeuxtournoi[]" id="hiddenselect" hidden multiple></select>

                            <select name="comboboxjeutournoi" id="chkveg" multiple="multiple">
                                <?php
                                //Affichage de la liste de tout les jeux enregistrés dans la base de données
                                while ($data = $reqJeuduTournois->fetch()) {

                                    echo '<option selected value="' . $data['Id_Jeu'] . '">' . $data['Libelle'] . '</option>';
                                }
                                while ($data = $reqNonPresentTurnois->fetch()) {

                                    echo '<option value="' . $data['Id_Jeu'] . '">' . $data['Libelle'] . '</option>';
                                }

                                ?>
                            </select>
                            <input class="add ajouterjeu-valid" type="button" id="ajouterjeux" value="Valider la sélection" style="margin-bottom: 30px;">

                            <input type="text" name="jeux-tournoi" id="jeux-tournoi" placeholder="Ajouter un jeu non présent">
                            <input type="submit" value="Ajouter un jeu" class="submit add" name="ajouterJeu">
                            <span id="spaninfojeu"><?php echo $infoExecutionJeu ?> </span>
                        </div>
                    </div>

                    <div class="creation-tournoi-right">
                        <div class="creation-tournoi-input">
                            <label for="date-tournoi-deb">Date du debut du tournoi</label>
                            <input type="date" name="date-tournoi-deb" id="date-tournoi-deb" value="<?php echo $dateTournoisDeb ?>">
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="date-tournoi-fin">Date de fin du tournoi</label>
                            <input type="date" name="date-tournoi-fin" id="date-tournoi-fin" value="<?php echo $dateTournoisFin ?>">
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="lieu-tournoi">Lieu du tournoi</label>
                            <input type="text" name="lieu-tournoi" id="lieu-tournoi" value="<?php echo $lieu ?>">
                        </div>
                    </div>
                </div>
                <input class="update" type="submit" name="modifier" value="Modifier">
                <span><?php echo $infoExecution ?> </span>
            </form>
        </section>
    </main>

    <script>
        // on load function
        window.onload = function() {
            
            $('#chkveg').multiselect({
                includeSelectAllOption: true
            });
            
            var a = $('#chkveg').val();
            var hiddenselect = document.getElementById("hiddenselect");
            for (var i = 0; i < a.length; i++) {
                var opt = document.createElement('option');
                opt.value = a[i];
                opt.innerHTML = a[i];
                opt.selected = true;
                hiddenselect.appendChild(opt);
            }
        }

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
                for (var i = 0; i < a.length; i++) {
                    var opt = document.createElement('option');
                    opt.value = a[i];
                    opt.innerHTML = a[i];
                    opt.selected = true;
                    hiddenselect.appendChild(opt);
                }
                console.log(a.length    )
                if (a.length == 0) {
                    
                    spaninfojeu.innerHTML = "Aucun jeu sélectionné";
                } else {
                    spaninfojeu.innerHTML = a.length + " jeu(x) enregistré(s) !";
                }
            });
        });
    </script>
</body>

</html>