<?php

ini_set('display_errors', 1);
header("X-XSS-Protection: 1; mode=block");

session_start();

const APP_PATH   = __DIR__ . '/application/';

require_once(APP_PATH . 'init.php');

$app = new App;
