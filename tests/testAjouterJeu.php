<?php

use PHPUnit\Framework\TestCase;

final class testAjouterJeu extends TestCase
{
    public function testAjouterJeu()
    {
        require_once('../../SQL.php');
        $sql = new requeteSQL();
        

        $this->assertEquals(5, $result);
    }
}