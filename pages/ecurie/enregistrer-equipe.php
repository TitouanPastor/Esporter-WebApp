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
        $info_execution = "Equipe non enregistrée";
        require_once(realpath(dirname(__FILE__) . '/../../SQL.php'));
        if(!empty($_POST['nom-equipe'])  && !empty($_POST['email-equipe']) && !empty($_POST['mdp-equipe'])) {
            try{   
                // $sql = new requeteSQL();
                // Ajout d'une écurie (le dernier 1 correspond à l'id gestionnaire)
                // $sql->addEquipe($_POST['nom-equipe'],$_POST['jeu-equipe'],$_POST['mdp-equipe'],$_POST['email-equipe'],1);
                $info_execution = 'Equipe enregistrée !';
                header ("Refresh: 3;URL=enregistrer-joueurs.php");
            }catch(Exception $e){
                $info_execution = "Erreur : " . $e->getMessage();
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
                            <select name="jeu_equipe"> 
                            <?php
                                $sql = new requeteSQL();
                                $jeu = $sql -> getJeu();
                                while ($donnees = $jeu -> fetch()){?>
                                    <option value="<?php echo $donnees['Id_Jeu'];?>"><?php echo $donnees['Libelle'];?></option>
                            <?php } ?>  
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