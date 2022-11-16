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
        $info_execution = "Joueurs non enregistrés";
        require_once(realpath(dirname(__FILE__) . '/../../SQL.php'));
        if(isset($_POST['Ajouter un Joueur'])) {
            try{   
                // $sql = new requeteSQL();
                // Ajout d'une écurie (le dernier 1 correspond à l'id gestionnaire)
                // $sql->addEquipe($_POST['nom-equipe'],$_POST['jeu-equipe'],$_POST['mdp-equipe'],$_POST['email-equipe'],1);
                $info_execution = 'Joueurs enregistrés !';
                header ("Refresh: 0;URL=enregistrer-1joueur.php");
            }catch(Exception $e){
                $info_execution = "Erreur : " . $e->getMessage();
            }
        } 
    ?>
<body>
    <main class="main-creation-tournoi">
        <section class="creation-tournoi-container">
            <form action="enregistrer-joueurs.php" method="POST">

                <h1 class="creation-tournoi-title">Enregistrer les joueurs</h1>
                <div class="creation-tournoi">
                    <div class="creation-tournoi-left">
                        <div class="creation-tournoi-input">
                            <input class="boutonAddJoueur" type="button" name="Joueur1" onclick="self.location.href='enregistrer-1joueur.php'" value="Ajouter un Joueur">
                        </div>
                         <div class="creation-tournoi-input">
                            </br>
                            <input class="bouton" type="button" name="Joueur2" onclick="self.location.href='enregistrer-1joueur.php'" value="Ajouter un Joueur">
                        </div>
                        <div class="creation-tournoi-input">
                            </br>
                            <input class="bouton" type="button" name="Joueur3" onclick="self.location.href='enregistrer-1joueur.php'" value="Ajouter un Joueur">
                        </div>
                        <div class="creation-tournoi-input">
                            </br>
                            <input class="bouton" type="button" name="Joueur4" onclick="self.location.href='enregistrer-1joueur.php'" value="Ajouter un Joueur">
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