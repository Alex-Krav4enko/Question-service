<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once 'vendor/autoload.php';
$config = include_once 'lib/database/config.php';
include_once 'lib/database/DataBase.php';
include_once 'lib/router/router.php';

$loader = new Twig_Loader_Filesystem('template/');
$twig = new Twig_Environment($loader, [
  'cache' => 'tmp/cache/',
  'auto_reload' => true
]);

$params = [
  'data' => $data,
  'session' => $_SESSION,
];

$template = $twig->loadTemplate('main.twig');
$template->display($params);
