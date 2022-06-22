<?php
require_once __DIR__."\..\database\models\Student.php";

class registerRequest {
    private $name;
    private $email;
    private $password;
    private $confirmPassword;
    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

   
    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of confrimPassword
     */ 
    public function getConfrimPassword()
    {
        return $this->confirmPassword;
    }

    /**
     * Set the value of confrimPassword
     *
     * @return  self
     */ 
    public function setConfrimPassword($confirmPassword)
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }
    public function nameValidation() 
    {
        $errors = [];

        if(empty($this->name)){
            $errors['name-required'] = "<div class='flex' style='color:red;font-size:16px'>حقل الاسم مطلوب</div>";
        }
        return $errors;
    }
    public function emailValidation() 
    {
        $pattern = "/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/";
        // required
        $errors = [];

        if(empty($this->email)){
            // $errors['email-required'] = "<div class='alert alert-danger'> Email Is Required </div>";
            $errors['email-required'] = "<div class='flex' style='color:red;font-size:16px'>حقل الايميل مطلوب</div>";
        }else{
            // regular expression
            if(!preg_match($pattern,$this->email)){
                // $errors['email-pattern'] = "<div class='alert alert-danger'> Email Is Invalid </div>";
                $errors['email-pattern'] = "<div class='alert alert-danger'> <div class='flex' style='color:red;font-size:16px'>الايميل غير صحيح</div> </div>";
            }
        }
        return $errors;  
    }
    public function passwordValidation()
    {
        $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
        $errors = [];
        // required 
        if(empty($this->password)){
            // $errors['password-required'] = "<div class='alert alert-danger'> Password Is Required </div>";
            $errors['password-required'] = "<div class='alert alert-danger'> <div class='flex' style='color:red;font-size:16px'>حقل كلمة السر مطلوب</div> </div>";
        }
        // required
        if(empty($this->confirmPassword)){
            // $errors['confirmPassword-required'] = "<div class='alert alert-danger'> Confirm Password Is Required </div>";
            $errors['confirmPassword-required'] = "<div class='alert alert-danger'> <div class='flex' style='color:red;font-size:16px'>حقل تاكيد كلمة السر مطلوب</div> </div>";
        }

        if(empty($errors)){
            // confirmed
            if($this->password !== $this->confirmPassword){
                // $errors['password-confirmed'] = "<div class='alert alert-danger'> Password Dosen't Match  </div>";
                $errors['password-confirmed'] = "<div class='flex' style='color:red;font-size:16px'>كلمة السر و تاكيد كلمة السر لايتطابقان</div>";
            }
            //regex
            if(!preg_match($pattern,$this->password)){
                // $errors['password-pattern'] = "<div class='alert alert-danger'>Minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character. </div>";
                $errors['password-pattern'] = "<div class='flex' style='color:red;font-size:16px'>يحب ان تحتوي كلمة السر علي حروف كبيرة وصغيرة وارقام و حروف خاصة و علي الاقل 8 مقاطع </div>";
            }
        }
        return $errors;  

    }
    public function emailExists()
    {
        $errors  = [];
        $StudentObject = new Student;
        $StudentObject->setEmail($this->email);
        $result = $StudentObject->checkIfEmailExists();
        if($result){
            // $errors['email-unique'] = "<div class='alert alert-danger'>Email Already Exists </div>";
            $errors['email-unique'] = "<div class='flex' style='color:red;font-size:16px'>الايميل مسجل مسبقا يرجي استخدام ايميل اخر</div>";
        }
        return $errors;
    }

    
}