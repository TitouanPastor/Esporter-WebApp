<?php
$nbJoueurCreer = 0;
$nbEcurieCreer = 0;
$nbEquipeCreer = 0; 
$file = 'https://api.namefake.com/french-france/random/';
$data = file_get_contents($file);
$obj = json_decode($data);


$mdp = $obj->password;

require_once('SQL.php');
$sql = new requeteSQL();
$liste_jeu = ["Call Of Duty", "Counter Strike", "FIFA", "Fortnite", "League Of Legends", "Overwatch", "Rocket League", "Valorant", "Mario Party", "Mario Kart", "TrackMania", "Minecraft", "Rainbow Six Siege", "Splatoon 3"];
$liste_statut = ["Associative", "Professionnelle"];
//echo $liste_jeu[array_rand($liste_jeu)];
for ($ecurie = 1; $ecurie <10; $ecurie++) {
    $nomEcurie = $obj->company;
    $nomEcurie = explode(" ", $nomEcurie);
    if (count($nomEcurie) > 1) {
        array_pop($nomEcurie);
    }
    $nomEcurie = implode(" ", $nomEcurie);
    $sql->addEcurie($nomEcurie, $liste_statut[array_rand($liste_statut)], $mdp, str_replace(" ", "", $nomEcurie) . "@esporter.com", 1);
    $idEcurie = $sql->getIdEcurieByMail(str_replace(" ", "", $nomEcurie) . "@esporter.com"  );
    $liste_jeu_ecurie = array();
    $nbEquipe = rand(2,8);
    echo "[Création Ecurie] : " . $nomEcurie . $ecurie . "avec " . $nbEquipe . " équipes <br>"; 
    $nbEcurieCreer += 1;
    
    for ($equipe = 0; $equipe < $nbEquipe; $equipe++) {
        $data = file_get_contents($file);
        $obj = json_decode($data);
        $mdp = $obj->password;
        //Permet de vérifier que deux equipes non pas le même jeu
        $jeu = $liste_jeu[array_rand($liste_jeu)];
        if (in_array($jeu, $liste_jeu_ecurie)) {
            while (in_array($jeu, $liste_jeu_ecurie)) {
                $jeu = $liste_jeu[array_rand($liste_jeu)];
            }
        }
        $nomEquipe = $obj->company;
        
        $idJeu = $sql->getIdJeuByLibelle($jeu);
        $nomEquipe = explode(" ", $nomEquipe);
        if (count($nomEquipe) > 1) {
            array_pop($nomEquipe);
            if ($nomEquipe[count($nomEquipe) - 1] == "et") {
                array_pop($nomEquipe);
            }
        }
        $nomEquipe = implode(" ", $nomEquipe);
        $sql->addEquipe($nomEquipe, $mdp, str_replace(" ", "", $nomEquipe). str_replace(" ", "", $jeu) . "@esporter.com", 0, $idJeu, $idEcurie);
        $idEquipe = $sql->getIdEquipeByMail(str_replace(" ", "", $nomEquipe). str_replace(" ", "", $jeu) . "@esporter.com");
        echo  "[Création Equipe] : " . $nomEquipe . $equipe . "Jeu : " . $jeu . "<br>";
        $nbEquipeCreer += 1;
        for ($joueur = 0; $joueur < 4; $joueur++) {
            $data = file_get_contents($file);
            $obj = json_decode($data);  
            $nomJoueur =  $obj->name;
            $pseudoJoueur = $obj->email_u;
            $dateJoueur =  $obj->birth_data;
            $nomJoueur = explode(" ", $nomJoueur);
            $nom = $nomJoueur[0];
            $prenom = $nomJoueur[1];
            $sql->addJoueur($nom, $prenom, $dateJoueur, $pseudoJoueur, $pseudoJoueur . "@esporter.com", $idEquipe);
            echo "[Création Joueur] : " . $nom . " " . $prenom . " " . $pseudoJoueur . "<br>" ;
            $nbJoueurCreer += 1;
        }
        echo  "<br>";
    }
}

echo "<br> Nombre d'écurie créer : " . $nbEcurieCreer . " -- Nombre d'équipe créer : " . $nbEquipeCreer . " -- Nombre de joueur créer : " . $nbJoueurCreer;
