<?php
session_start();
include 'functions.php';

$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$name = $_POST['name'];
$workplace = $_POST['workplace'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$status = $_POST['status'];
$vk = $_POST['vk'];
$telegram = $_POST['telegram'];
$instagram = $_POST['instagram'];


if (empty($email)) {
    set_flash_message('danger', 'Поле email обязательно для заполнения');
    redirect_to('page_create_user.php');
    exit;
}

if (empty($_POST['password'])) {
    set_flash_message('danger', 'Поле password обязательно для заполнения');
    redirect_to('page_create_user.php');
    exit;
}

if(get_user_by_email($email)) {
    set_flash_message('danger', 'Этот эл. адрес уже занят другим пользователем.');
    redirect_to('page_create_user.php');
    exit;
}

$id = add_user($email, $password);

add_info($name, $workplace, $phone, $id, $address);
set_status($id, $status);
upload_avatar($id, $_FILES['avatar']);
add_social_links($id, $vk, $telegram, $instagram);

set_flash_message('success', 'Пользователь успешно добавлен');
redirect_to('users.php');


