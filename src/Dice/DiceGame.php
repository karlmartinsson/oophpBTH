<?php

namespace Karl\Dice;

/**
 * A dicegame.
 */
class DiceGame
{
    /**
     * @var array $players Array consisting of dices.
     */
    private $player;
    private $opponents;
    private $dices;
    private $winner;

    /**
     * Constructor to initiate the Game with a number of playes.
     *
     * @param int $opponents Number of players to create, defaults to four.
     * @param int $dices Number of dices to use, defaults to 2.
     */
    public function __construct(int $opponents = 3, int $dices = 2)
    {
        $this->opponents = [];
        $this->dices = $dices;

        for ($i = 0; $i < $opponents; $i++) {
            $this->opponents[$i] = new DicePlayer($dices);
            $this->opponents[$i]->setId($i + 1);
        }
        $this->player = new DicePlayer($dices);
        $this->player->setId("you");
        $this->winner = null;
    }

    private function makeThrow($player)
    {
        $dicehand = $player->getDiceHand()->roll();
        $player->addToLastThrows($dicehand);
        
        if (in_array(1, $dicehand)) {
            $player->resetUnsavedPoints();
            return false;
        } else {
            $player->addUnsavedPoints($player->getDiceHand()->sum());
            if ($player->showPoints() + $player->showUnsavedPoints() >= 100) {
                $player->savePoints();
                $this->winner = $player;

                return "won";
            }
            return true;
        }
    }

    public function play($continue, $playanyway = false)
    {
        if ($this->player->showUnsavedPoints() == 0) {
            $this->player->clearLastThrows();  
        }
        if ($this->winner && !$playanyway) {
            return;
        }       
        foreach ($this->opponents as $opponent) {
            $opponent->clearLastThrows();
        }
        if ($continue) {
            $win = $this->makeThrow($this->player);
            if (!$win) {                            
                $this->computerPlay($this->opponents);
            }
        } else {
            $this->player->savePoints();
            $this->computerPlay($this->opponents);
        }
    }

    private function computerPlay($opponents)
    {
        for ($i = 0; $i < count($opponents); $i++) {
            $continue = true;
            $runs = rand(1, 4);
            $run = 0;
            while ($continue && $run < $runs) {
                if ($continue === "won") {
                    return;
                }
                $continue = $this->makeThrow($opponents[$i]);
                $run += 1;
            }
            if ($continue) {
                $opponents[$i]->savePoints();
            }
        }   
    }

    public function showPlayer()
    {
        return $this->player;
    }


    public function showOpponents()
    {
        return $this->opponents;
    }

    public function isGameWon()
    {
        return $this->winner;
    }
}
