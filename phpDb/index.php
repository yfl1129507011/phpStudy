<?php
/**
 * Created by PhpStorm.
 * User: hylanda69874
 * Date: 2018/6/20
 * Time: 11:26
 */
namespace phpDb;

$config = array(
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '123456',
    'database' => 'zhongmiao',
    'port' => '',
);

$db = new \mysqli('localhost', 'root', '123456', 'zhongmiao', 3306);
$sql = "SELECT * FROM `zm_user_visit_log` LIMIT 5;";
$queryID = $db->query($sql);
$res = $queryID->fetch_assoc();
//$queryID->free_result();
var_dump($res);
$res = $queryID->fetch_assoc();
var_dump($res);