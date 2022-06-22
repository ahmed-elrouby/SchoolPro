<?php
session_start();
include_once "app/middlewares/guest.php";
include_once 'app/database/models/Student.php';
include_once 'app/request/loginRequest.php';
include_once "app/mail/mail.php";
include_once "app/request/registerRequest.php";
define('verifeid', 1);
if (isset($_POST['login'])) {
  $errors = [];
  // email validation
  $emailValidation = new registerRequest;
  $emailValidation->setEmail($_POST['email']);
  $emailValidationResult = $emailValidation->emailValidation();
  // password validaiton
  $passwordValidation = new loginRequest;
  $passwordValidation->setPassword($_POST['password']);
  $passwordValidationResult = $passwordValidation->passwordValidation();
  // if validation => success
  if (empty($passwordValidationResult) and empty($emailValidationResult)) {
    // check on db
    $StudentData = new Student;
    $StudentData->setPassword($_POST['password']);
    $StudentData->setEmail($_POST['email']);
    $loginResult = $StudentData->login();
    // if the attempt was correct
    if ($loginResult) {
      // check on status
      $user = $loginResult->fetch_object();
      if ($user->verified_at == '') {
        // send mail
        $subject = "Voluntary-Verification-Code";
        $body = "<p>Hello {$user->name}</p><p> Your Verification Code is:<b>$user->code</b></p><p>Thank You.</p>";
        $newMail = new mail($_POST['email'], $subject, $body);
        $mailResult = $newMail->sendMail();
        if ($mailResult) {
          $_SESSION['email'] = $_POST['email'];
          header('location:check-code.php?page=login');
          die;
        } else {
          // $errors['failed-email']  = "<div c lass='alert alert-danger'> Try To Verify You Account Later </div>";
          $errors['failed-email']  = "<div class='flex' style='color:red;font-size:16px'>حاول تاكيد ملكية الايميل في وقت اخر</div>";
        }
      } else if ($user->status != verifeid) {
        $errors['admin-acceptance'] = "<div class='flex' style='color:red;font-size:16px;text-align:center'>انتظر حتي يتم قبولك عن طريق ادمن الموقع</div>";
      } else {
        // goto to home with session data
        $_SESSION['user'] = $user;
        header('location:voluntary.php');
        die;
      }
    } else {
      $errors['wrong-attempt'] = "<div class='alert alert-danger'> Failed Attempt </div>";
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
  <title>تسجيل الدخول</title>
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



  <!-- start login -->

  <div class="login">
    <?php 
    if (isset($errors)) {
            foreach ($errors as $key => $value) {
              echo $value;
            }
          }
          // if (isset($_GET['wait'])) {
          //   echo $_GET['wait'];
          // }
          if (isset($_SESSION['wait'])) {
            echo $_SESSION['wait'];
            unset($_SESSION['wait']);
          }
    // if (isset($errors['admin-acceptance'])) {
    //   echo $errors['admin-acceptance'];
    // } 
    ?>
    <div class="container">

      <div class="image">
        <img src="assets/images/01234.png" alt="">
      </div>
      <div class="login-form">

        <form method="post">
          <div class="inputBox">
            <input type="email" name="email" placeholder="الايميل" id="" required value="<?php if(isset($_POST['email'])){echo $_POST['email'];}?>">
            <i class="fas fa-user"></i>
          </div>
          <?php
          if (!empty($emailValidationResult)) {
            foreach ($emailValidationResult as $key => $value) {
              echo $value;
            }
          }
          ?>
          <div class="inputBox">
            <input type="password" name="password" placeholder="كلمة السر" id="" required>
            <i class="fas fa-lock"></i>
          </div>
          <?php
          if (!empty($passwordValidationResult)) {
            foreach ($passwordValidationResult as $key => $value) {
              echo $value;
            }
          }
          
          ?>
          <input type="submit" name="login" value="تسجيل الدخول" class="btn">
          <div class="flex">
            <a href="forgot-password.php">تعيين كلمة السر؟</a>
            <a href="register.php">انشاء حساب جديد</a>
          </div>
        </form>

      </div>

    </div>

  </div>

  <!--end login -->


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