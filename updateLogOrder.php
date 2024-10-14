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


    
                if ($result = mysqli_query($link, 'SELECT * FROM order_log')) {
                    echo "<table  id=orderLogTab class = 'table'>";
                    echo "<thead>
                        <tr>
                            <th>№</th>
                            <th scope = 'row'>Наименование поставщика</th>
                            <th scope = 'row'>Поставляемый материал</th>
                            <th scope = 'row'>Количество</th>
                            <th scope = 'row'>Дата заказа</th>
                            <th scope = 'row'>Сумма заказа</th>
                
                        </tr></thead>";
                
                    /* Вывод данных бд на сайт */
                    echo "<tbody>";
                    while( $row = mysqli_fetch_assoc($result) ){
                        echo "<tr>";
                        printf("<td >%s</td> <td >%s</td> <td >%s</td> <td>%s</td> <td>%s</td> <td>%s</td>", $row['id_order'], $row['log_postav'],$row['log_mater'], $row['log_count'], $row['log_date'], $row['log_summ']);
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                    /* Освобождаем используемую память */
                    mysqli_free_result($result);
                }
                
    

  
?>
