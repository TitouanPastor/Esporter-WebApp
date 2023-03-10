<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrer équipe - E-Sporter</title>
    <link rel="icon" href="../../img/esporter-icon.png">
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <main class="main-creation-tournoi">
        <section class="creation-tournoi-container">
            <form action="enregistrer-equipe.php" method="POST">

                <h1 class="creation-tournoi-title">Enregistrer une Équipe</h1>
                <div class="creation-tournoi">
                    <div class="creation-tournoi-left">
                        <div class="creation-tournoi-input">
                            <label for="nom-equipe">Nom de l'équipe</label>
                            <input type="text" name="nom-equipe" id="nom-equipe">
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="jeu-equipe">Jeu</label>
                            <select name="jeu_equipe" id="jeu-equipe">
                                ##AffichageJeux##
                            </select>
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="email-equipe">Email</label>
                            <input type="text" name="email-equipe" id="email-equipe">
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="mdp-equipe">Mot de Passe</label>
                            <input type="password" name="mdp-equipe" id="mdp-equipe">
                        </div>
                    </div>
                </div>
                <input class="submit" type="submit" name="ajouter" value="Ajouter">
                <span>##infoExecution</span>
            </form>
        </section>
    </main>
</body>


</html>