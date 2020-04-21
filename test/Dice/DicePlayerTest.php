<?php

namespace Karl\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test class på the class DicePlayer.
 */
class DicePlayerTest extends TestCase
{
    public function testCreateDicePlayer()
    {
        $diceplayer = new DicePlayer(3);
        $this->assertInstanceOf("\Karl\Dice\DicePlayer", $diceplayer);
    }

    public function testPointsSaving()
    {
        $diceplayer = new DicePlayer(3, 0);
        $diceplayer->addUnsavedPoints(5);
        $this->assertEquals($diceplayer->showUnsavedPoints(), 5);

        $diceplayer->savePoints();
        $this->assertEquals($diceplayer->showUnsavedPoints(), 0);
        $this->assertEquals($diceplayer->showPoints(), 5);
        $this->assertEquals($diceplayer->showLastSavedPoints(), 5);
        

        $diceplayer->addUnsavedPoints(5);
        $diceplayer->resetUnsavedPoints();
        $this->assertEquals($diceplayer->showUnsavedPoints(), 0);
    }

    public function testThrowSaving()
    {
        $diceplayer = new DicePlayer(3, 0);
        $diceplayer->addToLastThrows($diceplayer->getDiceHand());
        $this->assertTrue(count($diceplayer->showLastThrows()) === 1);

        $diceplayer->clearLastThrows();
        $this->assertTrue(count($diceplayer->showLastThrows()) === 0);
    }

    public function testId()
    {
        $diceplayer = new DicePlayer(3, 0);
        $diceplayer->setId("hej");
        $this->assertEquals($diceplayer->getId(), "hej");

        $diceplayer->addToLastThrows($diceplayer->getDiceHand());
        $this->assertTrue(count($diceplayer->showLastThrows()) === 1);

        $diceplayer->clearLastThrows();
        $this->assertTrue(count($diceplayer->showLastThrows()) === 0);
    }
}
