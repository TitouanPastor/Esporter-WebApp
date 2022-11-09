<?php

use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    public function testDivide()
    {
        $simple = 10;
        $result = $simple/2;

        $this->assertEquals(6, $result);
    }
}
?>