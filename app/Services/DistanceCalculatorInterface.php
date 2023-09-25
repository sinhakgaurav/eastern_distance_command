<?php

namespace App\Services;

interface DistanceCalculatorInterface
{
    /**
     * @param array $sourceData
     * @param array $destinationData
     *
     * @return float
     */
    public function calculateDistanceBetweenPoints($sourceData, $destinationData): float;
}
