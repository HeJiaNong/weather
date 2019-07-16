<?php
/**
 * Created by PhpStorm.
 * User: jianong
 * Date: 2019-07-14
 * Time: 13:00
 */

namespace Hejiang\Weather;

use GuzzleHttp\Client;
use Hejiang\Weather\Exceptions\HttpException;
use Hejiang\Weather\Exceptions\InvalidArgumentException;

class Weather
{
    protected $key;

    protected $guzzleOptions = [];

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

    public function getWeather($city, string $type = 'base', string $format = 'json')
    {
        $url = 'https://restapi.amap.com/v3/weather/weatherInfo';

        if (!\in_array(\strtolower($type), ['base', 'all'], true)) {
            throw new InvalidArgumentException("Invalid type value(base/all): $type");
        }

        if (!\in_array(\strtolower($format), ['xml', 'json'], true)) {
            throw new InvalidArgumentException("Invalid response format: $format");
        }

        $query = array_filter([
            'key' => $this->key,
            'city' => $city,
            'output' => \strtolower($format),
            'extensions' => \strtolower($type),
        ]);

        try {
            $response = $this->getHttpClient()->get($url, compact('query'))->getBody()->getContents();

            return 'json' === $format ? \json_decode($response, true) : $response;
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }
}