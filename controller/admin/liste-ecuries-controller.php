
<?php

    session_start();
    require_once(realpath(dirname(__FILE__) . '/../../controller/visiteur/header-controller.php'));
    require_once(realpath(dirname(__FILE__) . '/../../model/Ecurie.php'));

    $ecurieModel = new Ecurie();

    ob_start();
    require_once(realpath(dirname(__FILE__) . '/../../view/admin/liste-ecuries-view.html'));
    $buffer = ob_get_clean();
    $buffer = str_replace('##filtreParNom##', $ecurieModel->trierPar('nom') , $buffer);
    $buffer = str_replace('##filtrePArStatut', $ecurieModel->trierPar('statut') , $buffer);
    $buffer = str_replace('##filtreParID##', $ecurieModel->trierPar('id') , $buffer);
    echo $buffer;
 
?>


