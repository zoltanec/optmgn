<?php
//обработка логов асечных демонов
//$GLOBALS['log_id']=msg_get_queue(ftok("/dev/shm/icq_log.mem", 'R'),0666);
function debug($message) {
    echo date('Y/m/d H:i:s ').$message."\n";
    return true;
/*   global $log_id;
   if(defined(DAEMON_NAME)) {
   	msg_send ($log_id,2,array('daemon'=>DAEMON_NAME,message=>$message),true,true,$msg_err);
   }
   return true;*/
}
