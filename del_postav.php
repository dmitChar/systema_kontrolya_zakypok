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
    $id_postav = $_POST["p_del"];      

    $result = mysqli_query($link, "SELECT * FROM postav WHERE id_postav = '$id_postav'");
    
    if ($result && mysqli_num_rows($result) > 0)
    {
        $push = mysqli_query($link, "DELETE FROM postav  WHERE id_postav  = '$id_postav'");

    }
    else {
        echo "Введенного значения не существует!";
            return;
    }
    

    if ($result = mysqli_query($link, 'SELECT * FROM postav')) {
        echo "<table  id=postavTab class = 'table'>";
        echo "<thead>
            <tr class = 'table-active'>
                <th>№</th>
                <th scope = 'row'>Наименование поставщика</th>
                <th scope = 'row'>Поставляемый материал</th>
                <th scope = 'row'>Стоимость за ед</th>
                <th scope = 'row'>Затраты на логистику</th>
    
            </tr></thead>";
    
        /* Вывод данных бд на сайт */
        echo "<tbody>";
        while( $row = mysqli_fetch_assoc($result) ){
            echo "<tr>";
            printf("<td class='table-active'>%d</td> <td class='table-active'>%s</td> <td class='table-active'>%s</td> <td class='table-active'>%d</td> <td class='table-active'>%d</td>", $row['id_postav'], $row['name_postav'],$row['mater_postav'], $row['cost_postav'], $row['logist_postav']);
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        /* Освобождаем используемую память */
        mysqli_free_result($result);
    }

  
?>
