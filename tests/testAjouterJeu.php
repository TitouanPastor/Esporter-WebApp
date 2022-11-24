<?php

use PHPUnit\Framework\TestCase;

final class testAjouterJeu extends TestCase
{
    public function testAjouterJeu()
    {
        require_once('/../SQL.php');
        $sql = new requeteSQL();
        $jeu = "God of War";
        $sql->addJeu($jeu);
        

        $this->assertEquals(5, $result);
    }
}