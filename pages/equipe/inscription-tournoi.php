<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inscription Tournoi</title>
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
        if (isset($_POST["tournoi-jeu"])){
            $value_tournoi_jeu = $_POST["tournoi-jeu"];
        } else {
            $value_tournoi_jeu = "default";
        }
        $req = $sql -> getJeuEquipe($_SESSION['username']);
        $jeu_equipe = $req -> fetchColumn();
        $param = $jeu_equipe;
        $req = $sql -> getTournoiInscription($param);

        ?>
        <main class ="main-listes">
            <section class="main-listes-container">
                <h1>Liste des tournois à venir</h1>
                <form action="post">
                    <div class ="container">
                        <span>Jeu de l'équipe : <?php echo $jeu_equipe?> </span>
                        <table>
                            <thead>
                                <tr>
                                    <th>Nom du tournoi</th>
                                    <th>Date du tournoi</th>
                                    <th>Nombre de place</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    while ($donnees = $req -> fetch()){
                                    $req = $sql->getNbEquipeTournoi($donnees[0]);
                                    $nb_equipe = $req->fetchColumn();
                                    echo
                                        '<tr>
                                        <td>' . $donnees[0] . '</td>
                                        <td>' . date('d-m-Y', strtotime($donnees[1])) . '</td>
                                        <td>';
                                        echo 16 - $nb_equipe.' / 16';
                                        echo '<td>';
                                        if ((16 - $nb_equipe) != 0){
                                            echo "<input type = 'button' value = \"S'inscrire\">";
                                        } else {
                                            echo "<input type = 'button' value = 'Complet' disabled>";
                                        }
                                        echo '</td>
                                        <tr>';
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </form>

            </section>

        </main>
    </body>
</html>