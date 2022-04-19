<?php

$email=$user_data['Email'];
$phone_number=$user_data['PhoneNumber'];
$username=$user_data['Username'];
$Address=$user_data['Address'];
$Image=$user_data['Image'];
$Gender=$user_data['Gender'];
$DL_ISSUE_DATE=$user_data['DL_ISSUE_DATE'];
$DL_EXPIRE_DATE=$user_data['DL_EXPIRE_DATE'];
$DL_FrontImage=$user_data['DL_FrontImage'];
$DL_BackendImage=$user_data['DL_BackendImage'];

?>

      
       <div class="content-body">
            <!-- row -->
			<div class="container-fluid">
				<div class="form-head d-flex mb-3 align-items-start">
				
					<div class="col-sm-12 p-md-0 justify-content-sm-start mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="buyer-renter.html">User Management</a></li>
                            <li class="breadcrumb-item active"><a href="#">View Detail</a></li>
                        </ol>
                    </div>
				
				</div>
                <div class="row">
				        <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body profile pt-5">
                                <div class="profile-photo m-auto">
                                        <img src="<?php echo base_url()."/".$Image;?>" class="img-fluid rounded-circle" alt="">
                                    </div>
                                    <div class="profile-details text-center">
                                        <div class="profile-name px-3 pt-2">
                                            <h4 class="text-primary mb-0"><?php  echo $username;?></h4>
                                            <p><?php  echo $email;?></p>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
				    <div class="col-xl-8">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-sm table-borderless mt-md-0 mt-3 view-detaillist">
                                            <tbody>
                                                <tr>
                                                    <th>Phone Number:</th>
                                                    <td><?php  echo $phone_number;?>
                                                    </td>
                                                </tr>
                                            
                                                <tr>
                                                    <th>Location:</th>
                                                    <td><?php echo $Address;?></td>
                                                </tr>
                                                <tr>
                                                    <th>Gender:</th>
                                                    <td><?php echo $Gender;?></td>
                                                </tr>
                                                  <tr>
                                                    <th>Licence details:</th>
                                                    <td>Issue Date: <?php echo $DL_ISSUE_DATE; ?></td>
                                                    <td>Expire Date: <?php echo $DL_EXPIRE_DATE; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                </div>
                            </div>
                    </div>

            <div class="col-xl-12">
                   <div class="card">
                      <div class="card-body profile-block pt-5 text-center">
                             <img src="<?php echo base_url()."/".$DL_FrontImage;?>" class="img-fluid" alt=""> 
                             <img src="<?php echo base_url()."/".$DL_BackendImage;?>" class="img-fluid" alt=""> 
                             <div class="text-center">
                              <a type="submit" class="btn detail-view" href="javascript:;" style="width: 20%;">Approve</a>
                              <a type="submit" class="btn detail-view-deny" href="javascript:;" style="width: 20%;">Deny</a>
                         </div>
                         </div>
                      </div>
                         </div>
				 </div>
            </div>
        </div>
    