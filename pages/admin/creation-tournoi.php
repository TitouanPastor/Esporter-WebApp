<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<?php
require_once(realpath(dirname(__FILE__) . '/../../class/header.php'));
$header = new header(2);
echo $header->header_admin();
$info_execution = "Tournoi non ajouté";
if (!empty($_POST['nom-tournoi']) && !empty($_POST['type-tournoi']) && !empty($_POST['jeux-tournoi']) && !empty($_POST['date-debut']) && !empty($_POST['date-fin']) && !empty($_POST['lieu-tournoi']) && !empty($_POST['notoriete-tournoi']) && !empty($_POST['points-tournoi']) && !empty($_POST['lieu-tournoi'])) {
    try {
        require_once(realpath(dirname(__FILE__) . '/../../SQL.php'));
        $sql = new requeteSQL();
        // Ajout d'un tournoi (les deux derniers 1 correspondent au id du gestionnaire et de l'arbitre)
        $sql->addTournoi($_POST['type-tournoi'], $_POST['nom-tournoi'], $_POST['date-debut'], $_POST['date-fin'], $_POST['notoriete-tournoi'], $_POST['lieu-tournoi'], $_POST['points-tournoi'], 1, 1);
        // Récupération de l'ID dernier tournoi créer
        $idTournoi = $sql->getLastIDTournoi();
        // Ajout des jeux du tournoi
        $sql->addConcerner($idTournoi, 1);
        $info_execution = 'Tournoi ajouté !';
    } catch (Exception $e) {
        $info_execution = "Erreur : " . $e->getMessage();
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
                            <input type="text" name="nom-tournoi" id="nom-tournoi">
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="type-tournoi">Type du tournoi</label>
                            <select name="comboboxtypetournoi" id="comboboxtypetournoi">
                                <option value="Local">Local</option>
                                <option value="National">National</option>
                                <option value="International">International</option>
                            </select>
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="jeux-tournoi">Jeux présents</label> 
                            <select name="comboboxtypetournoi" id="comboboxtypetournoi">
                                <!-- rempli avec la balise option et requetes les jeux ici -->
                            </select>
                            <input type="text" name="jeux-tournoi" id="jeux-tournoi">
                            <input type="submit" value="Ajouter un jeu" class="submit add">
                        </div>
                    </div>

                    <div class="creation-tournoi-right">
                        <div class="creation-tournoi-input">
                            <label for="date-tournoi">Nombre de points distribués</label>
                            <input type="text" name="points-tournoi" id="points-tournoi">
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="lieu-tournoi">Lieu du tournoi</label>
                            <input type="text" name="lieu-tournoi" id="lieu-tournoi">
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
</body>


</html>