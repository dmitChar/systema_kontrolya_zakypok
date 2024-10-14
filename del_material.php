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
    $name_item = $_POST["delMaterbtn"];      
    $count_item = (float)$_POST["count_item"];  

    $result = mysqli_query($link, "SELECT * FROM sklad WHERE name_item = '$name_item'");
    if ($result && mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_assoc($result);
        if ($count_item < (float)$row['count_item'])
        {
            $type_item = $row['type_item'];
            $plan_item = $row['plan_item'];
            $count_item = abs($count_item- (float)$row['count_item']);
            $push = mysqli_query($link, "DELETE FROM sklad  WHERE name_item = '$name_item'");
            $push = mysqli_query($link, "INSERT INTO sklad (name_item, type_item, count_item, plan_item) VALUES('$name_item', '$type_item', '$count_item','$plan_item')");
        }

        elseif ($count_item == (float)$row['count_item']){
            $push = mysqli_query($link, "DELETE FROM sklad  WHERE name_item = '$name_item'");
        }
        else 
        {
            echo"Количество материала недостаточно";
            return;
        }//Количество материала недостаточно
      

    }

    

    
    if ($result = mysqli_query($link, 'SELECT * FROM sklad')) {
        echo "<table  id=materTab class = 'table'>";
        echo "<thead>
            <tr>
                <th>№</th>
                <th>Название материала</th>
                <th>Тип материала</th>
                <th>Количество</th>
                <th>План на месяц</th>
            </tr></thead>";
    
        /* Вывод данных бд на сайт */
        echo "<tbody>";
        $_count = 0;
        while( $row = mysqli_fetch_assoc($result) ){
            $_count = $_count + 1;
            echo "<tr>";
            printf("<td>%d</td><td>%s</td> <td>%s</td> <td>%d</td> <td>%d</td> ", $_count, $row['name_item'], $row['type_item'], $row['count_item'], $row['plan_item']);
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        /* Освобождаем используемую память */
        mysqli_free_result($result);
    }

  
?>
