<?php
//подключаемся к пулу
$GLOBALS['log_id']=msg_get_queue(ftok("/dev/shm/icq_log.mem", 'R'),0666);
while(1) {
   if(msg_receive ($log_id, 2, $msg_type, 16384, $msg, true)) {
      echo date('Y/m/d H:i:s ')."[".$msg['daemon']."] ".$msg['message']."\n";
   }
}
?>