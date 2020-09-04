<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/RD1_Assignment/models/city/CityDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/RD1_Assignment/models/config.php";
class CityDAO_PDO implements CityDAO
{

    private $_strInsert = "INSERT INTO `Citys`(`cityID`, `cityName`) VALUES (:cityID,:cityName);";
    private $_strUpdate = "UPDATE `Citys` SET `cityName`=:cityName WHERE `cityID`=:cityID;";
    private $_strDelete = "DELETE FROM `Citys` WHERE `cityID`=:cityID;";
    private $_strCheckCityExist = "SELECT COUNT(*) FROM `Citys` WHERE `cityID`=:cityID;";
    private $_strGetAll = "SELECT * FROM `Citys`;";
    private $_strGetOne = "SELECT * FROM `Citys` WHERE `cityID`=:cityID;";

    //新增會員
    public function insertCity($cityID, $cityName)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare($this->_strInsert);
            $sth->bindParam("cityID", $cityID);
            $sth->bindParam("cityName", $cityName);
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
    //新增會員 用物件
    public function insertCityByObj($city)
    {
        return $this->insertCity(
            $city->getCityID(),
            $city->getCityName()
        );
    }

    //更新會員
    public function updateCity($city)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare($this->_strUpdate);
            $sth->bindParam("cityID", $city->getCityID());
            $sth->bindParam("cityName", $city->getCityName());
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

    //之後需增加檢查是否有訂單
    public function deleteCityByID($id)
    {
        try {
            if ($this->checkCityExist($id) != 1) {
                throw new Exception("找不到");
            }
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare($this->_strDelete);
            $sth->bindParam("cityID", $id);
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

    public function getAllCity()
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->query($this->_strGetAll);
            $request = $sth->fetchAll(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            echo ($err->__toString());
            return false;
        }
        $dbh = null;
        return City::dbDatasToModelsArray($request);
    }
    public function getOneCityByID($id)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare($this->_strGetOne);
            $sth->bindParam("cityID", $id);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            echo ($err->__toString());
            return false;
        }
        $dbh = null;
        return City::dbDataToModel($request);
    }

    public function checkCityExist($id)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare($this->_strCheckCityExist);
            $sth->bindParam("cityID", $id);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_NUM);
        } catch (Exception $err) {
            return false;
        }
        return $request['0'];
    }
}
