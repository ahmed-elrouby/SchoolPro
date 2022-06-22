<?php
include_once "app/database/models/Student.php";
include_once "app/mail/mail.php";


// echo __DIR__;

if(isset($_POST['register']))
{

	if(empty($_POST["name"]))
	{
		$Error['name']="<h1>Thier is no name thier!</h1>";
	}
	if(empty($_POST["email"]))
	{
		$Error['email']="<h1>Thier is no email thier!</h1>";
	}
	if(empty($_POST["password"]))
	{
		$Error['password']="<h1>Thier is no password thier!</h1>";
	}
	if(empty($Error))
	{
		$code = rand(10000, 99999);
		$StudentObject=new Student;
		$StudentObject->setName($_POST['name']);
		$StudentObject->setEmail($_POST['email']);
		$StudentObject->setPassword($_POST['password']);
		$StudentObject->setCode($code);
		$createResult = $StudentObject->create();
		if($createResult)
		{
			// send email
			$subject = "Voluntary-Verification-Code";
			$body = "<p>Hello {$_POST['name']}</p><p> Your Verification Code is:<b>$code</b></p><p>Thank You.</p>";
			$newMail = new mail($_POST['email'], $subject, $body);
			$mailResult = $newMail->sendMail();
			if ($mailResult) {
				// $_SESSION['email'] = $_POST['email'];
				// header("location:check-code.php?page=register");exit;
				echo "the code is send";
			} else {
				$mailError  = "<div class='alert alert-danger'> Try To Verify You Account Later </div>";
			}
			echo "this Student are Registered!";
		}
	}
	
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>register New Student</title>
</head>
<body>
<form method="post">
<label>Name</label>
<input type='text' name="name" <?php if(isset($_POST['name'])){?>
 value='<?php echo $_POST['name'];}?>' ><br>
 <?php if(isset($Error['name'])){ echo$Error['name'];}?>
<label>Email</label>
<input type='email' name="email" <?php if(isset($_POST['email'])){?>
 value='<?php echo $_POST['email'];}?>' ><br>
 <?php if(isset($Error['email'])){ echo$Error['email'];}?>
<label>Password</label>
<input type='password' name="password"><br>
<?php if(isset($Error['password'])){ echo$Error['password'];}?>
<input type='submit' name='register'><br>
</form>
</body>
<html/>

