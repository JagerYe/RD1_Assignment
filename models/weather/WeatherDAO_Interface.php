<?php
interface WeatherDAO
{
    public function insertWeather(
        $startTime,
        $cityID,
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
    public function getCityNowWeather($cityID);
    public function getCityTwoDaysWeather($cityID);
    public function getCityAWeekWeather($cityID);
}
