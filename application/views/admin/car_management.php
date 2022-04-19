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
                                                <th>User Name</th>
                                                <th>Car</th>
                                                <th>Car Type</th>
                                                <th>Color</th>
                                                <th>Price</th>
                                                <th>Milegae</th>
                                        
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach($cars as $car)
                                            {
                                            
                                            ?>
                                            <tr>
                                                <td><?php echo $car['Username'];?></td>
                                                <td><div class="d-flex align-items-center"><img src="<?php echo base_url()."/".$car['Image'];?>" class="rounded-lg" width="24" alt=""> <span class="w-space-no"><?php echo $car['Model'];?></span></div></td>
                                                <td><?php echo $car['carType'];?></td>
                                                 <td><?php echo $car['Color'];?></td>
                                                <td><?php echo $car['Price'];?></td>
                                                 <td><?php echo $car['Mileage'];?></td>
                                            
                                                 <td><a type="submit" class="btn detail-view" href="details/<?php echo $car['carID'];?>">Detail</a></td>
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
       