<?php
if(D::$req->textLine("dir"))
$T['current_dir'] = D_Core_Factory::Media_Dir(D::$req->textLine("dir"));
else $T['current_dir'] = D_Core_Factory::Media_Dir('root');
?>