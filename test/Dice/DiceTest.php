<?php

namespace Karl\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Example test class.
 */
class DiceTest extends TestCase
{
    public function testCreateDice()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Karl\Dice\Dice", $dice);
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
