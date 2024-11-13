<?php
$count = mysqli_fetch_array(mysqli_query($db, 'SELECT COUNT(*) FROM `details_problem_brand` WHERE `id` = \''.mysqli_real_escape_string($db, $_GET['id']).'\' ;'));
if ($count['COUNT(*)'] > 0) {
$content = mysqli_fetch_array(mysqli_query($db, 'SELECT * FROM `details_problem_brand` WHERE `id` = \''.mysqli_real_escape_string($db, $_GET['id']).'\' LIMIT 1;'));
$content = stripslashes_array($content);
} else {
header('Location: '.$config['url'].'problems-brand/'.$_GET['brand_id'].'/');
}
# Сохраняем:
if ($_POST['send'] == 1) {



mysqli_query($db, 'UPDATE `details_problem_brand` SET
`name` = \''.mysqli_real_escape_string($db, $_POST['name']).'\',
`type` = \''.mysqli_real_escape_string($db, $_POST['type']).'\',
`repair_name` = \''.mysqli_real_escape_string($db, $_POST['repair_name']).'\',
`repair_end` = \''.mysqli_real_escape_string($db, $_POST['repair_end']).'\',
`repair_end2` = \''.mysqli_real_escape_string($db, $_POST['repair_end2']).'\',
`repair_end3` = \''.mysqli_real_escape_string($db, $_POST['repair_end3']).'\'
WHERE `id` = \''.mysqli_real_escape_string($db, $_GET['id']).'\' LIMIT 1
;') or mysqli_error($db);


admin_log_add('Обновлена причина отказа деталей #'.$_GET['id']);

mysqli_query($db, 'DELETE FROM `problem_link_brand` where `problem_id` = '.$_GET['id'].';') or mysqli_error($db);

if ($_POST['problem_link']) {

foreach ($_POST['problem_link'] as $link)  {
    mysqli_query($db, 'INSERT INTO `problem_link_brand` (
    `problem_id`,
    `repair_type`
    ) VALUES (
    \''.mysqli_real_escape_string($db, $_GET['id']).'\',
    \''.mysqli_real_escape_string($db, $link).'\'
    );') or mysqli_error($db);
}

}

header('Location: '.$config['url'].'problems-brand/'.$_GET['brand_id'].'/');
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
           <h2>Редактирование причины отказа детали</h2>

  <form id="send" method="POST">
   <div class="adm-form" style="padding-top:0;">

                  <div class="item" >
              <div class="level">Название:</div>
              <div class="value">
                <input type="text" name="name" style="    width: 400px;" value="<?=htmlspecialchars($content['name']);?>"  />
              </div>
            </div>

   <div class="item" >
              <div class="level">Тип ремонта:</div>
              <div class="value">
              <select name="type">
               <option value="" >Выберите вариант</option>
               <option value="АТО" <?php if ($content['type'] == 'АТО') {echo 'selected';} ?>>АТО</option>
               <option value="АНРП" <?php if ($content['type'] == 'АНРП') {echo 'selected';} ?>>АНРП</option>
               <option value="Всегда блочный ремонт" <?php if ($content['type'] == 'Всегда блочный ремонт') {echo 'selected';} ?>>Всегда блочный ремонт</option>
               <option value="Всегда компонентный ремонт" <?php if ($content['type'] == 'Всегда компонентный ремонт') {echo 'selected';} ?>>Всегда компонентный ремонт</option>
               <option value="Замена аксессуаров" <?php if ($content['type'] == 'Замена аксессуаров') {echo 'selected';} ?>>Замена аксессуаров</option>
               <option value="Простой ремонт" <?php if ($content['type'] == 'Простой ремонт') {echo 'selected';} ?>>Простой ремонт</option>
              </select>
              </div>
            </div>
              <br><br>
 <h3>Вид ремонта:</h3>
<div class="adm-finish">
            <ul>
              <?php
              $sql2 = mysqli_query($db, 'SELECT * FROM `repair_type_brand` ;');
              if (mysqli_num_rows($sql2) != false) {
                    while ($row2 = mysqli_fetch_array($sql2)) {
                     $checked = mysqli_fetch_array(mysqli_query($db, 'SELECT COUNT(*) FROM `problem_link` where `problem_id` = '.$_GET['id'].' and `repair_type` = '.$row2['id'].';'));
                     $check = ($checked['COUNT(*)'] > 0) ? 'checked' : '';
                     echo '<li style="padding:5px 0px;"><label><input type="checkbox" name="problem_link[]" value="'.$row2['id'].'" '.$check.'/>'.$row2['name'].'</label></li>';
                    }
              }

              ?>
            </ul>
            </div>

               <br><br>

 <h3>Итоги ремонта:</h3>
<div class="adm-finish" style="padding-top:0px;"><ul>
  <li><label><input name="repair_end" type="checkbox" value="1" <?=(($content['repair_end'] == '1') ? 'checked' : '');?>/>Выдаем обратно клиента (Дефект не обнаружен)</label></li>
  <li><label><input name="repair_end2" type="checkbox"  value="1" <?=(($content['repair_end2'] == '1') ? 'checked' : '');?>/>Оставляем у себя (Подтвердилось)</label></li>
  <li><label><input type="checkbox" name="repair_end3" value="1" <?=(($content['repair_end3'] == '1') ? 'checked' : '');?>/>Выдаем обратно клиенту (Отказано в гарантии)</label></li>
  </ul></div>
<br><br>

 <h3>Причина отказа:</h3>
<div class="adm-finish" style="padding-top:0px;"><ul><li><label><input name="repair_name" type="checkbox" value="Ремонт невозможен" <?=(($content['repair_name'] == 'Ремонт невозможен') ? 'checked' : '');?>/>Ремонт невозможен</label></li><li><label><input name="repair_name" type="checkbox"  value="В гарантии отказано" <?=(($content['repair_name'] == 'В гарантии отказано') ? 'checked' : '');?>/>В гарантии отказано</label></li><li><label><input type="checkbox" name="repair_name" value="Дефект не обнаружен" <?=(($content['repair_name'] == 'Дефект не обнаружен') ? 'checked' : '');?>/>Дефект не обнаружен</label></li></ul></div>





                <div class="adm-finish">
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