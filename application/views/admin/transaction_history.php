 
 <div class="content-body">
            <!-- row -->
			<div class="container-fluid">
				<div class="form-head d-flex mb-3 align-items-start">
				
					<div class="col-sm-12 p-md-0 justify-content-sm-start mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Transaction History</a></li>
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
                                                <th>TRANSACTION ID</th>
                                                <th>BUYER</th>
                                                <th>SELLER</th>
                                                <th>AMOUNT PAID</th>
                                                <th>STATUS</th>
                                                <th>DATE|TIME</th>
                                               
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach($transaction as $transactions)
                                            {
                                            
                                            ?>
                                            <tr>
                                            <td><?php echo $transactions['TransactionNumber'];?></td>
                                                <td><?php echo $transactions['buyerName'];?></td>
                                                <td><?php echo $transactions['SellerName'];?></td>
                                                
                                                 <td><?php echo $transactions['Amount'];?></td>
                                                <td><span class="green-text-block">successful</span></td>
                                                <td><?php echo $transactions['addedDate'];?></td>
                                                
                                                <td>
                                                    
                                                     <a type="submit" class="btn detail-view" href="transactionDetails/<?php echo $transactions['PaymentID'];?>">Detail</a>
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
       