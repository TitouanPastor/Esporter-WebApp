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
       $check_valider = 0;

       //Sauvegarde de la valeur de la liste
       if (isset($_POST["tournoi-jeu"])) {
           $value_tournoi_jeu = $_POST["tournoi-jeu"];
       } else {
           $value_tournoi_jeu = "default";
       }
       $req = $sql->getJeuEquipe($_SESSION['username']);
       $jeu_equipe = $req->fetchColumn();
       $param = $jeu_equipe;
       $req = $sql->getTournoiInscription($param);

       //Requête d'inscription au tournoi cliqué
       if (isset($_GET['id'])) {
            $param = [];
            $param[0] = $sql -> getIdEquipe($_SESSION['username']);
            $param[1] = $_GET['id'];
            $param[2] = $sql -> getIdJeu($jeu_equipe);
            $reqInscription = $sql->inscriptionTournoi($param);
       }

       ?>
    <main class="main-listes">
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
                        <input style="background-color: var(--btn-bouton); cursor:pointer;" type="button" onclick="popupNo()"  class="popupconfirm-button" value="Non">
                    </form>
                </div>
            </div>
        </div>
        <section class="main-listes-container">
            <h1>Liste des tournois à venir</h1>
            <form action="post">
                <div class="container">
                    <span>Jeu de l'équipe :
                        <?php echo $jeu_equipe ?>
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
                                        $nb_equipe = $reqNbEquipe->fetchColumn();
                                        $id_tournoi = $donnees[2];
                                        echo
                                            '<tr>
                                                <td>' . $donnees[0] . '</td>
                                                <td>' . date('d / m / Y', strtotime($donnees[1])) . '</td>
                                                <td>';
                                        echo $nb_equipe . ' / 16';
                                        echo '<td>';
                                        if ((16 - $nb_equipe) != 0) {
                                            echo "<a style='text-decoration: underline;cursor:pointer;color:blue;' value='inscription-tournoi.php?id=$id_tournoi' onclick='openPopUp(this)' >S'inscrire</a>";
                                            // echo "<input type = 'submit' class ='submit' title = \"S'inscrire\" >";
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
    </script>
</body>

</html>