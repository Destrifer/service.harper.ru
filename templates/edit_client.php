<?php

use models\Clients;

$count = mysqli_fetch_array(mysqli_query($db, 'SELECT COUNT(*) FROM `clients` WHERE `id` = \''.mysqli_real_escape_string($db, $_GET['id']).'\' ;'));
if ($count['COUNT(*)'] > 0) {
$content = mysqli_fetch_array(mysqli_query($db, 'SELECT * FROM `clients` WHERE `id` = \''.mysqli_real_escape_string($db, $_GET['id']).'\' LIMIT 1;'));
} else {
header('Location: '.$config['url'].'clients/');
}
# Сохраняем:
if ($_POST['send'] == 1) {


mysqli_query($db, 'UPDATE `clients` SET
`name` = \''.mysqli_real_escape_string($db, $_POST['name']).'\',
`type_id` = \''.mysqli_real_escape_string($db, $_POST['type_id']).'\',  
`scenario_id` = \''.mysqli_real_escape_string($db, $_POST['scenario_id']).'\',    
`code` = \''.mysqli_real_escape_string($db, $_POST['code']).'\',
`address` = \''.mysqli_real_escape_string($db, $_POST['address']).'\',
`phone` = \''.mysqli_real_escape_string($db, $_POST['phone']).'\',
`contact_name` = \''.mysqli_real_escape_string($db, $_POST['contact_name']).'\',
`contacts_phone` = \''.mysqli_real_escape_string($db, $_POST['contacts_phone']).'\',
`manager_name` = \''.mysqli_real_escape_string($db, $_POST['manager_name']).'\',
`manager_phone` = \''.mysqli_real_escape_string($db, $_POST['manager_phone']).'\',
`days` = \''.mysqli_real_escape_string($db, $_POST['days']).'\',
`result_yes` = \''.mysqli_real_escape_string($db, $_POST['result_yes']).'\',
`manager_email` = \''.mysqli_real_escape_string($db, $_POST['manager_email']).'\',
`manager_notify` = \''.mysqli_real_escape_string($db, $_POST['manager_notify']).'\',
`manager_contact_notify` = \''.mysqli_real_escape_string($db, $_POST['manager_contact_notify']).'\',
`result_no` = \''.mysqli_real_escape_string($db, $_POST['result_no']).'\'
WHERE `id` = \''.mysqli_real_escape_string($db, $_GET['id']).'\' LIMIT 1
;') or mysqli_error($db);

admin_log_add('Обновлен клиент #'.$_GET['id']);

header('Location: '.$config['url'].'clients/');
}


?>
<!doctype html>
<html>
<head>
<meta charset=utf-8>
<title>Панель управления</title>
<link href="<?=$config['url'];?>css/fonts.css" rel="stylesheet" />
<link href="<?=$config['url'];?>css/style.css" rel="stylesheet" />
<script src="/_new-codebase/front/vendor/jquery/jquery-1.7.2.min.js"  ></script>
<script src="<?=$config['url'];?>js/jquery-ui.min.js"></script>
<script src="<?=$config['url'];?>js/jquery.placeholder.min.js"></script>
<script src="<?=$config['url'];?>js/jquery.formstyler.min.js"></script>
<script src="<?=$config['url'];?>js/main.js?<?= intval(microtime(1)) ?>"></script>

<script src="<?=$config['url'];?>notifier/js/index.js"></script>
<link rel="stylesheet" type="text/css" href="<?=$config['url'];?>notifier/css/style.css">
<link rel="stylesheet" href="/_new-codebase/front/vendor/animate.min.css" />
<script src='/_new-codebase/front/vendor/mustache/mustache.min.js'></script>
<script src="/_new-codebase/front/vendor/malihu/jquery.mCustomScrollbar.concat.min.js"></script>
<link rel="stylesheet" href="/_new-codebase/front/vendor/malihu/jquery.mCustomScrollbar.min.css" />

<script  src="/_new-codebase/front/vendor/datatables/1.10.12/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?=$config['url'];?>css/datatables.css">

<script >
// Таблица
$(document).ready(function() {
    $('#table_content').dataTable({
      "pageLength": 30,
      stateSave: true,
      "oLanguage": {
            "sLengthMenu": "Показывать _MENU_ записей на страницу",
            "sZeroRecords": "Записей нет.",
            "sInfo": "Показано от _START_ до _END_ из _TOTAL_ записей",
            "sInfoEmpty": "Записей нет.",

            "oPaginate": {
                 "sFirst": "Первая",
                 "sLast": "Последняя",
                 "sNext": "Следующая",
                 "sPrevious": "Предыдущая",
                },
            "sSearch": "Поиск",
            "sInfoFiltered": "(отфильтровано из _MAX_ записи/(ей)"
        }});

  $('ul.tabs li').click(function(){
    var tab_id = $(this).attr('data-tab');

    $('ul.tabs li').removeClass('current');
    $('.tab-content').removeClass('current');

    $(this).addClass('current');
    $("#"+tab_id).addClass('current');
  })

} );

</script>
<style>
ul.tabs{
      margin: 0px;
      padding: 0px;
      list-style: none;
    }
    ul.tabs li{
      background: none;
      color: #222;
      display: inline-block;
      padding: 10px 15px;
      cursor: pointer;
    }

    ul.tabs li.current{
      background: #ededed;
      color: #222;
    }

    .tab-content{
      display: none;
      background: #ededed;
      padding: 15px;
    }

    .tab-content.current{
      display: inherit;
    }
</style>
</head>

<body>

<div class="viewport-wrapper">

<div class="site-header">
  <div class="wrapper">

    <div class="logo">
      <a href="/dashboard/"><img src="<?=$config['url'];?>i/logo.png" alt=""/></a>
      <span>Сервис</span>
    </div>

<div class="not-container">
  <button style="position:relative;    margin-left: 120px;   margin-top: 15px;" type="button" class="button-default show-notifications js-show-notifications animated swing">
  <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30" height="32" viewBox="0 0 30 32">
    <defs>
      <g id="icon-bell">
        <path class="path1" d="M15.143 30.286q0-0.286-0.286-0.286-1.054 0-1.813-0.759t-0.759-1.813q0-0.286-0.286-0.286t-0.286 0.286q0 1.304 0.92 2.223t2.223 0.92q0.286 0 0.286-0.286zM3.268 25.143h23.179q-2.929-3.232-4.402-7.348t-1.473-8.652q0-4.571-5.714-4.571t-5.714 4.571q0 4.536-1.473 8.652t-4.402 7.348zM29.714 25.143q0 0.929-0.679 1.607t-1.607 0.679h-8q0 1.893-1.339 3.232t-3.232 1.339-3.232-1.339-1.339-3.232h-8q-0.929 0-1.607-0.679t-0.679-1.607q3.393-2.875 5.125-7.098t1.732-8.902q0-2.946 1.714-4.679t4.714-2.089q-0.143-0.321-0.143-0.661 0-0.714 0.5-1.214t1.214-0.5 1.214 0.5 0.5 1.214q0 0.339-0.143 0.661 3 0.357 4.714 2.089t1.714 4.679q0 4.679 1.732 8.902t5.125 7.098z" />
      </g>
    </defs>
    <g fill="#000000">
      <use xlink:href="#icon-bell" transform="translate(0 0)"></use>
    </g>
  </svg>

  <div class="notifications-count js-count"></div>

</button>
</div>



    <div class="logout">

      <a href="/logout/">Выйти, <?=\models\User::getData('login');?></a>
    </div>

  </div>
</div><!-- .site-header -->

<div class="wrapper">

<?=top_menu_admin();?>

  <div class="adm-tab">

<?=menu_dash();?>

  </div><!-- .adm-tab -->
           <br>
           <h2>Редактирование клиента</h2>

  <form id="send" method="POST">
   <div class="adm-form" style="padding-top:0;">

                     <div class="item">
              <div class="level">Наименование:</div>
              <div class="value">
                <input type="text" name="name" value="<? echo htmlspecialchars($content['name'],ENT_QUOTES)?>"  />
              </div>
            </div>

                    <div class="item">
              <div class="level">Тип клиента:</div>
              <div class="value">
              <select name="type_id" >
               <option value="">Выберите</option>
               <option value="1" <?php if ($content['type_id'] == 1) { echo 'selected';}?>>Потребитель</option>
               <option value="2" <?php if ($content['type_id'] == 2) { echo 'selected';}?>>Магазин</option>
              </select>
              </div>
            </div>

            <div class="item">
              <div class="level">План ремонта:</div>
              <div class="value">
              <select name="scenario_id" >
               <option value="0">- не выбран -</option>
               <?php
                  foreach(Clients::$scenario as $id => $name) {
                    $selFlag = ($content['scenario_id'] == $id) ? 'selected' : '';
                    echo '<option value="'.$id.'" '.$selFlag.'>'.$name.'</option>';
                  }
               ?>
              </select>
              </div>
            </div>

                  <div class="item">
              <div class="level">Код клиента (для партий возвратов):</div>
              <div class="value">
                <input type="text" name="code" value="<?=$content['code'];?>"  />
              </div>
            </div>

                  <div class="item">
              <div class="level">Адрес:</div>
              <div class="value">
                <input type="text" name="address" value="<?=$content['address'];?>"  />
              </div>
            </div>


                   <div class="item">
              <div class="level">Телефон:</div>
              <div class="value">
                <input type="text" name="phone" value="<?=$content['phone'];?>"  />
              </div>
            </div>

                  <div class="item">
              <div class="level">Контактное лицо:</div>
              <div class="value">
                <input type="text" name="contact_name" value="<?=$content['contact_name'];?>"  />
              </div>
            </div>

                  <div class="item" style="position:relative;">
              <div class="level">Контактный<br> эл. адрес:</div>
              <div class="value" >

              <div style="    position: absolute;
    left: 68px;
    top: 68px;">

                             <div class="adm-finish" style="    display: inline-block;">

                      <ul style="    padding-top: 0px;">
              <li><label><input type="checkbox" name="manager_contact_notify" value="1"  <?=($content['manager_contact_notify'] == 1) ? 'checked' : '';?>/></label></li>
                      </ul>

            </div>
              </div>

                <input type="text" name="contacts_phone" value="<?=$content['contacts_phone'];?>"  />
              </div>
            </div>


                  <div class="item">
              <div class="level">Сколько дней по договору на проверку качества:</div>
              <div class="value">
                <input type="text" name="days" value="<?=$content['days'];?>"  />
              </div>
            </div>

                <div class="item">
              <div class="level">Ведущий менеджер:</div>
              <div class="value">
                <input type="text" name="manager_name" value="<?=$content['manager_name'];?>"  />
              </div>
            </div>

                  <div class="item">
              <div class="level">Контакт менеджера:</div>
              <div class="value">
                <input type="text" name="manager_phone" value="<?=$content['manager_phone'];?>"  />
              </div>
            </div>

                  <div class="item" style="width:100%:">
              <div class="level" style="    margin: 0 auto;
    display: block;">Email менеджера:</div><br>
              <div class="value">
                           <div class="adm-finish" style="    display: inline-block;">

                      <ul style="    padding-top: 0px;">
              <li><label><input type="checkbox" name="manager_notify" value="1"  <?=($content['manager_notify'] == 1) ? 'checked' : '';?>/>Уведомлять</label></li>
                      </ul>

            </div>
                <input type="text" name="manager_email" value="<?=$content['manager_email'];?>"  />
              </div>
            </div>


                <div class="adm-finish">

                      <ul>
              <li><label><input type="checkbox" name="result_yes" value="1"  <?=($content['result_yes'] == 1) ? 'checked' : '';?>/>Оставляем у себя (Подтвердилось)</label></li>
              <li><label><input type="checkbox" name="result_no" value="1"  <?=($content['result_no'] == 1) ? 'checked' : '';?>/>Выдаем обратно клиенту (Дефект не обнаружен)</label></li>
                      </ul>

            <div class="save">
              <input type="hidden" name="send" value="1" />
              <button type="submit" >Сохранить</button>
            </div>
            </div>
        </div>

      </form>




        </div>
  </div>
</div>
</body>
</html>