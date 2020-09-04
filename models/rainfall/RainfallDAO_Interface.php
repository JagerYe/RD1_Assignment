<?php
interface RainfallDAO
{
    public function insertRainfall(
        $town_sn,
        $cityID,
        $locationName,
        $rain = null,
        $hour_24 = null
    );
    public function updateRainfall($rainfall);
    public function getOneByID($id);
    public function getCityObservatory($id);
}
