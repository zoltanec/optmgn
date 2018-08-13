<?php
//запрос языкового сообщения с кодом $code
function translit($phrase) {
	//список русских букв
	$letters_in=array(' э','шь','а','б','в','г','д','е','ё','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ъ','ы','э','ж','ц','ч','ш','щ','ю','я','ь');
	//соответсвующие замены в английской раскладке
	$letters_out=array(' e','sh','a','b','v','g','d','e','e','z','i','y','k','l','m','n','o','p','r','s','t','u','f','h','\'','i','ei','zh','ts','ch','sh','shch','yu','ya','\'');
	//эквиваленты замены в верхнем регистре
	$letters_big_out=array_map("strtoupper",$letters_out);
	foreach($letters_in AS $key=>$letter) {
		//преобразуем юникод букву в верхний регистр
		$letters_big_in[]=mb_strtoupper($letter,"UTF-8");
	}
	$phrase=str_replace($letters_in,$letters_out,$phrase);
	$phrase=str_replace($letters_big_in,$letters_big_out,$phrase);
	return $phrase;
}
class Session {
   //номер icq сессии
   var $icqnum,
           //логин пользователя
           $username=NULL,
           //переменные сессии
           $svars=array(),
           //идентификатор юзера
           $cid=0,
           //время последнего доступа к сессии
           $lastaccess=0,
           //язык сессии
           $lang="translit",
           //флаг авторизации
           $auth=FALSE;
   //конструктор класса, принимает одну переменную - номер аськи юзера
   function Session($icqnum) {
      global $db;
      $this->icqnum=$icqnum;
      $info=$db->fetchline("SELECT a.*,b.username FROM vpn_icq_list a 
LEFT OUTER JOIN vpn_contracts b USING (cid)
WHERE a.icq = '{$icqnum}' AND a.auto_auth LIMIT 1");
      if(!empty($info)) {
         $this->username=$info['username'];
         $this->cid=$info['cid'];
         $this->auth=TRUE;
      }
      $this->lastaccess=time();
      return 0;
   }
   //функция производит запрос языкового сообщения исходя из данных о языке пользователя
  function lang($code,$format_elements='') {
	//подключаем глобальную область видимости
	global $lang;
	$this->lang="translit";
	switch($this->lang) {
		case "ru":
		     $msg=iconv("UTF-8","CP1251",$lang['ru'][$code]);
		     break;
		case "en":
		     $msg=$lang['en'][$code];
		     break;
		case "translit":
		     $msg=translit($lang['ru'][$code]);
		     break;
		default: $msg=$lang['en'][$code];
		    break;
	}
	if(!empty($format_elements) AND is_array($format_elements)) {
	       return vsprintf($msg,$format_elements);
	} else return $msg;
  }
   //проверяем не слишком ли старая сессия
   function isOld() {
      if($this->lastaccess<time()-1800) {
         //сессия устаревшая
         return true;
      } else {
         //сессия не устаревшая
         return false;
      }
   }
   //устанавливаем авторизацию
   function auth($username,$password,$cid) {
      //устанавливаем все переменные
      $this->username=$username;
      $this->cid=$cid;
      $this->auth=TRUE;
      return true;
   }
   //обновляем время доступа
   function touch() {
      //ставим новую метку времени
      $this->lastaccess=time();
      return true;
   }
}
//класс обработчика пользовательских комманд
class Commands {
	private $commands=array();
	//число загруженных в бота комманд
	private $commands_loaded=1;
	//перечень загруженных функций
	private $functions=array();
	//счетчик вероятности
	private $iter=0;
	function export($params) {
		//счетчик загруженных функций
		$loaded_fnc=0;
		$loaded_cmds=0;
		//для каждой функции из модуля загружаем инфу
		foreach($params AS $function) {
			//если несколько команд ссылаются на одну функцию
			if(is_array($function['commands'])) {
				foreach($function['commands'] AS $command) {
					debug("Loaded action $command for function '{$function['function']}'");
					$this->commands[$this->commands_loaded]=$command;
					$this->functions[$this->commands_loaded]=$function['function'];
					$this->commands_loaded++;
					$loaded_cmds++;
				}
			} else {
				$this->commands[$this->commands_loaded]=$functions['commands'];
				$this->functions[$this->commands_loaded]=$function['function'];
				$this->commands_loaded++;
				$loaded_cmds++;
			}
			$loaded_fnc++;
		}
		debug("Loaded $loaded_fnc functions and $loaded_cmds commands");
	
	}
	//запускаем действие которое связано с нашим ключевым словом
	function run_action($message='',$icq=0)
	{
                $message=preg_replace('/\0/','',$message);
		//$message=addslashes($message);
		$action=explode(" ",$message);
                //проверяем существует ли сессия на данную аську
                if(isset($this->sessions[$icq])) {
                     $this->sessions[$icq]->touch();
                } else {
                     //сессии нет..создаем
                     $this->sessions[$icq]=new Session($icq);
                }
                //каждую 100ю обработку,чистим сессии
		if($this->iter == 100 ) {
			//производим очистку сессий
			foreach($this->sessions AS &$session) {
				if($session->isOld()) {
					unset($this->sessions[$icq]);
				}
			}
                        //сбрасываем счетчик итераций
                        $this->iter=0;
		} else {
			//увеличиваем количество итераций
			$this->iter++;
		}
		//осуществляем поиск
		debug("Getted action: {$action[0]}");
		if(!empty($action[0])) {
			if($id=array_search($action[0],$this->commands)) {
				debug("Running function ".$this->functions[$id]);
				eval("\$return={$this->functions[$id]}('{$message}',&\$this->sessions['$icq']);");
				return $return;
			} else {
				return help_badcmd('',&$this->sessions[$icq]);
			}
		} else {
			debug("Empty action...");
		}
	}
}
$cmd=new Commands();
$GLOBALS['commands']=array();
//функция отладки
define('DAEMON_NAME','commands');
//загрузка свойств 
function export($params) {
	
}
require_once "../../config.php";
require_once $sysPath."/include/sql.php";
require_once $sysPath."/languages/bot_lang.php";
require_once $sysPath."/include/helpers.lib.php";
$GLOBALS['db']=new Database();
$q_id=msg_get_queue(ftok("/dev/shm/icq_bot.mem", 'R'),0666);
//загружаем бота и инициализируем модули
debug("Loading commands parser");
debug("Opening modules dir...");
$modules=opendir("modules");
while($line=readdir($modules)) {
	if($line[0]!=".") {
		debug("Loading file $line");
		require_once "modules/$line";
	}
}
debug("Connecting to MySQL database");
$db->connect("localhost",$dbUser,$dbPassword,$dbName);
$iter=0;
while(msg_receive ($q_id, 2, $msg_type, 16384, $ipc_msg, true,MSG_NOERROR, $msg_error)) {
		if(!$db->ping()) {
         unset($db);
         $GLOBALS['db']=new Database();
         debug("Re-connecting to MySQL database");
         $db->connect("localhost",$dbUser,$dbPassword,$dbName);
      }
      //отладка
      debug("Recieved message from {$ipc_msg['from']}: {$ipc_msg['message']}");
      //обрабатываем сообщение и генерируем ответ
      $answer=$cmd->run_action($ipc_msg['message'],$ipc_msg['from']);
      //если ответ сгенерирован, то шлем его
      if(!empty($answer)) {
        //посылаем IPC сообщение
        if(!msg_send ($q_id,1,array('icq'=>$ipc_msg['from'],'message'=>$answer),true,true,$msg_err))
	{
                //не удалось отослать, ошибка
		debug("Unable to send IPC message");
	}
      //ничего не отослали, поспим
      }
}
?>
