<?php

namespace App\Services;

interface GeocodingServiceInterface
{
    /**
    * @param string $address
    *
    * @return array
    */
    public function getCoordinates(string $address): array;
}
