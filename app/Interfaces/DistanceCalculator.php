<?php

namespace App\Interfaces;

interface DistanceCalculator
{
    public function calculateDistance($source, $destinations);
    public function getLatLong($client, $address, $apiKey);
}
