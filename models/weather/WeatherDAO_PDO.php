<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/RD1_Assignment/models/weather/WeatherDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/RD1_Assignment/models/config.php";
class WeatherDAO_PDO implements WeatherDAO
{

    private $_strInsert = "INSERT INTO `Weather`(
        `startTime`, `endTime`, `cityName`, `Wx`, `T`,
        `MinT`, `MaxT`, `AT`, `PoP`, `RH`,
        `CI`, `WS`, `WD`, `UVI`)
        VALUES (:startTime,:endTime,:cityName,:Wx,:T,
                :MinT,:MaxT,:AT,:PoP,:RH,
                :CI,:WS,:WD,:UVI);";
    private $_strUpdate = "UPDATE `Weather`
        SET `endTime`=:endTime,`Wx`=:Wx,`T`=:T,`MinT`=:MinT,`MaxT`=:MaxT,
            `AT`=:AT,`PoP`=:PoP,`RH`=:RH,`CI`=:CI,`WS`=:WS,
            `WD`=:WD,`UVI`=:UVI
        WHERE `startTime`=:startTime AND `cityName`=:cityName;";
    private $_strDeleteOld = "DELETE FROM `Weather` WHERE `startTime` < DATE_ADD(NOW(),INTERVAL 1 DAY);";
    private $_strCheckSingleWeatherExist = "SELECT COUNT(*) FROM `Weather` WHERE `startTime`=:startTime AND `cityName`=:cityName;";
    private $_strGetNow = "SELECT * FROM `Weather` WHERE TIMESTAMPDIFF(HOUR, NOW(), `startTime`) < 36 AND `cityName`=:cityName;";
    private $_strGetTwoDay = "SELECT * FROM `Weather` WHERE TIMESTAMPDIFF(DAY, NOW(), `startTime`) < 3 AND `cityName`=:cityName;";
    private $_strGetAWeek = "SELECT * FROM `Weather` WHERE TIMESTAMPDIFF(WEEK, NOW(), `startTime`) < 1 AND `cityName`=:cityName;";
    private $_strGetOne = "SELECT * FROM `weather` WHERE `startTime`=:startTime AND `cityName`=:cityName;";

    //新增
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
    ) {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare($this->_strInsert);
            $sth->bindParam("startTime", $startTime);
            $sth->bindParam("endTime", $endTime);
            $sth->bindParam("cityName", $cityName);
            $sth->bindParam("Wx", $wx);
            $sth->bindParam("T", $t);
            $sth->bindParam("MinT", $minT);
            $sth->bindParam("MaxT", $maxT);
            $sth->bindParam("AT", $aT);
            $sth->bindParam("PoP", $pop);
            $sth->bindParam("RH", $rh);
            $sth->bindParam("CI", $ci);
            $sth->bindParam("WS", $wS);
            $sth->bindParam("WD", $wD);
            $sth->bindParam("UVI", $uvi);
            $sth->execute();
            $dbh->commit();
            $sth = null;
        } catch (Exception $err) {
            $dbh->rollBack();
            $dbh = null;
            return false;
        }
        $dbh = null;
        return true;
    }

    //新增 用物件
    public function insertWeatherByObj($weather)
    {
        return $this->insertWeather(
            $weather->getStartTime(),
            $weather->getcityName(),
            $weather->getEndTime(),
            $weather->getWX(),
            $weather->getT(),
            $weather->getMinT(),
            $weather->getMaxT(),
            $weather->getAT(),
            $weather->getPOP(),
            $weather->getRH(),
            $weather->getCI(),
            $weather->getWS(),
            $weather->getWD(),
            $weather->getUVI()
        );
    }

    //更新
    public function updateWeather($weather)
    {
        try {
            $dbh = Config::getDBConnect();
            $oldWeather = $this->getOneWeather($weather->getStartTime(), $weather->getCityName());

            if ($weather->getWX() === null) $weather->setWX($oldWeather->getWX());
            if ($weather->getT() === null) $weather->setT($oldWeather->getT());
            if ($weather->getMinT() === null) $weather->setMinT($oldWeather->getMinT());
            if ($weather->getMaxT() === null) $weather->setMaxT($oldWeather->getMaxT());
            if ($weather->getAT() === null) $weather->setAT($oldWeather->getAT());
            if ($weather->getPOP() === null) $weather->setPOP($oldWeather->getPOP());
            if ($weather->getRH() === null) $weather->setRH($oldWeather->getRH());
            if ($weather->getCI() === null) $weather->setCI($oldWeather->getCI());
            if ($weather->getWS() === null) $weather->setWS($oldWeather->getWS());
            if ($weather->getWD() === null) $weather->setWD($oldWeather->getWD());
            if ($weather->getUVI() === null) $weather->setUVI($oldWeather->getUVI());

            $dbh->beginTransaction();
            $sth = $dbh->prepare($this->_strUpdate);
            $sth->bindParam("startTime", $weather->getStartTime());
            $sth->bindParam("endTime", $weather->getEndTime());
            $sth->bindParam("cityName", $weather->getcityName());
            $sth->bindParam("Wx", $weather->getWX());
            $sth->bindParam("T", $weather->getT());
            $sth->bindParam("MinT", $weather->getMinT());
            $sth->bindParam("MaxT", $weather->getMaxT());
            $sth->bindParam("AT", $weather->getAT());
            $sth->bindParam("PoP", $weather->getPOP());
            $sth->bindParam("RH", $weather->getRH());
            $sth->bindParam("CI", $weather->getCI());
            $sth->bindParam("WS", $weather->getWS());
            $sth->bindParam("WD", $weather->getWD());
            $sth->bindParam("UVI", $weather->getUVI());
            $sth->execute();
            $dbh->commit();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            return false;
        }
        $dbh = null;
        return true;
    }

    private function getOneWeather($startTime, $cityName)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare($this->_strGetOne);
            $sth->bindParam("startTime", $startTime);
            $sth->bindParam("cityName", $cityName);
            $sth->execute();
            $requests = $sth->fetch(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            return false;
        }
        $dbh = null;
        return Weather::dbDataToModel($requests);
    }

    public function deleteOldWeather()
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare($this->_strDeleteOld);
            $sth->execute();
            $dbh->commit();
            $sth = null;
        } catch (Exception $err) {
            $dbh->rollBack();
            return false;
        }
        $dbh = null;
        return true;
    }

    public function checkSingleWeatherExist($startTime, $cityName)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare($this->_strCheckSingleWeatherExist);
            $sth->bindParam("startTime", $startTime);
            $sth->bindParam("cityName", $cityName);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_NUM);
            $sth = null;
        } catch (PDOException $err) {
            return false;
        }
        $dbh = null;
        return $request['0'];
    }

    public function getCityNowWeather($cityName)
    {
        return $this->getCityWeather($cityName, "now");
    }

    public function getCityTwoDaysWeather($cityName)
    {
        return $this->getCityWeather($cityName, "twoDay");
    }

    public function getCityAWeekWeather($cityName)
    {
        return $this->getCityWeather($cityName, "aWeek");
    }

    private function getCityWeather($cityName, $howLong = "now")
    {
        try {
            $dbh = Config::getDBConnect();

            switch ($howLong) {
                case "now":
                    $sth = $dbh->prepare($this->_strGetNow);
                    break;
                case "twoDay":
                    $sth = $dbh->prepare($this->_strGetTwoDay);
                    break;
                case "aWeek":
                    $sth = $dbh->prepare($this->_strGetAWeek);
                    break;
            }

            $sth->bindParam("cityName", $cityName);
            $sth->execute();
            $requests = $sth->fetchAll(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            return false;
        }
        $dbh = null;
        return Weather::dbDatasToModelsArray($requests);
    }
}
