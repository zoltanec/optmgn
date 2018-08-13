<?php
echo "Hello";
$user = new dORMModel(D::$dCMSCorePath."/modules/users/models/user.json");
var_dump($user);
echo "<pre>";
echo $user->getCreateSQL();
echo json_last_error();
 switch(json_last_error())
    {
        case JSON_ERROR_DEPTH:
            echo ' - Maximum stack depth exceeded';
        break;
        case JSON_ERROR_CTRL_CHAR:
            echo ' - Unexpected control character found';
        break;
        case JSON_ERROR_SYNTAX:
            echo ' - Syntax error, malformed JSON';
        break;
        case JSON_ERROR_NONE:
            echo ' - No errors';
        break;
    }
exit;
?>