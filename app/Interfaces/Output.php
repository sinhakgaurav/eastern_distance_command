<?php

namespace App\Interfaces;

interface Output
{
    public function writeToConsole($source, $distances);
    public function writeToCSV($source, $distances);
}
