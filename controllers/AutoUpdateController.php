<?php
class AutoUpdateController extends Controller
{
    private $cityC, $rainfallC, $weatherC;

    public function __construct()
    {
        date_default_timezone_set('Asia/Taipei');
        require_once "{$_SERVER['DOCUMENT_ROOT']}/RD1_Assignment/controllers/CityController.php";
        require_once "{$_SERVER['DOCUMENT_ROOT']}/RD1_Assignment/controllers/RainfallController.php";
        require_once "{$_SERVER['DOCUMENT_ROOT']}/RD1_Assignment/controllers/WeatherController.php";
        $this->cityC = new CityController();
        $this->rainfallC = new RainfallController();
        $this->weatherC = new WeatherController();
        $this->cityC->requireDAO("city");
        $this->rainfallC->requireDAO("rainfall");
        $this->weatherC->requireDAO("weather");
    }

    public function doUpdate()
    {
        if (date("h") == 6) {
            $this->weatherC->deleteOld();
        }
        $this->updateAWeekWeather();
        $this->updateTwoDaysWeather();
        $this->updateRainfall();
    }

    public function updateNowWeather($locationName = null)
    {
        if ($locationName === null) {
            $locationName = " ";
        }
        $url = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization=CWB-082621CE-932C-4699-BFA2-166C55CF8720&locationName=$locationName";
        $lines_array = file($url);
        $jsonObj = json_decode($lines_array["0"]);
        $location = $jsonObj->records->location;
        $weathers = Weather::apiObjToModels("36Hours", $location);
        foreach ($weathers as $weather) {
            if ($this->weatherC->checkWeatherExist($weather->getStartTime(), $weather->getCityName())) {
                $this->weatherC->updateByObj($weather);
            } else {
                $this->weatherC->insertByObj($weather);
            }
        }
    }

    public function updateTwoDaysWeather($locationName = null)
    {
        if ($locationName === null) {
            $locationName = " ";
        }
        $url = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-089?Authorization=CWB-082621CE-932C-4699-BFA2-166C55CF8720&locationName=$locationName";
        $lines_array = file($url);
        $jsonObj = json_decode($lines_array["0"]);
        $location = $jsonObj->records->locations['0']->location;
        $weathers = Weather::apiObjToModels("twoDays", $location);
        foreach ($weathers as $weather) {
            if ($this->weatherC->checkWeatherExist($weather->getStartTime(), $weather->getCityName())) {
                $this->weatherC->updateByObj($weather);
            } else {
                $this->weatherC->insertByObj($weather);
            }
        }
    }

    public function updateAWeekWeather($locationName = null)
    {
        if ($locationName === null) {
            $locationName = " ";
        }
        $url = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-091?Authorization=CWB-082621CE-932C-4699-BFA2-166C55CF8720&locationName=$locationName";
        $lines_array = file($url);
        $jsonObj = json_decode($lines_array["0"]);
        $location = $jsonObj->records->locations['0']->location;
        $weathers = Weather::apiObjToModels("aWeek", $location);
        foreach ($weathers as $weather) {
            if ($this->weatherC->checkWeatherExist($weather->getStartTime(), $weather->getCityName())) {
                $this->weatherC->updateByObj($weather);
            } else {
                $this->weatherC->insertByObj($weather);
            }
        }
    }

    //雨量更新
    private function updateRainfall($locationName = null)
    {
        if ($locationName === null) {
            $locationName = " ";
        }
        $url = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/O-A0002-001?Authorization=CWB-082621CE-932C-4699-BFA2-166C55CF8720&locationName=$locationName";
        $lines_array = file($url);
        $jsonObj = json_decode($lines_array["0"]);
        $locations = $jsonObj->records->location;
        foreach ($locations as $location) {
            $rainfall = $this->rainfallC->getApiObjToModel("rainfall", $location);
            if ($this->rainfallC->checkExist($rainfall->getstationId())) {
                $this->rainfallC->updateByObj($rainfall);
            } else {
                $this->rainfallC->insertByObj($rainfall);
            }
        }
    }
}
