<?php
require_once(realpath(dirname(__FILE__) . '/../SQL.php'));
use PHPUnit\Framework\TestCase;

final class TestAuthentification extends TestCase
{
    public function testAuthenfication()

    {
        
        $sql = new requeteSQL();
        $req = $sql -> checkLogin('equipe@esporter.com','1234','equipe');
        $this -> assertTrue($req);
    }
}
