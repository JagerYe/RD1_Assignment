<?php

class Controller
{
    public function requireDAO($dao)
    {
        require_once "{$_SERVER['DOCUMENT_ROOT']}/RD1_Assignment/models/$dao/{$dao}Service.php";
        require_once "{$_SERVER['DOCUMENT_ROOT']}/RD1_Assignment/models/$dao/$dao.php";
    }
    public function getJsonToModel($model, $jsonStr)
    {

        return $model::jsonStringToModel($jsonStr);
    }

    public function getJsonArrToModelsArr($model, $jsonStr)
    {
        return $model::jsonArrayStringToModelsArray($jsonStr);
    }
}
