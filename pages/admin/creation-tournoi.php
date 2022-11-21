<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link href="https://unpkg.com/bootstrap@3.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://unpkg.com/jquery@3.3.1/dist/jquery.min.js"></script>
    <script src="https://unpkg.com/bootstrap@3.3.2/dist/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/bootstrap-multiselect@0.9.13/dist/js/bootstrap-multiselect.js"></script>
    <link href="https://unpkg.com/bootstrap-multiselect@0.9.13/dist/css/bootstrap-multiselect.css" rel="stylesheet" />

</head>
<?php
require_once(realpath(dirname(__FILE__) . '/../../class/header.php'));
$header = new header(2);
echo $header->header_admin();
$info_execution = "";
$info_execution_jeu = "";
require_once(realpath(dirname(__FILE__) . '/../../SQL.php'));
$sql = new requeteSQL();
$reqJeu = $sql->getJeux();
if (isset($_POST['ajouter'])) {


    try {


        // Ajout d'un tournoi (les deux derniers 1 correspondent au id du gestionnaire et de l'arbitre)
        $sql->addTournoi($_POST['comboboxtypetournoi'], $_POST['nom-tournoi'], $_POST['date-debut'], $_POST['date-fin'], $_POST['lieu-tournoi'], $_POST['points-tournoi'], 1, 1);
        // Récupération de l'ID dernier tournoi créer
        $idTournoi = $sql->getLastIDTournoi();
        // Ajout des jeux du tournoi
        $sql->addConcerner($idTournoi, 1);
        $info_execution = 'Tournoi ajouté !';
    } catch (Exception $e) {
        $info_execution = "Erreur : " . $e->getMessage();
    }
}

if (isset($_POST['ajouterJeu'])) {
    if (!empty($_POST['jeux-tournoi'])) {
        try {
            $sql->addJeu($_POST['jeux-tournoi']);
            $reqJeu = $sql->getJeux();
            $info_execution_jeu = "Jeu ajouté !";
        } catch (Exception $e) {
            if (strpos($e->getMessage(), "1062") !== False) {
                $info_execution_jeu = "Le jeu existe déjà !";
            } else {
                $info_execution_jeu = "Erreur lors de l'ajout du jeu !";
            }
        }
    }
}

?>

<body>
    <main class="main-creation-tournoi">
        <section class="creation-tournoi-container">
            <form action="creation-tournoi.php" method="POST">

                <h1 class="creation-tournoi-title">Création d'un tournoi</h1>
                <div class="creation-tournoi">
                    <div class="creation-tournoi-left">
                        <div class="creation-tournoi-input">
                            <label for="nom-tournoi">Nom du tournoi</label>
                            <input type="text" name="nom-tournoi" id="nom-tournoi" placeholder="Nom">
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="type-tournoi">Type du tournoi</label>
                            <select name="comboboxtypetournoi" id="comboboxtypetournoi">
                                <option type="checkbox" value="Local">Local</option>
                                <option value="National">National</option>
                                <option value="International">International</option>
                            </select>
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="jeux-tournoi">Jeux présents</label>
                            <select  name="comboboxjeutournoi[]" id="chkveg" multiple="multiple">
                                <?php
                                while ($data = $reqJeu->fetch()) {

                                    echo '<option value="' . $data['Id_Jeu'] . '">' . $data['Libelle'] . '</option>';
                                }
                                ?>
                            </select>
                            <input type="button" id="btnget" value="Get Selected Values" />
                            <input type="text" name="jeux-tournoi" id="jeux-tournoi" placeholder="Ajouter un jeu non présent">
                            <input type="submit" value="Ajouter un jeu" class="submit add" name="ajouterJeu">
                            <span><?php echo $info_execution_jeu ?> </span>
                        </div>
                    </div>

                    <div class="creation-tournoi-right">
                        <div class="creation-tournoi-input">
                            <label for="points-tournoi">Nombre de points distribués</label>
                            <select name="points-tournoi" id="points-tournoi">
                                <option value="150">150 points</option>
                                <option value="100">100 points</option>
                                <option value="50">50 points</option>
                            </select>
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="lieu-tournoi">Lieu du tournoi</label>
                            <input type="text" name="lieu-tournoi" id="lieu-tournoi" placeholder="Lieu">
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="date-fin">Début du tournoi</label>
                            <input type="date" name="date-fin" id="date-fin">
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="date-debut">Fin du tournoi</label>
                            <input type="date" name="date-debut" id="date-debut">
                        </div>
                    </div>
                </div>
                <input class="submit" type="submit" name="ajouter" value="Ajouter">
                <span><?php echo $info_execution ?> </span>
                            </form>
        </section>
    </main>

    <script>
        $(function() {

            $('#chkveg').multiselect({
                includeSelectAllOption: true
            });

            $('#btnget').click(function() {
             var a = $('#chkveg').val();
             console.log(a)
            
            });
        });
    </script>
</body>


</html>