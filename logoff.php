<?php
session_start();
include 'functions.php';

unset($_SESSION['user']);
redirect_to('page_login.php');
