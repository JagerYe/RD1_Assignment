<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/RD1_Assignment/models/rainfall/RainfallDAO_PDO.php";
class RainfallService
{
    public static function getDAO()
    {
        return new RainfallDAO_PDO();
    }
}
