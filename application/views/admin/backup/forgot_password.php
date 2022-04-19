<!DOCTYPE html>
<html lang="en">


<head>
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

                
                    <div class="form-content">
                        <div class="logo-login"> <img src="assets/img/logo_login.png" alt=""> </div>

                        <h1 class="">Forgot Password </h1>
                        <p class="signup-link">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur . </p>
                        <form class="text-left" id="formoid" method="post">
                            <div id='required' style="display:none" class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <span id="showMsg"></span>
                        </div>
                        <div style="display:none" id="required1" class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>  
                             <span id="showMsg1"></span>
                        </div>
                            <div class="form">
                                <div id="username-field" class="field-wrapper input">
                                    <img  class="msg" src="assets/img/msg.svg" alt="">
                                    <input name="login_email" id="emailID" type="email" class="form-control" placeholder="Enter email id">
                                </div>       
                                <div class="field-wrapper pt-3">
                                    <!--<a href="#" class="btn btn-primary main_btn mt-2" value="">Submit</a>-->
                                    <input type="submit" name="submit" class="btn btn-primary main_btn mt-2" value="Submit" >
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
                    $("#showMsg").text("This email is not found, Please try with the valid Email!");
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