<?php

use PHPUnit\Framework\TestCase;

final class testAjouterJeu extends TestCase
{
    public function testAjouterJeu()
    {
        require_once(realpath(dirname(__FILE__) . '/../SQL.php'));
        $sql = new requeteSQL();
        $libelle = "God of War";
        $sql->addJeu($libelle);
        $idJeu = $sql->getLastIDJeu();
        $req = $sql->jeuId($idJeu);
        while($row = $req->fetch()){
            $this->assertEquals($row['Libelle'], $libelle);
        }
    }
}