<?php
session_start();
include 'functions.php';

$id = $_POST['id'];
$info = get_info_by_id($id);

if ($info['avatar'] !== '') {
    unlink($info['avatar']);
}

upload_avatar($id, $_FILES['img']);
set_flash_message('success', 'Профиль успешно обновлен');
redirect_to('page_profile.php?id=' . $id);