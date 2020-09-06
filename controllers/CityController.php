<?php
class CityController extends Controller
{
    public function __construct()
    {
        $this->requireDAO("city");
    }

    public function insertByApiObj($location)
    {
        if (CityService::getDAO()->insertCity(
            $location->locationName
        )) {
            return true;
        }

        return false;
    }

    public function insertByObj($str)
    {

        if (!($city = $this->getJsonToModel("city", $str))) {
            return false;
        }


        if (CityService::getDAO()->insertCityByObj($city)) {
            return true;
        }

        return false;
    }

    public function update($str)
    {
        if (!($city = $this->getJsonToModel("city", $str))) {
            return false;
        }

        if (CityService::getDAO()->updateCity($city)) {
            return true;
        }
        return false;
    }

    public function delete($id)
    {
        if (CityService::getDAO()->deleteCityByID($id)) {
            return true;
        }
        return false;
    }

    public function getAll()
    {
        if ($citys = CityService::getDAO()->getAllCity()) {
            return json_encode($citys);
        }
        return false;
    }

    public function getOne($id)
    {
        if ($city = CityService::getDAO()->getOneCityByID($id)) {
            $a = json_encode($city);
            return $a;
        }
        return false;
    }

    public function checkCityExist($id)
    {
        return CityService::getDAO()->checkCityExist($id);
    }
}
