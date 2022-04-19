 <?php

$TransactionNumber=$TransactionDetails['TransactionNumber'];
$Amount=$TransactionDetails['Amount'];
$DeliveryCost=$TransactionDetails['DeliveryCost'];
$pickupCost=$TransactionDetails['pickupCost'];
$PaymentType=$TransactionDetails['PaymentType'];
$addedDate=$TransactionDetails['addedDate'];
$buyerName=$TransactionDetails['buyerName'];
$sellerName=$TransactionDetails['sellerName'];
$TotalAmount=$TransactionDetails['TotalAmount'];

?>
 
 <div class="content-body">
            <!-- row -->
			<div class="container-fluid">
				<div class="form-head d-flex mb-3 align-items-start">
				
					<div class="col-sm-12 p-md-0 justify-content-sm-start mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="booking_management.html">Transaction</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:;">Transaction Detail</a></li>
                        </ol>
                    </div>
				</div>
                <div class="row">
				<div class="col-xl-12">
                    
                       <div class="card">
                                 <div class="card-body pt-3 px-0 pb-0">
                                    <div class="d-flex p-3 border-bottom"><h2>Invoice</h2><span class="ml-auto fav-block"><a href="javascript:;"><i class="fa fa-print" aria-hidden="true"></i></a>
<a href="javascript:;"><i class="fa fa-download" aria-hidden="true"></i></a>
</span></div>
                                    <div class="p-3  border-bottom">
                                        <h6>Traction ID <span class="ml-auto">#<?php echo $TransactionNumber;?></span></h6>
                                            <p><?php echo $addedDate; ?></p>
                                    </div>
                                        <div class="p-3  border-bottom">
                                        <h6><?php echo $sellerName; ?>(Seller)</h6>
                                        <p><?php  echo $TransactionDetails['sellerEmail'];?></p>
                                          <h6><?php echo $buyerName; ?>(Renter)</h6>
                                            <p><?php  echo $TransactionDetails['Email'];?></p>
                                    </div>

                                        <div class="description-block">
                                                <h2>Payment Method</h2>
                                                 <h5 class="p-3 mb-0"><?php echo $sellerName; ?> </h5>   
                                            </div>
                                            <div class="amounttwo-block p-3">
                                                <ul>
                                                    <li><strong>Amount:</strong></li>
                                                         <li><strong><?php echo $Amount; ?>$</strong></li>
                                                          <li>Delivery Cost:</li>
                                                         <li><?php echo $DeliveryCost; ?>$</li>
                                                            <li>Pickup Cost:</li>
                                                         <li><?php echo $pickupCost; ?>$</li>
                                                </ul>
                                                        <ul>
                                                            <li><strong>Total Amount:</strong></li>
                                                            <li><strong><?php echo $TotalAmount; ?>$</strong></li>
                                                        </ul>
                                            </div>
                            </div>
                               </div>
                    

                        
                            </div>

                                    

				 </div>
                     </div>
                       </div>
       