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

                        <h1 class="">Please enter your new password</h1>
                        <p class="signup-link">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur . </p>
                        <?php $this->load->helper('form'); ?>
                        <form class="text-left" action=" <?php echo $url ?>forgotResetPassword" method="post" role="form" enctype="multipart/form-data">
                            <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
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
                             <div class="col-lg-6">
                                <a href="<?php echo $url;?>login"  class="btn btn-small btn-primary mt-4">Login</a>
                            </label>
                          </div>
                            <?php } else { ?> 
                            <div class="form">
                                
                                <div id="username-field" class="field-wrapper input">
                                    <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
                                    <img src="<?php echo base_url(); ?>assets/img/password.svg" alt="">
                                    <input id="validationCustom09" name="password" type="password" class="form-control" placeholder="Password" value="" required="">
                                </div>
                                <div id="username-field" class="field-wrapper input">
                                    <img src="<?php echo base_url(); ?>assets/img/password.svg" alt="">
                                    <input id="validationCustom09" name="confirm_password" type="password" class="form-control" placeholder="Confirm Password" value="" required="">
                                </div>
                                <div class="field-wrapper pt-3">
                                    <!--<a href="#" class="btn btn-primary main_btn mt-2" value="">Submit</a>-->
                                    <input type="submit" name="submit" class="btn btn-primary main_btn mt-2" value="Submit" >
                                </div>
                            </div>
                            <?php } ?>
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
  
</html>