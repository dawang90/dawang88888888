<?php
require_once("mysql.class.php");
$DB=new DB_MYSQL;
$DB->dbServer="localhost:3306";
$DB->dbUser="root";
$DB->dbPwd="";
$DB->dbDatabase="my_db";
$DB->dbcharset="utf8";
$DB->connect();
?>