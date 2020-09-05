<?php
interface CityDAO
{
    public function insertCity($cityName);
    public function updateCity($city);
    public function deleteCityByID($id);
    public function getOneCityByID($id);
    public function getAllCity();
    public function checkCityExist($id);
}
