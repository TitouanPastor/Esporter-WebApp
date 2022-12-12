<?php
    // classe php qui genere des bracket de tournois
    class bracket {

        // idées de fonctionnalités:
        
        // Niveau UI

        // - afficher les jeux dans lesquels on peut créer un bracket pour chaque tournoi

                    // <div class="left-jeux">
                    //     <span class="libellejeu">Jeux 1</span>
                    //     <input type="button" value="Selectionner">
                    // </div>

        public function display_games($games) {
            $html = "";
            foreach ($games as $game) {
                $html .= "<div class=\"left-jeux\">
                    <span class=\"libellejeu\">$game</span>
                    <input type=\"button\" value=\"Selectionner\">
                </div>";
            }
            return $html;
        }

        // - afficher les équipes inscrites dans un tournoi pour le jeu selectionné
        // - afficher les poules du bracket pour le jeu selectionné

        // premiere fonction :
        // fonction qui prend en parametre un tableau d'équipes et qui genere un bracket de tournoi d'un jeu particulier
        // Quand ? : quand l'admin clic sur "créer le bracket"
        // Condition : il faut que le nombre d'équipes soit égal à 16
        //niveau bdd : insere les quatres poules dans la bdd ainsi que le lien entre les poules et le tournoi, et poule et équipe



        // deuxieme fonction :
        // fonction qui prend en entrée quatres tableaux des poules et qui génère une poule finale
        // Quand ? : quand l'arbitre clic sur "créer la poule finale"
        // Condition : il faut que tout les résultats des poules soient entrés
        // niveau bdd : insere la poule finale dans la bdd ainsi que le lien entre la poule finale et le tournoi, et poule finale et équipe



        // troisième fonction :
        // Fonction qui prend en entrée toutes les poules d'un tournoi (qualificative et finale) et qui retourne le classement final du tournoi
        // Quand ? : quand l'arbitre clic sur "Génerer classement final"
        // Condition : il faut que tout les résultats des poules soient entrés
        // niveau bdd : insere le classement final dans la bdd ainsi que le lien entre le classement final et le tournoi, et classement final et équipe

    }