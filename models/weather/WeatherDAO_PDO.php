<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/RD1_Assignment/models/weather/WeatherDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/RD1_Assignment/models/config.php";
class WeatherDAO_PDO implements WeatherDAO
{

    private $_strInsert = "INSERT INTO `Weather`(
        `startTime`, `endTime`, `cityID`, `Wx`, `T`,
        `MinT`, `MaxT`, `AT`, `PoP`, `RH`,
        `CI`, `WS`, `WD`, `UVI`)
        VALUES (:startTime,:endTime,:cityID,:Wx,:T,
                :MinT,:MaxT,:AT,:PoP,:RH,
                :CI,:WS,:WD,:UVI);";
    private $_strUpdate = "UPDATE `Weather`
        SET `endTime`=:endTime,`Wx`=:Wx,`T`=:T,`MinT`=:MinT,`MaxT`=:MaxT,
            `AT`=:AT,`PoP`=:PoP,`RH`=:RH,`CI`=:CI,`WS`=:WS,
            `WD`=:WD,`UVI`=:UVI
        WHERE `startTime`=:startTime AND `cityID`=:cityID;";
    private $_strDeleteOld = "DELETE FROM `Weather` WHERE `startTime` < NOW();";
    private $_strCheckSingleWeatherExist = "SELECT COUNT(*) FROM `Weather` WHERE `startTime`=:startTime AND `cityID`=:cityID;";
    private $_strGetNow = "SELECT * FROM `Weather` WHERE TIMESTAMPDIFF(HOUR, NOW(), `startTime`) < 36 AND `cityID`=:cityID;";
    private $_strGetTwoDay = "SELECT * FROM `Weather` WHERE TIMESTAMPDIFF(DAY, NOW(), `startTime`) < 3 AND `cityID`=:cityID;";
    private $_strGetAWeek = "SELECT * FROM `Weather` WHERE TIMESTAMPDIFF(WEEK, NOW(), `startTime`) < 1 AND `cityID`=:cityID;";

    //新增
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
    ) {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare($this->_strInsert);
            $sth->bindParam("startTime", $startTime);
            $sth->bindParam("endTime", $endTime);
            $sth->bindParam("cityID", $cityID);
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
            $weather->getCityID(),
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
            $dbh->beginTransaction();
            $sth = $dbh->prepare($this->_strUpdate);
            $sth->bindParam("startTime", $weather->getStartTime());
            $sth->bindParam("endTime", $weather->getEndTime());
            $sth->bindParam("cityID", $weather->getCityID());
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

    public function checkSingleWeatherExist($startTime, $cityID)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare($this->_strCheckSingleWeatherExist);
            $sth->bindParam("startTime", $startTime);
            $sth->bindParam("cityID", $cityID);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_NUM);
            $sth = null;
        } catch (PDOException $err) {
            return false;
        }
        $dbh = null;
        return $request['0'];
    }

    public function getCityNowWeather($cityID)
    {
        return $this->getCityWeather($cityID, "now");
    }

    public function getCityTwoDaysWeather($cityID)
    {
        return $this->getCityWeather($cityID, "twoDay");
    }

    public function getCityAWeekWeather($cityID)
    {
        return $this->getCityWeather($cityID, "aWeek");
    }

    private function getCityWeather($cityID, $howLong = "now")
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

            $sth->bindParam("cityID", $cityID);
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
