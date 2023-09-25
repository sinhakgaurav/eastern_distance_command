<?php

namespace App\Console\Commands;

use App\Helpers\Utils;
use Illuminate\Console\Command;
use App\Interfaces\DistanceCalculator;
use App\Services\CSVWriterInterface;
use App\Services\DistanceCalculatorInterface;
use App\Services\GeocodingServiceInterface;

class CalculateDistanceCommand extends Command
{
    protected $signature = 'calculate:distances {source}';

    protected $description = 'Calculate distances from a source address to multiple destinations and export to CSV.';

    /**
     * @var \App\Services\GeocodingServiceInterface
     */
    protected $geocodingService;

    /**
     * @var \App\Services\DistanceCalculatorInterface
     */
    protected $distanceCalculator;

    /**
     * @var \App\Services\CSVWriterInterface
     */
    protected $csvWriter;

    /**
     * @var \App\Helpers\Utils
     */
    protected $utils;

    public function __construct(
        GeocodingServiceInterface $geocodingService,
        DistanceCalculatorInterface $distanceCalculator,
        CSVWriterInterface $csvWriter,
        Utils $utils,
    ){
        parent::__construct();

        $this->geocodingService = $geocodingService;
        $this->distanceCalculator = $distanceCalculator;
        $this->csvWriter = $csvWriter;
        $this->utils = $utils;
    }

    public function handle()
    {
        $source = $this->argument('source');
        $sourceArray = $this->utils->getPlaceAndAddress($source);

        if (empty($sourceArray['address'])) {
            $this->error('Invalid source address.');
            return;
        }

        // Get current lat and long for source
        $sourceData = $this->geocodingService->getCoordinates($sourceArray['address']);

        // Get destination data from helper
        $destinations = \App\Helpers\Data::getDestinationsRecords();

        // Calculate distance between source and destinations
        foreach ($destinations as $destination) {
            $destinationArray = $this->utils->getPlaceAndAddress($destination);
            // lat long for addresses in destinations
            $destinationData = $this->geocodingService->getCoordinates($destinationArray['address']);

            if ($destinationData) {
                // Calculate distance in kilometers
                $distance = $this->distanceCalculator->calculateDistanceBetweenPoints($sourceData, $destinationData);
                $destinations[$destination] = $distance;
            }
        }

        asort($destinations);
        // usort($destinations, function ($a, $b) {
        //     return $a['distance'] - $b['distance'];
        // });

        // Write to console
        $this->writeToConsole($source, $destinations);

        // Write to CSV
        $this->csvWriter->exportToCSV($source, $destinations);

        // return "true happend";
        $this->info('Distances exported to distances.csv');
    }

    /**
     * @param array $source
     * @param array $address
     *
     * @return void
     */
    protected function writeToConsole(string $source, array $destinations): void
    {
        // Implementation for writing to console
        // Output to console
        foreach ($destinations as $destination => $distance) {
            echo "Distances from given source to : ";
            //@todo Need to implement format to print the distance
            echo "$destination is : $distance km\n";
        }
    }
}
