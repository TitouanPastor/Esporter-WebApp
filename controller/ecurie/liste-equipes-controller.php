<?php

session_start();
require_once(realpath(dirname(__FILE__) . '/../../controller/visiteur/header-controller.php'));
require_once(realpath(dirname(__FILE__) . '/../../model/Equipe.php'));
require_once(realpath(dirname(__FILE__) . '/../../model/Ecurie.php'));

$triEquipeModel = new Equipe();
$ecurieModel = new Ecurie();

$idEcurie = $ecurieModel->getIdEcurieByMail($_SESSION['username']);
$triNom = $triEquipeModel->listeEquipeTrierPar('nom', $idEcurie);
$triPoint = $triEquipeModel->listeEquipeTrierPar('point', $idEcurie);
$triId = $triEquipeModel->listeEquipeTrierPar('id', $idEcurie);

ob_start();
require_once(realpath(dirname(__FILE__) . '/../../view/ecurie/liste-equipes-view.html'));
$buffer = ob_get_clean();
$buffer = str_replace('##filtreParNom##', $triNom, $buffer);
$buffer = str_replace('##filtreParPoint##', $triPoint, $buffer);
$buffer = str_replace('##filtreParId##', $triId, $buffer);
echo $buffer;
