<?php

namespace Karl\Dice1;

use PHPUnit\Framework\TestCase;

/**
 * Test class to test the HistogramTrait.
 */
class HistogramTraitTest extends TestCase
{
    public function testGetHistogramSerie()
    {
        $diceGame = new DiceGame(2, 2);
        $diceGame->play(true);
        $diceGame->play(false);
        $histogramSerie = $diceGame->getHistogramSerie();
        $this->assertTrue(count($histogramSerie) >= 6);
    }

    public function testGetHistogramString()
    {
        $diceGame = new DiceGame(2, 2);
        $diceGame->play(true);
        $diceGame->play(false);
        $histogramString = $diceGame->printHistogram();
        $this->assertTrue(is_string($histogramString));

        $diceGame = new DiceGame(2, 2);
        $diceGame->play(true);
        $diceGame->play(false);
        $histogramString = $diceGame->printHistogram(1, 6);
        $firstLetter = substr($histogramString, 0, 1);
        $this->assertTrue($firstLetter == "1");
    }
}
