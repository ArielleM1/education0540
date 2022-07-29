<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
session_start();

$url = explode("/", $_SERVER['REQUEST_URI']);
require_once("php/bd.php");
require_once("php/classes/User.php");

if ($url[1] == "auth") {
  $content = file_get_contents("pages/login.html");
} else if ($url[1] == "reg") {
  $content = file_get_contents("pages/register.html");
} else if ($url[1] == "blog") {
  $content = file_get_contents("pages/blog.html");
} else if ($url[1] == "contact") {
  $content = file_get_contents("pages/contact.php");
} else if ($url[1] == "users") {
  require_once("pages/users/index.html");
} else if ($url[1] == "addUser") {
  echo User::addUser($_POST["name"], $_POST["lastname"], $_POST["email"], $_POST["pass"]);
} else if ($url[1] == "authUser") {
  echo User::authUser($_POST["email"], $_POST["pass"]);
} else if ($url[1] == "getUser") {
  echo User::getUser($_SESSION["id"]);
} else if ($url[1] == "getUsers") {
  echo User::getUsers();
} else {
  $content = file_get_contents("pages/index.php");
}
if (!empty($content))
  require_once("template.php");
