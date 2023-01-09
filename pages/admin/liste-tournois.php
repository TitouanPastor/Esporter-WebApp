<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournois - E-Sporter</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/style-inscription.css">
    <link rel="icon" href="../../img/esporter-icon.png">
</head>

<body>
    <?php
    session_start();
    require_once(realpath(dirname(__FILE__) . '/../../class/header.php'));
    /$header = new header(2);
    require_once('bracket.php');
    $bracket = new bracket();

    // Fermeture d'un tournoi et génération du bracket
    if (isset($_GET['close_id'])) {
        $close_id = $_GET['close_id'];
        $bracket->genererBracket($close_id);
    }

    if ($_SESSION['role'] == "gestionnaire") {
        echo $header->customize_header($_SESSION['role']);
    } else {
        header('Location: ../../acces-refuse.php');
    }
    ?>
    <main class="main-listes">
        <div class="popupconfirm">
            <div class="popupconfirm-content">
                <div class="popupconfirm-header">
                    <h2>Confirmation</h2>
                </div>
                <div class="popupconfirm-body">
                    <p>Voulez-vous vraiment fermer les inscriptions à ce tournoi ?</p>
                    <p>Cette action va générer les poules et les matchs du tournoi.</p>
                    <span class="idTournoi" style="display: none;"></span>
                </div>
                <div class="popupconfirm-footer">
                    <form action="post">
                        <input style="background-color: var(--btn-submit); cursor:pointer;" type="button" onclick="popupYes()" class="popupconfirm-button" value="Oui">
                        <input style="background-color: var(--btn-bouton); cursor:pointer;" type="button" onclick="popupNo()" class="popupconfirm-button" value="Non">
                    </form>
                </div>
            </div>
        </div>
        <section class="main-listes-container">
            <h1>Liste des tournois</h1>
            <span>Filtrer par: </span>
            <div class="main-listes-tabs">
                <div class="main-listes-filters">
                    <ul>
                        <li><button type="submit" name="filter3" class="btn-filter" onclick="changerTabListe(this, 'filter3')">Nom</button></li>
                        <li><button type="submit" name="filter1" class="btn-filter" onclick="changerTabListe(this, 'filter1')">Type</button></li>
                        <li><button type="submit" name="filter4" class="btn-filter" onclick="changerTabListe(this, 'filter4')">Date</button></li>
                        <li><button type="submit" name="filter2" class="btn-filter" onclick="changerTabListe(this, 'filter2')">Lieu</button></li>

                        <li><button type="submit" name="annuler" class="btn-filter btn-filter-active" onclick="changerTabListe(this, 'filterdefault')">par défaut</button></li>
                    </ul>
                </div>

                <?php
                require_once(realpath(dirname(__FILE__) . '/tri-tournois.php'));
                $triTournois = new TriTournois();
                ?>

                <div id="filter1" class="liste">
                    <?php
                    echo $triTournois->trierParType();
                    ?>
                </div>

                <div id="filter2" class="liste">
                    <?php
                    echo $triTournois->trierParLieu();
                    ?>
                </div>

                <div id="filter3" class="liste">
                    <?php
                    echo $triTournois->trierParNom();
                    ?>
                </div>

                <div id="filter4" class="liste">
                    <?php
                    echo $triTournois->trierParDate();
                    ?>
                </div>

                <div style="display: flex;" id="filterdefault" class="liste">
                    <?php
                    echo $triTournois->trierParId();
                    ?>
                </div>
            </div>
        </section>
    </main>
    <script>
        function openPopUp(a) {
            document.querySelector('.popupconfirm').style.display = 'flex';
            document.querySelector('.idTournoi').innerHTML = a.getAttribute('value');
        }

        function popupYes() {
            document.querySelector('.popupconfirm').style.display = 'none';
            window.location.href = document.querySelector('.idTournoi').innerHTML;
        }

        function popupNo() {
            document.querySelector('.popupconfirm').style.display = 'none';
        }
    </script>
    <script type="text/javascript" src="../../main.js"></script>
</body>

</html>