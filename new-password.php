<?php
session_start();
include_once "app/request/registerRequest.php";
include_once "app/database/models/Student.php";
if (isset($_POST['change-password'])) {
  $errors = [];
  $registerValidation = new registerRequest;
  $registerValidation->setPassword($_POST['password']);
  $registerValidation->setConfrimPassword($_POST['confirm_password']);
  $passwordValidationResult = $registerValidation->passwordValidation();
  if(empty($passwordValidationResult)){
      $StudentData = new Student;
      $StudentData->setPassword($_POST['password']);
      $StudentData->setEmail($_SESSION['email']);
      unset($_SESSION['email']);
      $updatePasswordResult = $StudentData->updatePassword();
      if($updatePasswordResult){
          header('location:login.php');die;
      }else{
          $errors['something'] = "<div class='alert alert-danger'> something went wrong  </div>";
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
  <title>كلمة السر الجديدة</title>
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

  <div class="new-password">

    <div class="container">

      <div class="new-password-form">

        <div class="text">
          <h1>تغيير كلمة السر</h1>
        </div>

        <form action="" method="post">
          <div class="inputBox">
            <input type="password" name="password" placeholder="كلمة السر الجديده" id="" required>
            <i class="fas fa-lock"></i>
          </div>
          <?php
          if (isset($passwordValidationResult['password-required'])) {
            echo $passwordValidationResult['password-required'];
          }
          if (isset($passwordValidationResult['password-pattern'])) {
            echo $passwordValidationResult['password-pattern'];
          }
          ?>
          <div class="inputBox">
            <input type="password" name="confirm_password" placeholder="تاكيد كلة السر" id="" required>
            <i class="fas fa-lock"></i>
          </div>
          <?php
          if (isset($passwordValidationResult['confirmPassword-required'])) {
            echo $passwordValidationResult['confirmPassword-required'];
          }
          if (isset($passwordValidationResult['password-confirmed'])) {
            echo $passwordValidationResult['password-confirmed'];
          }
          if (isset($errors)) {
            foreach ($errors as $key => $value) {
              echo $value;
            }
          }
          ?>
          <input type="submit" name="change-password" value="تغير كلمة السر" class="btn">
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