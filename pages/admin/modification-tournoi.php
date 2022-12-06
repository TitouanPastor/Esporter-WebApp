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
    echo $header->customize_header($_SESSION['role']);
} else {
    header('Location: ../../acces-refuse.php');
}

require_once(realpath(dirname(__FILE__) . '/../../SQL.php'));
$sql = new requeteSQL();
$id_Tournois = $_GET['id'];
$reqTournoisId = $sql->tournoiId($id_Tournois);
$info_execution_jeu = "";
while ($row = $reqTournoisId->fetch()) {
    $nom = $row['Nom'];
    $nb_pts_max = $row['Nombre_point_max'];
    $type = $row['Type'];
    $dateTournoisDeb = $row['Date_debut'];
    $dateTournoisFin = $row['Date_fin'];
    $lieu = $row['Lieu'];
}
if (isset($_POST['modifier'])){
    if ($_POST['type-tournoi'] == "Local" ) {
        $ptsMAX = 50;
    } else if ($_POST['type-tournoi'] == "National" ) {
        $ptsMAX = 100;
    } else if ($_POST['type-tournoi'] == "International") {
        $ptsMAX = 150;
    } else {
        $ptsMAX = 0;
    }
    //Modification tu tournoi
    $reqModifier = $sql->modifierTournoi($_POST['nom-tournoi'], $_POST['date-tournoi-deb'], $_POST['date-tournoi-fin'], $_POST['type-tournoi'], $_POST['lieu-tournoi'],$ptsMAX,$id_Tournois);
    //Suppression des jeux du tournoi
    $reqSupprimerJeuxTournois = $sql->supprimerJeuxTournoi($id_Tournois);
    //Ajout des nouveau jeux du tournoi
    foreach ($_POST['jeuxtournoi'] as $jeu) {
        $sql->addConcerner($id_Tournois, $jeu);
    }


}   
$reqJeuduTournois = $sql->getJeuxTournois($id_Tournois);
$reqNonPresentTurnois = $sql->jeuNonPresentDansTournois($id_Tournois);
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
                $info_execution_jeu = "Jeu ajouté !";
            } catch (Exception $e) {
                $info_execution_jeu = "Erreur lors de l'ajout du jeu !";
            }
        } else {
            $info_execution_jeu = "Le jeu existe déjà";
        }
    }
}



?>

<body>
    <main class="main-creation-tournoi">
        <section class="creation-tournoi-container">
            <form action="<?php echo "modification-tournoi.php?id=" . $id_Tournois ?>" method="POST">

                <h1 class="creation-tournoi-title">Modifier un tournoi</h1>
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
                                    echo '<option value="Local" selected>Local (50 points)</option>';
                                }else{
                                    echo '<option value="Local">Local (50 points)</option>';
                                }
                                if ($type == "National") {
                                    echo '<option value="National" selected>National (100 points)</option>';
                                }else{
                                    echo '<option value="National">National (100 points)</option>';
                                }
                                if ($type == "International") {
                                    echo '<option value="International" selected>International (150 points)</option>';
                                }else{
                                    echo '<option value="International">International (150 points)</option>';
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
                            <span id="spaninfojeu"><?php echo $info_execution_jeu ?> </span>
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
                if (a.length == 0) {
                    mainsubmit.classList.remove("submit-active");
                    spaninfojeu.innerHTML = "Aucun jeu sélectionné";
                } else {
                    spaninfojeu.innerHTML = a.length + " jeu(x) enregistré(s) !";
                }
            });
        });
    </script>
</body>

</html>