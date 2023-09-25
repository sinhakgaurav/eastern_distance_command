<?php

namespace App\Services;

interface CSVWriterInterface
{
    public function exportToCSV($source, $distances): void;
}
