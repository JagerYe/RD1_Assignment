<?php
class City implements \JsonSerializable
{
    private $_cityName;

    public static function jsonStringToModel($jsonStr)
    {
        $jsonObj = json_decode($jsonStr);

        return new City($jsonObj->_cityName);
    }

    public static function jsonArrayStringToModelsArray($jsonStr)
    {
        $jsonArr = json_decode($jsonStr);
        foreach ($jsonArr as $jsonObj) {
            $citys[] = new City($jsonObj->_cityName);
        }
        return $citys;
    }

    public static function dbDataToModel($request)
    {
        return new City(
            $request['cityName'],
        );
    }

    public static function dbDatasToModelsArray($requests)
    {
        foreach ($requests as $request) {
            $citys[] = new City(
                $request['cityName'],
            );
        }
        return $citys;
    }

    public function __construct($cityName)
    {
        $this->setCityName($cityName);
    }

    public function getCityName()
    {
        return $this->_cityName;
    }
    public function setCityName($cityName)
    {
        $this->_cityName = $cityName;
        return true;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
}
