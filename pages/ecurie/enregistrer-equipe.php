<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrer équipe - E-Sporter</title>
    <link rel="icon" href="../../img/esporter-icon.png">
    <link rel="stylesheet" href="../../css/style.css">
</head>



<?php

// Création du header
session_start();
require_once(realpath(dirname(__FILE__) . '/../../class/header.php'));
$header = new header(2);
echo $header->customize_header($_SESSION['role']);

// Initialisation des variables
$info_execution = "";
require_once(realpath(dirname(__FILE__) . '/../../SQL.php'));
$sql = new requeteSQL();
$reqJeu = $sql->getJeux();

// Ajouter une équipe
if (isset($_POST['ajouter'])) {
    // Vérification de si tout les champs sont remplis
    if(!empty($_POST['nom-equipe']) && !empty($_POST['jeu_equipe']) && !empty($_POST['email-equipe']) && !empty($_POST['mdp-equipe'])){
        //Vérification de si une équipe dans l'écurie n'a pas ce jeu
        $id = $sql->getIdEcurieByMail($_SESSION['username']);
        $equipes = $sql->getEquipeEcurie('$id');
        $sameJeu = False;
        while($equipe = $equipes->fetch()) {
            if ($equipe['Id_Jeu'] == $_POST['Id_Jeu']) {
                $sameJeu = True;
            }
        }
        if(!$sameJeu){    
            //Vérification de si une équipe du même nom n'existe pas déjà
            $equipes = $sql->getEquipe();
            $sameEquipe = False;
            while($equipe = $equipes->fetch()) {
                if (strtoupper($equipe['Nom']) == strtoupper($_POST['nom-equipe'])) {
                    $sameEquipe = True;
                }
            }
            if(!$sameEquipe){
                try{   
                    //Ajout d'une équipe (le dernier 1 correspond à l'id gestionnaire)
                    //$sql->addEquipe($_POST['nom-equipe'],$_POST['jeu-equipe'],$_POST['mdp-equipe'],$_POST['email-equipe'],1);
                    $info_execution = 'Equipe enregistrée !';
                    //header ("Refresh: 3;URL=enregistrer-joueurs.php");
                }catch(Exception $e){
                    $info_execution = "Erreur lors de l'ajout de l'équipe ! Veuillez réessayer.";
                }
                $info_execution = "L'équipe a bien été ajoutée";
            }else{
                $info_execution = "Une équipe avec le même nom existe déjà !";
            }
        } else {
            $info_execution = "Une équipe dans l'écurie avec le même jeu existe déjà !";
        }
    } else {
        $info_execution = "Veuillez remplir tous les champs";
    }
}
        
?>


<body>
    <main class="main-creation-tournoi">
        <section class="creation-tournoi-container">
            <form action="enregistrer-equipe.php" method="POST">

                <h1 class="creation-tournoi-title">Enregistrer une équipe</h1>
                <div class="creation-tournoi">
                    <div class="creation-tournoi-left">
                        <div class="creation-tournoi-input">
                            <label for="nom-equipe">Nom de l'équipe</label>
                            <input type="text" name="nom-equipe" id="nom-equipe">
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="jeu-equipe">Jeu</label>
                            <select name="jeu_equipe" id="jeu-equipe"> 
                            <?php
                                //Affichage de la liste de tout les jeux enregistrés dans la base de données
                                while ($data = $reqJeu->fetch()) {
                                    echo '<option value="' . $data['Id_Jeu'] . '">' . $data['Libelle'] . '</option>';
                                }
                            ?>
                            </select>
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="email-equipe">Email</label>
                            <input type="text" name="email-equipe" id="email-equipe">
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="mdp-equipe">Mot de Passe</label>
                            <input type="text" name="mdp-equipe" id="mdp-equipe">
                        </div>
                    </div>

                </div>
                <input class="submit" type="submit" name="ajouter" value="Ajouter">
                <span><?php echo $info_execution?> </span>
            </form>
        </section>
    </main>
</body>


</html>