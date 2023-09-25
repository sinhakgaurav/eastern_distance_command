<?php

namespace App\Modules;

use App\Interfaces\Output;
use GuzzleHttp\Client;
use League\Csv\Writer;

class GoogleMapsDistanceCalculator implements Output
{
    public function writeToConsole($source, $distances)
    {
        // Implementation for writing to console
    }

    public function writeToCSV($source, $distances)
    {
        // Implementation for writing to CSV
    }
}
