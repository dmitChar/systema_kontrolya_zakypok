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
    $name_project = $_POST["name_project"];
    $num_dog = $_POST["num_dog"];        
    $date_start = $_POST["date_start"];
    $date_end = $_POST["date_end"];
    $budjet = $_POST["budjet"];   



    $push = mysqli_query($link, "INSERT projects ( name_project, num_dog, date_start, date_end, budjet) VALUES('$name_project', '$num_dog', '$date_start', '$date_end', '$budjet')");

    
    if ($result = mysqli_query($link, 'SELECT * FROM projects')) {
        echo "<table  id=tab class = 'table'>";
        echo "<thead>
            <tr>
                <th>№</th>
                <th>Название проекта</th>
                <th>Номер договора</th>
                <th>Дата начала проекта</th>
                <th>Примерная дата окончания</th>
                <th>Плановый бюджет</th>
            </tr></thead>";
    
        /* Вывод данных бд на сайт */
        echo "<tbody>";
        while( $row = mysqli_fetch_assoc($result) ){
            echo "<tr>";
            printf("<td>%d</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td>", $row['id_project'], $row['name_project'], $row['num_dog'], $row['date_start'], $row['date_end'],$row['budjet']);
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        /* Освобождаем используемую память */
        mysqli_free_result($result);
    }

  
?>
