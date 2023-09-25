<?php

namespace App\Services;

use GuzzleHttp\Client;
use Exception;

class GeocodingService implements GeocodingServiceInterface
{
    /**
     * @var string
     */
    public const RESPONSE_OK = 'OK';

    /**
     * @var Client
     */
    protected $client;

    /**
     * GeocodingService constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Undocumented function
     *
     * @param string $address
     *
     * @return array
     *
     * @throws Exception
     */
    public function getCoordinates(string $address): array
    {
        $apiUrl = $this->getApiUrl();

        $response = $this->client->get(\sprintf('%s?address=%s&key=%s', $apiUrl, $address, $this->getApiKey()));

        $data = json_decode($response->getBody());

        if ($data->status == self::RESPONSE_OK) {
            $location = $data->results[0]->geometry->location;
            return [
                'lat' => $location->lat,
                'lng' => $location->lng,
            ];
        }

        throw new \Exception('Unable to get coordinates for address: ' . $address);
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return getenv('GOOGLE_MAP_API_KEY');
    }

    /**
     * @return string
     */
    public function getApiUrl(): string
    {
        return getenv('GOOGLE_MAP_API_URL');
    }
}
