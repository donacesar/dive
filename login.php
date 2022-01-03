<?php
session_start();
include 'functions.php';

$email = $_POST['email'];
$password = $_POST['password'];

if (login($email, $password)) {
    redirect_to('user.php');
    exit;
}

set_flash_message('danger', 'Неправильный логин или пароль.');
redirect_to('page_login.php');