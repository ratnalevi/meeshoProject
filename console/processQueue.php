<?php

require_once( '../config/config.php' );
require_once( SERVER_PATH . '/console/Worker.php');

$queue = new Worker();

?>