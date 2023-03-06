<?php

session_start();
require_once(realpath(dirname(__FILE__) . '/../../controller/visiteur/header-controller.php'));
require_once(realpath(dirname(__FILE__) .'/../../model/bracket.php'));
require_once(realpath(dirname(__FILE__) . '/../../model/Tournoi.php'));


$bracket = new bracket();

// Fermeture d'un tournoi et génération du bracket
if (isset($_GET['close_id'])) {
    $closeId = $_GET['close_id'];
    $bracket->genererBracket($closeId);
}

ob_start();
require_once(realpath(dirname(__FILE__) . '/../../view/admin/liste-tournois-view.html'));
$buffer = ob_get_clean();
$buffer = str_replace('##filtreParType##', trierPar('type') , $buffer);
$buffer = str_replace('##filtreParLieu##', trierPar('lieu') , $buffer);
$buffer = str_replace('##filtreParNom##', trierPar('nom') , $buffer);
$buffer = str_replace('##filtreParDate##', trierPar('date') , $buffer);
$buffer = str_replace('##filtreParID##', trierPar('ID') , $buffer);
echo $buffer;
?>