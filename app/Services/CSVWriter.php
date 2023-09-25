<?php

namespace App\Services;

use League\Csv\Writer;
use App\Helpers\Utils;

class CSVWriter implements CSVWriterInterface
{
    public function __construct(
        protected Utils $utils,
    ){

    }
    /**
     * @param string $address
     *
     * @return void
     */
    public function exportToCSV($source, $distances): void
    {
        // Output to CSV
        $csv = Writer::createFromPath(storage_path('distances.csv'), 'w+');

        $csv->insertOne(['Sortnumber', 'Distance', 'Name', 'Address']);
        $incremeter = 1;
        // var_dump("destinations>>>>>>>>", $distances);
        foreach ($distances as $destination => $distance) {
            $destinationArray = $this->utils->getPlaceAndAddress($destination);
            if (count ($destinationArray) < 2) {
                continue;
            }
            $csvData[] = [$incremeter, $distance . " km", $destinationArray['name'], $destinationArray['address']];
            $incremeter = $incremeter + 1;
        }

        $csv->insertAll($csvData);
    }
}
