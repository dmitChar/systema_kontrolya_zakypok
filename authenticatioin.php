<?php


if (!isset($_SESSION['auth']) )
{
    $_SESSION['auth_status'] = "login to access dashboard";
    header("location: login.php");
    exit(0);
}

else {
    if ($_SESSION['auth'] == "1")
    {
        

    }
    else{
        $_SESSION['status'] = "You are not authorised as admin";
        header("Location: main.php");
        exit(0);
    }
}




?>