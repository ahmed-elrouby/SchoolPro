<?php
session_start();
// session_destroy();
include_once "app/middlewares/auth.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>الملف الشخصي</title>
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

  <!-- start profile -->

  <div class="profile">

    <div class="container">

      <div class="image">
				<img src="assets/images/student/<?=$_SESSION['user']->image?>" alt="" style="border-radius: 250px;">
			</div>

			<div class="text">
				<h2><?=$_SESSION['user']->name?></h2>
			  <h2><?=$_SESSION['user']->email?></h2>
			</div>

			<span>مجالات التطوع</span>

			<div class="works">
				<div class="work"><button>ثقافي</button></div>
				<div class="work"><button>تربوي</button></div>
				<div class="work"><button>رياضي</button></div>
				<div class="work"><button>فني</button></div>
			</div> 

		</div>

	</div>

  <!-- end profile -->

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