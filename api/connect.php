<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->exec("set names utf8");



