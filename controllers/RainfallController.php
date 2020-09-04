<?php
class RainfallController extends Controller
{
    private $_dao;
    public function __construct()
    {
        $this->requireDAO("rainfall");
    }

    public function insertByObj($str)
    {
        if (!($record = $this->getJsonToModel("rainfall", $str))) {
            return false;
        }

        if (RainfallService::getDAO()->insertRainfallByObj($record)) {
            return true;
        }

        return false;
    }

    public function update($str)
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
}
