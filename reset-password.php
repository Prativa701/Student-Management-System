<?php
        require_once "config/init.php";
        require_once "inc/header.php";
        $user = new User();

        if(isset($_SESSION, $_SESSION["token"]) && !empty($_SESSION["token"])){
            redirect("dashboard.php","success","You are already logged in.");
        }

        if(isset($_GET['token']) && !empty($_GET['token'])){
            $token = sanitize($_GET['token']);
            $user_info = $user->getUserFromForgetToken($token);
            if(!$user_info){
                redirect("./","warning","Invalid or broken token specified.");
            }
            setSession("reset_user",$user_info[0]->id);
            setSession("forget_token", $token);
           // debug($token);
        }else{
            redirect("./","warning","You do not have access to this page.");
        }
?>

<div class="container">

<!-- Outer Row -->
<div class="row justify-content-center">

  <div class="col-xl-6 col-lg-6 col-md-6">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          
          <div class="col-lg-12">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Set New Password</h1>
                <p>Enter You registered email for reset password.</p>
              </div>

              
              <form class="user" method ="POST" action = "process/reset.php">

                <?php  flash(); ?>

                <div class="form-group">
                  <input type="password" class="form-control form-control-user" name="password" required id="password"  placeholder="Enter Password...">
                </div>

                <div class="form-group">
                  <input type="password" class="form-control form-control-user" name="re_password" required id="re-password"  placeholder="Enter Password Again..">
                </div>
                
                <button type="submit" class="btn btn-primary btn-user btn-block">
                  Reset Password
                </button>

              </form>
              <hr>
              
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

</div>

</div>
<?php
    require_once 'inc/footer.php';
?>
