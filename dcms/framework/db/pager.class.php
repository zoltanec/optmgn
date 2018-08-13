<?php
trait D_Db_Pager {

  //public $totalpages;

  static function __pager_settings() {
    return array('url' => '',
                 'visible' => 3,
                 'mode' => 'normal',
                 'perpage' => 50,
                 'template' => 'core;pager');
  }

  static function __table() {
		return '#PX#_'.strtolower(get_called_class());
	}

  static function __fetch_query() {
    $table = self::__table();
    return "SELECT * FROM {$table}";
  }

  static function getSettings() {
    $default_settings = D_Db_Pager::__pager_settings();
    $settings = self::__pager_settings();
    foreach($default_settings as $setting => $value) {
      if(!isset($settings[$setting]))
        $settings[$setting] = $value;
    }
    return $settings;
	}

  static function __pager() {
    return call_user_func_array(array(get_called_class(), 'getPages'), func_get_args());
  }

  //argument: $current, $total
  static function getPager() {
    //var_dump(self::$total_pages);exit;
    // $visible показывать количество страниц в навигации
    // $mode режим отображения
    // при режиме reverse сначала идут страницы с более высоким номером, при режиме normal наоборот
    // $url на который надо перебрасывать
    // проверяем все параметры которые нам были переданы
    $settings = self::getSettings();

    $visible = $settings['visible'];
    $mode = $settings['mode'];
    
    //$pager = self::__pager();
    //$total = $pager->totalpages;
    $arguments = func_get_args();
    isset($arguments[0]) ? $current = $arguments[0] : $current = 1;
    if(isset($arguments[1]))
      $total = $arguments[1];
    else $total = self::$total_pages;

    if($total <= 1) {
      return '';
    }
    
    // список страниц
    if($total <= $visible) {
        $range = range(1, $total);
      } else {
        $side_count = floor($visible / 2);
        if($current + $side_count >= $total )  {
          $range =  range($current  - $side_count, $total);
        } elseif($current - $side_count <= 0 ) {
        $range =  range(1, $current + $side_count);
        } else {
        $range =  range($current - $side_count ,$current + $side_count);
        }
      }
      if($mode == 'reverse') {
        $range = array_reverse($range);
      }
      if( ( $mode == 'normal' && $current > ceil($visible/2) ) || ($mode == 'reverse' && $current < $total - floor($visible/2)) ) {
        // первая страница в зависимости от режима
        $begin_page = ($mode == 'normal') ? '1' : $total;
        $result['begin_page'] = $begin_page;
      }
      if( ( $mode == 'normal' && $current > 1 ) || ( $mode == 'reverse' && $current < $total ) ) {
        $left_page = ($mode == 'normal') ? $current - 1 : $current + 1;
        $result['left_page'] = $left_page;
      }

      if( ( $mode == 'normal' && $current < $total ) || ( $mode == 'reverse' && $current > 1 )) {
        $right_page = ($mode == 'normal') ? $current + 1 : $current - 1;
        $result['right_page'] = $right_page;
      }
      if( ( $mode == 'normal' && $current < $total - ceil($visible/2)) || ( $mode == 'reverse' && $current > ceil($visible/2) )) {
        $end_page = ($mode == 'normal') ? $total : 1;
        $result['end_page'] = $end_page;
      }
      $result['range'] = $range;
      $result['current'] = $current;
      $result['url'] = $settings['url'];
      return $result;
  }

  //Получить навигацию smarty
  static function getPagerNav() {
    //var_dump(func_get_args());exit;
    $params = call_user_func_array(array(get_called_class(), 'getPager'), func_get_args());
    //var_dump($params);exit;
    if(is_array($params))
      self::getPagerTemplate($params);
  }

  //Зарегистрировать переменные smarty и отобразить шаблон
  static function getPagerTemplate($params) {
    foreach($params as $varname => $value) {
      D::$tpl->assign($varname, $value);
    }
    $settings = self::getSettings();
    echo D::$tpl->fetchTpl($settings['template']);
  }

  static function getPages($filter = array(), $order = '', $group = '') {
    $order_field = '';
    $sort = '';
    self::$total_pages = '';
    //Если аргументы переданы через __pager
    $arguments = func_get_args();
    if(count($arguments)) {
      $filter = $arguments[0];
      if(isset($arguments[1]))
        $order = $arguments[1];
    }

    if(is_array($order)) {
      foreach($order as $field => $sort_order) {
        if(!prev($order))
        $order_field = 'ORDER BY ';
        $order_field .= $field . ' ' . $sort_order;
        if(next($order))
          $order_field .= ',';
      }
      //list($order_field, $sort) = $order;
      //$order_field = "ORDER BY " . $order_field;
    } elseif($order) {
      $sort = "DESC";
      $order_field = "ORDER BY " . $order . ' ' . $sort;
    }
    
    $group_field = '';
    if($group) {
      $group_field = "GROUP BY " . $group . ' ' . $sort;
    }

    $settings = self::getSettings();
    $perpage = $settings['perpage'];

    //Основная часть запроса
    $fetch_query = self::__fetch_query();

    //Список для постраничного вывода
    $list = new D_Db_List();
    $list->fetch_query = 'SELECT /*COLS*/*/*/COLS*/ FROM (' . $fetch_query . D_Db_Query::getWhere($filter) . " {$group_field} {$order_field} {$sort} ) as total";
    //var_dump($list->fetch_query );exit;
    $list->container(get_called_class())->perpage($perpage);
    //$list->pagerNav = self::getPagerNav($list->totalpages);
    //$result['list'] = $list;
   // $result['pager'] =
    self::$total_pages = $list->totalpages;
    return $list;
  }

}
?>