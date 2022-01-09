<?php
/*
 * Parameters:
 *          $email string
 *
 * Description: поиск пользователя по электронному адресу
 *
 * Return value: array | bool (false)
 *
 */
function get_user_by_email($email): mixed {
    $pdo = new PDO("mysql:host=localhost;dbname=my_database;charset=utf8", 'root', 'root');
    $statement = $pdo->prepare("SELECT * FROM users WHERE email=:email");
    $response = $statement->execute([':email' => $email]);
    if ($response === false) {
        return false;
    }
    return $statement->fetch(PDO::FETCH_ASSOC);
}

/*
 * Parameters:
 *          $email string
 *          $password string
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
 *         $name (ключ) string
 *         $message (Значение, текст сообщения) string
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
 *          $name (ключ) string
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
 *          $path string
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
 *          $email string
 *          $password string
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
 *          $id int
 *
 * Description: Достать информацию о пользователе
 *
 * Return value: array | boolean (false)
 *
 * */
function get_info_by_id($id): mixed {
    $pdo = new PDO("mysql:host=localhost;dbname=my_database;charset=utf8", 'root', 'root');
    $statement = $pdo->prepare("SELECT * FROM users_info WHERE user_id=:id");
    $response = $statement->execute([':id' => $id]);
    if ($response === false) {
        return false;
    }
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

/*
 * Parameters:
 *          $id int
 *          $name string
 *          $workplace string
 *          $phone string
 *          $address string
 *
 * Description: редактировать пользователя
 *
 * Return value: void
 **/
function add_info($name, $workplace, $phone, $id, $address): void {
    $pdo = new PDO("mysql:host=localhost;dbname=my_database;charset=utf8", 'root', 'root');
    $statement = $pdo->prepare("INSERT INTO users_info (name, workplace, phone, user_id, address) VALUES (:name, :workplace, :phone, :user_id, :address) ");
    $statement->execute([':name' => $name, ':workplace' => $workplace, ':phone' => $phone, ':user_id' => $id, ':address' => $address]);
}

/*
 * Parameters:
 *          $id int
 *          $status string
 *
 * Description: установить статус
 *
 * Return value: void
 *
 **/
function set_status($id, $status): void {
    $pdo = new PDO("mysql:host=localhost;dbname=my_database;charset=utf8", 'root', 'root');
    $statement = $pdo->prepare("UPDATE users_info SET status=:status WHERE user_id = :user_id");
    $statement->execute([':status' => $status, ':user_id' => $id]);
}

/*
 * Parameters:
 *          $filename string
 *
 * Description: Генерирует уникальное имя для файла
 *
 * Return value: string*/
function filename_generate($filename): string {
    $extension = pathinfo($filename)['extension'];
    return uniqid() . "." . $extension;
}

/*
 * Parameters:
 *          $id int
 *          $image array
 * Description: загрузить аватар
 *
 * Return value: void
 *
 * */
function upload_avatar($id, $image): void {
    $filename = filename_generate($image['name']);
    $filename = 'img/demo/avatars/' . $filename;
    move_uploaded_file($image['tmp_name'], $filename);
    $pdo = new PDO("mysql:host=localhost;dbname=my_database;charset=utf8", 'root', 'root');
    $statement = $pdo->prepare("UPDATE users_info SET avatar=:avatar WHERE user_id=:user_id");
    $statement->execute([':avatar' => $filename, ':user_id' => $id]);
}

/*
 * Parameters:
 *          $id int
 *          $vk string
 *          $telegram string
 *          $instagram string
 * Description: добавить ссылки на соцсети
 *
 * Return value: void
 *
 * */
function add_social_links($id, $vk, $telegram, $instagram): void {
    $pdo = new PDO("mysql:host=localhost;dbname=my_database;charset=utf8", 'root', 'root');
    $statement = $pdo->prepare("UPDATE users_info SET vk=:vk, telegram=:telegram, instagram=:instagram WHERE user_id=:user_id");
    $statement->execute([':vk' => $vk, ':telegram' => $telegram, ':instagram' => $instagram, ':user_id' => $id]);
}

/*
 * Parameters:
 *              $logged_user_id int
 *              $edit_user_id int
 *
 * Description: проверить автор ли текущий авторизированный пользователь
 *
 * Return value: boolean
 *
 * */
function is_author($logged_user_id, $edit_user_id): bool {
    if($logged_user_id === $edit_user_id) {
        return true;
    }
    return false;
}

/*
 * Parameters:
 *          $user_id int
 *
 * Description: получить пользователя по id
 *
 * Return value: array | boolean(false)
 *
 * */
function get_user_by_id($id): mixed {
    $pdo = new PDO("mysql:host=localhost;dbname=my_database;charset=utf8", 'root', 'root');
    $statement = $pdo->prepare("SELECT * FROM users WHERE id=:id");
    $response = $statement->execute([':id' => $id]);
    if ($response === false) {
        return false;
    }
    return $statement->fetch(PDO::FETCH_ASSOC);
}

/*
 * Parameters:
 *          $user_id int
 *          $name string
 *          $workplace string
 *          $phone string
 *          $address string
 *
 * Description: редактировать общую информацию
 *
 * Return value: void
 *
 * */
function edit_info($user_id, $name, $workplace, $phone, $address): void {
    $pdo = new PDO("mysql:host=localhost;dbname=my_database;charser=utf8", 'root', 'root');
    $statement = $pdo->prepare("UPDATE users_info SET name=:name, workplace=:workplace, phone=:phone, address=:address WHERE user_id=:user_id");
    $statement->execute([':name' => $name, ':workplace' => $workplace, ':phone' => $phone, ':address' => $address, ':user_id' => $user_id]);

}

/*
 * Parameters:
 *          $user_id int
 *          $email string
 *          $password string
 *
 * Description: редактировать входные данные email или password
 *
 *  Return value: void
 *
 * */
function edit_credentials($id, $email, $password) {
    $pdo = new PDO("mysql:host=localhost;dbname=my_database;charset=utf8", 'root', 'root');
    if ($password === '') {
        $statement = $pdo->prepare("UPDATE users SET email=:email WHERE id=:id");
        $statement->execute([':email' => $email, ':id' => $id]);
        return;
    }
    $statement = $pdo->prepare("UPDATE users SET email=:email, password=:password WHERE id=:id");
    $statement->execute([':email' => $email, ':password' => $password, ':id' => $id]);
}

