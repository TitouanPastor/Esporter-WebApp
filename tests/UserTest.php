<?php

use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    public function testDivide()

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
