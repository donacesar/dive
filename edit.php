<?php
session_start();
include 'functions.php';

$name = $_POST['name'];
$workplace = $_POST['workplace'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$id = $_POST['id'];

edit_info($id, $name, $workplace, $phone, $address);
set_flash_message('success', 'Пользователь успешно обновлен');
redirect_to('page_profile.php');