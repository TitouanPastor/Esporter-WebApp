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
        if(!empty($_POST['nom-ecurie']) && !empty($_POST['statut-ecurie']) && !empty($_POST['email-ecurie']) && !empty($_POST['mdp-ecurie'])){
            try{   
                require_once('../../SQL.php');
                $sql = new requeteSQL();
                // Ajout d'une écurie (le dernier 1 correspond à l'id gestionnaire)
                $sql->addEcurie($_POST['nom-ecurie'],$_POST['statut-ecurie'],$_POST['mdp-ecurie'],$_POST['email-ecurie'],1);
                $info_execution = 'Equipe enregistrée !';
            }catch(Exception $e){
                $info_execution = "Erreur : " . $e->getMessage();
            }
        }
    ?>
<body>
    <main class="main-creation-tournoi">
        <section class="creation-tournoi-container">
            <form action="enregistrer-ecurie.php" method="POST">

                <h1 class="creation-tournoi-title">Enregistrer une équipe</h1>
                <div class="creation-tournoi">
                    <div class="creation-tournoi-left">
                        <div class="creation-tournoi-input">
                            <label for="nom-equipe">Nom de l'équipe</label>
                            <input type="text" name="nom-equipe" id="nom-equipe">
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="jeu-equipe">Jeu</label>
                            <input type="text" name="jeu-equipe" id="jeu-equipe">
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

                    <div class="creation-tournoi-right">
                        <div class="creation-tournoi-input">
                            <input class="update" type="submit" name="Ajouter un Joueur" value="Ajouter un Joueur">
                        </div>
                        <div class="creation-tournoi-input">
                            </br>
                            <input class= "update" type="submit" name="Ajouter un Joueur" value="Ajouter un Joueur">
                        </div>
                        <div class="creation-tournoi-input">
                            </br>
                            <input class="update" type="submit" name="Ajouter un Joueur" value="Ajouter un Joueur">
                        </div>
                        <div class="creation-tournoi-input">
                            </br>
                            <input class="update" type="submit" name="Ajouter un Joueur" value="Ajouter un Joueur">
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