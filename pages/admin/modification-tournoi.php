<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../../css/style.css">
</head>

<body>
    <main class="main-creation-tournoi">
        <section class="creation-tournoi-container">
            <form action="creation-tournoi.php" method="POST">

                <h1 class="creation-tournoi-title">Modifier un tournoi</h1>
                <div class="creation-tournoi">
                    <div class="creation-tournoi-left">
                        <div class="creation-tournoi-input">
                            <label for="nom-tournoi">Nom du tournoi</label>
                            <input type="text" name="nom-tournoi" id="nom-tournoi">
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="type-tournoi">Type du tournoi</label>
                            <input type="text" name="type-tournoi" id="type-tournoi">
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="jeux-tournoi">Jeux présents</label>
                            <input type="text" name="jeux-tournoi" id="jeux-tournoi">
                        </div>
                    </div>

                    <div class="creation-tournoi-right">
                        <div class="creation-tournoi-input">
                            <label for="date-tournoi">Nombre de points distribués</label>
                            <input type="text" name="points-tournoi" id="points-tournoi">
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="date-tournoi">Date du tournoi</label>
                            <input type="date" name="date-tournoi" id="date-tournoi">
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="lieu-tournoi">Lieu du tournoi</label>
                            <input type="text" name="lieu-tournoi" id="lieu-tournoi">
                        </div>
                    </div>
                </div>
                <input class="update" type="submit" name="modifier" value="Modifier">
            </form>
        </section>
    </main>
</body>

</html>