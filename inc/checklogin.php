<?php
$user = new User;

//if data is set in cookie validate that data,
if(!isset($_SESSION['token']) || empty($_SESSION['token'])){

    if(isset($_COOKIE['_au']) && !empty($_COOKIE['_au'])){
        $cookie_token = sanitize($_COOKIE['_au']); //sanitize function to clean the data
        $user_info = $user->getUserByCookie($cookie_token);

        if($user_info){
            //user found
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

                
                 setcookie("_au",$token,time()+864000,"/"); //nem,token,time(we've set login validity for 10 days),path
                 $user_data = array(
                     'remember_token'=> $token
                 );
                 $user->updateById($user_data,$user_info[0]->id);
                

            }else{
                //not allowed to access since user not active 
                setcoookie("_au",time()-60,"/");
                redirect("../","error","You account is currently disabled to access.");
            }
        }else{
            //user not found
            setcoookie("_au",time()-60,"/");
            redirect("./","error","Please Login first,after clearing your cookie");
        }
    }else{
        redirect("./","error","Please Login First");
    }
}