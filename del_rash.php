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
    $rash_id  = $_POST["rash_del"];      

    $result = mysqli_query($link, "SELECT * FROM rashody");
    
    if ($result && mysqli_num_rows($result) > 0)
    {
        
        $push = mysqli_query($link, "DELETE FROM rashody  WHERE rash_id  = '$rash_id'");

    }
    else {
        echo "Введенного значения не существует!";
            return;
    }
    

    if ($result = mysqli_query($link, 'SELECT * FROM rashody')) {
        echo "<table  id=rashodTab class = 'table'>";

        echo "<thead>
            <tr class = 'table-active'>
                <th>№</th>
                <th scope = 'row'>Материал/оборудование</th>
                <th scope = 'row'>Категория</th>
                <th scope = 'row'>Количество</th>
                <th scope = 'row'>Дата затрат</th>
                <th scope = 'row'>Сумма затрат(руб)</th>
            </tr></thead>";
    
        /* Вывод данных бд на сайт */
        echo "<tbody>";
        while( $row = mysqli_fetch_assoc($result) ){
            echo "<tr>";
            printf("<td class='table-active'>%d</td> <td class='table-active'>%s</td> <td class='table-active'>%s</td> <td class='table-active'>%d</td> <td class='table-active'>%s</td> <td class='table-active'>%d</td> ", $row['rash_id'], $row['rash_mater'],$row['rash_categ'], $row['rash_count'], $row['rash_date'], $row['rash_summ']);
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        /* Освобождаем используемую память */
        mysqli_free_result($result);
    }

  
?>
