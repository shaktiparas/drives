 
 <div class="content-body">
            <!-- row -->
			<div class="container-fluid">
				<div class="form-head d-flex mb-3 align-items-start">
				
					<div class="col-sm-12 p-md-0 justify-content-sm-start mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Booking Management</a></li>
                        </ol>
                    </div>
				</div>
                <div class="row">
				<div class="col-xl-12">
                       <div class="card">
                                 <div class="card-body pt-3 px-0 pb-0">
                                <div class="table-responsive">
                                    <table class="table header-border table-responsive-sm display" id="example3">
                                        <thead>
                                            <tr>
                                                <th>Seller</th>
                                                <th>Buyer</th>
                                                <th>Vehicle</th>
                                                <th>DVV Address</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Testdrive Status</th>
                                                 <th>Payment Status</th>
                                        
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach($testdrives as $testdrive)
                                            {
                                            
                                            ?>
                                            <tr>
                                            <td><?php echo $testdrive['sellerName'];?></td>
                                                <td><?php echo $testdrive['Username'];?></td>
                                                <td><?php echo $testdrive['vehicleType'];?></td>
                                                <td>DVV Address</td>
                                                 <td><?php echo $testdrive['TestDriveDate'];?></td>
                                                <td><?php echo $testdrive['TestDriveTime'];?></td>
                                                <td><?php echo $testdrive['TestDriveStatus'];?></td>
                                                 <td><?php echo $testdrive['CarPaymentStatus'];?></td>
                                            
                                                <td>
                                                    <?php
                                                    if($testdrive['TestDriveStatus']=='Completed')
                                                    {
                                                       ?>
                                                       <button type="button" class="btn detail-view" id="<?php echo $testdrive['ID'];?>" disabled="">Completed</button>
                                                       <?php
                                                    }
                                                    else
                                                    {
                                                    ?>
                                                    <button type="button" class="btn detail-view" id="<?php echo $testdrive['ID'];?>" onclick="completeRequest(this.id)">Complete</button>
                                                     <?php
                                                    }
                                                     ?>
                                                     <a type="submit" class="btn detail-view" href="requestDetails/<?php echo $testdrive['ID'];?>">Detail</a>
                                                </td>
                                                
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
       