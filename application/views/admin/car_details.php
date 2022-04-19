 <?php

$carType=$car_details['carType'];
$Model=$car_details['Model'];
$Color=$car_details['Color'];
$Brand=$car_details['Brand'];
$Mileage=$car_details['Mileage'];
$Seater=$car_details['Seater'];
$Year=$car_details['Year'];
$Price=$car_details['Price'];
$Description=$car_details['Description'];

?>
 
 <div class="content-body">
            <!-- row -->
			<div class="container-fluid">
				<div class="form-head d-flex mb-3 align-items-start">
				
					<div class="col-sm-12 p-md-0 justify-content-sm-start mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="booking_management.html">Cars</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:;">Car Management Detail</a></li>
                        </ol>
                    </div>
				</div>
                <div class="row">
				<div class="col-xl-6">
                        <div class="col-xl-12 pl-0">
                       <div class="card">
                                 <div class="card-body pt-1 px-3 pb-0">
                                    <div class="profile-news">
                                    <div class="media pt-3 pb-3">
                                        <img src="images/car_bg6.jpg" alt="image" class="mr-3 rounded" width="200">
                                        <div class="media-body">
                                            <h5 class="m-b-5"><?php echo $Model;?></h5>
                                            <p class="mb-2"><?php echo $carType;?></p>
                                            <span class="badge badge-success">Booked</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                               </div>
                                </div>

                        <div class="col-xl-12 pl-0">
                     <div class="card">
                            <div class="card-header border-bottom py-3">
                                <h2 class="card-title">Card Detail</h2>
                            </div>
                            <div class="card-body pb-0 pt-2">
                                <ul class="list-group list-group-flush card-listing">
                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                        <strong>Brand</strong>
                                        <span class="mb-0"><?php echo $Brand;?></span>
                                    </li>
                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                        <strong>Price</strong>
                                        <span class="mb-0"><?php echo $Price;?></span>
                                    </li>
                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                        <strong>Average</strong>
                                        <span class="mb-0"><?php echo $Mileage;?>km/ltr</span>
                                    </li>
                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                        <strong>Color</strong>
                                        <span class="mb-0"><?php echo $Color;?></span>
                                    </li>
                                      <li class="list-group-item d-flex px-0 justify-content-between">
                                        <strong>Seating</strong>
                                        <span class="mb-0"><?php echo $Seater;?> Person</span>
                                    </li>
                                </ul>
                            </div>
                        
                        </div>
                                </div>
                            </div>

                                    <div class="col-xl-6">
                                              <div class="col-xl-12 pl-0">
                                             <div class="card p-3">
                                                <div class="description-block">
                                                <h2>Vehicle Description</h2>
                                                <p><?php echo $carType;?></p>
                                        </div>
                                            <div class="description-block">
                                                <h2>Booking Details</h2>
                                                 <ul>
                                                     <li><span>Date:</span>23 Apr, 2020 To 28 Apr, 2020</li>
                                                     <li><span>Pickup Time :</span>09:00 AM</li>  
                                                       <li><span>Drop Time :</span>06:00 PM</li> 
                                                        <li><span>Total Days:</span>6</li> 
                                                 </ul>       
                                            </div>
                                            <div class="description-block">
                                                <h2>Payment Method</h2>
                                                 <h5 class="pt-2">Bank / Debit / Credit </h5>   
                                            </div>
                                            <div class="amounttwo-block">
                                                <ul>
                                                    <li><strong>Amount:</strong></li>
                                                         <li><strong>60$</strong></li>
                                                          <li>Delivery Cost:</li>
                                                         <li>20$</li>
                                                            <li>Pickup Cost:</li>
                                                         <li>5$</li>
                                                </ul>
                                                        <ul>
                                                            <li><strong>Total Amount:</strong></li>
                                                            <li><strong>80$</strong></li>
                                                        </ul>
                                            </div>
                                             </div>
                                               </div>             
                                    </div>

				 </div>
                     </div>
                       </div>
       