<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier - E-Sporter</title>
    <link rel="icon" href="../../img/esporter-icon.png">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/style_calendrier.css">
</head>

<body>
    <?php
    
        # Initialisation de la session
        session_start();

        # Importation des fichiers
        require_once(realpath(dirname(__FILE__) . '/../../class/header.php'));
        require_once(realpath(dirname(__FILE__) . '/../../SQL.php'));
        
        # Affichage du header
        $header = new header(2);
        echo $header->customizeHeader($_SESSION['role']);

       
        # Création object et initialisation des variables
        $sql = new requeteSQL();
        $checkValider = 0;
        
        #Exécution de la requête en fonction des paramètres fournis (liste rempli ou non)
        if (isset($_POST["valider"])) {
            $checkValider = 1;
            $param = array();
            $param[0] = $_POST["tournoi_date"];
            $param[1] = $_POST["tournoi_nom"];
            $param[2] = $_POST["tournoi_jeu"];
            $req = $sql -> getTournoiCalendrier($param);
        }

        # Contrôle sur la minimum et maximum à selectionner (date 01/01/2023 au 31/12/2023)
        $min = new DateTime('01-01-2023');
        $max = new DateTime('31-12-2023');    
        $dateMin = $min -> format('Y-m-d');
        $dateMax = $max -> format('Y-m-d');

        # Valeur et affichage d'une liste -> conserver la valeur après validation
        if (isset($_POST["tournoi_date"])){
            $valueTournoiDate = $_POST["tournoi_date"];
        } else {
            $valueTournoiDate = "2023-01-01";
        }

        if (isset($_POST["tournoi_nom"])){ 
            $valueTournoiNom = $_POST["tournoi_nom"];
        } else {
            $valueTournoiNom = "default";
        }

        if (isset($_POST["tournoi_jeu"])){
            $valueTournoiJeu = $_POST["tournoi_jeu"];
        } else {
            $valueTournoiJeu = "default";
        }


    ?>
    <main class ="main-listes">
        <section class="main-listes-container">
            <div class="title">
                <h1 class="firsttitle">Calendrier des Tournois</h1>
                <svg width="60px" height="60px" viewBox="0 0 1024 1024" class="icon"  version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <path d="M106.666667 810.666667V298.666667h810.666666v512c0 46.933333-38.4 85.333333-85.333333 85.333333H192c-46.933333 0-85.333333-38.4-85.333333-85.333333z" fill="#CFD8DC" /><path d="M917.333333 213.333333v128H106.666667v-128c0-46.933333 38.4-85.333333 85.333333-85.333333h640c46.933333 0 85.333333 38.4 85.333333 85.333333z" fill="#F44336" /><path d="M704 213.333333m-64 0a64 64 0 1 0 128 0 64 64 0 1 0-128 0Z" fill="#B71C1C" /><path d="M320 213.333333m-64 0a64 64 0 1 0 128 0 64 64 0 1 0-128 0Z" fill="#B71C1C" /><path d="M704 64c-23.466667 0-42.666667 19.2-42.666667 42.666667v106.666666c0 23.466667 19.2 42.666667 42.666667 42.666667s42.666667-19.2 42.666667-42.666667V106.666667c0-23.466667-19.2-42.666667-42.666667-42.666667zM320 64c-23.466667 0-42.666667 19.2-42.666667 42.666667v106.666666c0 23.466667 19.2 42.666667 42.666667 42.666667s42.666667-19.2 42.666667-42.666667V106.666667c0-23.466667-19.2-42.666667-42.666667-42.666667z" fill="#B0BEC5" /><path d="M277.333333 426.666667h85.333334v85.333333h-85.333334zM405.333333 426.666667h85.333334v85.333333h-85.333334zM533.333333 426.666667h85.333334v85.333333h-85.333334zM661.333333 426.666667h85.333334v85.333333h-85.333334zM277.333333 554.666667h85.333334v85.333333h-85.333334zM405.333333 554.666667h85.333334v85.333333h-85.333334zM533.333333 554.666667h85.333334v85.333333h-85.333334zM661.333333 554.666667h85.333334v85.333333h-85.333334zM277.333333 682.666667h85.333334v85.333333h-85.333334zM405.333333 682.666667h85.333334v85.333333h-85.333334zM533.333333 682.666667h85.333334v85.333333h-85.333334zM661.333333 682.666667h85.333334v85.333333h-85.333334z" fill="#90A4AE" />
                </svg>
            </div>
            <h1></h1>

            <form action="" method="post">
                <div class="container">
                    <!-- Affichage du choix des dates -->
                    <input type="date" name="tournoi_date" class="element" value="<?php echo $valueTournoiDate?>"min="<?php echo $dateMin;?>" max="<?php echo $dateMax;?>">

                    <select name="tournoi_nom" class="element" class="select">
                        <option value="default" selected>Sélectionner un tournoi</option>
                        <?php
                            # Affichages des tournois dans une liste déroulante
                            $tournoi = $sql->getTournoi();
                            while ($donnees = $tournoi->fetch()) { ?>
                        <option value="<?php echo $donnees['Nom']; ?>" <?php if ($valueTournoiNom == $donnees['Nom']) echo 'selected'?>>
                            <?php echo $donnees['Nom']; ?>
                        </option>
                        <?php } ?>
                    </select>

                    <select name="tournoi_jeu" class="element" class="select">
                        <option value="default" selected>Sélectionner un jeu</option>
                            <?php
                             # Affichages des jeux dans une liste déroulante
                            $jeu = $sql->getJeux();
                            while ($donnees = $jeu->fetch()) { ?>
                            <option value="<?php echo $donnees['Libelle']; ?>" <?php if ($valueTournoiJeu == $donnees['Libelle']) echo 'selected';?>>
                                <?php echo $donnees['Libelle']; ?>
                            </option>
                            <?php } ?>
                    </select>

                    <input name="valider" type="submit" class="submit" class="element" value="valider">
                </div>
                <?php
                
                # Affichage des tournois selon les critères séléctionné 
                if ($checkValider == 1) {
                    if ($req -> rowCount() == 0){
                        echo "<div style='display : flex; justify-content :center; padding-top : 50px;'> Il n'y a pas de tournoi pour ces critères </div>";
                    } else {
                        echo "
                    <div class = 'tableau-style'>
                    <table>
                        <thead>
                            <tr>
                                <th> Nom du Tournoi </th>
                                <th> Date du tournoi</th>
                                <th> Jeu du Tournoi </th>
                            </tr>
                        </thead>
        
                        <tbody>";
                        while ($donnees = $req->fetch()) {
                            echo '
                            <tr>
                                <td>' . $donnees[0] . '</td>
                                <td>' . date('d / m / Y', strtotime($donnees[1])). '</td>
                                <td>' . $donnees[2] . '</td>
                            </tr>
                            ';
                        }
                        echo "
                            </tbody>
                            </table>
                            </div>
                        </form>
                    ";
                    } 
                }
                ?>
            </form>
        </section>
    </main>
</body>

</html>