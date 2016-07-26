<?php
// all traffic except urls that start with '/content' is redirected to this file
require_once ('config.php');
require_once('functions.php');

//$db = mysqli_connect(DB_HOST,DB_USERNAME,DB_PASS,DB_NAME);
//$db->set_charset('utf8');
//if ($db->connect_error) {
//    die("Connection failed: " . self::$db->connect_error);
//}
//
//$stmt = $db->prepare("SELECT * FROM posts");
//$stmt->execute();
//$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
//var_dump($result);

$url = $_SERVER['REQUEST_URI'];

parseURL($url);

