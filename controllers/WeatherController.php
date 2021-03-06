<?php
class WeatherController extends Controller
{
    public function __construct()
    {
        $this->requireDAO("weather");
    }

    public function insertByObj($record)
    {
        return WeatherService::getDAO()->insertWeatherByObj($record);
    }

    public function insertByJson($str)
    {
        if (!($record = $this->getJsonToModel("weather", $str))) {
            return false;
        }

        if (WeatherService::getDAO()->insertWeatherByObj($record)) {
            return true;
        }

        return false;
    }

    public function updateByObj($record)
    {
        return WeatherService::getDAO()->updateWeather($record);
    }

    public function updateByJson($str)
    {
        if (!($record = $this->getJsonToModel("weather", $str))) {
            return false;
        }

        if (WeatherService::getDAO()->updateWeather($record)) {
            return true;
        }
        return false;
    }

    public function deleteOld()
    {
        return WeatherService::getDAO()->deleteOldWeather();
    }

    public function getCityNow($cityID)
    {

        if ($records = WeatherService::getDAO()->getCityNowWeather($cityID)) {
            return json_encode($records);
        }
        return false;
    }

    public function getCityTwoDays($cityID)
    {
        if ($record = WeatherService::getDAO()->getCityTwoDaysWeather($cityID)) {
            return json_encode($record);
        }
        return false;
    }

    public function getCityAWeek($cityID)
    {
        if ($record = WeatherService::getDAO()->getCityAWeekWeather($cityID)) {
            return json_encode($record);
        }
        return false;
    }

    public function checkWeatherExist($startTime, $cityName)
    {
        return WeatherService::getDAO()->checkSingleWeatherExist($startTime, $cityName);
    }
}
