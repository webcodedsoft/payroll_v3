<?php


class Classes_Validations
{
    private $_passed = false, $_errors = array(), $_query = null;


    public function __construct()
    {
        $this->_query = Classes_Db::getInstance();
    }


    public function checkRules($source, $items = array()){

        //
        foreach ($items as $item => $rules) {
            //var_dump($items);
            foreach ($rules as $rule => $rule_value) {
             $value = $source[$item];
                $item_name = $rules["name"];
              // var_dump($item);
             if($rule === 'required' && empty($value)){
                 $this->addError("{$item_name} is required");
             }else {
                 switch ($rule) {
                    case 'email_matches':
                            if (!preg_match('/^([a-zA-Z0-9_.-]+)\@([a-zA-Z0-9_.-]+)\.([a-zA-Z0-9_.-]+)$/', $source[$item])) {
                                $this->addError("{$item_name} is not valid!!!, Please Try Again");
                            }
                    break;
                    case 'email_unique':
                            $check = $this->_query->get('company', array('Company_Email', '=', $source[$item]));
                            if ($check->count()) {
                                $this->addError("Email already registered, Please Try Again");
                            }
                    break;

                    case 'unique_id':
                    $check = $this->_query->get('company', array('Company_ID', '=', $source[$item]));
                    if ($check->count()) {
                        $this->addError("ID already registered, Please Try Again");
                    }
                    break;

                    case 'is_number':
                          if ( !is_numeric($source[$item])) {
                                $this->addError("{$item_name} Suppose to be number");
                          }
                    break;

                    case 'user_email_unique':
                            $check = $this->_query->get('users', array('Email', '=', $source[$item]));
                            if ($check->count()) {
                                $this->addError("Email already registered, Please Try Again");
                            }
                    break;

                    case 'confirm_match':
                            if($value != $source[$rule_value]){
                                $this->addError("{$item_name} must match ");
                            }
                    break;

                   
                            
                 }
             }

            }
        }

        if(empty($this->_errors)){
            $this->_passed = true;  
        }
        return $this;
    }



    public function addError($error){
        $this->_errors[] = $error;
    }


    public function errors()
    {
       return $this->_errors;
    }

    public function passed()
    {
        return $this->_passed;
    }


}
