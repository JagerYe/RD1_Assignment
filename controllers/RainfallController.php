<?php
class RainfallController extends Controller
{
    public function __construct()
    {
        $this->requireDAO("rainfall");
    }

    public function insertByObj($rainfall)
    {
        if (RainfallService::getDAO()->insertRainfallByObj($rainfall)) {
            return true;
        }

        return false;
    }

    public function insertByJsonStr($str)
    {
        if (!($record = $this->getJsonToModel("rainfall", $str))) {
            return false;
        }

        if (RainfallService::getDAO()->insertRainfallByObj($record)) {
            return true;
        }

        return false;
    }

    public function updateByObj($rainfall)
    {
        if ($id = RainfallService::getDAO()->updateRainfall($rainfall)) {
            return true;
        }
        return false;
    }

    public function updateBuJsonStr($str)
    {
        if (!($record = $this->getJsonToModel("rainfall", $str))) {
            return false;
        }

        if ($id = RainfallService::getDAO()->updateRainfall($record)) {
            return true;
        }
        return false;
    }

    public function getOne($id)
    {

        if ($records = RainfallService::getDAO()->getOneByID($id)) {
            return json_encode($records);
        }
        return false;
    }

    public function getCityObservatory($id)
    {
        if ($record = RainfallService::getDAO()->getCityObservatory($id)) {
            return json_encode($record);
        }
        return false;
    }

    public function checkExist($id)
    {
        return RainfallService::getDAO()->checkExist($id);
    }
}
