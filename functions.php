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
function get_user_by_email($email): array {
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
function add_user($email, $password): int
{
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
function set_flash_message($name, $message): void {
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
function display_flash_message($name): void {
    echo $_SESSION[$name];
    unset($_SESSION[$name]);
}

/*
 * Parameters:
 *          string - $path
 *
 * Description: перенаправляет на другую страницу
 *
 * Return value: void
 *
 * */
function redirect_to($path): void {
    header("Location: " . $path);
}

/*
 * Parameters:
 *          string - $email
 *          string - $password
 *
 * Description: авторизировать пользователя
 *
 * Return value: boolean
 *
 * */
function login($email, $password): bool
{
    $user = get_user_by_email($email);
    if (!$user) {
        return false;
    }
    if(password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        return true;
    }
    return false;
}

/*
 * Parameters:
 *          none
 *
 * Description: Проверить что пользователь не залогинен
 *
 * Return value: boolean
 *
 * */
function is_not_logged_in(): bool
{
    if(isset($_SESSION['user'])) {
        return false;
    }
    return true;
}

/*
 * Parameters:
 *          int - $id
 *
 * Description: Достать информацию о пользователе
 *
 * Return value: array
 *
 * */
function get_info_by_id($id): array {
    $pdo = new PDO("mysql:host=localhost;dbname=my_database;charset=utf8", 'root', 'root');
    $statement = $pdo->prepare("SELECT * FROM users_info WHERE user_id=:id");
    $statement->execute([':id' => $id]);
    return $statement->fetch(PDO::FETCH_ASSOC);
}

/*
 * Parameters:
 *          none
 *
 * Description: Получить всех пользователей
 *
 * Return value: array
 *
 * */
function get_all_users(): array {
    $pdo = new PDO("mysql:host=localhost;dbname=my_database;charset=utf8", 'root', 'root');
    $statement = $pdo->prepare("SELECT * FROM users");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}