<?php

class Classes_Inputs{

    public static function exists($type = 'post'){
        switch ($type) {
            case 'post':
                return (!empty($_POST)) ? true : false;
                break;

            case 'get':
                return (!empty($_GET)) ? true : false;
                break;

            default:
                return false;
                break;
        }
    }

    public static function get($item){
        if(isset($_POST[$item])){
            return $_POST[$item] == 'null' ? '' : $_POST[$item];
        }elseif (isset($_GET[$item])) {
            return $_GET[$item] == 'null' ? '' : $_GET[$item];
        }
        return ''; 
    }


    public static function MultipleGet($params){
        //Retrive the path passing here
        if ($params) {
            $post = $_POST;
            $params_paths = explode('/', $params); //Remove the path seperetor /

            foreach ($params_paths as $param_path) { //Loop through the path
                //print_r($config[$path]);
                if (isset($post[$param_path])) { // Check if the path is exist in the GLOBALS config 
                    $post = $post[$param_path];
                }
            }

            return $post;
        }
        return false;
    }
}