<?php
session_start();
?>

<DOCTYPE HTML>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="jquery-3.7.1.min.js" ></script>
<meta charset="UTF-8">
    <link rel="stylesheet" href = "login.css" type="text/css">
    <title>Учет поставщиков</title>

    <script type="text/javascript">
        var req=false;
           if(window.XMLHttpRequest) {
            req = new XMLHttpRequest();
            } else 
            {
              try 
              {    req=new ActiveXObject('Msxml2.XMLHTTP');
                } catch (e)
           {  req=new ActiveXObject('Microsoft.XMLHTTP');   }   }

          if (! req) // если объект XMLHttpRequest не поддерживается
             alert('Объект XMLHttpRequest не поддерживается данным браузером');


        function add_postav() 
        { 
            if (! req)  return;
            if ((document.getElementById("field1").value) == "" || document.getElementById("field3").value == "" || document.getElementById("field2").value == "" || document.getElementById("field4").value == "") 
            {
                alert("Поля не должны быть пустыми!");
                return; 
            }
            //alert("yes");
            $.ajax({
                url: "add_postav.php",
                method: "POST",
                dataType: 'html',
                data: $("#addPostav").serialize(),
                success:function(respose){
                    if(respose == "Ошибка! Введенный поставщик уже поставляет данный материал!")
                    {
                        alert("Ошибка! Введенный поставщик уже поставляет данный материал!");
                        return;
                        
                    }
                    document.getElementById('postavTab').innerHTML = respose;
                    document.getElementById('field1').value ="";
                    document.getElementById('field3').value ="";
                    document.getElementById('field4').value ="";
                    document.getElementById('field2').value ="";
                    
                    
                }

            });
        }

    

        function del_postav() 
        { 
            if (! req)  return;
            if ((document.getElementById("field6").value) == "")
            {
                alert("Поле не должно быть пустым!");
                return; 
            }

            else if (Number(document.getElementById('field6').value) < 1)
            {
                alert("Ошибка! Значение строки таблицы не может быть меньше 1!");
                return;
            }

            $.ajax({
                url: "del_postav.php",
                method: "POST",
                dataType: 'html',
                data: $("#delPostav").serialize(),
                success:function(respose){
                    //alert(respose);
                    if (respose == "Введенного значения не существует!")
                        alert("Введенного значения не существует!");
                    else {
                    document.getElementById('postavTab').innerHTML = respose;
                    document.getElementById('field6').value = "";

                    }
                }

            });
        }


        function getComp() 
        { 
            if (! req)  return;
            
            $.ajax({
                url: "getComp.php",
                method: "POST",
                dataType: 'html',
                data: $("#addPostav").serialize(),
                success:function(respose){
                    //alert(respose);
                    document.getElementById('addOrderName').innerHTML = respose;
                }

            });
        }


        function add_order() 
        { 
            if (! req)  return;
            if ((document.getElementById("addOrderMater").value) == "" || document.getElementById("addOrderCount").value == "") 
            {
                alert("Поля не должны быть пустыми!");
                return; 
            }
            //alert("yes");
            $.ajax({
                url: "addOrder.php",
                method: "POST",
                dataType: 'html',
                data: $("#addOrder").serialize(),
                success:function(respose){
                    if(respose == "Введенного материала у данного поставщика нет!")
                    {
                        alert("Введенного материала у данного поставщика нет!");
                        return;
                        
                    }

                    document.getElementById('addOrderMater').value ="";
                    document.getElementById('addOrderCount').value ="";
                    alert("Заказ успешно оформлен!");

                    
                }

            });
        }

        function update_log_order() 
        { 
            if (! req)  return;
            $.ajax({
                url: "updateLogOrder.php",
                method: "POST",
                dataType: 'html',
                data: $("#addOrder").serialize(),
                success:function(respose){
                   
                    document.getElementById('orderLogTab').innerHTML =respose;

                    
                }

            });
        }

        </script>
    </head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <nav>
    <ul class="nav nav-pills nav-fill">
    <li class="nav-item">
  <a class="nav-link active" aria-current="page" href="main.php">Главная</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="forUsersSklad.php">Контроль запасов на складе</a>
  </li>
  <li class="nav-item">
  <a class="nav-link active" aria-current="page" href="forUsersPostav.php">Выбор поставщиков</a>
  </li>
  <li class="nav-item">
  <a class="nav-link active" aria-current="page" href="forUsersRashody.php">Учет затрат на материалы и оборудование</a>
  </li>

</ul>
    </nav>
<main>
<div class="dropdown">
<button type="button" class="btn btn-primary btn-lg">
  <?php
        if (($_SESSION['status'] == "logged in successfully") or ($_SESSION['status'] == "logged in successfully as admin"))
        {
            echo $_SESSION['auth_user']['login_user'];
        }
        else {
            echo "Not logged in";
        }
    
    ?>
  </button>
    <div>
        <form action = "code.php" method = "POST">
            <button type ="submit" name = "logout_btn" class = "btn btn-danger">Log out</button>
        </form>
    </div>


</div>
<?php
 $link = mysqli_connect(
    '127.0.0.1',  /* Хост, к которому мы подключаемся */
    'root',       /* Имя пользователя */
    '',   /* Используемый пароль */
    'kursach');     /* База данных для запросов по умолчанию */

if (!$link) {
printf("Невозможно подключиться к базе данных. Код ошибки: %s\n", mysqli_connect_error());
exit;
}
if ($result = mysqli_query($link, 'SELECT * FROM postav')) {
    echo "<table  id=postavTab class = 'table'>";
    printf("<h1>Сохраненные поставщики</h1>");
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

<form id="addPostav">
<p>

  <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    Добавить поставщика
  </button>
</p>

<div class="collapse" id="collapseExample">
  <div class="card card-body">
  <div class="input-group flex-nowrap">
        <span class="input-group-text" id="basic-addon1">1.</span>
        <input type="text" id = "field1" name="name_postav" class="form-control" placeholder="Наименование поставщика" aria-label="Название материала" aria-describedby="basic-addon1">
      </div>

    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="basic-addon3">2.</span>
        <input type="text" id = "field2" name="mater_postav" class="form-control" placeholder="Поставляемый материал" aria-describedby="basic-addon3">
    </div>

    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="basic-addon3">3.</span>
        <input type="text" id = "field3" name="cost_postav" class="form-control" placeholder="Стоимость за ед" aria-describedby="basic-addon3">
    </div>

    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="basic-addon3">4.</span>
        <input type="text" id = "field4" name="logist_postav" class="form-control" placeholder="Затраты на логистику"  aria-describedby="basic-addon3">
    </div>



      <button class="btn btn-success" type="button" onclick="add_postav()" id="liveToastBtn">Добавить</button>
  </div>
</div>
</form>



<div>
    <h3>Удаление поставщика</h3>
<form id = "delPostav">
    <div class="input-group mb-3">
    <button class="btn btn-warning" type="button" onclick = "del_postav()">Удалить</button>
    <input type="text" id = "field6" name="p_del" class="form-control" placeholder="Введите номер строки таблицы" aria-describedby="basic-addon3">
</div>
</form>
</div>



<form id = "addOrder">
<p>
  <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExampl" aria-expanded="false" aria-controls="collapseExampl" onclick = "getComp()">
    Оформить заказ материалов
  </button>
</p>

<div class="collapse" id="collapseExampl">
  <div class="card card-body">
  <h4>Оформить заказ материалов</h4>
  <div class="input-group flex-nowrap">
        <span class="input-group-text" id="basic-addon3">1.</span>
        <select class="form-select" id = "addOrderName" name = "addOrderName" aria-label="Пример элемента выбора с помощью надстройки кнопки">
        
    </select>

    </div>

    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="basic-addon3">2.</span>
        <input type="text" id = "addOrderMater" name="addOrderMater" class="form-control" placeholder="Материал" aria-label="Количество материала" aria-describedby="basic-addon3">
    </div>

    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="basic-addon3">4.</span>
        <input type="text" id = "addOrderCount" name="addOrderCount" class="form-control" placeholder="Количество материала" aria-label="План по материалу" aria-describedby="basic-addon3">
    </div>

      <button class="btn btn-success" type="button" onclick="add_order()" id="liveToastBt">Добавить</button>

     
  </div>
</div>
</form>


<p>

  <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExamp" aria-expanded="false" aria-controls="collapseExample" onclick = "update_log_order()">
    История заказов
  </button>
</p>

<div class="collapse" id="collapseExamp">
  <div class="card card-body">
  <div id = "logs"> 
    <?php
  if ($result = mysqli_query($link, 'SELECT * FROM order_log')) {
    echo "<table  id=orderLogTab class = 'table'>";
    printf("<h4>История заказов</h4>");
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
</div>
</div>
</div>




</main>
</body>
</html>