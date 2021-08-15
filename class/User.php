<?php
    final class User extends Database{

        public function __construct(){
            parent::__construct(); 
            $this->table = "users"; //setting this var. in above constructor
        } 

        public function getUserByEmail($email){ //this function executes 'Select * from users where email=$email'
           //Select * from users where email = $email [we've to generate this query from $attr]
            $attr = array(
                //'fields' => "id, email, name, password, role",        //when fields are sent in string
                //'fields' => ["id","name","email","password","role"],  //in array
               // 'where' => "email = '".$email."'"                     //when where sent in string
                'where' => array(                                       //in array
                    'email' => $email
                )

           );
           return $this->select($attr);
        }
    }
?>