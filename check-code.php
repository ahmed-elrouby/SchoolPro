<?php
session_start();
include_once 'app/database/models/Student.php';
include_once "app/request/checkCodeRequest.php";
if ($_GET) {
  if (!isset($_GET['page'])) {
    header('location:views/errors/404.php');
    die;
  } else {
    if (!in_array($_GET['page'], ["login", "register", "verify", "my-account"])) {
      header('location:views/errors/404.php');
      die;
    }
  }
} else {
  header('location:views/errors/404.php');
  die;
}

if (isset($_POST['check-code'])) {
  $errors = [];
  $checkCOde = new checkCodeRequest;
  $checkCOde->setCode($_POST['code']);
  // required , numeric , digits:5
  $codeValidationResult = $checkCOde->codeValidation();
  if (empty($codeValidationResult)) {
    // check if code correct in db
    $StudentData = new Student;
    $StudentData->setCode($_POST['code']);
    $StudentData->setEmail($_SESSION['email']);
    $checkCodeResult = $StudentData->checkCode();
    if ($checkCodeResult) {
      // update status , change email verified_at
      // $StudentData->setStatus(1);
      $StudentData->setVerified_at(date("Y-m-d H:i:s"));
      $verifyUserResult = $StudentData->verifyMail();
      if ($verifyUserResult) {
        switch ($_GET['page']) {
          case 'login':
            // $_SESSION['user'] = $checkCodeResult->fetch_object();
            unset($_SESSION['email']);
            $_SESSION['wait']="<div class='flex' style='color:red;font-size:16px;text-align:center'>انتظر حتي يتم قبولك عن طريق ادمن الموقع</div>";
            header('location:login.php');
            die;
          case 'register':
            unset($_SESSION['email']);
            header('location:login.php');
            die;
          case 'my-account':
            $_SESSION['user'] = $checkCodeResult->fetch_object();
            unset($_SESSION['email']);
            header('location:my-account.php');
            die;
          case 'verify':
            header('location:new-password.php');
            die;
          default:
            header('location:views/errors/404.php');
            die;
        }
      } else {
        $errors['something'] = "<div class='alert alert-danger'> Something Went Wrong </div>";
      }
    } else {
      // $errors['wrong'] = "<div class='alert alert-danger'> Code Isn't Correct </div>";
      $errors['wrong'] = "<div class='flex' style='color:red;font-size:16px;text-align:center'>الكود غير صحيح</div>";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>تاكيد الكود</title>
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
      
      <nav>
        <ul>
          <li><a href="register.php">مستخدم جديد</a></li>
          <li><a href="login.php" class="signin">تسجيل الدخول</a></li>
          <li>
            <form action="" class="search-form">
              <input type="search" id="search-box">
              <label for="search-box" class="fas fa-search"></label>
            </form>
          </li>
          <li><a href="about.html">من نحن</a></li>
        </ul>
      </nav>
      
      <a href="index.php" class="logo"><img src="assets/images/logo.png" alt=""></a>
      
      <div id="menu-btn" class="fas fa-bars"></div>
    
      <a href="login.php"><i class="fa-regular fa-user"></i></a>

    </div>
    
  </header>

  <!-- end header  -->

<!-- start forgot password  -->

<div class="reset-code">

<div class="container">

  <div class="reset-code-form">

    <div class="text">
      <h1>ادخل الرمز</h1>
    </div>

    <form action="" method="post">
        <div class="inputBox">
          <input type="number" name="code" placeholder="ادخل الرمز" id="" required>
          <i class="fas fa-user-check"></i>
        </div>
        <?php
          if (!empty($codeValidationResult)) {
            foreach ($codeValidationResult as $key => $value) {
              echo $value;
            }
          }
          if (isset($errors['wrong'])) {
            echo $errors['wrong'];
          }
          if (isset($errors['something'])) {
            echo $errors['something'];
          }
          ?>
        <input type="submit" name="check-code" value="تاكيد الكود" class="btn">
        <!-- <div class="flex">
          <a href="login.php">تسجيل الدخول</a>
        </div> -->
    </form>

  </div>

</div>

</div>
<!-- end forgot password  -->

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












  <!-- file js  -->
  <script src="assets/js/script.js"></script>
</body>

</html>