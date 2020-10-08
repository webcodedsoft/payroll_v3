<?php
class Classes_Upload
{

    
    private static $__static_path = "../../Folders/Company_Folders/";
    
    public static function uploading($file, $newname, $path){
        $empty_img_arr = array();

        $storage = array_map('Classes_Converter::FileSize', array(Classes_Session::get("Free_Storage")));

        $file_size = 0;
        foreach ($file['tmp_name'] as $keys => $value) {
            $file_size += $file['size'][$keys];
        }

        $remaining_storage = $storage[0] - $file_size;
        // echo json_encode($storage[0]."<br>");
        // echo json_encode($file_size . "<br>");
        // echo json_encode($remaining_storage . "<br>");

        if ($storage[0] >= $file_size) {
            

            $path_exist = Classes_Folder::exist($path); 

            if ($file['name'] != null) {
                $iterate = 0;
            
                foreach ($file['tmp_name'] as $key => $value) {
                    $temp_file = $file['tmp_name'][$key];
                    $targetDir = self::$__static_path.$path_exist; //'../../images/company_images/';
                    
                    $filename = explode(".", $file['name'][$key]);

                    $newname = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $newname)));

                    $newfilename = $newname .'_'. $iterate++. '.' . end($filename);
                    $targetFile =  $targetDir . '/' . $newfilename;

                    unlink($targetDir . '/' . $newname . '.png');
                    unlink($targetDir . '/' . $newname . '.jpg');
                    unlink($targetDir . '/' . $newname . '.jpeg');
                    unlink($targetDir . '/' . $newname . '.gif');

                    if (move_uploaded_file($temp_file, $targetFile)) {
                         $empty_img_arr[] = $newfilename;
                         $all_file = implode(',', $empty_img_arr);
                    }
                
                }
                
                 $files = !empty($all_file) ? $all_file : false;
                return array('Message' => $files, "Status" => 'Done' );
            }
            else {
                return array('Message' => false, "Status" => 'No Image');
            }

        } else {
            $msg = "File Unable to Save Your Storage is low";
            return array('Message' => $msg, "Status" => 'Low Storage');
        }

        
    } 




    public static function get($path){

        $full_path_default= self::$__static_path . $path;
        $file_in_path_default = array_diff(scandir($full_path_default), array('.', '..'));

        if(Classes_Inputs::get("folder_name")){
            $full_path = self::$__static_path . $path;
            $file_in_path = array_diff(scandir($full_path), array('.', '..'));
        }
        else{
            $full_path = self::$__static_path . $path.'/Logo';
            $file_in_path = array_diff(scandir($full_path), array('.', '..'));
        }
        
        //var_dump($full_path);
        return array("Path" => $full_path, "Files" => $file_in_path, "Default_Path" => $full_path_default, "Default_Files" => $file_in_path_default);
    }



    public static function getFolders($path){
        $folder_name_array = array();
        $folder_file_count = array();

        $folders = array_filter(glob(self::$__static_path . $path . '/*', GLOB_ONLYDIR), "is_dir");
        if (count($folders) > 0) {
            foreach ($folders as $key => $folder) {
                //find the last word from dir
                $folder_name = strrpos($folder, '/') + 1; //Just to make sure we dont include / in the result
                $folder_name_array[] = substr($folder, $folder_name);
                $folder_file_count[] = count(scandir($folder)) - 2;
               // return ["Folder_Name" => $folder_name_array, "Folder_File_Count" => count(scandir($folder)) - 2];
                //var_dump(count(scandir($folder)) - 2);
            }
        }
        return ["Folder_Name" => $folder_name_array, "Folder_File_Count" => $folder_file_count];

    }



  public static function deleteimage($filename, $path){
        $targetDir = self::$__static_path.$path;
        if(unlink($targetDir . '/' . $filename)){
            return true;
        }
        return false;
  }
}
