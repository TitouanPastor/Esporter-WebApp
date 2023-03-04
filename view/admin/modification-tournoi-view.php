<!DOCTYPE html>
<html lang="fr">

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
    <script src="../../js/bootstrap-multiselect.js"></script>
    <link href="../../css/bootstrap-multiselect.css" rel="stylesheet" />

</head>


<body>
    <main class="main-creation-tournoi">
        <section class="creation-tournoi-container">
            <form action="modification-tournoi-view.php?id= ##idTournoi##" method="POST">

                <h1 class="creation-tournoi-title">Modifier un Tournoi</h1>
                <div class="creation-tournoi">
                    <div class="creation-tournoi-left">
                        <div class="creation-tournoi-input">
                            <label for="nom-tournoi">Nom du tournoi</label>
                            <input type="text" name="nom-tournoi" id="nom-tournoi" value="##nom##">
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="type-tournoi">Type du tournoi</label>
                            <select name="type-tournoi" id="type-tournoi">
                                ##typeTournoi##
                            </select>
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="jeux-tournoi">Jeux présents</label>

                            <!-- Select caché pour récuperer les jeux dans le POST -->
                            <select name="jeuxtournoi[]" id="hiddenselect" hidden multiple></select>

                            <select name="comboboxjeutournoi" id="chkveg" multiple="multiple">
                                ##jeu##
                            </select>
                            <input class="add ajouterjeu-valid" type="button" id="ajouterjeux" value="Valider la sélection" style="margin-bottom: 30px;">

                            <input type="text" name="jeux-tournoi" id="jeux-tournoi" placeholder="Ajouter un jeu non présent">
                            <input type="submit" value="Ajouter un jeu" class="submit add" name="ajouterJeu">
                            <span id="spaninfojeu">##infoExecutionJeu## </span>
                        </div>
                    </div>

                    <div class="creation-tournoi-right">
                        <div class="creation-tournoi-input">
                            <label for="date-tournoi-deb">Date du debut du tournoi</label>
                            <input type="date" name="date-tournoi-deb" id="date-tournoi-deb" value="##dateTournoisDeb##">
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="date-tournoi-fin">Date de fin du tournoi</label>
                            <input type="date" name="date-tournoi-fin" id="date-tournoi-fin" value="##dateTournoisFin##">
                        </div>
                        <div class="creation-tournoi-input">
                            <label for="lieu-tournoi">Lieu du tournoi</label>
                            <input type="text" name="lieu-tournoi" id="lieu-tournoi" value="##lieu##">
                        </div>
                    </div>
                </div>
                <input class="update" type="submit" name="modifier" value="Modifier">
                <span>##infoExecution## </span>
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
                console.log(a.length    )
                if (a.length == 0) {
                    
                    spaninfojeu.innerHTML = "Aucun jeu sélectionné";
                } else {
                    spaninfojeu.innerHTML = a.length + " jeu(x) enregistré(s) !";
                }
            });
        });
    </script>
</body>

</html>