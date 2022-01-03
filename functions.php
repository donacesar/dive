<?php
/*
 * Parameters:
 *          string - $email
 *
 * Description: поиск пользователя по электронному адресу
 *
 * Return value: array
 *
 */
function get_user_by_email($email) {
    $pdo = new PDO("mysql:host=localhost;dbname=my_database;charset=utf8", 'root', 'root');
    $statement = $pdo->prepare("SELECT * FROM users WHERE email=:email");
    $statement->execute([':email' => $email]);
    return $statement->fetch(PDO::FETCH_ASSOC);
}

/*
 * Parameters:
 *          string - $email
 *          string - $password
 *
 * Description: Добавить пользователя в БД
 *
 * Return value: int (user_id)
 *
 */
function add_user($email, $password){
    $pdo = new PDO("mysql:host=localhost;dbname=my_database;charset=utf8", 'root', 'root');
    $statement = $pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
    $statement->execute([':email' => $email, ':password' => $password]);
    return $pdo->lastInsertId();
}

 /*
  * Parameters:
  *         string - $name (ключ)
  *         string - $message (Значение, текст сообщения)
  *
  * Description: Подготовить текст сообщения
  *
  * Return value: null
  *
  * */
function set_flash_message($name, $message){
    $_SESSION[$name] = $message;
}

/*
 * Parameters:
 *          string - $name (ключ)
 *
 * Description: вывести флеш сообщение
 *
 * Return value: null
 *
 * */
function display_flash_message($name){
    echo $_SESSION[$name];
    unset($_SESSION[$name]);
}

/*
 * Parameters:
 *          string - $path
 *
 * Description: перенаправляет на другую страницу
 *
 * Return value: null
 *
 * */
function redirect_to($path){
    header("Location: " . $path);
}
