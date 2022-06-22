<?php
session_start();
// include_once "app/middlewares/auth.php";
// echo $_SESSION['user']->name;
// echo $_SESSION['user']->email;
// echo $_SESSION['user']->status;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=, initial-scale=1.0">
  <title>ثانوية الملك فهد بالمجمعة</title>
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


  <!-- start home landing -->
  
  <div class="home-landing">

    <div class="image">
      <img src="assets/images/home-landing.png" alt="">
    </div>

    <div class="box-container">

      <div class="box">
        <h2>نحو</h2>
        <h1><span> مليون ساعه تطوع </span></h1>
        <p>العمل التطوعي سمة المجتمعات الحيوية لدورة في تفعيل طاقات المجتمع , يمكنك ان تتطوع في المكان والزمان والمجال الذي يناسب خبراتك ومهاراتك واصدار شهاداتك التطوعيه , كن جزاء من رؤية المملكة 2030 وانضم الي ركب المتطوعين </p>
      </div>

      <div class="box">
        <h2>وثق تطوعك</h2>
          <span>واحفظ حقك معنا</span>
          <h2>ساهم معنا</h2>
          <span>حتي نصل لمليون ساعة تطوع</span>
      </div>

      <div class="box box-image">
        <img src="assets/images/landing-box.png" alt="">
      </div>

    </div>

  </div>

  <!-- end home landing -->


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









  <!-- js file  -->
  <script src="assets/js/script.js"></script>
</body>
</html>