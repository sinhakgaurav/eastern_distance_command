<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use League\Csv\Writer;

class AddressDistanceController extends Controller
{
    public function calculateDistances(Request $request)
    {
        // Google Maps API key
        $apiKey = 'AIzaSyC1Y_rGkz1hHVNJqrNEUcQmfiY9VQqT7aU';

        $source = $request->input('source');
        $sourceArray = $this->getPlaceAndAddress($source); // Splits provided address for name and address

        $destinations = $request->input('destinations');

        $client = new Client();
        $distances = [];

        // Get latitude and longitude for the source
        $sourceData = $this->getLatLong($client, $sourceArray['address'], $apiKey);

        if ($sourceData) {
            // Calculate distances for each destination
            foreach ($destinations as $destination) {
                $destinationArray = $this->getPlaceAndAddress($destination);
                $destinationData = $this->getLatLong($client, $destinationArray['address'], $apiKey);

                if ($destinationData) {
                    // Calculate distance in kilometers
                    $distance = $this->calculateDistanceBetweenPoints($sourceData, $destinationData);
                    $distances[$destination] = $distance;
                }
            }

            // Sort addresses by distance
            asort($distances);

            // Write to console
            $this->writeToConsole($source, $distances);

            // Write to CSV
            $this->writeToCSV($source, $distances);

            return response()->json(['distances' => $distances], 200);
        } else {
            return response()->json(['error' => 'Unable to calculate distances.'], 400);
        }
    }

    private function getLatLong($client, $address, $apiKey)
    {
        // echo "https://maps.googleapis.com/maps/api/geocode/json?address=$address&key=$apiKey";
        $response = $client->get("https://maps.googleapis.com/maps/api/geocode/json?address=$address&key=$apiKey");
        $data = json_decode($response->getBody());

        if ($data->status == 'OK') {
            $location = $data->results[0]->geometry->location;
            return [
                'lat' => $location->lat,
                'lng' => $location->lng,
            ];
        } else {
            return null;
        }
    }

    private function calculateDistanceBetweenPoints($sourceData, $destinationData)
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

        return 6371 * $c;
    }

    private function writeToConsole($source, $distances)
    {
        // Output to console
        foreach ($distances as $destination => $distance) {
            echo "Distances from $source  to : ";
            echo "$destination : $distance km\n";
        }
    }

    private function writeToCSV($source, $distances)
    {
        // Output to CSV
        $csv = Writer::createFromPath(storage_path('distances.csv'), 'w+');

        $csv->insertOne(['Sortnumber', 'Distance', 'Name', 'Address']);
        $incremeter = 1;
        foreach ($distances as $destination => $distance) {
            $destinationArray = $this->getPlaceAndAddress($destination);
            $csvData[] = [$incremeter, $distance, $destinationArray['name'], $destinationArray['address']];

        }
        $csv->insertAll($csvData);
    }

    private function getPlaceAndAddress($place)
    {
        $addressArray = explode('-', $place);

        if (!$addressArray) {
            return false;
        }

        return [
            'name' => $addressArray[0],
            'address' => $addressArray[1]
        ];
    }
}
