<?php
require_once("../../core/init/init.php");
require_once("../admin/validation_rules.php");

$auth_model = new Model_AuthModel();

$_query = Classes_Db::getInstance();
$validate = new Classes_Validations();

echo "Reach";


// if(isset($_POST["login_btn"])){
//     if(Classes_Inputs::exists('post')){
//         $login_result = $auth_model->LoginValidation(Classes_Inputs::get("login_email"), Classes_Inputs::get("login_password"));

//         if(empty($_POST["login_password"])){
//             if ($login_result && $login_result["Plan_Name"] != '') {
//                 echo json_encode(array("Complete"));
//             } elseif ($login_result && $login_result["Plan_Name"] == '') {
//                 Classes_Session::put("Setup_Session", $login_result["Company_Email"]);
//                 echo json_encode(array("Exist"));
//             }
//             elseif ($login_result == "Not Admin") {
              
//             } 
//         } else {

//            // var_dump($login_result);
//             if ($login_result["Login_ID"] != '') {

//                 if (password_verify(Classes_Inputs::get("login_password"), $login_result['Password'])) {
                    
//                     Classes_Session::put("Loggedin_Session", $login_result["Subscriber_ID"]);
//                     Classes_Session::put("Login_ID", $login_result["Login_ID"]);
//                     echo json_encode(array("Logged"));
//                 } else {
//                     echo json_encode(array("Invalid Login Password"));
//                 }
//             }
//             else {
//                 echo json_encode(array("Invalid Login Email"));
//             }
//         }
        
     
        
//     }
// }

// if(isset($_POST["login_btn"])){
//     if(Classes_Inputs::exists('post')){

//         if(Classes_Inputs::get("login_email")){
//             $auth_result = $auth_model->EmailValidation(Classes_Inputs::get("login_email"));
//             if ($auth_result["Plan_Name"] != '') {

//                 echo json_encode(array("Complete"));

//             } elseif ($auth_result && $auth_result["Plan_Name"] == '') {

//                 Classes_Session::put("Setup_Session", $auth_result["Company_Email"]);
//                 echo json_encode(array("Exist"));

//             } elseif (Classes_Inputs::get("login_password") && Classes_Inputs::get("login_email")) {

//                 $login_result = $auth_model->LoginValidation(Classes_Inputs::get("login_email"), Classes_Inputs::get("login_password"));
//             echo json_encode(array("Yes"));
//             //    if($login_result){
//             //         Classes_Session::put("Loggedin_Session", $auth_result["Subscriber_ID"]);
//             //         Classes_Session::put("Login_ID", $login_result["Login_ID"]);
//             //     }

//             } else {
//                 echo json_encode(array("Invalid Input"));
//             }
//         }

            
        
//     }
    
// }