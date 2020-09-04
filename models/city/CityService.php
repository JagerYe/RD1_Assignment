<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/RD1_Assignment/models/city/CityDAO_PDO.php";
class CityService
{
    public static function getDAO()
    {
        return new CityDAO_PDO();
    }
}
