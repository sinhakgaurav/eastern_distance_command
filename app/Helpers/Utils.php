<?php

namespace App\Helpers;

class Utils
{
    /**
     * @param string $address
     *
     * @return array
     */
    public function getPlaceAndAddress(string $address): array
    {
        $addressArray = explode(' - ', $address);

        if (empty($addressArray) || count ($addressArray) < 2) {
            return [];
        }

        return [
            'name' => $addressArray[0],
            'address' => $addressArray[1]
        ];
    }
}
