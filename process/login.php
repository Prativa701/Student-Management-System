<?php
    require_once "../config/init.php";
    $user = new User;
    if(isset($_POST) && !empty($_POST)){
       $email = filter_var($_POST['email'],FILTER_VALIDATE_EMAIL);
       if(!$email){ //if email is not in email format
           redirect("../","error","Inavlid email format");
       }
       //validate email with users

       $user_info = $user->getUserByEmail($email); //this function executes 'Select * from users where email=$email' 
       if($user_info){
           //user exist
            if(password_verify($_POST['password'], $user_info[0]->password)){
                //username and password match
                if($user_info[0]->status == "active"){
                    //allowed to acess system

                    setSession("user_id",$user_info[0]->id);
                    setSession("name",$user_info[0]->name);
                    setSession("email",$user_info[0]->email);
                    setSession("role",$user_info[0]->role);
                    setSession("status",$user_info[0]->status);
                    setSession("image",$user_info[0]->image);
                    
                    //token is set for remember_me i.e. remember_token
                    $token = generateRandomString(100);
                    setSession("token",$token);
                    //debug($token,true);

                    if(isset($_POST['remember_me']) && !empty($_POST['remember_me'])){
                        setcookie("_au",$token,time()+864000,"/"); //nem,token,time(we've set login validity for 10 days),path
                        $user_data = array(
                            'remember_token'=> $token
                        );
                        $user->updateById($user_data,$user_info[0]->id);
                    }

                    //finally, ready to access our system,to access user
                    redirect("../dashboard.php","success","Welcome to Admin Panel");

                }else{
                    //not allowed to access since user not active 
                    redirect("../","error","You account is currently disabled to access.");
                }
            }else{
                //password does not match
                redirect("../","error","User Credential does not match");
            }
       }else{
           redirect("../","error","User does not exist");
       }
    
    }else{
        redirect("../","warning","Please Login First");
    }
   

