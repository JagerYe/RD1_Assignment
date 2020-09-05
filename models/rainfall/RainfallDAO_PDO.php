<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/RD1_Assignment/models/rainfall/RainfallDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/RD1_Assignment/models/config.php";
class RainfallDAO_PDO implements RainfallDAO
{

    private $_strInsert = "INSERT INTO `Rainfall`(
        `stationId`, `cityName`, `locationName`, `rain`, `hour_24`)
        VALUES (:stationId,:cityName,:locationName,:rain,:hour_24);";
    private $_strUpdate = "UPDATE `Rainfall`
        SET `locationName`=:locationName,`rain`=:rain,`hour_24`=:hour_24
        WHERE `stationId`=:stationId AND `cityName`=:cityName;";
    private $_strGetOneByID = "SELECT * FROM `Rainfall` WHERE `stationId`=:stationId;";
    private $_strCityGetObservatory = "SELECT `stationId`, `cityName`, `locationName` FROM `Rainfall` WHERE `cityName`=:cityName;";
    private $_strCheckExist = "SELECT COUNT(*) FROM `rainfall` WHERE `stationId`=:stationId";

    //新增
    public function insertRainfall(
        $stationId,
        $cityName,
        $locationName,
        $rain = null,
        $hour_24 = null
    ) {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare($this->_strInsert);
            $sth->bindParam("stationId", $stationId);
            $sth->bindParam("cityName", $cityName);
            $sth->bindParam("locationName", $locationName);
            $sth->bindParam("rain", $rain);
            $sth->bindParam("hour_24", $hour_24);
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
    public function insertRainfallByObj($Rainfall)
    {
        return $this->insertRainfall(
            $Rainfall->getstationId(),
            $Rainfall->getCityName(),
            $Rainfall->getLocationName(),
            $Rainfall->getRain(),
            $Rainfall->getHour_24()
        );
    }

    //更新
    public function updateRainfall($Rainfall)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare($this->_strUpdate);
            $sth->bindParam("locationName", $Rainfall->getLocationName());
            $sth->bindParam("rain", $Rainfall->getRain());
            $sth->bindParam("hour_24", $Rainfall->getHour_24());
            $sth->bindParam("stationId", $Rainfall->getstationId());
            $sth->bindParam("cityName", $Rainfall->getCityName());
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

    public function getOneByID($stationId)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare($this->_strGetOneByID);
            $sth->bindParam("stationId", $stationId);
            $sth->execute();
            $requests = $sth->fetch(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            return false;
        }
        $dbh = null;
        return Rainfall::dbDataToModel($requests);
    }

    public function getCityObservatory($cityName)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare($this->_strCityGetObservatory);
            $sth->bindParam("cityName", $cityName);
            $sth->execute();
            $requests = $sth->fetchAll(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            return false;
        }
        $dbh = null;
        return Rainfall::dbDatasToModelsArray($requests);
    }

    public function checkExist($id)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare($this->_strCheckExist);
            $sth->bindParam("stationId", $stationId);
            $sth->execute();
            $requests = $sth->fetch(PDO::FETCH_NUM);
            $sth = null;
        } catch (Exception $err) {
            $dbh = null;
        }
        $dbh = null;
        return $requests['0'];
    }
}
