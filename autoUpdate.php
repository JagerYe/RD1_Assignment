<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/RD1_Assignment/core/Controller.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/RD1_Assignment/controllers/CityController.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/RD1_Assignment/controllers/RainfallController.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/RD1_Assignment/controllers/WeatherController.php";

$cityC = new CityController();
$rainfallC = new RainfallController();
$weatherC = new WeatherController();
$cityC->requireDAO("city");
$rainfallC->requireDAO("rainfall");
$weatherC->requireDAO("weather");

$url = 'https://opendata.cwb.gov.tw/api/v1/rest/datastore/O-A0002-001?Authorization=CWB-082621CE-932C-4699-BFA2-166C55CF8720';
$lines_array = file($url);
$jsonObj = json_decode($lines_array["0"]);

$locations = $jsonObj->records->location;

//更新城市
// insertCity();
// function insertCity()
// {
//     global $locations;
//     global $cityC;
//     foreach ($locations as $location) {

//         if (!$cityC->checkCityExist($location->parameter['0']->parameterValue)) {
//             $cityC->insertByApiObj($location);
//         }
//     }
// }

//雨量更新
// updateRainfall();
// function updateRainfall()
// {
//     global $locations;
//     global $rainfallC;
//     foreach ($locations as $location) {
//         $rainfall = $rainfallC->getApiObjToModel("rainfall", $location);
//         if ($rainfallC->checkExist($rainfall->getstationId())) {
//             $rainfallC->updateByObj($rainfall);
//         } else {
//             $rainfallC->insertByObj($rainfall);
//         }
//     }
// }
