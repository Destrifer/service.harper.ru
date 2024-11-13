<?php

use models\Services;
require '_new-codebase/front/templates/main/parts/common.php';
$service = Services::getServiceByID( $_GET['id']);

if(!empty($_POST['tariff_id'])){
  Services::setServiceTariff($_GET['id'], $_POST['tariff_id']);
  exit;
}

check_prices();

function content_list() {
  global $db;
  $content_list = '';
if (!\models\User::hasRole('admin')) {
  return '';
}
$cats = [];
$c = mysqli_query($db, 'SELECT `id`, `name` FROM `cats` WHERE `is_deleted` = 0');
while ($row = mysqli_fetch_array($c)) {
  $cats[$row['id']] = $row['name'];
}
$sql = mysqli_query($db, 'SELECT * FROM `prices_service` WHERE `service_id` = ' . $_GET['id'] . ' 
AND `cat_id` IN (SELECT `cat_id` FROM `cats_users` WHERE `service_id` = ' . $_GET['id'] . ' and `service` = 1)');
if (mysqli_num_rows($sql) != false) {
    while ($row = mysqli_fetch_array($sql)) {
          if(empty($cats[$row['cat_id']])){
            continue;
          }
          $content_list .= '<tr>
          <td>'.$row['id'].'</td>
          <td style="font-size:14px">'.$cats[$row['cat_id']].'</td>
          <td><input class="editable" style="width:110px;" data-pass-protect-input readonly type="number" min="0" name="component" value="'.$row['component'].'" data-cat-id="'.$row['cat_id'].'" data-service-id="'.$_GET['id'].'"></td>
          <td><input class="editable" style="width:110px;" data-pass-protect-input readonly type="number" min="0" name="block" value="'.$row['block'].'" data-cat-id="'.$row['cat_id'].'" data-service-id="'.$_GET['id'].'"></td>
          <td><input class="editable" style="width:110px;" data-pass-protect-input readonly type="number" min="0" name="access" value="'.$row['access'].'" data-cat-id="'.$row['cat_id'].'" data-service-id="'.$_GET['id'].'"></td>
          <td><input class="editable" style="width:110px;" data-pass-protect-input readonly type="number" min="0" name="anrp" value="'.$row['anrp'].'" data-cat-id="'.$row['cat_id'].'" data-service-id="'.$_GET['id'].'"></td>
          <td><input class="editable" style="width:110px;" data-pass-protect-input readonly type="number" min="0" name="ato" value="'.$row['ato'].'" data-cat-id="'.$row['cat_id'].'" data-service-id="'.$_GET['id'].'"></td>
          </tr>';
    }
  return $content_list;
}
}

function get_prices_global($id) {
  global $db;
$sql = mysqli_query($db, 'SELECT * FROM `prices` where `cat_id` = '.$id.' ;');
if (mysqli_num_rows($sql) != false) {
  return $prices = mysqli_fetch_array($sql);
}
}



function check_prices() {
  global $db;

if (\models\User::hasRole('admin')) {

//$content = mysqli_fetch_array(mysqli_query($db, 'SELECT * FROM `requests` WHERE `user_id` = \''.mysqli_real_escape_string($db, $_GET['id']).'\' LIMIT 1;'));
//$content['cats'] = explode('|', $content['cat']);

$sql2 = mysqli_query($db, 'SELECT * FROM `cats_users` WHERE `service_id` = \''.mysqli_real_escape_string($db, $_GET['id']).'\' and `service` = 1;');
while ($row2 = mysqli_fetch_array($sql2)) {
$cats[] = $row2['cat_id'];
}

$sql = mysqli_query($db, 'SELECT * FROM `cats`;');
if (mysqli_num_rows($sql) != false) {
    while ($row = mysqli_fetch_array($sql)) {
      if (in_array($row['id'], $cats)) {

          $current = mysqli_fetch_array(mysqli_query($db, 'SELECT COUNT(*) FROM `prices_service` WHERE `service_id` = \''.mysqli_real_escape_string($db, $_GET['id']).'\' and `cat_id` = '.$row['id'].' LIMIT 1;'));
      
          
          if ($current['COUNT(*)'] == 0) {
            
          $prices_global = get_prices_global($row['id']);
          mysqli_query($db, 'INSERT INTO `prices_service` (
            `service_id`,
            `cat_id`,
            `block`,
            `component`,
            `access`,
            `anrp`,
            `ato`
            ) VALUES (
            \''.mysqli_real_escape_string($db, $_GET['id']).'\',
            \''.mysqli_real_escape_string($db, $row['id']).'\',
            \''.mysqli_real_escape_string($db, $prices_global['block']).'\',
            \''.mysqli_real_escape_string($db, $prices_global['element']).'\',
            \''.mysqli_real_escape_string($db, $prices_global['acess']).'\',
            \''.mysqli_real_escape_string($db, $prices_global['anrp']).'\',
            \''.mysqli_real_escape_string($db, $prices_global['ato']).'\'
            );') or mysqli_error($db);
           
          }/* else {
          $prices_global = get_prices_global($row['id']);
          mysqli_query($db, 'UPDATE `prices_service` SET
            `service_id`,
            `cat_id`,
            `block`,
            `component`,
            `access`,
            `anrp`,
            `ato`
            WHERE `service_id` = \''.mysqli_real_escape_string($db, $_GET['id']).'\' and `cat_id` =
            \''.mysqli_real_escape_string($db, $_GET['id']).'\',
            \''.mysqli_real_escape_string($db, $row['id']).'\',
            \''.mysqli_real_escape_string($db, $prices_global['block']).'\',
            \''.mysqli_real_escape_string($db, $prices_global['component']).'\',
            \''.mysqli_real_escape_string($db, $prices_global['access']).'\',
            \''.mysqli_real_escape_string($db, $prices_global['anrp']).'\',
            \''.mysqli_real_escape_string($db, $prices_global['ato']).'\'
            );') or mysqli_error($db);
          } */



      }
    }

}


}
}


$secNav = [
  ['name' => 'Изменить', 'url' => '#', 'action' => 'pass-protect-open'],
  ['name' => 'Сохранить', 'url' => '#', 'action' => 'save-changes', 'class' => 'disabled']
];
?>
<!doctype html>
<html>
<head>
<meta charset=utf-8>
<title>Тарифы сервиса <?= $service['name']; ?> - Панель управления</title>
<link href="/css/fonts.css" rel="stylesheet" />
<link href="/css/style.css" rel="stylesheet" />
<script src="/_new-codebase/front/vendor/jquery/jquery-1.7.2.min.js"  ></script>
<script src="/js/jquery-ui.min.js"></script>
<script src="/js/jquery.placeholder.min.js"></script>
<script src="/js/jquery.formstyler.min.js"></script>
<script src="/js/main.js?<?= intval(microtime(1)) ?>"></script>

<script src="/notifier/js/index.js"></script>
<link rel="stylesheet"  href="/notifier/css/style.css">
<link rel="stylesheet" href="/_new-codebase/front/vendor/animate.min.css" />
<script src='/_new-codebase/front/vendor/mustache/mustache.min.js'></script>
<script src="/_new-codebase/front/vendor/malihu/jquery.mCustomScrollbar.concat.min.js"></script>
<link rel="stylesheet" href="/_new-codebase/front/vendor/malihu/jquery.mCustomScrollbar.min.css" />

<script  src="/_new-codebase/front/vendor/datatables/1.10.12/jquery.dataTables.min.js"></script>
<link rel="stylesheet"  href="/css/datatables.css">

<script >
// Таблица
$(document).ready(function() {
    $('#table_content').dataTable({
      "pageLength": 30,
      "dom": '<"top"flp<"clear">>rt<"bottom"ip<"clear">>',
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



     let data = {};
    let blockFlag = false;

    $('body').on('click', '[data-action]', function(event) {
        event.preventDefault();
        switch (this.dataset.action) {
            case 'save-changes':
                save();
                break;
        }
    });


    function save() {
        if(blockFlag || !Object.keys(data).length){
            return;
        }
        blockFlag = true;
        $.ajax({
            type: 'POST',
            url: '/ajax.php?type=update_service_price',
            data: 'data=' + JSON.stringify(data),
            success: function(resp) {
                if (+resp['error_flag']) {
                    alert(resp['message']);
                    return;
                }
                alert('Тарифы сохранены.');
                data = {};
            },
            complete: function() {
                blockFlag = false;
            },
        });
    }


    $('body').on('change', 'input.editable', function() {
        collectData($(this).attr('name'), $(this).data('cat-id'), $(this).data('service-id'), $(this).val());
    });


    $(document).on('passprotect:unblock', function() {
        $('[data-action="save-changes"]').removeClass('disabled');
    });


    function collectData(field, catID, serviceID, value) {
        data[catID+field] = { 'field': field, 'value': value, 'cat_id': catID, 'service_id': serviceID};
    }

} );

</script>
<!-- New codebase -->
<link href="/_new-codebase/front/vendor/fancybox/jquery.fancybox.min.css" rel="stylesheet" />
<link href="/_new-codebase/front/templates/main/css/form.css" rel="stylesheet" />
<link href="/_new-codebase/front/templates/main/css/layout.css" rel="stylesheet" />
<link href="/_new-codebase/front/templates/main/css/sec-nav.css" rel="stylesheet" />
  <style>
        * {
            box-sizing: border-box;
        }

        [readonly] {
            background-color: #f1f1f1;
            cursor: default;
        }
  </style>
</head>

<body>

<div class="viewport-wrapper">

<div class="site-header">
  <div class="wrapper">

    <div class="logo">
      <a href="/dashboard/"><img src="/i/logo.png" alt=""/></a>
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
           <h2 style="margin-bottom:24px">Тарифы сервиса <?= $service['name']; ?></h2>
           <div class="layout__mb_md">
             <label for="tariff-select">Применять тариф:</label>
              <select class="nomenu" id="tariff-select">
                <option value="2" <?= (($service['tariff_id'] == 2) ? 'selected' : ''); ?>>Тариф 2018</option>
                <option value="1" <?= (($service['tariff_id'] == 1) ? 'selected' : ''); ?>>Тариф 2022</option>
                <option value="3" <?= (($service['tariff_id'] == 3) ? 'selected' : ''); ?>>Тариф 2023</option>
              </select>
           </div>

           <nav class="layout__mb_md">
            <?php secNavHTML($secNav); ?>
    </nav>

  <div class="adm-catalog">

     <br>
  <table id="table_content" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th align="left">№</th>
                <th align="left">Категория</th>
                <th align="left">Компонентный</th>
                <th align="left">Блочный</th>
                <th align="left">Замена аксессуаров</th>
                <th align="left">АНРП</th>
                <th align="left">АТО</th>
            </tr>
        </thead>

        <tbody>
        <?=content_list();?>
        </tbody>
</table>


</div>


        </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
  $('#tariff-select').on('change', function(){
    const select = this;
    const tariffID = select.value;
    select.style.opacity = .4;
    $.ajax({
            type: 'POST',
            url: location.href,
            data: 'tariff_id=' + tariffID,
            dataType: 'json',
            cache: false,
            complete: function(){
              select.style.opacity = '';
            },
            error: function(jqXHR) {
                console.log('Ошибка сервера');
                console.log(jqXHR.responseText);
            }
        });
    });
  });
  </script>

      <!-- New codebase -->
      <script src="/_new-codebase/front/vendor/fancybox/jquery.fancybox.min.js"></script>
    <script src="/_new-codebase/front/components/pass-protect/pass-protect.js"></script>
</body>
</html>