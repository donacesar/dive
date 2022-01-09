<?php
session_start();
include 'functions.php';

$email = $_POST['email'];
$password = $_POST['password'];
$id = $_POST['id'];

if($password !== '') {
    $password = password_hash($password, PASSWORD_DEFAULT);
}

$user = get_user_by_id($id);
if ($email !== $user['email']) {
    if(get_user_by_email($email)) {
        set_flash_message('danger', 'Этот эл. адрес уже занят другим пользователем.');
        redirect_to('page_security.php');
        exit;
    }
}

edit_credentials($id, $email, $password);
set_flash_message('success', 'Профиль успешно обновлен');
redirect_to('page_profile.php?id=' . $id);
