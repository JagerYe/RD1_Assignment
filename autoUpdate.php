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

// //aWeek
$url = 'https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-091?Authorization=CWB-082621CE-932C-4699-BFA2-166C55CF8720';
$lines_array = file($url);
$jsonObj = json_decode($lines_array["0"]);
// //twoDays
// $url = 'https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-089?Authorization=CWB-082621CE-932C-4699-BFA2-166C55CF8720';
// $lines_array = file($url);
// $jsonObj = json_decode($lines_array["0"]);
//36hours
// $url = 'https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization=CWB-082621CE-932C-4699-BFA2-166C55CF8720';
// $lines_array = file($url);
// $jsonObj = json_decode($lines_array["0"]);



//天氣更新
updateWeather();
function updateWeather()
{
    global $jsonObj, $weatherC;
    //aWeek
    $location = $jsonObj->records->locations['0']->location;
    $weathers = $weatherC->getApiObjToModels("weather", $location);
    foreach ($weathers as $weather) {
        if ($weatherC->checkWeatherExist($weather->getStartTime(), $weather->getCityName())) {
            $weatherC->updateByObj($weather);
        }else{
            $weatherC->insertByObj($weather);
        }
    }
}


// $locations= $jsonObj->records->location;
//更新城市
// insertCity();
// function insertCity()
// {
//     global $locations;
//     global $cityC;
//     foreach ($locations as $location) {

//         if (!$cityC->checkCityExist($location->locationName)) {
//             $cityC->insertByApiObj($location);
//         }
//     }
// }

// $locations = $jsonObj->records->location;
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
