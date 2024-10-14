<?php
session_start();
?>

<DOCTYPE HTML>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="jquery-3.7.1.min.js" ></script>
<meta charset="UTF-8">
    <link rel="stylesheet" href = "login.css" type="text/css">
    <title>Склад</title>

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


        function add_material() 
        { 
            if (! req)  return;

            $.ajax({
                url: "add.material.php",
                method: "POST",
                dataType: 'html',
                data: $("#addMater").serialize(),
                success:function(respose){
                    document.getElementById('materTab').innerHTML = respose;
                    document.getElementById('field1').value ="";
                    document.getElementById('field3').value ="";
                    document.getElementById('field4').value ="";
                    update_del_mater();
                    
                    
                }

            });
        }

    

        function del_mater() 
        { 
            if (! req)  return;

            $.ajax({
                url: "del_material.php",
                method: "POST",
                dataType: 'html',
                data: $("#delMater").serialize(),
                success:function(respose){
                    //alert(respose);
                    if (respose == "Количество материала недостаточно")
                        alert("Ошибка! На складе недостаточно материала");
                    else {
                    document.getElementById('materTab').innerHTML = respose;
                    document.getElementById('exampleInputEmail1').value = "";
                    document.getElementById('exampleInputEmail1').placeholder="Количетсво удаляемого материала";
                    update_del_mater();
                    }
                }

            });
        }

        function update_del_mater() 
        { 
            if (! req)  return;

            $.ajax({
                url: "update_del_mater.php",
                method: "POST",
                dataType: 'html',
                data: $("#adduser").serialize(),
                success:function(respose){
                    //alert(respose);
                    document.getElementById('delMaterbtn').innerHTML = respose;
                }

            });
        }

        function set_del_size() 
        { 
            var name= document.getElementsByName("delMaterbtn")[0].value;

            
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
if ($result = mysqli_query($link, 'SELECT * FROM sklad')) {
    echo "<table  id=materTab class = 'table'>";
    printf("<h1>Наличие материалов на складе</h1>");
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

<form id="addMater">
<p>

  <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    Добавить материалы на склад
  </button>
</p>

<div class="collapse" id="collapseExample">
  <div class="card card-body">
  <div class="input-group flex-nowrap">
        <span class="input-group-text" id="basic-addon1">1.</span>
        <input type="text" id = "field1" name="name_item" class="form-control" placeholder="Название материала" aria-label="Название материала" aria-describedby="basic-addon1">
      </div>

      <div class="input-group flex-nowrap">
        <span class="input-group-text" id="basic-addon3">2.</span>
        <select class="form-select" id = "type_item" name = "type_item" aria-label="Пример элемента выбора с помощью надстройки кнопки">
        <option>"Мелкогабаритная деталь"</tr></option>
        <option>"Крупногабаритная деталь"</tr></option>
        <option>"Металл"</tr></option>
        <option>"Жидкость/газ"</tr></option>
        <option>"Оборудование"</tr></option>
        <option>"Прочее"</tr></option>
    </select>

    </div>

    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="basic-addon3">3.</span>
        <input type="text" id = "field3" name="count_item" class="form-control" placeholder="Количество материала" aria-label="Количество материала" aria-describedby="basic-addon3">
    </div>

    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="basic-addon3">4.</span>
        <input type="text" id = "field4" name="plan_item" class="form-control" placeholder="План по материалу" aria-label="План по материалу" aria-describedby="basic-addon3">
    </div>

      <button class="btn btn-success" type="button" onclick="add_material()" id="liveToastBtn">Добавить</button>

     


  </div>
</div>
</form>



<div>
    <h3>Удаление материалов</h3>
    <form id = "delMater">

    <div class="input-group mb-3">
  <button class="btn btn-warning" type="button" onclick = "del_mater()">Удалить</button>
  <select class="form-select" id = "delMaterbtn" name = "delMaterbtn">
    <?php
    if ($result = mysqli_query($link, 'SELECT name_item FROM sklad'))
    {
            while ($row = mysqli_fetch_assoc($result))
            {
                printf("<option>%s", $row['name_item']);
                echo "</tr>";
            }
            mysqli_free_result($result);
    echo '</option>';
    }
    
    ?>
  </select>
</div>
<div class="mb-3">
    <input type="text" class="form-control" name = "count_item"id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Количетсво удаляемого материала">
    </div>
    </form>
</div>



</main>
</body>
</html>