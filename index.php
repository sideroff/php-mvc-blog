<?php
// all traffic except urls that start with '/content' is redirected to this file
require_once ('config.php');
require_once('functions.php');

session_start();

$url = $_SERVER['REQUEST_URI'];
parseURL($url);

