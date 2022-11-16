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
        $info_execution = "Joueur non enregistré";
        require_once(realpath(dirname(__FILE__) . '/../../SQL.php'));
        if(!empty($_POST['nom-joueur'])  && !empty($_POST['prenom-joueur']) && !empty($_POST['dtn_joueur']) && !empty($_POST['pseudo_joueur']) && !empty($_POST['email_joueur'])) {
            try{   
                // $sql = new requeteSQL();
                // Ajout d'une écurie (le dernier 1 correspond à l'id gestionnaire)
                // $sql->addEquipe($_POST['nom-equipe'],$_POST['jeu-equipe'],$_POST['mdp-equipe'],$_POST['email-equipe'],1);
                $info_execution = 'Joueur enregistré !';
                header ("Refresh: 2;URL=enregistrer-joueurs.php");
            }catch(Exception $e){
                $info_execution = "Erreur : " . $e->getMessage();
            }
        } 
    ?>
<body>
    <main class="main-creation-tournoi">
        <section class="creation-tournoi-container">
            <form action="enregistrer-1joueur.php" method="POST">

                <h1 class="creation-tournoi-title">Enregistrer un joueur</h1>
                <div class="creation-tournoi">
                    <div class="creation-tournoi-left">
                        <div class="creation-tournoi-input">
                            <label for="nom-joueur">Nom du joueur</label>
                            <input type="text" name="nom-joueur" id="nom-joueur">
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="prenom-joueur">Prenom du joueur</label>
                            <input type="text" name="prenom-joueur" id="prenom-joueur">
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="dtn_joueur">Date de naissance</label>
                            <input type="date" name="dtn_joueur" id="dtn_joueur">
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="pseudo_joueur">Pseudo</label>
                            <input type="text" name="pseudo_joueur" id="pseudo_joueur">
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="email_joueur">Email</label>
                            <input type="text" name="email_joueur" id="email_joueur">
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