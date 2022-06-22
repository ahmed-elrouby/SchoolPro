<?php
session_start();
include_once "app/middlewares/guest.php";
include_once "app/database/models/Student.php";
include_once "app/request/registerRequest.php";
include_once "app/mail/mail.php";
if (isset($_POST['register'])) {
  //validation logic
  $registerValidation = new registerRequest;
  $registerValidation->setName($_POST['name']);
  $nameValidationResult = $registerValidation->nameValidation();

  $registerValidation->setEmail($_POST['email']);
  $emailValidationResult = $registerValidation->emailValidation();

  $registerValidation->setPassword($_POST['password']);
  $registerValidation->setConfrimPassword($_POST['confirm_password']);
  $passwordValidationResult = $registerValidation->passwordValidation();

  if (empty($emailValidationResult) and empty($passwordValidationResult) and empty($nameValidationResult)) {
    $emailExistsResult = $registerValidation->emailExists();
    if (empty($emailExistsResult)) {
      // insert Student into database
      $code = rand(10000, 99999);
      $StudentObject = new Student;
      $StudentObject->setName($_POST['name']);
      $StudentObject->setEmail($_POST['email']);
      $StudentObject->setPassword($_POST['password']);
      $StudentObject->setCode($code);
      $createResult = $StudentObject->create();
      if ($createResult) {
        // send email
        $subject = "Voluntary-Verification-Code";
        $body = "<p>Hello {$_POST['name']}</p><p> Your Verification Code is:<b>$code</b></p><p>Thank You.</p>";
        $newMail = new mail($_POST['email'], $subject, $body);
        $mailResult = $newMail->sendMail();
        if ($mailResult) {
          $_SESSION['email'] = $_POST['email'];
          header("location:check-code.php?page=register");exit;
        } else {
          $mailError  = "<div class='alert alert-danger'> Try To Verify You Account Later </div>";
        }
      } else {
        $databaseError  = "<div class='alert alert-danger'> Something Went Wrong </div>";
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=, initial-scale=1.0">
  <title>انشاء حساب جديد</title>
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


  <!--  start register -->

  <div class="register">

    <div class="container">
      <div class="image">
        <img src="assets/images/0123.png" alt="">
      </div>
      <div class="register-form">

        <form method="post">
          <div class="inputBox">
            <input type="text" name="name" placeholder="اسم الطالب كاملا" id="" required vlaue="<?php if (isset($_POST['name'])) {
                                                                                                  echo $_POST['name'];
                                                                                                } ?>">
            <i class="fas fa-user"></i>
          </div>
          <?php
          if (!empty($nameValidationResult)) {
            foreach ($nameValidationResult as $key => $value) {
              echo $value;
            }
          }
          ?>
          <div class="inputBox">
            <input type="email" name="email" placeholder="الايميل" id="" required vlaue="<?php if (isset($_POST['email'])) {
                                                                                            echo $_POST['email'];
                                                                                          } ?>">
            <i class="fas fa-envelope"></i>
          </div>
          <?php
          if (!empty($emailValidationResult)) {
            foreach ($emailValidationResult as $key => $value) {
              echo $value;
            }
          }
          if(isset($emailExistsResult))
          {
            echo $emailExistsResult['email-unique'];
          }
          ?>
          <div class="inputBox">
            <input type="password" name="password" placeholder="كلمة المرور" id="" >
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
            <input type="password" name="confirm_password" placeholder="تاكيد كلمة المرور" id="" >
            <i class="fas fa-lock"></i>
          </div>
          <?php
          if (isset($passwordValidationResult['confirmPassword-required'])) {
            echo $passwordValidationResult['confirmPassword-required'];
          }
          if (isset($passwordValidationResult['password-confirmed'])) {
            echo $passwordValidationResult['password-confirmed'];
          }
          ?>
          <input type="submit" name="register" value="انشاء " class="btn">
          <div class="flex">
            <a href="login.php">تسجيل الدخول</a>
          </div>
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












  <!-- file js  -->
  <script src="assets/js/script.js"></script>
</body>

</html>