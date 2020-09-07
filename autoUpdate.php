<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/RD1_Assignment/core/Controller.php";
set_time_limit(0); //讓程序一直執行下去

require_once "{$_SERVER['DOCUMENT_ROOT']}/RD1_Assignment/controllers/AutoUpdateController.php";

date_default_timezone_set('Asia/Taipei');

$autoUpdateC = new AutoUpdateController();
do {
    $autoUpdateC->doUpdate();
    //設定下次更新時間
    $nowTime = time();
    $nextHours = (intval(date('H') / 3) + 1) * 3;
    $nextTime = mktime($nextHours, 0, 0, date('m'), date('d'), date('Y'));
    echo "Next update : " . ($nextTime - $nowTime);
    ob_flush();
    flush();
    sleep($nextTime - $nowTime);
} while (true);
