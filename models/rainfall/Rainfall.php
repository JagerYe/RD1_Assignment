<?php
class Rainfall implements \JsonSerializable
{
    private $_town_sn;
    private $_cityID;
    private $_locationName;
    private $_rain;
    private $_hour_24;

    public static function jsonStringToModel($jsonStr)
    {
        $jsonObj = json_decode($jsonStr);

        return new Rainfall(
            $jsonObj->_town_sn,
            $jsonObj->_cityID,
            $jsonObj->_locationName,
            $jsonObj->_rain = null,
            $jsonObj->_hour_24 = null
        );
    }

    public static function jsonArrayStringToModelsArray($jsonStr)
    {
        $jsonArr = json_decode($jsonStr);
        $rainfall = new Rainfall("", "", "");


        foreach ($jsonArr as $jsonObj) {
            $rainfall->setTown_sn($jsonObj->_town_sn);
            $rainfall->setCityID($jsonObj->_cityID);
            $rainfall->setLocationName($jsonObj->_locationName);
            $rainfall->setRain($jsonObj->_rain);
            $rainfall->setHour_24($jsonObj->_hour_24);
            $rainfalls[] = $rainfall;
        }
        return $rainfalls;
    }

    public static function dbDataToModel($request)
    {
        return new Rainfall(
            $request['town_sn'],
            $request['cityID'],
            $request['locationName'],
            $request['rain'],
            $request['hour_24']
        );
    }

    public static function dbDatasToModelsArray($requests)
    {
        foreach ($requests as $request) {
            $records[] = new Rainfall(
                $request['town_sn'],
                $request['cityID'],
                $request['locationName'],
                $request['rain'],
                $request['hour_24']
            );
        }
        return $records;
    }

    public function __construct(
        $town_sn,
        $cityID,
        $locationName,
        $rain = null,
        $hour_24 = null
    ) {
        $this->setTown_sn($town_sn);
        $this->setCityID($cityID);
        $this->setLocationName($locationName);
        $this->setRain($rain);
        $this->setHour_24($hour_24);
    }

    public function getTown_sn()
    {
        return $this->_town_sn;
    }
    public function setTown_sn($town_sn)
    {
        $this->_town_sn = $town_sn;
        return true;
    }

    public function getCityID()
    {
        return $this->_cityID;
    }
    public function setCityID($cityID)
    {
        $this->_cityID = $cityID;
        return true;
    }

    public function getLocationName()
    {
        return $this->_locationName;
    }
    public function setLocationName($locationName)
    {
        $this->_locationName = $locationName;
        return true;
    }

    public function getRain()
    {
        return $this->_rain;
    }
    public function setRain($rain)
    {
        $this->_rain = $rain;
        return true;
    }

    public function getHour_24()
    {
        return $this->_hour_24;
    }
    public function setHour_24($hour_24)
    {
        $this->_hour_24 = $hour_24;
        return true;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
