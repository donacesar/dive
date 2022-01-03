<?php
session_start();
include 'functions.php';

$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

if(get_user_by_email($email)) {
    set_flash_message('danger', 'Этот эл. адрес уже занят другим пользователем.');
    redirect_to('page_register.php');
    exit;
}

add_user($email, $password);

set_flash_message('success', 'Регистрация успешна');
redirect_to('page_login.php');
