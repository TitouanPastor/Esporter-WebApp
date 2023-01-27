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
    $header = new header(2);
    require_once('bracket.php');
    $bracket = new bracket();

    // Fermeture d'un tournoi et génération du bracket
    if (isset($_GET['close_id'])) {
        $closeId = $_GET['close_id'];
        $bracket->genererBracket($closeId);
    }

    if ($_SESSION['role'] == "gestionnaire") {
        echo $header->customizeHeader($_SESSION['role']);
    } else {
        header('Location: ../../acces-refuse.php');
    }
    ?>
    <main class="main-listes">
        <!-- div de notification pour informer que le tournoi à été généré -->
        <div class="notification">
            <div class="notification-content">
                <div>
                    <div class="notification-header">
                        <h4>Confirmation</h4>
                    </div>
                    <div class="notification-body">
                        <p>texte a remplir dynamiquement</p>
                    </div>
                </div>
                <div class="notification-footer">
                    <!-- image svg check verte -->
                    <svg height="20px" width="20px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" xml:space="preserve">
                        <g>
                            <g id="check">
                                <g>
                                    <polygon style="fill:#5f43b2;" points="11.941,28.877 0,16.935 5.695,11.24 11.941,17.486 26.305,3.123 32,8.818 			" />
                                </g>
                            </g>
                        </g>
                    </svg>
                </div>
            </div>
        </div>
        <!-- div de confirmation pour fermer un tournoi -->
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
            <h1>Liste des Tournois</h1>
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

        // Fonction qui notifie l'utilisateur que le tournoi a bien été fermé et qui s'affiche sous la forme d'une notification
        function notify() {
            var notification = document.querySelector('.notification');
            notification.classList.add('notification-active');
            setTimeout(function() {
                notification.classList.remove('notification-active');
            }, 5000);
        }
        // Fonction qui cherche lorsque la page est chargée si il y a un paramètre ?param dans l'url
        window.onload = function() {
            var url = window.location.href;
            if (url.indexOf('?close_id') != -1) {
                var texteNotif = document.querySelector('.notification-body p');
                texteNotif.innerHTML = "Le tournoi a bien été fermé.";
                // On change l'url de la page en enlevant le variable ?close_id
                window.history.pushState("", "", "liste-tournois.php");
                notify();
            } else if (url.indexOf('?modifyTournoi') != -1) {
                var texteNotif = document.querySelector('.notification-body p');
                texteNotif.innerHTML = "Le tournoi a bien été modifié.";
                window.history.pushState("", "", "liste-tournois.php");
                notify();
            } else if (url.indexOf('?createTournoi') != -1) {
                var texteNotif = document.querySelector('.notification-body p');
                texteNotif.innerHTML = "Le tournoi a bien été créé.";
                window.history.pushState("", "", "liste-tournois.php");
                notify();
            }
        }
    </script>
    <script type="text/javascript" src="../../main.js"></script>
</body>

</html>