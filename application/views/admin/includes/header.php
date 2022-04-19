<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Drive Admin </title>
    <link href="<?php echo base_url();?>assets/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">
</head>
<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="<?php echo base_url();?>/dashboard" class="brand-logo">
                <img class="logo-abbr" src="<?php echo base_url();?>/assets/images/logo.png" alt="">
                <img class="logo-compact" src="<?php echo base_url();?>/assets/images/logo-text.png" alt="">
                <img class="brand-title" src="<?php echo base_url();?>/assets/images/logo-text.png" alt="">
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->
		
		<!--**********************************
            Chat box start
        ***********************************-->
	
		<!--**********************************
            Chat box End
        ***********************************-->
		
		<!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                       

                        <ul class="navbar-nav header-right ml-auto">
							
					
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                    <img src="<?php echo base_url();?>assets/images/profile/pic1.jpg" width="20" alt=""/>
                                    <div class="header-info">
                                        <span>Hello, <strong>Samuel</strong></span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="deznav">
            <div class="deznav-scroll">
				<ul class="metismenu" id="menu">
					<li>
                        <a href="<?php echo site_url();?>/dashboard" class="ai-icon " aria-expanded="false">
						<i class="flaticon-381-networking"></i>
						<span class="nav-text">Dashboard</span>
					</a>
				</li>
                     <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                            <i class="flaticon-381-television"></i>
                            <span class="nav-text">User Management</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="<?php echo site_url();?>/buyers">Buyer & Renter</a></li>
                              <li><a href="<?php echo site_url();?>/sellers">Seller & Sharer</a></li>
                        </ul>
                    </li>

					<li><a href="<?php echo site_url();?>/carListing" class="ai-icon active" aria-expanded="false">
						<i class="flaticon-381-settings-2"></i>
						<span class="nav-text">Booking Management</span>
					</a>
				</li>
                <li><a href="<?php echo site_url();?>/ObpTestDriveList" class="ai-icon" aria-expanded="false">
                    <i class="flaticon-381-division"></i>
                    <span class="nav-text">Outright Test Drive</span>
                </a>
                </li>
                <li><a href="<?php echo site_url();?>/RTOTestDriveList" class="ai-icon" aria-expanded="false">
                    <i class="flaticon-381-settings-2"></i>
                    <span class="nav-text">RTO Test Drive</span>
                </a>
                </li>
				<li>
                    <a href="<?php echo site_url();?>/transactionHistory" class="has-arrow ai-icon" aria-expanded="false">
					<i class="flaticon-381-settings-2"></i>
					<span class="nav-text">Payment Management</span>
				</a>
			</li>
            <li><a href="<?php echo site_url();?>/changePassword" class="ai-icon" aria-expanded="false">
                <i class="flaticon-381-settings-8"></i>
                <span class="nav-text">Change Password</span>
            </a>
            </li>
			<li><a href="<?php echo site_url();?>/logout" class="ai-icon" aria-expanded="false">
				<i class="flaticon-381-settings-2"></i>
				<span class="nav-text">Logout</span>
			</a>
		</li>
         </ul>
		</div>
     </div>
        <!--**********************************
            Sidebar end
        ***********************************-->