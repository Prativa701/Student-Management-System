<?php
abstract class Database{
    protected $conn = null;
    protected $sql = null;
    protected $stmt = null;

    protected $table = null;

    public function __construct(){
        try{
        $this->conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";",DB_USER,DB_PWD);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        
        //to solve unicode prblm
        $this->sql = "SET NAMES utf-8";
        $this->stmt = $this->conn->prepare($this->sql);
        $this->stmt->execute();

        }catch(PDOException $e){
            //2021-07-24 10:31 AM: Connection(PDO), Error establishing error connection
            //2021/../.. next line display
            $msg = date('Y-m-d h:i:s A: ')."Connection(PDO), ".$e->getMessage()."\r\n";
            error_log($msg,3,ERROR_LOG); //errormsg,msgtype,pathtostore
        }catch(Exception $e){
            $msg = date('Y-m-d h:i:s A: ')."Connection(General), ".$e->getMessage()."\r\n";
            error_log($msg,3,ERROR_LOG); //errormsg,msgtype,pathtostore
        }
    }

    final protected function select($attr = array(),$is_debug = false){
     try{
            //SELECT <fields> FROM <table>

            $this->sql = 'SELECT ';

            if(isset($attr['fields'])){
                //select only those fields
               if(is_string($attr['fields'])){
                   $this->sql .= $attr['fields'];
               }else{
                   $this->sql .= implode(", ", $attr['fields']);
               }
            }else{
                $this->sql .= "*";
            }

                $this->sql .= " FROM ";

                if(!isset($this->table) || empty($this->table)){
                    throw new Exception("Table not set.");
                }

                $this->sql .= $this->table;

            //JOIN OPERATION HERE

            //WHERE OPERATION
                if(isset($attr['where']) && !empty($attr['where'])){
                    if(is_string($attr['where'])){
                        $this->sql .= " WHERE " .$attr['where'];
                    }else{
                        $temp = array();
                        foreach($attr['where'] as $column_name => $value){
                            $str = $column_name." = :".$column_name;
                            $temp[] = $str;
                        }
                        $this->sql .= " WHERE ".implode(" AND ",$temp);
                    }
                }


            if($is_debug){
                debug($attr);
                debug($this->sql, true);
            }

            //after placing every data in sql conver into prepared statement
                $this->stmt = $this->conn->prepare($this->sql); //pass the sql

                if(isset($attr['where']) && !empty($attr['where']) && is_array($attr['where'])){
                    //bind your email value in :column_name , create loop
                    foreach($attr['where'] as $column_name=>$value){
                        if(is_int($value)){
                            $param = PDO::PARAM_INT;
                        }else if(is_bool($value)){
                            $param = PDO::PARAM_BOOL;
                        }else{
                            $param = PDO::PARAM_STR;
                        }

                        if($param){
                            $this->stmt->bindvalue(":".$column_name, $value, $param); // :key,value,datatype
                        }
                    }
                }

                $this->stmt->execute(); //after ps op. performed execute
                $data = $this->stmt->fetchAll(PDO::FETCH_OBJ); //Then fetch data
                return $data;

        }catch(PDOException $e){
            //2021-07-24 10:31 AM: Connection(PDO), Error establishing error connection
            //2021/../.. next line display
            $msg = date('Y-m-d h:i:s A: ')."Select(PDO), ".$e->getMessage()."\r\n";
            error_log($msg,3,ERROR_LOG); //errormsg,msgtype,pathtostore
        }catch(Exception $e){
            $msg = date('Y-m-d h:i:s A: ')."Select(General), ".$e->getMessage()."\r\n";
            error_log($msg,3,ERROR_LOG); //errormsg,msgtype,pathtostore
        }

    }


    final protected function update($data = array(), $attr = array(),$is_debug = false){
        try{
               /**UPDATE <table> 
                    SET column_name = :_column_name,
                    <column_name_n> = :_column_name_n
                    WHERE
                    <column_name> =
                    **/
   
               $this->sql = 'UPDATE ';
   
                   if(!isset($this->table) || empty($this->table)){
                       throw new Exception("Table not set.");
                   }
   
                   $this->sql .= $this->table." SET ";
   
               //DATA OPERATION HERE
               if(isset($data) && !empty($data)){
                if(is_string($data)){
                    $this->sql .= $data;
                }else{
                    $temp = array();

                    foreach($data as $column_name => $value){
                        $str = $column_name." = :_".$column_name;
                        $temp[] = $str;
                    }
                    $this->sql .=implode(" , ", $temp);
                }
            }else{
                throw new Exception("Data not set for update");
            }
   
               //WHERE OPERATION
                   if(isset($attr['where']) && !empty($attr['where'])){
                       if(is_string($attr['where'])){
                           $this->sql .= " WHERE " .$attr['where'];
                       }else{
                           $temp = array();
                           foreach($attr['where'] as $column_name => $value){
                               $str = $column_name." = :".$column_name;
                               $temp[] = $str;
                           }
                           $this->sql .= " WHERE ".implode(" AND ",$temp);
                       }
                   }
   
   
               if($is_debug){
                   debug($attr);
                   debug($this->sql, true);
               }
   
               //after placing every data in sql convert into prepared statement
                   $this->stmt = $this->conn->prepare($this->sql); //pass the sql

                   if(isset($data) && !empty($data) && is_array($data)){
                    //if data is not empty and is array type, create loop
                    foreach($data as $column_name=>$value){
                        if(is_int($value)){
                            $param = PDO::PARAM_INT;
                        }else if(is_bool($value)){
                            $param = PDO::PARAM_BOOL;
                        }else{
                            $param = PDO::PARAM_STR;
                        }

                        if($param){
                            $this->stmt->bindvalue(":_".$column_name, $value, $param); // :key,value,datatype
                        }
                    }
                }

   
                   if(isset($attr['where']) && !empty($attr['where']) && is_array($attr['where'])){
                       //bind your email value in :column_name , create loop
                       foreach($attr['where'] as $column_name=>$value){
                           if(is_int($value)){
                               $param = PDO::PARAM_INT;
                           }else if(is_bool($value)){
                               $param = PDO::PARAM_BOOL;
                           }else{
                               $param = PDO::PARAM_STR;
                           }
   
                           if($param){
                               $this->stmt->bindvalue(":".$column_name, $value, $param); // :key,value,datatype
                           }
                       }
                   }
   
                   return $this->stmt->execute(); //after ps op. performed execute
                   
   
           }catch(PDOException $e){
               //2021-07-24 10:31 AM: Connection(PDO), Error establishing error connection
               //2021/../.. next line display
               $msg = date('Y-m-d h:i:s A: ')."Update(PDO), ".$e->getMessage()."\r\n";
               error_log($msg,3,ERROR_LOG); //errormsg,msgtype,pathtostore
           }catch(Exception $e){
               $msg = date('Y-m-d h:i:s A: ')."Update(General), ".$e->getMessage()."\r\n";
               error_log($msg,3,ERROR_LOG); //errormsg,msgtype,pathtostore
           }
   
       }


    final protected function runRaw($is_debug= false){
        try{
            if($is_debug){
                debug($this->sql,true);
            }

            $this->stmt = $this->conn->prepare($this->sql);
            return $this->stmt->execute();

        }catch(PDOException $e){
            $msg = date("Y-m-d h:i:s A: ")."Run Raw(PDO), ".$e->getMessage()."\r\n";
            error_log($msg,3,ERROR_LOG);
        }catch(Exception $e){
            $msg = date("Y-m-d h:i:s A: ")."Run Raw(General), ".$e->getMessage()."\r\n";
            error_log($msg,3,ERROR_LOG);
        }
    }
}
?>