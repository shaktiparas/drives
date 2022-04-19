<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Drive Admin </title>
    <!-- Favicon icon -->
    <!-- <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon.png"> -->
    <link href="<?php echo base_url();?>/assets/css/style.css" rel="stylesheet">
</head>
<body class="h-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    
                                    
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
                        
                         <?php $this->load->helper('form'); ?>
                         
                         
                                    <p><img src="<?php echo base_url();?>/assets/images/logo-text.png" class="img-fluid"></p>
                                    <h4 class="text-center mb-4 text-white">Sign in your account</h4>
                                    
                                    <form action="<?php echo base_url(); ?>loginMe" method="post">
                                        <div class="form-group">
                                            <label class="mb-1"><strong class="text-white">Email</strong></label>
                                            <input type="email" name="email" class="form-control" value="hello@example.com">
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong class="text-white">Password</strong></label>
                                            <input type="password" name="password" class="form-control" value="Password">
                                        </div>
                                        <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                            <div class="form-group">
                                               <div class="custom-control custom-checkbox ml-1">
													<input type="checkbox" class="custom-control-input" id="basic_checkbox_1">
													<label class="custom-control-label text-white" for="basic_checkbox_1">Remember me</label>
												</div>
                                            </div>
                                            <div class="form-group">
                                                <a href="forgot-password.html" class="text-white">Forgot Password?</a>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                                        </div>
                                    </form>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="<?php echo base_url();?>/assets/js/global.min.js"></script>
    <script src="<?php echo base_url();?>/assets/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url();?>/assets/js/custom.min.js"></script>
    <script src="<?php echo base_url();?>/assets/js/deznav-init.js"></script>
</body>
</html>