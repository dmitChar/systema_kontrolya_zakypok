

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
    $addOrderName = $_POST["addOrderName"];
    $addOrderMater = $_POST["addOrderMater"];        
    $addOrderCount = $_POST["addOrderCount"];   

    $result = mysqli_query($link, "SELECT * FROM postav");
    if ($result && mysqli_num_rows($result) > 0)
    {
        $check = 0;
        $cost = 0;
        while ($row = mysqli_fetch_assoc($result))
            {

        if($row['mater_postav'] == $addOrderMater && $row['name_postav'] == $addOrderName)
        {
            $cost = $row['cost_postav'] * $addOrderCount + $row['logist_postav'];
            $check = 1;
            $categ = $row['cateh_postav'];
            //break;
        }
    }
        if ($check == 0){
            echo "Введенного материала у данного поставщика нет!";
            return;
        } 
        else 
        {
            $d = date('Y-m-d H:i:s');


            $push = mysqli_query($link, "INSERT INTO rashody (rash_mater, rash_categ, rash_count, rash_date, rash_summ) VALUES('$addOrderMater', '$categ', '$addOrderCount','$d', '$cost')");
            $push = mysqli_query($link, "INSERT INTO order_log (log_postav, log_mater, log_count, log_date, log_summ) VALUES('$addOrderName', '$addOrderMater', '$addOrderCount','$d', '$cost')");
            
            $plan = null;
            $result = mysqli_query($link, "SELECT * FROM sklad WHERE name_item = '$addOrderMater'");
            if ($result && mysqli_num_rows($result) > 0)
            {
                $row = mysqli_fetch_assoc($result);
                $addOrderCount = $addOrderCount + (float)$row['count_item'];
                $push = mysqli_query($link, "DELETE FROM sklad  WHERE name_item = '$addOrderMater'");
                $plan = $row['count_item'];
                //$push = mysqli_query($link, "UPDATE sklad SET count_item = '$addOrderCount' WHERE mater_postav = '$mater_postav'");
                
        
            }
            
            $push = mysqli_query($link, "INSERT INTO sklad (name_item, type_item, count_item, plan_item) VALUES('$addOrderMater', '$categ', '$addOrderCount','$plan')");
        
        }
    }
    
    

    
   

  
?>


