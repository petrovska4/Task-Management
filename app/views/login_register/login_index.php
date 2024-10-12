<?php
include_once "../header.php";

?>
<div class="container">
    <div style="margin-top:50px;" class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
        <div class="panel panel-info" >
            <div class="panel-heading">
                <div class="panel-title">Sign In</div>
                <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#">Forgot password?</a></div>
            </div>     

            <div style="padding-top:30px" class="panel-body" >

                <!-- <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div> -->

                <form action="../../controllers/login.php" class="form-horizontal" method="post" role="form">
                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                    </div>
                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="input-group">
                        <div class="checkbox">
                            <label>
                              <!-- this is cookie -->
                              <input id="remember" type="checkbox" name="remember" value="1"> Remember me
                            </label>
                        </div>
                    </div>

                    <div style="margin-top:10px" class="form-group">
                        <div class="col-sm-4 controls">
                            <button class="btn btn-lg btn-primary btn-block" type="submit">Log in</button>
                        </div>
                    </div>
                </form> 


                <div class="form-group">
                    <div class="col-md-12 control">
                        <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                            Don't have an account! 
                            <a href="register_index.php">Sign Up Here</a>
                        </div>
                    </div>
                </div>    
            </div>                     
        </div>  
    </div>
</div>

<?php
include_once "../footer.php";
?>