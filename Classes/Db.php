<?php

class Classes_Db{
    private static $_db_instance, $_con_db;
    private $_query, $_error = false, $_results = null, $_count =0;

    private function __construct(){
        self::$_con_db = new mysqli(Classes_Config::getConfig("mysql/hostname"), Classes_Config::getConfig("mysql/username"), Classes_Config::getConfig("mysql/password"), Classes_Config::getConfig("mysql/db_name"));
        if (mysqli_connect_errno(self::$_con_db)) {
            echo mysqli_connect_error();
        }
        
    }


    public static function getInstance()
    {
        if(!isset(self::$_db_instance)){
            self::$_db_instance = new Classes_Db();
        }
        return self::$_db_instance;
    }



    public function query($sql, $params = array()){
        
        $this->_error = false;
        $this->_results = null;
        //$this->_query = mysqli_stmt_init(self::$_con_db);
        if ($stmt = self::$_con_db->prepare($sql)) {

            if (count($params)) {
                $types = str_repeat('s', count($params)); //add data type base on array count 
                //var_dump($params);
                foreach ($params as $param) {
                    $stmt->bind_param($types, ...$params);
                }
            }
            
            //var_dump($stmt);
            if($stmt->execute()){
                $this->_query = $stmt->get_result();
                $this->_count = 0;

                $this->_count = $stmt->affected_rows;

                if(!$this->_query){
                    $this->_count = $stmt->affected_rows;
                }
                elseif($this->_count > 0){
                    // while ($row = $this->_query->fetch_object()) {
                    //     $this->_results[] = $row;
                    // }
                    $this->_results =  $this->_query->fetch_all(MYSQLI_ASSOC);
                    
                }
              

                $stmt->close();
            }
        }


        return $this;
    }


    public function action($action, $table, $where = array())
    {
        
            $operators = array('=', '>', '<', '>=', '<=', '!=' );
            $table_col = $where[0];
            $operator = $where[1];
            $value = $where[2];

            if(in_array($operator, $operators)){
                $sql = "{$action} FROM {$table} WHERE {$table_col} {$operator} ?  ";

            //print_r($sql);
                if(!$this->query($sql, array($value))->error()){
                    return $this;
                }
            }
        return false;
    }


    public function get($table, $where )
    {
        return $this->action('SELECT *', $table, $where);
    }


    public function delete($table, $where)
    {
        return $this->action('DELETE', $table, $where);
    }


    public function insert($table, $fields)
    {
        if(count($fields)){
            $table_col = array_keys($fields);
            $data_value_placeholder = '';
            $iterate = 1;

            $data_value = array_values($fields);
            
            //var_dump(array_values($fields));
            foreach ($fields as $field) {
                $data_value_placeholder .='?';
                if($iterate < count($fields)){
                    $data_value_placeholder .=', ';
                }
                $iterate++;
            }
            $sql = "INSERT INTO {$table} (" . implode( ', ', $table_col ) . ") VALUES ({$data_value_placeholder})";
            //var_dump($sql);
            if(!$this->query($sql, $data_value)){
                return true;
            }

        }

        return false;
    }


    public function update($table, $condition, $fields)
    {
        $set = '';
        $iterate = 1;
        $where_table = array_keys($condition);
        $condition_value = array_values($condition);
        $where_table = $where_table[0];
        $condition_value = $condition_value[0];

        $data_value = array_values($fields);
        //var_dump($data_value);
        
        foreach ($fields as $name => $value) {
            $set .= "{$name} = ?";
            if($iterate < count($fields)){
                $set.= ', ';
            }
            $iterate++;

            
        }
        $sql = "UPDATE {$table} SET {$set} WHERE {$where_table} = '$condition_value'";
        if (!$this->query($sql, $data_value)) {
            return true;
        }
        // var_dump($sql);
        // var_dump($data_value);
        return $this;
    }


    public function results()
    {
        return $this->_results;
    }

    public function first()
    {
        return $this->results()[0];
    }

    public function error()
    {
        return $this->_error;
    }

    public function count()
    {
        return $this->_count;
    }

}


