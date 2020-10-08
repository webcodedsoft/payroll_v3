<?php

class Classes_Config
{

    public static function getConfig($paths = null)
    {
        //Retrive the path passing here
        if ($paths) {
            $config = $GLOBALS["config"];
            $paths = explode('/', $paths); //Remove the path seperetor /

            foreach($paths as $path){ //Loop through the path
                //print_r($config[$path]);
                if(isset($config[$path])){ // Check if the path is exist in the GLOBALS config 
                    $config = $config[$path];
                }
            }

            return $config;
        }
        return false;
    }
}
