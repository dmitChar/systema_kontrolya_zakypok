<?php
header('Content-Type: text/html;');
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
    $login = $_POST["loginUser"];


    $push = mysqli_query($link, "DELETE FROM users  WHERE login = '$login'");

    
    if ($result = mysqli_query($link, 'SELECT * FROM users')) {
        echo "<table  id=userTab class = 'table'>";
        echo "<thead>
            <tr>
                <th>№</th>
                <th>Логин</th>
                <th>Пароль</th>
                <th>Роль</th>
            </tr></thead>";
    
        /* Вывод данных бд на сайт */
        echo "<tbody>";
        $count = 0;
        while( $row = mysqli_fetch_assoc($result) ){
            $count = $count +1;
            if ($row['role_as'] == "0"){
                $role = "Пользователь";
            }
            else {
                $role = "Администратор";
            }
            echo "<tr>";
            printf("<td>%d</td> <td>%s</td> <td>%s</td> <td>%s</td>", $count, $row['login'], $row['password'],  $role,);
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        /* Освобождаем используемую память */
        mysqli_free_result($result);
    }

  
?>
