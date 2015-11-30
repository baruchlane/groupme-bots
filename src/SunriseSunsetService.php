<?php

class SunriseSunsetService
{
    const STATUS_VALID = 'OK';

    protected $url = 'http://api.sunrise-sunset.org/json';

    protected $curlWrapper;

    public function __construct()
    {
        $this->curlWrapper = new CurlWrapper();
    }

    /**
     * @param string $lat
     * @param string $lng
     * @param DateTime|null $date
     * @return DateTime
     */
    public function getSunset($lat, $lng, DateTime $date = null)
    {
        $results = $this->getTimes($lat, $lng, $date);
        return $results['sunset'];
    }

    public function getSunrise($lat, $lng, DateTime $date = null)
    {
        $results = $this->getTimes($lat, $lng, $date);
        return $results['sunrise'];
    }

    public function getTimes($lat, $lng, DateTime $date = null)
    {
        if (!$date) {
            $date = new \DateTime();
        }
        $results = $this->getResults($lat, $lng, $date);
        foreach ($results as $k => $v) {
            try {
                $results[$k] = new \DateTime($v);
            } catch (\Exception $e){};
        }
        return $results;
    }

    protected function getResults($lat, $lng, \DateTime $date, $formatted = false)
    {
        $params = array(
            'lat' => $lat,
            'lng' => $lng,
            'date' => $date->format('Y-m-d'),
            'formatted' => $formatted ? 1 : 0
        );
        try {
            $response = json_decode($this->curlWrapper->get($this->url, $params), true);
        } catch (CurlWrapperException $e) {
            die($e->getMessage());
        }
        if ($response['status'] !== self::STATUS_VALID) {
            return false;
        }
        return $response['results'];
    }
}