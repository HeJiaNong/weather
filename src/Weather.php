<?php

namespace CannonSir\Weather;

use GuzzleHttp\Client;
use CannonSir\Weather\Exceptions\HttpException;
use CannonSir\Weather\Exceptions\InvalidArgumentException;

class Weather
{
    protected $key;

    protected $guzzleOptions = [];

    const API = 'https://restapi.amap.com/v3/weather/weatherInfo';

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey(string $key): void
    {
        $this->key = $key;
    }

    public function getHttpClient()
    {
        return new Client($this->guzzleOptions);
    }

    /**
     * @return array
     */
    public function getGuzzleOptions(): array
    {
        return $this->guzzleOptions;
    }

    /**
     * @param array $guzzleOptions
     */
    public function setGuzzleOptions(array $guzzleOptions): void
    {
        $this->guzzleOptions = $guzzleOptions;
    }

    public function getWeather($city, string $type = 'live', string $format = 'json')
    {
        $types = [
            'live' => 'base',
            'forecast' => 'all',
        ];

        if (!\array_key_exists(\strtolower($type), $types)) {
            throw new InvalidArgumentException('Invalid type value(live/forecast): '.$type);
        }

        if (!\in_array(\strtolower($format), ['xml', 'json'], true)) {
            throw new InvalidArgumentException("Invalid response format: $format");
        }

        $query = array_filter([
            'key' => $this->key,
            'city' => $city,
            'output' => \strtolower($format),
            'extensions' => \strtolower($types[$type]),
        ]);

        try {
            $response = $this->getHttpClient()->get(self::API, compact('query'))->getBody()->getContents();

            return 'json' === $format ? \json_decode($response, true) : $response;
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function getLiveWeather($city, $format = 'json')
    {
        return $this->getWeather($city, 'live', $format);
    }

    public function getForecastsWeather($city, $format = 'json')
    {
        return $this->getWeather($city, 'forecast', $format);
    }
}