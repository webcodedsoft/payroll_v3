<?php

class Classes_Session
{
    public static function exsit($name){
        return (isset($_SESSION[$name])) ? true : false;
    }

    public static function put($name, $value){
        return $_SESSION[$name] = $value;
    }

    public static function get($name){
        return $_SESSION[$name];
    }

    public static function delete($name){
        if(self::exsit($name)){
            unset($_SESSION[$name]);
        }
    }
}

// ["Performance" => "Active", "Configuration" => "Active", "Employee" => "Active", "Payroll" => "Active", "Report" => "Active", "Completion" => "Active", "Setting" => "Active"]
// ["Read"=> "true", "Write" => "true", "Create" => "true", "Delete" => "true", "Lock" => "true", "Unlock" => "true"]