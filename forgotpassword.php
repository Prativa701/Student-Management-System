<?php
     require_once "config/init.php";
     require_once "inc/header.php";

    if(isset($_SESSION, $_SESSION["token"]) && !empty($_SESSION["token"])){
          redirect("dashboard.php","success","You are already logged in.");
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
                    <h1 class="h4 text-gray-900 mb-4">Forgot password?</h1>
                    <p>Enter You registered email for reset password.</p>
                  </div>

                  
                  <form class="user" method ="POST" action = "process/forget.php">

                    <?php  flash(); ?>

                    <div class="form-group">
                      <input type="email" class="form-control form-control-user" name="email" required id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Send Email
                    </button>

                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="./">Login</a>
                  </div>
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
