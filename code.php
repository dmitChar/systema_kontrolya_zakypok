<?php
session_start();


if (isset($_POST['logout_btn']))
{
    session_destroy();
    unset($_SESSION['auth']);
    unset($_SESSION['auth_user']);

    $_SESSION['status'] = 'Logged out seccessfully';
    header('Location: login.php');
    exit(0);
}


?>