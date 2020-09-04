<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/RD1_Assignment/models/rainfall/RainfallDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/RD1_Assignment/models/config.php";
class RainfallDAO_PDO implements RainfallDAO
{

    private $_strInsert = "INSERT INTO `Rainfall`(
        `town_sn`, `cityID`, `locationName`, `rain`, `hour_24`)
        VALUES (:town_sn,:cityID,:locationName,:rain,:hour_24);";
    private $_strUpdate = "UPDATE `Rainfall`
        SET `locationName`=:locationName,`rain`=:rain,`hour_24`=:hour_24
        WHERE `town_sn`=:town_sn AND `cityID`=:cityID;";
    private $_strGetOneByID = "SELECT * FROM `Rainfall` WHERE `town_sn`=:town_sn;";
    private $_strCityGetObservatory = "SELECT `town_sn`, `cityID`, `locationName` FROM `Rainfall` WHERE `cityID`=:cityID;";

    //新增
    public function insertRainfall(
        $town_sn,
        $cityID,
        $locationName,
        $rain = null,
        $hour_24 = null
    ) {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare($this->_strInsert);
            $sth->bindParam("town_sn", $town_sn);
            $sth->bindParam("cityID", $cityID);
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
            $Rainfall->getTown_sn(),
            $Rainfall->getCityID(),
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
            $sth->bindParam("town_sn", $Rainfall->getTown_sn());
            $sth->bindParam("cityID", $Rainfall->getCityID());
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

    public function getOneByID($town_sn)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare($this->_strGetOneByID);
            $sth->bindParam("town_sn", $town_sn);
            $sth->execute();
            $requests = $sth->fetch(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            return false;
        }
        $dbh = null;
        return Rainfall::dbDataToModel($requests);
    }

    public function getCityObservatory($cityID)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare($this->_strCityGetObservatory);
            $sth->bindParam("cityID", $cityID);
            $sth->execute();
            $requests = $sth->fetchAll(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            return false;
        }
        $dbh = null;
        return Rainfall::dbDatasToModelsArray($requests);
    }
}
