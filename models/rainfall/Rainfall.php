<?php
class Rainfall implements \JsonSerializable
{
    private $_stationId;
    private $_cityName;
    private $_locationName;
    private $_rain;
    private $_hour_24;

    public static function apiObjToModel($apiObj)
    {
        return new Rainfall(
            $apiObj->stationId,
            $apiObj->parameter['0']->parameterValue,
            $apiObj->locationName,
            $apiObj->weatherElement['2']->elementValue,
            $apiObj->weatherElement['6']->elementValue
        );
    }

    public static function jsonStringToModel($jsonStr)
    {
        $jsonObj = json_decode($jsonStr);

        return new Rainfall(
            $jsonObj->_stationId,
            $jsonObj->_cityName,
            $jsonObj->_locationName,
            $jsonObj->_rain,
            $jsonObj->_hour_24
        );
    }

    public static function jsonArrayStringToModelsArray($jsonStr)
    {
        $jsonArr = json_decode($jsonStr);

        foreach ($jsonArr as $jsonObj) {
            $rainfalls[] = new Rainfall(
                $jsonObj->_stationId,
                $jsonObj->_cityName,
                $jsonObj->_locationName,
                $jsonObj->_rain,
                $jsonObj->_hour_24
            );
        }
        return $rainfalls;
    }

    public static function dbDataToModel($request)
    {
        return new Rainfall(
            $request['stationId'],
            $request['cityName'],
            $request['locationName'],
            $request['rain'],
            $request['hour_24']
        );
    }

    public static function dbDatasToModelsArray($requests)
    {
        foreach ($requests as $request) {
            $records[] = new Rainfall(
                $request['stationId'],
                $request['cityName'],
                $request['locationName'],
                $request['rain'],
                $request['hour_24']
            );
        }
        return $records;
    }

    public function __construct(
        $stationId,
        $cityName,
        $locationName,
        $rain = null,
        $hour_24 = null
    ) {
        $this->setstationId($stationId);
        $this->setCityName($cityName);
        $this->setLocationName($locationName);
        $this->setRain($rain);
        $this->setHour_24($hour_24);
    }

    public function getstationId()
    {
        return $this->_stationId;
    }
    public function setstationId($stationId)
    {
        $this->_stationId = $stationId;
        return true;
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
    public function setRain($data)
    {
        if ($data < 0) {
            $data = 0;
        }
        $this->_rain = $data;
        return true;
    }

    public function getHour_24()
    {
        return $this->_hour_24;
    }
    public function setHour_24($data)
    {
        if ($data < 0) {
            $data = 0;
        }
        $this->_hour_24 = $data;
        return true;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
