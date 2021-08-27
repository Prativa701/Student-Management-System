<?php
    final class User extends Database{
        use DataTraits;

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

        public function getUserByCookie($cookie){
            $attr = array(
                'where' => array(
                    'remember_token' => $cookie
                )
            );
            return $this->select($attr);
        }

        

        public function updateUserRaw($user_data,$id){
            $this->sql = "UPDATE users SET remember_token = '".$user_data['remember_token']."' WHERE id= .$id";
            $status = $this->runRaw();

            if($status){ //if status is success
                return $id;
            }else{
                return false;
            }
        }
        
        
    }
