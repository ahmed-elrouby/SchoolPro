<?php 

class checkCodeRequest {
    private $code;
    

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

    public function codeValidation()
    {
        $errors = [];
        // required
        if(empty($this->code)){
            // $errors['code-required'] = "<div class='alert alert-danger'> Code Is Required </div>";
            $errors['code-required'] = "<div class='flex' style='color:red;font-size:16px'>حقل الكود مطلوب</div>";
        }else{
            // numeric
            if(!is_numeric($this->code)){
                // $errors['code-numeric'] = "<div class='alert alert-danger'> Code Must Be a number </div>";
                $errors['code-numeric'] = "<div class='flex' style='color:red;font-size:16px'>يجب ان يكون الكود ارقام فقط</div>";
            }else{
                // 5 digits
                if(strlen($this->code) != 5){
                    // $errors['code-invalid'] = "<div class='alert alert-danger'> Invalid Code </div>";
                    $errors['code-invalid'] = "<div class='flex' style='color:red;font-size:16px'>كود خاطئ</div>";
                }
            }
        }
       
       
        
        return $errors;
    }
}