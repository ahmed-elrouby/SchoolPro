<?php
require_once __DIR__ ."\..\config\connection.php";
require_once __DIR__ ."\..\config\crud.php";
class Student extends connection implements crud
{
    private $id;
    private $name;
    private $email;
    private $password;
    private $image;
    private $status;
    private $code;
    private $create_at;
    private $updated_at;
    private $verified_at;


    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

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
     * Get the value of image
     */ 
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the value of image
     *
     * @return  self
     */ 
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of code
     */ 
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set the value of code
     *
     * @return  self
     */ 
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get the value of create_at
     */ 
    public function getCreate_at()
    {
        return $this->create_at;
    }

    /**
     * Set the value of create_at
     *
     * @return  self
     */ 
    public function setCreate_at($create_at)
    {
        $this->create_at = $create_at;

        return $this;
    }

    /**
     * Get the value of updated_at
     */ 
    public function getUpdated_at()
    {
        return $this->updated_at;
    }

    /**
     * Set the value of updated_at
     *
     * @return  self
     */ 
    public function setUpdated_at($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * Get the value of verified_at
     */ 
    public function getVerified_at()
    {
        return $this->verified_at;
    }

    /**
     * Set the value of verified_at
     *
     * @return  self
     */ 
    public function setVerified_at($verified_at)
    {
        $this->verified_at = $verified_at;

        return $this;
    }
    public function create()
    {
        $query = "INSERT INTO student (name,email,password,code) 
        VALUES ('$this->name','$this->email','$this->password',$this->code)";
        // print_r($query);die;
        return $this->runDML($query);
    }
    public function read()
    {
        
    }
    public function update()
    {
        $query = "UPDATE student 
        SET name = '$this->name'";
        // if($this->image){
        //     $query .= ",image = '$this->image'";
        // }
        $query .= $this->image ? ",image = '$this->image'" :  "";
        $query .= " WHERE email = '$this->email'";
        return $this->runDML($query);

    }
    public function delete()
    {
        
    }
    public function checkIfEmailExists()
    {
        $query="SELECT * from student WHERE email='$this->email'";
        return $this->runDQL($query);
    }
    public  function checkCode()
    {
        $query="SELECT * from student WHERE email='$this->email' and code='$this->code'";
        return $this->runDQL($query);
    }
    public  function verifyMail()
    {
        $query = "UPDATE student SET verified_at = '$this->verified_at' WHERE email = '$this->email'";
        return $this->runDML($query);
    }
    public function login()
    {
        $query="SELECT * FROM student WHERE email = '$this->email' AND password = '$this->password'";
        return $this->runDQL($query);
    }
    public function updateCode()
    {
        $query = "UPDATE student SET code = '$this->code' WHERE email = '$this->email'";
        return $this->runDML($query);
    }
    public function updatePassword()
    {
        $query = "UPDATE student SET password = '$this->password' WHERE email = '$this->email'";
        return $this->runDML($query);
    }
}
