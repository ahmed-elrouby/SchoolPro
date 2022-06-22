<?php
session_start();
include_once "app/database/models/Student.php";
include_once "app/request/registerRequest.php";
include_once "app/mail/mail.php";

if (isset($_POST['verify-email'])) {
  $errors = [];
  $emailValidation = new registerRequest;
  $emailValidation->setEmail($_POST['email']);
  $emailValidationResult = $emailValidation->emailValidation();
  if (empty($emailValidationResult)) {
    $emailExistsResult = $emailValidation->emailExists();
    if (!empty($emailExistsResult)) {
      // create code
      $code = rand(10000, 99999);
      $StudentData = new Student;
      $StudentData->setCode($code);
      $StudentData->setEmail($_POST['email']);
      $updateCodeResult = $StudentData->updateCode();
      if ($updateCodeResult) {
        // send mail
        $checkIfEmailExistsResult = $StudentData->checkIfEmailExists();
        $user = $checkIfEmailExistsResult->fetch_object();
        $subject = "Voluntary-Verification-Code-forget-password";
        $body = "<p>Hello {$user->name}</p><p> Your Verification Code is:<b>$user->code</b></p><p>Thank You.</p>";
        $newMail = new mail($_POST['email'], $subject, $body);
        $mailResult = $newMail->sendMail();
        if ($mailResult) {
          $_SESSION['email'] = $_POST['email'];
          header('location:check-code.php?page=verify');
          die;
        } else {
          $errors['failed-email']  = "<div class='alert alert-danger'> Try To Verify You Account Later </div>";
        }
      } else {
        $errors['something'] = "<div> something went wrong </div>";
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>تعيين كلمة السر</title>
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

  <div class="forgot-password">

    <div class="container">

      <div class="forgot-password-form">

        <div class="text">
          <h1>تعيين كلمة السر</h1>
        </div>

        <form method="post">
          <div class="inputBox">
            <input type="email" name="email" placeholder="ادخل عنوان الايميل" id="" required>
            <i class="fas fa-user"></i>
          </div>
          <?php
          if (!empty($emailValidationResult)) {
            foreach ($emailValidationResult as $key => $value) {
              echo $value;
            }
          }
          if (!empty($errors)) {
            foreach ($errors as $key => $value) {
              echo $value;
            }
          }
          if (isset($emailExistsResult) and empty($emailExistsResult)) {
            // echo "<div class='alert alert-danger'>Email Not Found </div>";
            echo "<div class='flex' style='color:red;font-size:16px'>الايميل غير موجود</div>";
          }
          ?>
          <input type="submit" name="verify-email" value="استمرار" class="btn">
          <div class="flex">
            <a href="login.php">تسجيل الدخول</a>
          </div>
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