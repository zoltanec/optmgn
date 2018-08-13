<?php
$T['topics'] = Support_Topics::find(['active' => 1],['order' => 'upd_time DESC']);