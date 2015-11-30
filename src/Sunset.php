<?php

class Sunset
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
        $this->groupMeService = new GroupMeService('shabbos');
    }

    public function pingBot($message)
    {
        $results = preg_match('/^@ZmanimBot sunset in (.+)$/i', $message);
        if (isset($results[1])) {
            $this->groupMeService->sendRawMessage($this->getSunset($results[1]));
        }
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
        return 'Sunset for ' . $address . ': ' . $sunset->setTimezone(new \DateTimeZone($timeZoneId))->format('g:m:sa');
    }
}