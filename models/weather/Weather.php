<?php
class Weather implements \JsonSerializable
{
    private $_startTime; //開始時間
    private $_cityID; //城市ID
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

    public static function jsonStringToModel($jsonStr)
    {
        $jsonObj = json_decode($jsonStr);

        return new Weather(
            $jsonObj->_startTime,
            $jsonObj->_cityID,
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
                $jsonObj->_cityID,
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
            $request['cityID'],
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
                $request['cityID'],
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
        $cityID,
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
        $this->setCityID($cityID);
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

    public function getCityID()
    {
        return $this->_cityID;
    }
    public function setCityID($cityID)
    {
        $this->_cityID = $cityID;
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
        $this->_t = $t;
        return true;
    }

    public function getMinT()
    {
        return $this->_minT;
    }
    public function setMinT($minT)
    {
        $this->_minT = $minT;
        return true;
    }

    public function getMaxT()
    {
        return $this->_maxT;
    }
    public function setMaxT($maxT)
    {
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
