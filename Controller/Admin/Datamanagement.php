<?php

class Controller_Admin_Datamanagement{

    private static $_query;

    public function __construct()
    {
        self::$_query = Classes_Db::getInstance();
    }


    public function WebData(){
        return self::$_query->get('web_config', array('ID', '=', '1'));
    }

    public function SubscriptionPackage($plan_type)
    {
            return self::$_query->get('package_plan', array('Plan_Type', '=', $plan_type));
    }

    public function PackageCount(){
        return self::$_query->query('SELECT * FROM package_plan');
    }


}