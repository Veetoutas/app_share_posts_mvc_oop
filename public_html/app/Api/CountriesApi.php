<?php


namespace VFramework\Api;


class CountriesApi
{
    const ENDPOINT_ALL = '/all';

    /**
     * @var Client
     */
    private Client $client;

    /**
     * CountriesApi constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return mixed
     */
    public function getCountries()
    {
        return $this->client->getRequest(self::ENDPOINT_ALL);
    }
}
