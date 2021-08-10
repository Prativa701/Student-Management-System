<?php
abstract class Database{
    protected $conn = null;
    protected $sql = null;
    protected $stmt = null;

    public function __construct(){
        try{
        $this->conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME."",DB_USER,DB_PWD);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        
        //to solve unicode prblm
        $this->sql = "SET NAMES utf-8";
        $this->stmt = $this->conn->prepare($this->sql);
        $this->stmt->execute;

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
}
?>