<?php

class Classes_Folder
{
    private static $__static_path = "../../Folders/Company_Folders/";

    public static function create($path){
        return mkdir(self::$__static_path.$path, 0777, true);
    }

    public static function get(){

    }
 
    public static function exist($pathname){
        if(!file_exists(self::$__static_path.$pathname) && !is_dir(self::$__static_path.$pathname)){
            self::create($pathname);
            return $pathname;
        } else {
            return $pathname;
        }

       
    }


}
