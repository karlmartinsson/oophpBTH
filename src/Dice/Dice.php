<?php

namespace Karl\Dice;

/**
 * A dice class
 */
class Dice
{
    /**
     * @var value the value of the dice.
     */
    private $value;
    private $sides;

    public function __construct(int $sides = 6)
    {
        $this->sides = $sides;
    }

    /**
     * Roll the dice and return a number between 1 and $this->sides (default 6).
     * @return int
     */
    public function roll()
    { 
        $this->value = rand(1, $this->sides);
        return $this->value;
    }

    /**
     * Return the current dice
     * @return array
     */
    public function show()
    {
        return $this->value;
    }
}
