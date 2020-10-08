<?php

class model_authmodel 
{
    public function __construct()
    {
        $this->_query = Classes_Db::getInstance();
    }

    
    public function EmailValidation($email_address){

        $result = $this->_query->get('company', array('Company_Email', '=', $email_address));
        if ($result->count()) {
            return $result->first();
        }
        else{
            return false;
        }

    }

    public  function LoginValidation($login_email, $login_password ){

        if(empty($login_password)){
            $result = $this->_query->get('company', array('Company_Email', '=', $login_email));
            if ($result->count()) {
                return $result->first();
            } else {
                return "Not Admin";
            }
        }
        else {

            $login_result = $this->_query->get('logindetail', array('Email', '=', $login_email));
            if ($login_result->count()) {
                return $login_result->first();
                //return $login_result->first();
                //var_dump($login_result->first());
            } else {
                return false;
            }

        }
       
        // $login_result = $this->_query->get('logindetail', array('Email', '=', $login_email));

        // if ($login_result->count()) {

        //     $login_data = $login_result->first();
        //     $login_data["Subscriber_ID"];
        //     $login_data["Login_ID"];
        //     $login_data["Password"];

        //     //return $login_result->first();
        //     var_dump($login_result->first());
        // } else {
        //     return false;
        // }
    }
}
