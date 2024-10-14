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
    <title>Управление пользователями</title>

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

        function add_user() 
        { 
            if (! req)  return;
            console.log(document.getElementById("field1").value);
            if ((document.getElementById("field1").value) == "" || document.getElementById("field2").value == "" || document.getElementById("field3").value == "") 
            {
                alert("Поля не должны быть пустыми!");
                return; 
            }
            else if ((Number(document.getElementById("field3").value) >1) || (Number(document.getElementById("field3").value) < 0 ))
            {
              alert("Права администратора должны быть равны либо 0, либо 1");
              return; 
            }
            else{
            $.ajax({
                url: "add_user.php",
                method: "POST",
                dataType: 'html',
                data: $("#adduser").serialize(),
                success:function(respose){
                    //alert(respose);
                    if (respose == "Ошибка! Пользователь с таким логином уже существует!")
                      alert("Ошибка! Пользователь с таким логином уже существует!");
                    else {
                    document.getElementById('userTab').innerHTML = respose;
                    document.getElementById('field1').value = "";
                    document.getElementById('field2').value = "";
                    document.getElementById('field3').value = "";
                    
                    update_del_user();
                    }
                }

            });
          }
        }

        function del_user() 
        { 
            if (! req)  return;

            $.ajax({
                url: "del_user.php",
                method: "POST",
                dataType: 'html',
                data: $("#delUserForm").serialize(),
                success:function(respose){
                    //alert(respose);
                    document.getElementById('userTab').innerHTML = respose;
                    update_del_user();
                }

            });
        }

        function update_del_user() 
        { 
            if (! req)  return;

            $.ajax({
                url: "update_del_user.php",
                method: "POST",
                dataType: 'html',
                data: $("#adduser").serialize(),
                success:function(respose){
                    //alert(respose);
                    document.getElementById('inputGroupSelect03').innerHTML = respose;
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
if ($result = mysqli_query($link, 'SELECT * FROM users')) {
    echo "<table  id=userTab class = 'table'>";
    printf("<h1>Добавленные пользователи</h1>");
    echo "<thead>
        <tr>
            <th>№</th>
            <th>Логин</th>
            <th>Пароль</th>
            <th>Роль</th>
        </tr></thead>";

    /* Вывод данных бд на сайт */
    echo "<tbody>";
    $count = 0;
    while( $row = mysqli_fetch_assoc($result) ){
        $count = $count +1;
        if ($row['role_as'] == "0"){
            $role = "Пользователь";
        }
        else {
            $role = "Администратор";
        }
        echo "<tr>";
        printf("<td>%d</td> <td>%s</td> <td>%s</td> <td>%s</td>", $count, $row['login'], $row['password'],  $role,);
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    /* Освобождаем используемую память */
    mysqli_free_result($result);
}

?>
<form id="adduser">
<p>

  <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    Добавить пользователя
  </button>
</p>

<div class="collapse" id="collapseExample">
  <div class="card card-body">
  <div class="input-group flex-nowrap">
        <span class="input-group-text" id="basic-addon1">1.</span>
        <input type="text" id = "field1" name="loginUser" class="form-control" placeholder="Логин пользователя" aria-label="Логин пользователя" aria-describedby="basic-addon1">
      </div>

      <div class="input-group flex-nowrap">
        <span class="input-group-text" id="basic-addon2">2.</span>
        <input type="text" id = "field2" name="passUser" class="form-control" placeholder="Пароль пользователя" aria-label="Пароль пользователя" aria-describedby="basic-addon2">
      </div>

      <div class="input-group flex-nowrap">
        <span class="input-group-text" id="basic-addon3">3.</span>
        <input type="text" id = "field3" name="admUser" class="form-control" placeholder="Права администратора (0 - нет, 1 - да)" aria-label="Права администратора" aria-describedby="basic-addon3">
      </div>

      <button class="btn btn-success" type="button" onclick="add_user()" id="addBtn">Добавить</button>
  </div>
</div>
</form>


<form id = "delUserForm">
<p>
  <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#delUser" aria-expanded="false" aria-controls="delUser">
    Удалить пользователя
  </button>
</p>
<div class="collapse" id="delUser">
  <div class="card card-body">
  <div class="input-group mb-3">
  <button class="btn btn-warning" type="button" onclick = "del_user()">Удалить</button>
  <select class="form-select" id="inputGroupSelect03" name = "loginUser">
    <?php
    if ($result = mysqli_query($link, 'SELECT login FROM users'))
    {
            while ($row = mysqli_fetch_assoc($result))
            {
                printf("<option selected>%s", $row['login']);
                echo "</tr>";
            }
            mysqli_free_result($result);
    echo '</option>';
    }
    
    ?>
  </select>
</div>
    
</div>
  </div>
  </form>
</div>





</main>
</body>
</html>