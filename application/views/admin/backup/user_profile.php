<?php 
    /*print_r($vehicle_detail);
    die;*/
?>
 <style>
 
 .table > tbody > tr > td{    text-align: inherit;}
   .user_img{ width: 222px;
    padding: -9px;
    margin-top: 22px;
    border-radius: 22px;
    object-fit: cover;
    height: 183px;
    border: 1px solid #cec9c9;}

.user-row {
    margin-bottom: 14px;
}

.user-row:last-child {
    margin-bottom: 0;
}

.dropdown-user {
    margin: 13px 0;
    padding: 5px;
    height: 100%;
}

.dropdown-user:hover {
    cursor: pointer;
}

.table-user-information > tbody > tr {
    border-top: 1px solid rgb(221, 221, 221);
}

.table-user-information > tbody > tr:first-child {
    border-top: 0;
}


.table-user-information > tbody > tr > td {
    border-top: 0;
}
.toppad
{margin-top:20px;
}

 </style>
 <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <nav class="breadcrumb-one page_breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Home</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="<?php echo base_url(); ?>user"> User Management</a></li>
                        <li class="breadcrumb-item " aria-current="page"> Profile Details</li>
                    </ol>
                </nav>

                <div class="row layout-top-spacing">

                
                    
             
                    <div class="col-xl-12 col-lg-12 col-md-5 col-sm-12 layout-top-spacing">
                        <div class="container">
                            <div class="row">
                           
                              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-10 col-lg-offset-10 toppad" >
                         
                         
                                <div class="panel panel-info">
                                  <div class="panel-heading">
                                    
                                  </div>
                                  <div class="panel-body">
                                    <div class="row">
                                      <div class="col-md-3 col-lg-3 " align="center">
                                          <?php
                                            if(!empty($user_data['userProfile']))
                                            {
                                          ?>
                                                <img alt="User Pic" src="<?php echo base_url() .$user_data['userProfile']; ?>" class="img-circle img-responsive user_img"> 
                                        <?php
                                            }
                                            else
                                            {
                                        ?>
                                        `       <img alt="User Pic" src="<?php echo base_url(); ?>assets/img/avatar.jpg" class="img-circle img-responsive user_img">
                                        <?php 
                                            }
                                        ?>
                                      </div>
                   
                                      <div class=" col-md-9 col-lg-9 "> 

                                        <ul class="nav nav-tabs  mb-3 mt-3 nav-fill bg_white" id="justifyTab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="justify-home-tab" data-toggle="tab" href="#justify-home" role="tab" aria-controls="justify-home" aria-selected="true">Personal Info</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="justify-profile-tab" data-toggle="tab" href="#justify-profile" role="tab" aria-controls="justify-profile" aria-selected="false">Bank Detail</a>
                                            </li>
                                        </ul>
                                        
                                        <div class="tab-content" id="justifyTabContent">
                                            <div class="tab-pane fade show active" id="justify-home" role="tabpanel" aria-labelledby="justify-home-tab">
                                                
                                        
                                                <table class="table table-user-information">
                                                    <tbody>
          
                                                    <tr>
                                                        <td> <b>Name: </b></td>
                                                        <td><?php echo $user_data['firstName'] .' '. $user_data['lastName'] ?> </td>
                                                    </tr>
                                                    <tr>
                                                      <td> <b>Email: </b></td>
                                                      <td><?php echo $user_data['email']; ?></td>
                                                    </tr>
                                                    <tr>
                                                      <td> <b> Phone Number: </b></td>
                                                      <td> <?php echo $user_data['phoneNumber']; ?></td>
                                                    </tr>
                                                    <tr>
                                                      <td> <b> Address: </b></td>
                                                      <td> <?php echo $user_data['address']; ?></td>
                                                    </tr>
                                                    </tbody>
                                                  </table>
                                            </div>
                                            <div class="tab-pane fade" id="justify-profile" role="tabpanel" aria-labelledby="justify-profile-tab">
                                                
                                        <table class="table table-user-information">
                                            <tbody>
                                                <tr>
                                                  <td> <b>Name</b></td>
                                                  <td><?php echo $bank_detail['nameOnCard']; ?></td>
                                                </tr>
                                                <tr>
                                                  <td>  <b>Card Number </b></td>
                                                  <td><?php echo $bank_detail['cardNumber']; ?></td>
                                                </tr>
                                                
                                                <tr>
                                                  <td> <b>Zip Code </b></td>
                                                  <td> <?php echo $bank_detail['billingZipCode']; ?></td>
                                                </tr>
                                             
                                            </tbody>
                                          </table>
                                       
                                            </div>
                                        </div>

                                      </div>
                                    </div>
                                  </div>
                                     
                                  
                                </div>
                              </div>
                            </div>
                            <div class="row">
                                <h3>Booking Details </h3>
                                    <div class="table-responsive">
                                        <table class="table" id="paymenttable">
                                            <thead>
                                                <tr class="bg_th"> 
                                                     <th ><div class="th-content">ID</div></th>
                                                    <th><div class="th-content">Barber Name</div></th>
                                                    <th><div class="th-content">Status</div></th>
                                                    <th><div class="th-content">Request Type</div></th>
                                                    <th><div class="th-content">Date</div></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $i=1;
                                                    foreach($booking_details as $dt)
                                                    {
                                                ?>
                                                <tr>
                                                    <td><div class="td-content product-brand"><?php echo $i++; ?></div></td>
                                                    <td><div class="td-content customer-name"><?php echo $dt['firstName'].' '.$dt['lastName']; ?> </div></td>
                                                    <td><div class="td-content"><?php 
                                                        if($dt['status'] == 0)
                                                        {
                                                            echo "Pending";
                                                        }
                                                        if($dt['status'] == 1)
                                                        {
                                                            echo "Accepted";
                                                        }
                                                        if($dt['status'] == 2)
                                                        {
                                                            echo "Completed";
                                                        }
                                                        if($dt['status'] == 3)
                                                        {
                                                            echo "Cancelled";
                                                        }
                                                        ?></div></td>
                                                    <td><div class="td-content"><?php echo $dt['requestType']; ?></div></td>
                                                    <td><div class="td-content"><?php echo $dt['requestBookingDate']; ?></div></td>
                                                </tr>
                                               <?php
                                                    }
                                               ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                <h3>Review </h3>
                                    <div class="table-responsive">
                                        <table class="table" id="reviewtable">
                                            <thead>
                                                <tr class="bg_th"> 
                                                     <th ><div class="th-content">ID</div></th>
                                                    <th><div class="th-content">Barber Name</div></th>
                                                    <th><div class="th-content">Rating</div></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $i=1;
                                                    foreach($user_review_details as $rd)
                                                    {
                                                ?>
                                                <tr>
                                                    <td><div class="td-content product-brand"><?php echo $i++; ?></div></td>
                                                    <td><div class="td-content customer-name"><?php echo $rd['firstName'].' '.$rd['lastName']; ?> </div></td>
                                                    <td><div class="td-content"><?php echo $rd['rating']; ?></div></td>
                                                </tr>
                                               <?php
                                                    }
                                               ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                          </div>
                  
                    </div>
                </div>

            </div>

        </div>
        <!--  END CONTENT AREA  -->


    </div>
    <!-- END MAIN CONTAINER -->