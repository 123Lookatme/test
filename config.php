<?php



//Database Config
define('DB_HOST','');
define('DB_USER','');
define('DB_PASSWORD','');
define('DB_NAME','123Lookatme');
define('TABLE_NAME','user_messages');
define('TABLE_USERS','users');
///file upload dir
define('UPLOAD_DIR',$_SERVER['DOCUMENT_ROOT']."/Project/files/");


require_once('DataBase.php');

require_once('router.php');