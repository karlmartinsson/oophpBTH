<?php

namespace Karl\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Example test class.
 */
class DiceGameTest extends TestCase
{
    public function testCreateDiceGame()
    {
        $diceGame = new DiceGame();
        $this->assertInstanceOf("\Karl\Dice\DiceGame", $diceGame);
    }

    public function testPlayDiceGame()
    {
        $diceGame = new DiceGame();
        $diceGame->play(true);
        $this->assertTrue(count($diceGame->showPlayer()->showLastThrows()) > 0);

        $diceGame = new DiceGame();
        $diceGame->showPlayer()->addUnsavedPoints(100);
        $diceGame->showPlayer()->savePoints();
        $diceGame->play(true);
        $diceGame->play(true);
        $this->assertInstanceOf("\Karl\Dice\DicePlayer", $diceGame->isGameWon());

        $diceGame = new DiceGame();
        $diceGame->showPlayer()->addUnsavedPoints(50);
        $diceGame->play(false);
        $this->assertEquals($diceGame->showPlayer()->showPoints(), 50);


        // $number = $dice->roll();
        // $this->assertTrue($number < 7 && $number > 0);
    }

    public function testShowOpponents()
    {
        $diceGame = new DiceGame(2, 2);
        $opponents = $diceGame->showOpponents();
        $this->assertEquals(count($opponents), 2);
    }

    public function testComputerPlay()
    {
        $diceGame = new DiceGame(2, 2);
        $diceGame->showOpponents()[0]->addUnsavedPoints(100);
        $diceGame->showOpponents()[0]->savePoints();
        $diceGame->play(false, true);
        $this->assertInstanceOf("\Karl\Dice\DicePlayer", $diceGame->isGameWon());

        $this->assertTrue($diceGame->play(true) === null);
    }
}
