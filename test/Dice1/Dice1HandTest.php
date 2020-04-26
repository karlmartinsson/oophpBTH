<?php

namespace Karl\Dice1;

use PHPUnit\Framework\TestCase;

/**
 * Test class for testing of DiceHand.
 */
class Dice1HandTest extends TestCase
{
    public function testCreateDiceHand()
    {
        $diceHand = new DiceHand(5);
        $this->assertInstanceOf("\Karl\Dice1\DiceHand", $diceHand);
    }

    public function testRollDicehand()
    {
        $diceHand = new DiceHand(4);
        $numbers = $diceHand->roll();
        $this->assertTrue(count($numbers) === 4);
    }

    public function testShowDiceHand()
    {
        $diceHand = new DiceHand(4);
        $diceHand->roll();
        $this->assertTrue(count($diceHand->show()) === 4);
    }

    public function testShowDiceSum()
    {
        $diceHand = new DiceHand();
        $diceHand->roll();
        $this->assertTrue(array_sum($diceHand->show()) === $diceHand->sum());
    }
}
