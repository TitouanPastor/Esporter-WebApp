<?php

use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    public function testAuthentification(){ //test checkLogin
        require_once(realpath(dirname(__FILE__) . '../SQL.php'));
        $sql = new requeteSQL();
        $req = $sql -> checkLogin('equipe@esporter.com','1234','equipe');
        assertTrue($req);
    }
}

