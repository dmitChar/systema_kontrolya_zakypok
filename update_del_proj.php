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


    
           
                if ($result = mysqli_query($link, 'SELECT name_project FROM projects'))
    {
            while ($row = mysqli_fetch_assoc($result))
            {
                printf("<option>%s", $row['name_project']);
                echo "</tr>";
            }
            mysqli_free_result($result);
    echo '</option>';
    }
                
                
    

  
?>
