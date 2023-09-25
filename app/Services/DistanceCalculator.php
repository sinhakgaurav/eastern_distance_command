<?php

namespace App\Services;

use App\Services\DistanceCalculatorInterface;

class DistanceCalculator implements DistanceCalculatorInterface
{
    /**
     * @param array $sourceData
     * @param array $destinationData
     *
     * @return float
     */
    public function calculateDistanceBetweenPoints($sourceData, $destinationData): float
    {
        // Calculate distance in kilometers
        $lat1 = deg2rad($sourceData['lat']);
        $lon1 = deg2rad($sourceData['lng']);
        $lat2 = deg2rad($destinationData['lat']);
        $lon2 = deg2rad($destinationData['lng']);

        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;

        $a = sin($dlat / 2) ** 2 + cos($lat1) * cos($lat2) * sin($dlon / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return (float) round(6371 * $c, 2);
    }
}
