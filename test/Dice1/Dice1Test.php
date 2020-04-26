<?php

namespace Karl\Dice1;

use PHPUnit\Framework\TestCase;

/**
 * Test class for testing of Dice.
 */
class Dice1Test extends TestCase
{
    public function testCreateDice()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Karl\Dice1\Dice", $dice);
    }

    public function testRollDice()
    {
        $dice = new Dice();
        $number = $dice->roll();
        $this->assertTrue($number < 7 && $number > 0);
    }

    public function testShowDice()
    {
        $dice = new Dice();
        $dice->roll();
        $this->assertTrue($dice->show() < 7 && $dice->show() > 0);
    }
}
