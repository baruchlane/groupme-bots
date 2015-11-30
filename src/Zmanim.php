<?php

class Zmanim
{
    /**
     * @var GoogleMapsService
     */
    protected $googleMapsService;

    /**
     * @var SunriseSunsetService
     */
    protected $sunriseSunsetService;

    /**
     * @var GroupMeService
     */
    protected $groupMeService;

    public function __construct()
    {
        $this->googleMapsService = new GoogleMapsService();
        $this->sunriseSunsetService = new SunriseSunsetService();
        $this->groupMeService = new GroupMeService('zmanim');
    }

    public function pingBot($message)
    {
        if ($message == '@zmanimbot hi') {
            $this->groupMeService->sendRawMessage('Hi!');
            return;
        }
        $results = array();
        preg_match('/^@ZmanimBot (sunset|sunrise) in (.+)$/i', $message, $results);
        print_r($results);
        if (isset($results[2])) {
            $response = $results[1] === 'sunrise' ?
                $this->getSunrise($results[2]) :
                $this->getSunset($results[2]);
            $this->groupMeService->sendRawMessage($response);
        }
    }

    public function getSunrise($search)
    {
        $location = $this->googleMapsService->getLatLng($search);
        if (!$location) {
            return 'Location Error';
        }
        $address = $location['formattedAddress'];
        $timeZoneId = $this->googleMapsService->getTimeZone($location['lat'], $location['lng']);
        if (!$timeZoneId) {
            return 'Timezone error';
        }
        /** @var DateTime $sunset */
        $sunrise = $this->sunriseSunsetService->getSunrise($location['lat'], $location['lng']);
        if (!$sunrise) {
            return 'Sunrise error';
        }
        return 'Sunrise in ' . $address . ': ' . $sunrise->setTimezone(new \DateTimeZone($timeZoneId))->format('g:i:sa');
    }

    public function getSunset($search)
    {
        $location = $this->googleMapsService->getLatLng($search);
        if (!$location) {
            return 'Lat Lng Error';
        }
        $address = $location['formattedAddress'];
        $timeZoneId = $this->googleMapsService->getTimeZone($location['lat'], $location['lng']);
        if (!$timeZoneId) {
            return 'Timezone Id error';
        }
        /** @var DateTime $sunset */
        $sunset = $this->sunriseSunsetService->getSunset($location['lat'], $location['lng']);
        if (!$sunset) {
            return 'Sunset error';
        }
        return 'Sunset in ' . $address . ': ' . $sunset->setTimezone(new \DateTimeZone($timeZoneId))->format('g:i:sa');
    }
}