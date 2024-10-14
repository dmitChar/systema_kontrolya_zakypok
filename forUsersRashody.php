<?php
session_start();
?>

<DOCTYPE HTML>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="jquery-3.7.1.min.js" ></script>
<meta charset="UTF-8">
    <link rel="stylesheet" href = "login.css" type="text/css">
    <title>Контроль расходов</title>

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


        function add_rash() 
        { 
            if (! req)  return;
            if ((document.getElementById("field1").value) == "" || document.getElementById("field3").value == "" || document.getElementById("field4").value == "" || document.getElementById("field5").value == "") 
            {
                alert("Поля не должны быть пустыми!");
                return; 
            }
            $.ajax({
                url: "add_rash.php",
                method: "POST",
                dataType: 'html',
                data: $("#addRash").serialize(),
                success:function(respose){
                    document.getElementById('rashodTab').innerHTML = respose;
                    document.getElementById('field1').value ="";
                    document.getElementById('field3').value ="";
                    document.getElementById('field4').value ="";
                    document.getElementById('field5').value ="";
                    
                    
                }

            });
        }

    

        function del_rash() 
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
                url: "del_rash.php",
                method: "POST",
                dataType: 'html',
                data: $("#delRash").serialize(),
                success:function(respose){
                    //alert(respose);
                    if (respose == "Количество материала недостаточно")
                        alert("Ошибка! На складе недостаточно материала");
                    else {
                    document.getElementById('rashodTab').innerHTML = respose;
                    document.getElementById('field6').value = "";

                    }
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
if ($result = mysqli_query($link, 'SELECT * FROM rashody')) {
    echo "<table  id=rashodTab class = 'table'>";
    printf("<h1>Учет затрат на материалы и оборудование</h1>");
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

<form id="addRash">
<p>

  <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    Добавить затраты
  </button>
</p>

<div class="collapse" id="collapseExample">
  <div class="card card-body">
  <div class="input-group flex-nowrap">
        <span class="input-group-text" id="basic-addon1">1.</span>
        <input type="text" id = "field1" name="rash_mater" class="form-control" placeholder="Наименование расхода" aria-label="Название материала" aria-describedby="basic-addon1">
      </div>

      <div class="input-group flex-nowrap">
        <span class="input-group-text" id="basic-addon3">2.</span>
        <select class="form-select" id = "rash_categ" name = "rash_categ" aria-label="Пример элемента выбора с помощью надстройки кнопки">
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
        <input type="text" id = "field3" name="rash_count" class="form-control" placeholder="Количество материала/оборудования" aria-describedby="basic-addon3">
    </div>

    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="basic-addon3">4.</span>
        <input type="date" id = "field4" name="rash_date" class="form-control" placeholder="Дата затрат"  aria-describedby="basic-addon3">
    </div>

    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="basic-addon3">5.</span>
        <input type="text" id = "field5" name="rash_summ" class="form-control" placeholder="Сумма затрат" aria-describedby="basic-addon3">
    </div>

      <button class="btn btn-success" type="button" onclick="add_rash()" id="liveToastBtn">Добавить</button>

     


  </div>
</div>
</form>

<div>
    <h3>Удаление расходов</h3>
<form id = "delRash">
    <div class="input-group mb-3">
    <button class="btn btn-warning" type="button" onclick = "del_rash()">Удалить</button>
    <input type="text" id = "field6" name="rash_del" class="form-control" placeholder="Введите номер строки таблицы" aria-describedby="basic-addon3">
</div>
</form>
</div>




</main>
</body>
</html>