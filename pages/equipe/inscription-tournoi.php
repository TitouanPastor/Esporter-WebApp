<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Tournoi - E-Sporter</title>
    <link rel="icon" href="../../img/esporter-icon.png">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/style-inscription.css">
</head>

<body>
    <?php
    //Header
    session_start();
    require_once(realpath(dirname(__FILE__) . '/../../class/header.php'));
    $header = new header(2);

    if ($_SESSION['role'] == "equipe") {
        echo $header->customize_header($_SESSION['role']);
    } else {
        header('Location: ../../acces-refuse.php');
    }

    //Sql
    require_once(realpath(dirname(__FILE__) . '/../../SQL.php'));
    $sql = new requeteSQL();

    //Sauvegarde de la valeur de la liste
    if (isset($_POST["tournoi-jeu"])) {
        $valueTournoiJeu = $_POST["tournoi-jeu"];
    } else {
        $valueTournoiJeu = "default";
    }
    $req = $sql->getJeuEquipe($_SESSION['username']);
    $jeuEquipe = $req->fetchColumn();
    $param = $jeuEquipe;
    $req = $sql->getTournoiInscription($param);

    //Requête d'inscription au tournoi cliqué
    if (isset($_GET['id'])) {
        $param = [];
        $param[0] = $sql->getIdEquipe($_SESSION['username']);
        $param[1] = $_GET['id'];
        $param[2] = $sql->getIdJeu($jeuEquipe);
        $reqInscription = $sql->inscriptionTournoi($param);
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
                        <p>Inscription validée.</p>
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
                    <p>Voulez-vous vraiment vous inscrire à ce tournoi ?</p>
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
            <h1>Liste des Tournois à Venir</h1>
            <form action="post">
                <div class="container">
                    <span>Jeu de l'équipe :
                        <?php echo $jeuEquipe ?>
                    </span>
                    <table>
                        <thead>
                            <tr>
                                <th>Nom du tournoi</th>
                                <th>Date du tournoi</th>
                                <th>Equipes inscrites</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($donnees = $req->fetch()) {
                                if ($sql->estInscritTournoi($_SESSION['username'], $donnees[0]) == 0) {
                                    $reqNbEquipe = $sql->getNbEquipeTournoi($donnees[0]);
                                    $nbEquipe = $reqNbEquipe->fetchColumn();
                                    $idTournoi = $donnees[2];
                                    echo
                                    '<tr>
                                                <td>' . $donnees[0] . '</td>
                                                <td>' . date('d / m / Y', strtotime($donnees[1])) . '</td>
                                                <td>';
                                    echo $nbEquipe . ' / 16';
                                    echo '<td>';
                                    if ((16 - $nbEquipe) != 0) {
                                        echo "<a style='text-decoration: underline;cursor:pointer;color:blue;' value='inscription-tournoi.php?id=$idTournoi' onclick='openPopUp(this)' >S'inscrire</a>";
                                        
                                    } else {
                                        echo "<input type = 'button' class = 'bouton' title = 'Complet' disabled>";
                                    }
                                    echo '</td>
                                            </tr>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </form>

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
        // Fonction qui cherche lorsque la page est chargée si il y a un paramètre ?id dans l'url
        window.onload = function() {
            var url = window.location.href;
            if (url.indexOf('?id') != -1) {
                notify();
            }
        }
    </script>
</body>

</html>