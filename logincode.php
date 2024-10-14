<?php
session_start();

$link = mysqli_connect(
    '127.0.0.1',  /* Хост, к которому мы подключаемся */
    'root',       /* Имя пользователя */
    '',   /* Используемый пароль */
    'kursach');     /* База данных для запросов по умолчанию */

if (!$link) {
printf("Невозможно подключиться к базе данных. Код ошибки: %s\n", mysqli_connect_error());
exit;
}

if (isset($_POST['login_btn']))
{
    $login = $_POST['login'];
    $password = $_POST['password'];
    $query = "SELECT * FROM users WHERE login='$login' AND password='$password'";
	$res = mysqli_query($link, $query);

    if (mysqli_num_rows($res) > 0) 
    {
        foreach ($res as $row){
        $user_id = $row['id_users'];
        $login_user = $row['login'];
        $user_password= $row['password'];
        $role_as = $row['role_as'];
    }

    $_SESSION['auth'] = "$role_as";
    $_SESSION['auth_user'] =[ 
        'user_id' => $user_id,
        'login_user' => $login_user,
        'user_password'=> $password
    
    ];

    if ($role_as == '0')
    {
    $_SESSION['status'] = "logged in successfully";
    header('Location: main.php');
    }

    else if ($role_as == '1')
    {
        $_SESSION['status'] = "logged in successfully as admin";
        header('Location: admin.php');
    }

    }

    else{
        $_SESSION['status'] = "Invalid login or password";
        header('Location: login.php');
    }

}



?>