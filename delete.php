<?php
session_start();
include 'functions.php';

$id = $_GET['id'];

if (is_not_logged_in()) {
    redirect_to('page_login.php');
    exit;
}

if (!($_SESSION['user']['role'] == 'admin')) {
    if (!is_author($_SESSION['user']['id'], $id)) {
        set_flash_message('danger', 'Можно редактировать только свой профиль');
        redirect_to('users.php');
        exit;
    }
}

delete_user($id);


if ($id === $_SESSION['user']['id']){
    unset($_SESSION['user']);
    redirect_to('page_register.php');
    exit;
}

redirect_to('users.php');

