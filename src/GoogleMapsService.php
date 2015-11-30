<?php

class GoogleMapsService
{
    protected $geocodeUrl = 'https://maps.googleapis.com/maps/api/geocode/json';

    protected $timezoneUrl = 'https://maps.googleapis.com/maps/api/timezone/json';

    protected $curlWrapper;

    protected $apiKey;

    public function __construct()
    {
        $this->curlWrapper = new CurlWrapper();
        $this->apiKey = Config::getConfig()->get('google_maps_api_key');
    }

    public function getLatLng($search)
    {
        $search = preg_replace('/\\s/', '+', $search);
        $params = array('address' => $search);
        $response = json_decode($this->sendRequest($this->geocodeUrl, $params), true);
        if ($response['status'] == 'ZERO_RESULTS') {
            return false;
        }
        return array(
            'formattedAddress' => $response['results'][0]['formatted_address'],
            'lat' => $response['results'][0]['geometry']['location']['lat'],
            'lng' => $response['results'][0]['geometry']['location']['lng']
        );
    }

    public function getTimeZone($lat, $lng, $datetime = null)
    {
        if (!$datetime) {
            $datetime = new \DateTime();
        }
        $params = array(
            'location' => $lat . ',' . $lng,
            'timestamp' => $datetime->format('U'),
            'key' => $this->apiKey
        );
        $response = json_decode($this->sendRequest($this->timezoneUrl, $params), true);
        if ($response['status'] == 'ZERO_RESULTS') {
            return false;
        }
        return $response['timeZoneId'];
    }

    protected function sendRequest($url, $params)
    {
        try {
            $response = $this->curlWrapper->get($url, $params);
        } catch (CurlWrapperCurlException $e) {
            die($e->getMessage());
        }
        return $response;
    }
}