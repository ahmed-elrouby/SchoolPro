<?php
session_start();
// session_destroy();
include_once "app/middlewares/auth.php";
function validateDate($date, $format = 'Y-m-d H:i:s')
{
  $d = DateTime::createFromFormat($format, $date);
  return $d && $d->format($format) == $date;
}
if (isset($_POST['voluntary'])) {
  if (empty($_POST['name'])) {
    $error['empty-name'] = "<div class='flex' style='color:red;font-size:16px'>حقل الاسم مطلوب</div>";
  }
  if (empty(trim($_POST['code']))) {
    $error['empty-code'] = "<div class='flex' style='color:red;font-size:16px'>حقل رقم هوية الطالب مطلوب</div>";
  } else if (!is_numeric(trim($_POST['code']))) {
    $error['not_num-code'] = "<div class='flex' style='color:red;font-size:16px'>رقم هوية الطالب ارقام فقط</div>";
  }

  if (empty($_POST['type'])) {
    $error['empty-type'] = "<div class='flex' style='color:red;font-size:16px'>حقل نوع التطوع مطلوب</div>";
  }

  if (empty($_POST['start_date'])) {
    $error['empty-start_date'] = "<div class='flex' style='color:red;font-size:16px'>حقل تاريخ التنفيذ مطلوب</div>";
  } else if (!validateDate($_POST['start_date'], 'Y-m-d')) {
    $error['valid-start_date'] = "<div class='flex' style='color:red;font-size:16px'>تاريخ التنفيذ غير صحيح</div>";
  }
  if (empty($_POST['end_date'])) {
    $error['empty-end_date'] = "<div class='flex' style='color:red;font-size:16px'>حقل وقت التنفيذ مطلوب</div>";
  } else if (!validateDate($_POST['end_date'], 'Y-m-d')) {
    $error['valid-end_date'] = "<div class='flex' style='color:red;font-size:16px'>وقت التنفيذ غير صحيح</div>";
  }
  if (empty(trim($_POST['volunatry_name']))) {
    $error['empty-volunatry_name'] = "<div class='flex' style='color:red;font-size:16px'>حقل مسمي العمل التطوعي مطلوب</div>";
  }
  if (empty($_POST['hour'])) {
    $error['empty-hour'] = "<div class='flex' style='color:red;font-size:16px'>حقل عدد ساعتك التطوعية مطلوب</div>";
  }

  if (empty($error))
  {
    echo "ok";
  }
  else
  {
    echo "niii";
  }


  // print_r($_POST);die;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=, initial-scale=1.0">
  <title>سجل ساعاتك التطوعية</title>
  <link rel="icon" href="assets/images/landing-2.png">

  <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- custom css file link  -->
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

  <!-- start header  -->
  <header class="header">

    <div class="container">

      <nav class="navbar">
        <ul>
          <li><a href="logout.php">تسجيل الخروج</a></li>
          <li><a href="update-profile.php">تعديل الملف الشخصي</a></li>
          <li><a href="voluntary.php">سجل ساعاتك التطوعية</a></li>
          <li><a href="profile.php">الملف الشخصي</a></li>
        </ul>
      </nav>

      <a href="#" class="logo"><img src="assets/images/logo.png" alt=""></a>

      <div id="menu-btn" class="fas fa-bars"></div>

      <a href="profile.php"><i class="fa-regular fa-user"></i></a>

    </div>

  </header>

  <!-- end header  -->


  <!--  start register -->

  <div class="voluntary">

    <div class="container">
      <div class="image">
        <img src="assets/images/0123.png" alt="">
      </div>
      <div class="voluntary-form">
        <div class="text">
          <h1>سجل فرصتك وساعاتك التطوعية</h1>
          <p>يرجي تعبئة جميع البيانات التالية باللغة العربية</p>
        </div>

        <form action="" method="post">
          <div class="inputBox">
            <input type="text" name="name" placeholder="اسم الطالب كاملا" id="" required value="<?= trim($_SESSION['user']->name) ?>">
            <i class="fas fa-user"></i>
          </div>
          <?php
          if (isset($error['empty-name'])) {
            echo $error['empty-name'];
          }
          ?>
          <div class="inputBox">
            <input type="number" name="code" placeholder="رقم هوية الطالب" id="" required value="<?php if (isset($_POST['code'])) {
                                                                                                  echo trim($_POST['code']);
                                                                                                } ?>">
            <i class="fa-solid fa-address-card"></i>
          </div>
          <?php
          if (isset($error['empty-code'])) {
            echo $error['empty-code'];
          }
          if (isset($error['not_num-code'])) {
            echo $error['not_num-code'];
          }
          ?>
          <div class="inputBox">
            <select name="type" id="" >
              <option value="">نوع التطوع:</option>
              <?php
              $volunantry = ['عام', 'اداري', 'قانوني', 'تقني', 'ديني', 'تعليمي', 'بيئي', 'صحي', 'سياحي', 'اعلامي', 'اجتماعي', 'رياضي', 'ثقافي', 'تسويقي', 'مالي'];
              foreach ($volunantry as $value) {
                if ($value == $_POST['type']) {
                  echo "<option value='$value' selected>$value</option>";
                  continue;
                }
                echo "<option value='$value'>$value</option>";
              } ?>
            </select>
            <i class="fa-solid fa-hand-holding-heart"></i>
          </div>
          <?php
          if (isset($error['empty-type'])) {
            echo $error['empty-type'];
          }
          ?>
          <div class="inputBox">
            <input type="text" name="start_date" placeholder="تاريخ التنفيذ" id="" onfocus="(this.type='date')" onblur="if(!this.value) this.type='text'" value="<?php if (isset($_POST['code'])) {
                                                                                                                                                                    echo $_POST['start_date'];
                                                                                                                                                                  } ?>">
            <i class="fa-solid fa-calendar"></i>
          </div>
          <?php
          if (isset($error['empty-start_date'])) {
            echo $error['empty-start_date'];
          }
          if (isset($error['valid-start_date'])) {
            echo $error['valid-start_date'];
          }
          ?>
          <div class="inputBox">
            <input type="text" name="end_date" placeholder="وقت التنفيذ" id="" onfocus="(this.type='date')" onblur="if(!this.value) this.type='text'" value="<?php if (isset($_POST['code'])) {
                                                                                                                                                                echo $_POST['end_date'];
                                                                                                                                                              } ?>">
            <i class="fa-solid fa-clock"></i>
          </div>
          <?php
          if (isset($error['empty-end_date'])) {
            echo $error['empty-end_date'];
          }
          if (isset($error['valid-end_date'])) {
            echo $error['valid-end_date'];
          }
          ?>
          <div class="inputBox">
            <input type="text" name="volunatry_name" placeholder="مسمي العمل التطوعي" id="" value="<?php if (isset($_POST['volunatry_name'])) {
                                                                                                      echo $_POST['volunatry_name'];
                                                                                                    } ?>">
            <i class="fa-solid fa-hand-holding-heart"></i>
          </div>
          <?php
          if (isset($error['empty-volunatry_name'])) {
            echo $error['empty-volunatry_name'];
          }
          ?>
          <div class="inputBox">
            <select name="hour" id="">
              <option value="">عدد ساعاتك التطوعية</option>
              <?php
              for ($i = 1; $i <= 20; $i++) {
                if ($i == $_POST['hour']) {
                  echo "<option value='$i' selected>$i</option>";
                  continue;
                }
                echo "<option value='$i'>$i</option>";
              }
              ?>
            </select>
            <i class="fa-solid fa-clock"></i>
          </div>
          <?php
          if (isset($error['empty-hour'])) {
            echo $error['empty-hour'];
          }
          ?>
          <input type="submit" value="تسجيل " name="voluntary" class="btn">
        </form>

      </div>

    </div>

  </div>

  <!-- end register  -->


  <!-- start footer -->

  <footer class="footer">

    <div class="container">

      <a href="">&copy;حقوق الطبع والنشر</a>
      <a href="">دليل العمل التطوعي</a>
      <a href=""> الاسئله الشائعه</a>

      <div class="contact">
        <h3>تواصل معنا</h3>
        <div class="icons">
          <a href=""><i class="fa-brands fa-facebook"></i></a>
          <a href=""><i class="fa-brands fa-instagram"></i></a>
          <a href=""><i class="fa-brands fa-twitter"></i></a>
          <a href=""><i class="fa-brands fa-youtube"></i></a>
        </div>
      </div>

    </div>

  </footer>

  <!-- end footer -->












  <!--  js file  -->
  <script src="assets/js/script.js"></script>
</body>

</html>