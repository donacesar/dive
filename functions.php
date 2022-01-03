<?php
/*
 *  Parameters:
 *           string - $email
 *
 *   Description: поиск пользователя по электронному адресу
 *
 *   Return value: array
 *
 */
function get_user_by_email($email) {}

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
function add_user($email, $password){}

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
function set_flash_message($name, $message){}

/*
 * Parameters:
 *          string - $name (ключ)
 *
 * Description: вывести флеш сообщение
 *
 * Return value: null
 *
 * */
function display_flash_message($name){}

/*
 * Parameters:
 *          string - $path
 *
 * Description: перенаправляет на другую страницу
 *
 * Return value: null
 *
 * */
function redirect_to($path){}
