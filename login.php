<DOCTYPE HTML>

<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="jquery-3.7.1.min.js" ></script>
<meta charset="UTF-8">
    <link rel="stylesheet" href = "login.css" type="text/css">
    <title>авторизация</title>
    <link rel="stylesheet" type="text/css" href="webjars/bootstrap/5.3.2/css/bootstrap.min.css"/>
    </head>
<body>

<main>
<?php
    session_start();
    setlocale(LC_ALL, 'ru_RU.65001', 'rus_RUS.65001', 'Russian_Russia. 65001', 'russian');

    $link = mysqli_connect(
                            '127.0.0.1',  /* Хост, к которому мы подключаемся */
                            'root',       /* Имя пользователя */
                            '',   /* Используемый пароль */
                            'kursach');     /* База данных для запросов по умолчанию */

    if (!$link) {
                   printf("Невозможно подключиться к базе данных. Код ошибки: %s\n", mysqli_connect_error());
                   exit;
                }

    if (isset($_SESSION['auth']))
    {
        $_SESSION['status'] = "You are already logged in";
        header('Location: main.php');
        exit(0);
    }           



                if (isset($_SESSION['status'])) {
                    ?><div class="alert alert-warning alert-dismissible fade show" role="alert">
                  <strong>Hey</strong> <?php echo $_SESSION['status']; ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Закрыть"></button>
                </div>
                
                <?php
                unset($_SESSION['status']);
                }
                ?>
        <?php
    include('message.php');
    echo'<div class="registration-cssave">
    <form action = "logincode.php" method = post>
        <h2 class="text-center">Форма входа</h2>
        <div class="form-group">
            <input class="form-control item" type="text" name="login" maxlength="15" minlength="4" pattern="^[a-zA-Z0-9_.-]*$" id="username" placeholder="Логин" required>
        </div>
        <div class="form-group">
            <input class="form-control item" type="password" name="password" minlength="5" id="password" placeholder="Пароль" required>
        </div>
        <div class="form-group">
            <button class="btn btn-primary btn-block create-account" name = "login_btn" type="submit">Вход в аккаунт</button>
        </div>
    </form>
</div>';            

	
    mysqli_close($link);?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</main>
</body>
</html>