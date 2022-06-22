<?php
session_start();
include_once "app/middlewares/auth.php";
include_once "app/services/uploadImage.php";
include_once "app/database/models/Student.php";
$StudentData = new Student;
if (isset($_POST['update-profile'])) {
	$errors = [];
	$success = [];
	// validation
	if (!empty($_POST['fname']) && !empty($_POST['sname'])) {
		// pass form data to student model
		$StudentData->setName(implode(" ", [$_POST['fname'], $_POST['sname']]));
		$StudentData->setEmail($_SESSION['user']->email);
		// upload photo if exists
		if ($_FILES['image']['error'] == 0) {

			$directory = "assets/images/student/";

			$uploadImage = new uploadimage($_FILES['image'], $directory);
			$uploadImageSizeErrors = $uploadImage->validateOnSize();
			$uploadImageExtensionErrors = $uploadImage->validateOnExtension();
			if (empty($uploadImageSizeErrors) and empty($uploadImageExtensionErrors)) {
				$photoName = $uploadImage->uploadPhoto();
				if(trim($_SESSION['user']->image) != "default.jpg")
				{
					 unlink(__DIR__."\\assets\\images\\student\\".$_SESSION['user']->image);
				}
				$_SESSION['user']->image = $photoName;
				$StudentData->setImage($photoName);
			}
		}
		// update data if no errors in image
		if (empty($uploadImageSizeErrors) and empty($uploadImageExtensionErrors)) {
			// update database

			$updateResult = $StudentData->update();
			// if updated
			if ($updateResult) {
				// update session
				$_SESSION['user']->name = implode(" ", [$_POST['fname'], $_POST['sname']]);
				// $success['update-profile']['message']['success'] = "<div class='alert alert-success'> Data Updated Successfully </div>";
				$success['update-profile']['message']['success'] = "<div class='flex' style='color:green;font-size:20px'>تم تعديل بياناتك بنجاح</div>";
			} else {
				// print error
				$errors['update-profile']['message']['something'] = "<div class='alert alert-danger'> Something Went Wrong </div>";
			}
		}
	} else {
		$errors['update-profile']['message']['all-fields'] = "<div class='alert alert-danger'> All Fields Are Required </div>";
	}
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>تعديل الملف الشخصي</title>
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


	<!-- start update profile  -->

	<div class="update-profile">
		<?php
		if (isset($errors['update-profile']['message'])) {
			foreach ($errors['update-profile']['message'] as $key => $value) {
				echo $value;
			}
		}
		if (isset($success['update-profile']['message'])) {
			foreach ($success['update-profile']['message'] as $key => $value) {
				echo $value;
			}
		}
		?>
		<div class="container">

			<h1>تعديل صفحة البروفايل</h1>

			<form method="post" enctype="multipart/form-data">
				<?php
				$name = explode(" ", $_SESSION['user']->name);
				$fname = $name[0];
				unset($name[0]);
				$sname = implode(" ",$name);
				?>
				<!-- <img src="assets/images/pic-1.png" alt=""> -->
				<img src="assets/images/student/<?= $_SESSION['user']->image ?>" alt="">
				<div class="flex">
					<div class="inputBox">
						<h4>الاسم الاول</h4>
						<input type="text" name="fname" placeholder="الاسم الاول" value="<?= $fname ?>">
						<h4>الاسم الثاني</h4>
						<input type="text" name="sname" placeholder="الاسم الثاني" value="<?= $sname ?>">
						<h4></h4>
						<input type="file" name="image">
					</div>
					<?php
					if (isset($uploadImageSizeErrors)) {
						foreach ($uploadImageSizeErrors as $key => $value) {
							echo $value;
						}
					}
					if (isset($uploadImageExtensionErrors)) {
						foreach ($uploadImageExtensionErrors as $key => $value) {
							echo $value;
						}
					}
					?>
					<div class="flex-btn">
						<input type="submit" value="تم" name="update-profile" class="btn">
						<a href="profile.php" class="option-btn">رجوع</a>
					</div>
				</div>

			</form>

		</div>

	</div>

	<!-- end update profile  -->



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
	<script src="assets/js/script.js"></script>

</body>

</html>