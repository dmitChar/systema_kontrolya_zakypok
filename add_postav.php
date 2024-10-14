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
    $name_postav = $_POST["name_postav"];
    $mater_postav = $_POST["mater_postav"];        
    $cost_postav = $_POST["cost_postav"];  
    $logist_postav = $_POST["logist_postav"];  
    $cateh_postav = $_POST["type_item"];

    $result = mysqli_query($link, "SELECT * FROM postav where name_postav = '$name_postav'");
    if ($result && mysqli_num_rows($result) > 0)
    {
        while( $row = mysqli_fetch_assoc($result) ){
        if($row['mater_postav'] == $mater_postav && $row['name_postav'] == $name_postav && $row['cost_postav'] == $cost_postav && $row['logist_postav'] == $logist_postav)
        {
            echo "Ошибка! Введенный поставщик уже поставляет данный материал по данной цене!";
            return;
        }
        else if ($row['mater_postav'] == $mater_postav && $row['name_postav'] == $name_postav)
        {
            $push = mysqli_query($link, "UPDATE postav SET cost_postav = '$cost_postav', logist_postav = '$logist_postav' WHERE name_postav = '$name_postav' AND mater_postav = '$mater_postav'");
            
            break;
            //$push = mysqli_query($link, "DELETE FROM postav where name_postav = '$name_postav'");


        }
        else {$push = mysqli_query($link, "INSERT INTO postav (name_postav, mater_postav, cateh_postav, cost_postav, logist_postav) VALUES('$name_postav', '$mater_postav', '$cateh_postav', '$cost_postav','$logist_postav')"); 
        break;}
    }
    
}
else $push = mysqli_query($link, "INSERT INTO postav (name_postav, mater_postav, cateh_postav, cost_postav, logist_postav) VALUES('$name_postav', '$mater_postav', '$cateh_postav', '$cost_postav','$logist_postav')");
    
    
    
    if ($result = mysqli_query($link, 'SELECT * FROM postav')) {
        echo "<table  id=postavTab class = 'table'>";
        echo "<thead>
            <tr class = 'table-active'>
                <th>№</th>
                <th scope = 'row'>Наименование поставщика</th>
                <th scope = 'row'>Поставляемый материал</th>
                <th scope = 'row'>Категория материала</th>
                <th scope = 'row'>Стоимость за ед</th>
                <th scope = 'row'>Затраты на логистику</th>
    
            </tr></thead>";
    
        /* Вывод данных бд на сайт */
        echo "<tbody>";
        while( $row = mysqli_fetch_assoc($result) ){
            echo "<tr>";
            printf("<td class='table-active'>%d</td> <td class='table-active'>%s</td> <td class='table-active'>%s</td> <td class='table-active'>%s</td> <td class='table-active'>%d</td> <td class='table-active'>%d</td>", $row['id_postav'], $row['name_postav'], $row['mater_postav'],$row['cateh_postav'], $row['cost_postav'], $row['logist_postav']);
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        /* Освобождаем используемую память */
        mysqli_free_result($result);
    }

  
?>
