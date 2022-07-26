<?php
class Users
{
  private $name;
  private $lastname;
  private $email;
  private $id;

  function __construct($id, $name, $lastname, $email)
  {
    $this->id = $id;
    $this->name = $name;
    $this->lastname = $lastname;
    $this->email = $email;
  }
  function getId()
  {
    return $this->id;
  }
  function getName()
  {
    return $this->name;
  }
  function getLastname()
  {
    return $this->lastname;
  }
  function getEmail()
  {
    return $this->email;
  }
  // Статический метод добавления юзера
  static function addUser($name, $lastname, $email, $pass)
  {
    global $mysqli;
    $email = trim(mb_strtolower($email));
    $pass = trim($pass);
    $pass = password_hash($pass, PASSWORD_DEFAULT);

    $result = $mysqli->query("SELECT * FROM `users` WHERE `email` = '$email'");
    if ($result->num_rows != 0) {
      return json_encode(["result" => "exist"]);
    } else {
      $mysqli->query("INSERT INTO `users`(`name`, `lastname`, `email`, `pass`) VALUES ('$name', '$lastname', '$email', '$pass')");
      return json_encode(["result" => "success"]);
    }
  }
  // Статический метод авторизации юзера
  static function authUser($email, $pass)
  {
    global $mysqli;
    $email = trim(mb_strtolower($_POST['email']));
    $pass = trim($_POST["pass"]);

    $result = $mysqli->query("SELECT * FROM `users` WHERE `email` = '$email'");
    $result = $result->fetch_assoc(); // преобразование к массиву

    if (password_verify($pass, $result["pass"])) {
      return json_encode(["result" => "authOk"]);
    } else {
      return json_encode(["result" => "authFailed"]);
    }
  }
  // Статический метод получения юзера
  static function getUser($userId)
  {
    global $mysqli;
    $result = $mysqli->query("SELECT * FROM `users` WHERE `id` = '$userId'");
    $result = $result->fetch_assoc(); // преобразование к массиву

    return json_encode($result);
  }
  // Статический метод чего-то еще
  static function getUsers()
  {
    global $mysqli;
    $result = $mysqli->query("SELECT `name`, `lastname`, `email`, `id` FROM `users` WHERE 1");
    while ($row = $result->fetch_assoc()) {
      $users[] = $row;
    }
    return json_encode($users);
  }
}
