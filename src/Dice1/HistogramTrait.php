<?php

namespace Karl\Dice1;

/**
 * A trait implementing histogram for integers.
 */
trait HistogramTrait
{
    /**
     * @var array $serie  The numbers stored in sequence.
     */
    private $serie = [];



    /**
     * Get the serie.
     *
     * @return array with the serie.
     */
    public function getHistogramSerie()
    {
        return $this->serie;
    }



    /**
     * Print out the histogram, default is to print out only the numbers
     * in the serie, but when $min and $max is set then print also empty
     * values in the serie, within the range $min, $max.
     *
     * @param int $min The lowest possible integer number.
     * @param int $max The highest possible integer number.
     *
     * @return string representing the histogram.
     */
    public function printHistogram(int $min = null, int $max = null)
    {
        $serie = array_count_values($this->serie);
        $returnString = "";

        if ($min && $max) {
            for ($i = 1; $i <= $max - $min + 1; $i++) {
                $returnString .= $i . ": ";

                if (array_key_exists($i, $serie)) {
                    for ($star = 0; $star < $serie[$i]; $star++) {
                        $returnString .= "*";
                    }
                }
                $returnString .= "<br>";              
            }
            return $returnString;
        } else {
            ksort($serie);           
            foreach (array_keys($serie) as $key) {
                $returnString .= $key . ": ";
                for ($star = 0; $star < $serie[$key]; $star++) {
                    $returnString .= "*";
                }
                $returnString .= "<br>";
            }
            return $returnString;
        }
    }
}
