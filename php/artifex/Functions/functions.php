<?php
$appConf = require dirname(__DIR__,1).'/appConfig.php';
function logError(Exception $e):void {
    global $appConf;
    //error_log($e->getMessage().'---'.date('Y-m-d H:i:s')."\n", 3, $appConf['baseURL'].$appConf['prjName'].'Log/database_logfile.log');
    error_log($e->getMessage().'---'.date('Y-m-d H:i:s')."\n", 3, 'Log/database_logfile.log');
    //echo "A DB error occurred. Please try again later.";
}
