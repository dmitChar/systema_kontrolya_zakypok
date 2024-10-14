<?php
session_start();
include("authenticatioin.php");
?>

<DOCTYPE HTML>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="jquery-3.7.1.min.js" ></script>
<meta charset="UTF-8">
    <link rel="stylesheet" href = "login.css" type="text/css">
    <title>Главная страница</title>

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


        function add_project() 
        { 
            var name= document.getElementsByName("name_project")[0].value;
    
            if (! req)  return;

            $.ajax({
                url: "add_proj.php",
                method: "POST",
                dataType: 'html',
                data: $("#addproj").serialize(),
                success:function(respose){
                    //alert(respose);
                    document.getElementById('projTab').innerHTML = respose;
                    update_del_proj();
                }

            });
        }

        function del_proj() 
        { 
            if (! req)  return;

            $.ajax({
                url: "del_proj.php",
                method: "POST",
                dataType: 'html',
                data: $("#delProj").serialize(),
                success:function(respose){
                    //alert(respose);
                    document.getElementById('projTab').innerHTML = respose;
                    update_del_proj();
                }

            });
        }

        function update_del_proj() 
        { 
            if (! req)  return;

            $.ajax({
                url: "update_del_proj.php",
                method: "POST",
                dataType: 'html',
                data: $("#adduser").serialize(),
                success:function(respose){
                    //alert(respose);
                    document.getElementById('delProjects').innerHTML = respose;
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
  <a class="nav-link active" aria-current="page" href="admin.php">Главная</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="sklad.php">Контроль запасов на складе</a>
  </li>
  <li class="nav-item">
  <a class="nav-link active" aria-current="page" href="postavshiky.php">Выбор поставщиков</a>
  </li>
  <li class="nav-item">
  <a class="nav-link active" aria-current="page" href="rashody.php">Учет затрат на материалы и оборудование</a>
  </li>
  <li class="nav-item">
  <a class="nav-link active" aria-current="page" href="editUsers.php">Управление пользователями</a>
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
if ($result = mysqli_query($link, 'SELECT * FROM projects')) {
    echo "<table  id=projTab class = 'table'>";
    printf("<h1>Текущие проекты</h1>");
    echo "<thead>
        <tr>
            <th>№</th>
            <th>Название проекта</th>
            <th>Номер договора</th>
            <th>Дата начала проекта</th>
            <th>Примерная дата окончания</th>
            <th>Плановый бюджет</th>
        </tr></thead>";

    /* Вывод данных бд на сайт */
    echo "<tbody>";
    while( $row = mysqli_fetch_assoc($result) ){
        echo "<tr>";
        printf("<td>%d</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td>", $row['id_project'], $row['name_project'], $row['num_dog'], $row['date_start'], $row['date_end'],$row['budjet']);
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    /* Освобождаем используемую память */
    mysqli_free_result($result);
}

?>

<div>
    <h3>Добавление нового проекта</h3>
    <form id = "addproj">
    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="addon-wrapping">Название проекта</span>
        <input type="text" name="name_project" class="form-control"  aria-describedby="addon-wrapping">
    </div>

    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="addon-wrapping">№ договора</span>
        <input type="text" name="num_dog" class="form-control"  aria-describedby="addon-wrapping">
    </div>

    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="addon-wrapping">Дата начала</span>
        <input type="date" name="date_start" class="form-control"  aria-describedby="addon-wrapping">
    </div>

    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="addon-wrapping">Дата окончания</span>
        <input type="date" name="date_end" class="form-control"  aria-describedby="addon-wrapping">
    </div>

    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="addon-wrapping">Бюджет</span>
        <input type="text" name="budjet" class="form-control"  aria-describedby="addon-wrapping">
    </div>
    <button type="button" name = "add_btn" class="btn btn-success" onclick = "add_project()">Добавить</button>
    </form>
</div>


<div>
    <h3>Удаление проекта</h3>
    <form id = "delProj">

    <div class="input-group mb-3">
  <button class="btn btn-warning" type="button" onclick = "del_proj">Удалить</button>
  <select class="form-select" id = "delProjects" name = "delProjects" aria-label="Пример элемента выбора с помощью надстройки кнопки">
    <?php
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
  </select>
</div>
    </form>
</div>



</main>
</body>
</html>