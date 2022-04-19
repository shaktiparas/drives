
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
        <title>ECUTZ</title>
        <link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/img/favicon.png" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/plugins.css" rel="stylesheet" type="text/css" />
        
        <link href="<?php echo base_url(); ?>assets/css/form-1.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
    
        <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
        <link href="<?php echo base_url(); ?>plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
        <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    
    </head>
<body class="form">

    <div class="form-container">
       
        <div class="form-image">
            <div class="l-image">
             
            </div>
        </div>
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                <?php $this->load->helper('form'); ?>
                
                    <div class="form-content">
                        <div class="logo-login"> <img src="assets/img/logo_login.png" alt=""> </div>

                        <h1 class="">Welcome to <a href="#"><span class="brand-name">LOGIN</span></a></h1>
                        <p class="signup-link">To keep connected with us please login with your personal
                            information by email and password</p>
                            <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                                                           <div class="col-md-12">
                                                <?php
                                                $error = $this->session->flashdata('error');
                                                if($error)
                                                {
                                                    ?>
                                                    <div class="alert alert-danger alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                        <?php echo $error; ?>                    
                                                    </div>
                                                <?php }
                                                $success = $this->session->flashdata('success');
                                                if($success)
                                                {
                                                ?>
                                                <div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                    <?php echo $success; ?>                    
                                                </div>
                                                <?php } ?> 
                                            </div>
                            
                        <form class="text-left" action="<?php echo base_url(); ?>loginMe" method="post" role="form" enctype="multipart/form-data" >
                            <div class="form">

                                <div id="username-field" class="field-wrapper input">
                                    <img  class="msg" src="<?php echo base_url(); ?>assets/img/msg.svg" alt="">
                                    <input id="validationCustom08" name="email" type="email" class="form-control" placeholder="Username" value="<?php if(isset($_COOKIE["email"])) { echo $_COOKIE["email"]; } ?>" required="">
                                </div>

                                <div id="password-field" class="field-wrapper input mb-2">
                                   <img src="<?php echo base_url(); ?>assets/img/password.svg" alt="">
                                    <input id="validationCustom09" name="password" type="password" class="form-control" placeholder="Password" value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"]; } ?>" required="">
                                    <div class="d-flex mt-1 forgotpwd"> <div class="custom-control custom-checkbox mb-3">
    <input type="checkbox" class="custom-control-input" id="customCheckDisabled"  name="remember" <?php if(isset($_COOKIE["email"])) { ?> checked <?php } ?> >
    <label class="custom-control-label" for="customCheckDisabled">   <h5> Remember Password</h5></label>
</div>   <a href="<?php echo base_url(); ?>forgotPassword">Forgot Password? </a>  </div>
                                </div>
                              
                             
                                    
                                    <div class="field-wrapper pt-3">
                                        <!--<a href="" class="btn btn-primary main_btn mt-2" value="">Log In</a>-->
                                        <input type="submit" class="btn btn-primary main_btn mt-2 " value="Log In" >
                                    </div>
             
                            </div>
                        </form>                        
                    

                    </div>                    
                </div>
            </div>
        </div>
       
    </div>

       <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
       <script src="<?php echo base_url(); ?>assets/js/jquery-3.1.1.min.js"></script>
       <script src="<?php echo base_url(); ?>bootstrap/js/popper.min.js"></script>
       <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
       <script src="<?php echo base_url(); ?>plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
       <script src="<?php echo base_url(); ?>assets/js/app.js"></script>
       <script>
           $(document).ready(function() {
               App.init();
           });
       </script>
       <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
       <!-- END GLOBAL MANDATORY SCRIPTS -->
   
       <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
       <script src="<?php echo base_url(); ?>plugins/apex/apexcharts.min.js"></script>
       <script src="<?php echo base_url(); ?>assets/js/dash_1.js"></script>
       
       
       <script type='text/javascript'>
    $("#formoid").submit(function(event) {
        event.preventDefault();
        var email = $("#emailID").val();
        dataString = "login_email="+email
        $.ajax({ 
            type: 'post',    
            url: '<?php echo base_url() ?>Login/forgotPasswordMail',
            data: dataString,
            cache: false,
            success: function(res) {
                if(res == 2){
                    $("#required").show();
                    $("#showMsg").text("Email is required");
                }
                 if(res == 3){
                    $("#required").show();
                    $("#showMsg").text("This email is not associated with OMDA account, Please try with the valid Email!");
                }
                 if(res == 4){
                    $("#required").show();
                    $("#showMsg").text("Email error");
                }
                 if(res == 1){
                    $("#required1").show();
                    $("#showMsg1").text("Please check your e-mail, we have sent a password reset link to your registered Email.");
                } 
            }
        });
    });
</script>
</html>