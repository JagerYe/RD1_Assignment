<?php
class Weather implements \JsonSerializable
{
    private $_startTime; //開始時間
    private $_cityName; //城市ID
    private $_endTime; //結束時間
    private $_wx; //天氣現象
    private $_t; //平均溫度
    private $_minT; //最低溫度
    private $_maxT; //最高溫度
    private $_aT; //體感溫度
    private $_pop; //降雨機率
    private $_rh; //相對濕度
    private $_ci; //舒適度
    private $_wS; //風速
    private $_wD; //風向
    private $_uvi; //紫外線

    public static function apiObjToModels($aims, $locations)
    {
        switch ($aims) {
            case "aWeek":
                return Weather::_apiAWeekToModel($locations);
            case "twoDays":
                return Weather::_apiTwoDaysToModel($locations);
            case "36Hours":
                return Weather::_api36HoursToModel($locations);
        }
    }

    private static function _api36HoursToModel($locations){
        foreach ($locations as $location) {
            for ($i = 0; $i < count($location->weatherElement['1']->time); $i++) {
                $startTime = $location->weatherElement['1']->time[$i]->startTime;
                if (!($startTime->strpos("06:") > 0 || $startTime->strpos("18:") > 0)) {
                    continue;
                }
                $weather = new Weather("???", "???", "???");
                $weather->setStartTime($startTime);
                $weather->setCityName($location->locationName);
                $weather->setEndTime($location->weatherElement['1']->time[$i]->endTime);
                $weather->setWX($location->weatherElement['1']->time[$i]->elementValue['0']->value);
                $weather->setAT($location->weatherElement['2']->time[$i]->elementValue['0']->value);
                $weather->setT($location->weatherElement['3']->time[$i]->elementValue['0']->value);
                // $weather->setPOP($location->weatherElement['0']->time[$i]->elementValue['0']->value);
                $weather->setRH($location->weatherElement['4']->time[$i]->elementValue['0']->value);
                $weather->setCI($location->weatherElement['5']->time[$i]->elementValue['0']->value);
                $weather->setWS($location->weatherElement['8']->time[$i]->elementValue['0']->value);
                $weather->setWD($location->weatherElement['9']->time[$i]->elementValue['0']->value);
                foreach ($location->weatherElement['7']->time as $time) {

                    if ($time->startTime == $startTime) {
                        $weather->setPOP($time->elementValue['0']->value);
                    }
                    if ($time->startTime >= $startTime) {
                        break;
                    }
                }

                $weathers[] = $weather;
            }
        }
        return $weathers;
    }

    private static function _apiTwoDaysToModel($locations)
    {
        foreach ($locations as $location) {
            for ($i = 0; $i < count($location->weatherElement['1']->time); $i++) {
                $startTime = $location->weatherElement['1']->time[$i]->startTime;
                if (!($startTime->strpos("06:") > 0 || $startTime->strpos("18:") > 0)) {
                    continue;
                }
                $weather = new Weather("???", "???", "???");
                $weather->setStartTime($startTime);
                $weather->setCityName($location->locationName);
                $weather->setEndTime($location->weatherElement['1']->time[$i]->endTime);
                $weather->setWX($location->weatherElement['1']->time[$i]->elementValue['0']->value);
                $weather->setAT($location->weatherElement['2']->time[$i]->elementValue['0']->value);
                $weather->setT($location->weatherElement['3']->time[$i]->elementValue['0']->value);
                // $weather->setPOP($location->weatherElement['0']->time[$i]->elementValue['0']->value);
                $weather->setRH($location->weatherElement['4']->time[$i]->elementValue['0']->value);
                $weather->setCI($location->weatherElement['5']->time[$i]->elementValue['0']->value);
                $weather->setWS($location->weatherElement['8']->time[$i]->elementValue['0']->value);
                $weather->setWD($location->weatherElement['9']->time[$i]->elementValue['0']->value);
                foreach ($location->weatherElement['7']->time as $time) {

                    if ($time->startTime == $startTime) {
                        $weather->setPOP($time->elementValue['0']->value);
                    }
                    if ($time->startTime >= $startTime) {
                        break;
                    }
                }

                $weathers[] = $weather;
            }
        }
        return $weathers;
    }

    private static function _apiAWeekToModel($locations)
    {
        foreach ($locations as $location) {
            for ($i = 0; $i < count($location->weatherElement['0']->time); $i++) {
                $weather = new Weather("???", "???", "???");
                $weather->setStartTime($location->weatherElement['0']->time[$i]->startTime);
                $weather->setCityName($location->locationName);
                $weather->setEndTime($location->weatherElement['0']->time[$i]->endTime);
                $weather->setWX($location->weatherElement['6']->time[$i]->elementValue['0']->value);
                $weather->setT($location->weatherElement['1']->time[$i]->elementValue['0']->value);
                $weather->setMinT($location->weatherElement['8']->time[$i]->elementValue['0']->value);
                $weather->setMaxT($location->weatherElement['12']->time[$i]->elementValue['0']->value);
                $weather->setPOP($location->weatherElement['0']->time[$i]->elementValue['0']->value);
                $weather->setRH($location->weatherElement['2']->time[$i]->elementValue['0']->value);
                $weather->setWS($location->weatherElement['4']->time[$i]->elementValue['0']->value);
                $weather->setWD($location->weatherElement['13']->time[$i]->elementValue['0']->value);
                foreach ($location->weatherElement['9']->time as $time) {

                    if ($time->startTime == $weather->getStartTime()) {
                        $weather->setUVI($time->elementValue['0']->value);
                    }
                    if ($time->startTime >= $weather->getStartTime()) {
                        break;
                    }
                }
                $weathers[] = $weather;
            }
        }
        return $weathers;
    }

    public static function jsonStringToModel($jsonStr)
    {
        $jsonObj = json_decode($jsonStr);

        return new Weather(
            $jsonObj->_startTime,
            $jsonObj->_cityName,
            $jsonObj->_endTime,
            $jsonObj->_wx = null,
            $jsonObj->_t = null,
            $jsonObj->_minT = null,
            $jsonObj->_maxT = null,
            $jsonObj->_aT = null,
            $jsonObj->_pop = null,
            $jsonObj->_rh = null,
            $jsonObj->_ci = null,
            $jsonObj->_wS = null,
            $jsonObj->_wD = null,
            $jsonObj->_uvi = null
        );
    }

    public static function jsonArrayStringToModelsArray($jsonStr)
    {
        $jsonArr = json_decode($jsonStr);
        foreach ($jsonArr as $jsonObj) {
            $rainfall[] = new Weather(
                $jsonObj->_startTime,
                $jsonObj->_cityName,
                $jsonObj->_endTime,
                $jsonObj->_wx = null,
                $jsonObj->_t = null,
                $jsonObj->_minT = null,
                $jsonObj->_maxT = null,
                $jsonObj->_aT = null,
                $jsonObj->_pop = null,
                $jsonObj->_rh = null,
                $jsonObj->_ci = null,
                $jsonObj->_wS = null,
                $jsonObj->_wD = null,
                $jsonObj->_uvi = null
            );
        }
        return $rainfall;
    }

    public static function dbDataToModel($request)
    {
        return new Weather(
            $request['startTime'],
            $request['cityName'],
            $request['endTime'],
            $request['wx'],
            $request['t'],
            $request['minT'],
            $request['maxT'],
            $request['aT'],
            $request['pop'],
            $request['rh'],
            $request['ci'],
            $request['wS'],
            $request['wD'],
            $request['uvi']
        );
    }

    public static function dbDatasToModelsArray($requests)
    {
        foreach ($requests as $request) {
            $records[] = new Weather(
                $request['startTime'],
                $request['cityName'],
                $request['endTime'],
                $request['wx'],
                $request['t'],
                $request['minT'],
                $request['maxT'],
                $request['aT'],
                $request['pop'],
                $request['rh'],
                $request['ci'],
                $request['wS'],
                $request['wD'],
                $request['uvi']
            );
        }
        return $records;
    }

    public function __construct(
        $startTime,
        $cityName,
        $endTime,
        $wx = null,
        $t = null,
        $minT = null,
        $maxT = null,
        $aT = null,
        $pop = null,
        $rh = null,
        $ci = null,
        $wS = null,
        $wD = null,
        $uvi = null
    ) {
        $this->setStartTime($startTime);
        $this->setCityName($cityName);
        $this->setEndTime($endTime);
        $this->setWX($wx);
        $this->setT($t);
        $this->setMinT($minT);
        $this->setMaxT($maxT);
        $this->setAT($aT);
        $this->setPOP($pop);
        $this->setRH($rh);
        $this->setCI($ci);
        $this->setWS($wS);
        $this->setWD($wD);
        $this->setUVI($uvi);
    }

    public function getStartTime()
    {
        return $this->_startTime;
    }
    public function setStartTime($startTime)
    {
        $this->_startTime = $startTime;
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

    public function getEndTime()
    {
        return $this->_endTime;
    }
    public function setEndTime($endTime)
    {
        $this->_endTime = $endTime;
        return true;
    }

    public function getWX()
    {
        return $this->_wx;
    }
    public function setWX($wx)
    {
        $this->_wx = $wx;
        return true;
    }

    public function getT()
    {
        return $this->_t;
    }
    public function setT($t)
    {
        if ($t < -273.15) {
            $t = null;
        }
        $this->_t = $t;
        return true;
    }

    public function getMinT()
    {
        return $this->_minT;
    }
    public function setMinT($minT)
    {
        if ($minT < -273.15) {
            $minT = null;
        }
        $this->_minT = $minT;
        return true;
    }

    public function getMaxT()
    {
        return $this->_maxT;
    }
    public function setMaxT($maxT)
    {
        if ($maxT < -273.15) {
            $maxT = null;
        }
        $this->_maxT = $maxT;
        return true;
    }

    public function getAT()
    {
        return $this->_aT;
    }
    public function setAT($aT)
    {
        $this->_aT = $aT;
        return true;
    }

    public function getPOP()
    {
        return $this->_pop;
    }
    public function setPOP($pop)
    {
        if ($pop < 0) {
            $pop = 0;
        }
        $this->_pop = $pop;
        return true;
    }

    public function getRH()
    {
        return $this->_rh;
    }
    public function setRH($rh)
    {
        $this->_rh = $rh;
        return true;
    }

    public function getCI()
    {
        return $this->_ci;
    }
    public function setCI($ci)
    {
        $this->_ci = $ci;
        return true;
    }

    public function getWS()
    {
        return $this->_wS;
    }
    public function setWS($wS)
    {
        $this->_wS = $wS;
        return true;
    }

    public function getWD()
    {
        return $this->_wD;
    }
    public function setWD($wD)
    {
        $this->_wD = $wD;
        return true;
    }

    public function getUVI()
    {
        return $this->_uvi;
    }
    public function setUVI($uvi)
    {
        $this->_uvi = $uvi;
        return true;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
