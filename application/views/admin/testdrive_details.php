 <?php

$sellerName=$TestDriveDetails['sellerName'];
$Username=$TestDriveDetails['Username'];
$vehicleType=$TestDriveDetails['vehicleType'];
$TestDriveDate=$TestDriveDetails['TestDriveDate'];
$TestDriveTime=$TestDriveDetails['TestDriveTime'];
$Seater=$TestDriveDetails['Seater'];
$Year=$TestDriveDetails['Year'];
$Price=$TestDriveDetails['Price'];
$Description=$TestDriveDetails['Description'];
$Model=$TestDriveDetails['Model'];
$Color=$TestDriveDetails['Color'];
$Brand=$TestDriveDetails['Brand'];
$Mileage=$TestDriveDetails['Mileage'];
$vehicleType=$TestDriveDetails['vehicleType'];
$TestDriveStatus=$TestDriveDetails['TestDriveStatus'];
$images=$TestDriveDetails['images'];

foreach($images as $values)
{
    
    
}

?>
 
<div class="content-body" style="min-height: 801px;">
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
                            <div class="card-body profile pt-3">
                                <div class="m-auto">
                                    <h4 class="text-center">Rensult Trafic</h4>
                                    <div class="bootstrap-carousel">
                                        <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
                                            <ol class="carousel-indicators">
                                                <li data-target="#carouselExampleIndicators2" data-slide-to="0" class=""></li>
                                                <li data-target="#carouselExampleIndicators2" data-slide-to="1" class="active"></li>
                                                <li data-target="#carouselExampleIndicators2" data-slide-to="2" class=""></li>
                                            </ol>
                                            <div class="carousel-inner">
                                                <div class="carousel-item active carousel-item-left">
                                                    <img class="d-block w-100" src="./images/car_bg3.jpg" alt="First slide">
                                                </div>
                                                <div class="carousel-item carousel-item-next carousel-item-left">
                                                    <img class="d-block w-100" src="./images/car_bg4.jpg" alt="Second slide">
                                                </div>
                                                <div class="carousel-item">
                                                    <img class="d-block w-100" src="./images/car_bg5.jpg" alt="Third slide">
                                                </div>
                                            </div><a class="carousel-control-prev" href="#carouselExampleIndicators2" data-slide="prev"><span class="carousel-control-prev-icon"></span> <span class="sr-only">Previous</span> </a><a class="carousel-control-next" href="#carouselExampleIndicators2" data-slide="next"><span class="carousel-control-next-icon"></span>
                                                <span class="sr-only">Next</span></a>
                                        </div>
                                    </div>
                                    </div>
                             
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between p-0 pt-3"><span class="mb-0">Price:</span> <strong class="text-muted"><?php echo $Price;?> $	</strong></li>
                                        <li class="list-group-item d-flex justify-content-between p-0 pt-3"><span class="mb-0">Details:</span> 		<strong class="text-muted">Posted on:<?php echo $Price;?> 	</strong></li>
                                        <li class="list-group-item d-flex justify-content-between p-0 pt-3"><span class="mb-0">Brand:</span> <strong class="text-muted"><?php echo $Brand;?>	</strong></li>
                                        <li class="list-group-item d-flex justify-content-between p-0 pt-3"><span class="mb-0">Modal:</span> <strong class="text-muted"><?php echo $Model;?></strong></li>
                                        <li class="list-group-item d-flex justify-content-between p-0 pt-3"><span class="mb-0">Type:</span> <strong class="text-muted"><?php echo $vehicleType;?></strong></li>
                                        <li class="list-group-item d-flex justify-content-between p-0 pt-3"><span class="mb-0">Color:</span> <strong class="text-muted"><?php echo $Color;?></strong></li>
                                        <li class="list-group-item d-flex justify-content-between p-0 pt-3"><span class="mb-0">Year:</span> <strong class="text-muted"><?php echo $Year;?></strong></li>
                                        <li class="list-group-item d-flex justify-content-between p-0 pt-3"><span class="mb-0">Preference:</span> <strong class="text-muted"><?php echo $Price;?></strong></li>
                                    </ul>

                            </div>
                        </div>
                    </div>
				    <div class="col-xl-8">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-sm table-borderless mt-md-0 mt-3 view-detaillist">
                                            <tbody>
                                                <tr>
                                                    <th>SELLER:</th>
                                                    <td><?php  echo $sellerName;?>	</td>
                                                </tr>
                                            
                                                <tr>
                                                    <th>BUYER:</th>
                                                    <td><?php  echo $Username;?></td>
                                                </tr>
                                                <tr>
                                                    <th>VEHICLE:</th>
                                                    <td><?php  echo $vehicleType;?></td>
                                                </tr>
                                                  <tr>
                                                    <th>DVV ADDRESS:</th>
                                                    <td>2585 James Martin Circle</td>
                                                </tr>
                                                <tr>
                                                    <th>DATE:</th>
                                                    <td><?php  echo $TestDriveDate;?>	</td>
                                                </tr>
                                                <tr>
                                                    <th>TIME:</th>
                                                    <td><?php  echo $TestDriveTime;?>		</td>
                                                </tr>
                                                <tr>
                                                    <th>PAYMENT STATUS	:</th>
                                                    <td><span class="booked-green"><?php  echo $TestDriveStatus;?></span>		</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="text-left p-1 pt-3">
                                            <h4>Vechicle Description</h4>
                                            <p><?php  echo $Description;?></p>
                                        </div>
                                </div>
                           
                            </div>
                    </div>

  
				 </div>
            </div>
        </div>
       