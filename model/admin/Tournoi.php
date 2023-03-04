<?php 

    require_once(realpath(dirname(__FILE__) . '/../../DAO/tournoiDAO.php'));


    //DAO 

    

    //Fonction pour afficher les jeux sous forme de liste déroulante
    function afficherListeJeux($reqJeu){
        $html = '';
        while ($data = $reqJeu->fetch()) {

            $html .= '<option value="' . $data['Id_Jeu'] . '">' . $data['Libelle'] . '</option>';
        }

        return $html;
    }


?>