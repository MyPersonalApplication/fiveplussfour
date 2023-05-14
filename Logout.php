<?php
session_start();

unset($_COOKIE['username']);
unset($_COOKIE['admin']);
setcookie('username', '', time() - (24 * 60 * 60), '/');
setcookie('admin', '', time() - (24 * 60 * 60), '/');

if (session_destroy()) {
    header("Location: index.php");
    exit();
}
