 
 <div class="content-body">
            <!-- row -->
			<div class="container-fluid">
				<div class="form-head d-flex mb-3 align-items-start">
				
					<div class="col-sm-12 p-md-0 justify-content-sm-start mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Change Password</a></li>
                        </ol>
                    </div>
				</div>
                <div class="row">
				<div class="col-xl-12">
                       <div class="card">
                                <div class="card-body profile pt-3">
                                <div class="about_listing_block">
                                    
                                     
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
                                    
                                    <form action="<?php echo site_url();?>/dashboard/changePasswordInDB" method="POST">
                <div class="form-group">
                <label for="exampleInputEmail1">Enter Old Password</label>
                <input type="text" class="form-control" placeholder="" name="oldPassword">
       
                </div>
                <div class="form-group">
                <label for="exampleInputEmail1">Enter New Password</label>
                <input type="text" class="form-control" placeholder="" name="newPassword">
        
                </div>
                <div class="form-group">
                <label for="exampleInputEmail1">Confirm New Password</label>
                <input type="text" class="form-control" placeholder="" name="confirmNewPassword">
                </div>
                <p class="text-center border-0 pb-0 pt-0 mb-0"><button type="submit" class="btn btn-primary" name="Change">Submit</button></p>
                </form>
                                    </div>
                            </div>
                               </div>
                            </div>
				 </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script type='text/javascript'>
      
 // $(document).ready(function(){
 
 function completeRequest(id)
 {
   
    var postdata="requestID="+id;
    $.ajax({
     url:'<?=base_url()?>APIS/user/CompleteTestDriveRequest_Ajax',
     method: 'post',
     data: postdata,
     success: function(response){
         console.log(response);
         var json = $.parseJSON(response);
         if(json.success==1)
         {
             alert('Request successfully completed');
         }
         else
         {
             alert('Request completion error');
         }
      
     }
   });
 
 }

 //});
       
      </script>    
       