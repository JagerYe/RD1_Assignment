<?php
interface WeatherDAO
{
    public function insertWeather(
        $startTime,
        $cityName,
        $endTime,
        $wx,
        $t,
        $minT,
        $maxT,
        $aT,
        $pop,
        $rh,
        $ci,
        $wS,
        $wD,
        $uvi
    );
    public function updateWeather($weather);
    public function deleteOldWeather();
    public function getCityNowWeather($cityName);
    public function getCityTwoDaysWeather($cityName);
    public function getCityAWeekWeather($cityName);
}
