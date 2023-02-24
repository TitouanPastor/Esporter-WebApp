<?php
session_start();
require_once(realpath(dirname(__FILE__) . '/../../controller/visiteur/header-controller.php'));
$infoExecution = "";
// Ajouter une écurie
if (isset($_POST['ajouter'])) {
    require_once(realpath(dirname(__FILE__) . '/../../model/ecurie/Ecurie.php'));
    $ecurie = new Ecurie();
    // Vérification de si tout les champs sont remplis
    if (!empty($_POST['nom-ecurie']) && !empty($_POST['combobox-statut']) && !empty($_POST['email-ecurie']) && !empty($_POST['mdp-ecurie'])) {
        //Vérification de si une écurie du même nom ou même adresse mail n'existe pas
        $ecuries = $ecurie->getEcurie();
        $sameEcurie = False;
        $sameMail = False;
        while ($ecurie = $ecuries->fetch()) {
            if (strtoupper($ecurie['Nom']) == strtoupper($_POST['nom-ecurie'])) {
                $sameEcurie = True;
            }
            if (strtoupper($ecurie['Mail']) == strtoupper($_POST['email-ecurie'])) {
                $sameMail = True;
            }
        }
        if (!$sameEcurie) {
            if (!$sameMail) {
                try {
                    // Ajout d'une écurie (le dernier 1 correspond à l'id gestionnaire)
                    $ecurie->addEcurie($_POST['nom-ecurie'], $_POST['combobox-statut'], $_POST['mdp-ecurie'], $_POST['email-ecurie'], 1);
                    $infoExecution = 'Ecurie enregistrée !';
                    header('Location: liste-ecuries.php?createEcurie=success');
                } catch (Exception $e) {
                    $infoExecution = "Erreur lors de l'ajout de l'écurie ! Veuillez réessayer.";
                }
                $infoExecution = "L'écurie a bien été ajoutée";
            } else {
                $infoExecution = "Une écurie avec la même adresse mail existe déjà";
            }
        } else {
            $infoExecution = "Une écurie avec le même nom existe déjà";
        }
    } else {
        $infoExecution = "Veuillez remplir tous les champs";
    }
}
ob_start();
require_once(realpath(dirname(__FILE__) . '/../../view/admin/enregistrer-ecurie-view.html'));
$buffer = ob_get_clean();
$buffer = str_replace("##infoExecution##", $infoExecution, $buffer);
$buffer = str_replace("##header##", $header->customizeHeader($_SESSION['role']), $buffer);
echo $buffer;