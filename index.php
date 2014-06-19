<?php
require_once('config.php');


require_once('pages/header.html');



$router=Router::getInstance();
$router->route();




require_once('pages/footer.html');
?>


