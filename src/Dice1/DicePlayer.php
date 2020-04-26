<?php

namespace Karl\Dice1;

/**
 * A class to create a DicePlayer.
 */
class DicePlayer
{
    /**
     * @var int $points   current number of points.
     */
    private $points;
    private $unsavedPoints;
    private $lastSavedPoints;
    private $dicehand;
    private $lastThrows;
    private $id;

    /**
     * Constructor to initiate a Player with a dicehand with a number of dices.
     *
     * @param int $dices Number of dices the player will use, defaults to 2.
     * @param int $points Number of points the player will start with, defaults to 0.
     */
    public function __construct(int $dices = 2, int $points = 0)
    {
        $this->points = $points;
        $this->dicehand = new DiceHand($dices);
        $this->unsavedPoints = 0;
        $this->lastThrows = [];
        $this->id = null;
    }

    /**
     * Add points to unsaved pile.
     * @param int number of points to add
     */
    public function addUnsavedPoints($points)
    {
        $this->unsavedPoints += $points;
    }

    /**
     * Add points to player.
     * @param int number of points to add
     */
    public function savePoints()
    {
        $this->points += $this->unsavedPoints;
        $this->lastSavedPoints = $this->unsavedPoints;
        $this->unsavedPoints = 0;
    }

    /**
     * Show points of player.
     * @return int with current number of points.
     */
    public function showPoints()
    {
        return $this->points;
    }

     /**
     * Show points of player.
     * @return int with current number of points.
     */
    public function showUnsavedPoints()
    {
        return $this->unsavedPoints;
    }

    /**
     * Show points of player.
     * @return int with current number of points.
     */
    public function showLastSavedPoints()
    {
        return $this->lastSavedPoints;
    }

    /**
     * Reset points.
     * @param int with points to reset to. Defaults to 0.
     */
    public function resetUnsavedPoints(int $points = 0)
    {
        $this->unsavedPoints = $points;
        $this->lastSavedPoints = 0;
    }


    public function addToLastThrows($dicehand)
    {
        array_push($this->lastThrows, $dicehand);
    }

    public function clearLastThrows()
    {
        $this->lastThrows = [];
    }

    public function showLastThrows()
    {
        return $this->lastThrows;
    }

    public function getDiceHand()
    {
        return $this->dicehand;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}
