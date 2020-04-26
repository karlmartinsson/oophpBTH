<?php

namespace Karl\Dice1;

use PHPUnit\Framework\TestCase;

/**
 * Example test class.
 */
class Dice1GameTest extends TestCase
{
    public function testCreateDiceGame()
    {
        $diceGame = new DiceGame();
        $this->assertInstanceOf("\Karl\Dice1\DiceGame", $diceGame);
    }

    public function testPlayDiceGame()
    {
        $diceGame = new DiceGame();
        $diceGame->play(true);
        $this->assertTrue(count($diceGame->showPlayer()->showLastThrows()) > 0);

        // $diceGame = new DiceGame();
        // $diceGame->showPlayer()->addUnsavedPoints(100);
        // $diceGame->showPlayer()->savePoints();
        // $diceGame->play(true);
        // $diceGame->play(true);
        // $this->assertInstanceOf("\Karl\Dice1\DicePlayer", $diceGame->isGameWon());

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
        if (in_array(1, $diceGame->showOpponents()[0]->getDicehand()->show())) {
            $this->assertTrue($diceGame->isGameWon() === null);
        } else {
            $this->assertInstanceOf("\Karl\Dice1\DicePlayer", $diceGame->isGameWon());
        }
        

        $this->assertTrue($diceGame->play(true) === null);
    }

    public function testShoulComputerContinue()
    {
        $diceGame = new DiceGame(2, 2);
        $diceGame->showPlayer()->addUnsavedPoints(90);
        $diceGame->showPlayer()->savePoints();
        $this->assertEquals($diceGame->showPlayer()->showPoints(), 90);
        
        $diceGame->play(false);

        $lastThrowsFirstOpp = $diceGame->showOpponents()[0]->showLastThrows();

        $isOneInLastThrows = false;
        $sumLastThrows = 0;
        foreach ($lastThrowsFirstOpp as $dicehand) {
            if (in_array(1, $dicehand)) {
                $isOneInLastThrows = true;
            }
            $sumLastThrows += array_sum($dicehand);
        }

        if ($isOneInLastThrows) {
            $sumLastThrows = 0;
        }

        $this->assertEquals($diceGame->showOpponents()[0]->showPoints(), $sumLastThrows);
    }
}
