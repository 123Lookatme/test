<?php



//Database Config
define('DB_HOST','');
define('DB_USER','');
define('DB_PASSWORD','');
define('DB_NAME','123Lookatme');
define('TABLE_USER_MESSAGES','user_messages');
define('TABLE_USERS','users');

define('BASEPATH',$_SERVER['DOCUMENT_ROOT'].(substr($_SERVER['SCRIPT_NAME'],0,strrpos($_SERVER['SCRIPT_NAME'],'/'))));
define('UPLOAD_DIR',BASEPATH."/files/");

require_once('DataBase.php');
require_once('controller.php');
