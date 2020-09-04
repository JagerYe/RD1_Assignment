<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/RD1_Assignment/models/weather/WeatherDAO_PDO.php";
class WeatherService
{
    public static function getDAO()
    {
        return new WeatherDAO_PDO();
    }
}
