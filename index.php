<?php
//Database Constans
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASSWORD','1234');
define('DB_NAME','123Lookatme');
define('TABLE_NAME','user_messages');
define('TABLE_USERS','users');
define('UPLOAD_DIR',$_SERVER['DOCUMENT_ROOT']."/Project/files/");



require_once('DataBase.php');

require_once('router.php');
require_once('pages/header.html');



$router=Router::getInstance();
$router->route();




require_once('pages/footer.html');
?>


