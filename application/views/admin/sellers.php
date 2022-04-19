     <div class="content-body">
            <!-- row -->
			<div class="container-fluid">
				<div class="form-head d-flex mb-3 align-items-start">
					<div class="col-sm-12 p-md-0 justify-content-sm-start mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">User Management</a></li>
                            <li class="breadcrumb-item active"><a href="#">Buyer & Renter</a></li>
                        </ol>
                    </div>
				</div>
                <div class="row">
					<div class="col-lg-12">
                        <div class="card">
                            <div class="border-bottom pb-2">
                                   <div class="my-1 d-flex align-items-center w-50 select-block">
                                                <label class="mr-sm-2 mb-0">Status: </label>
                                                   <select class="form-control" id="exampleFormControlSelect1">
                                                  <option>Buyer</option>
                                                  <option>Renter</option>
                                                </select>
                                                 <label class="mr-sm-2 mb-0 ml-3">Approved/Pending </label>
                                                   <select class="form-control" id="exampleFormControlSelect1">
                                                  <option>Approved</option>
                                                  <option>Pending</option>
                                                </select>
                                            </div>

                                        </div>
                            <div class="card-body pt-3 px-0">

                                <div class="table-responsive">
                                    <table class="table header-border table-responsive-sm">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Location</th>
                                                <th>Phone No</th>
                                                <th>Email Address</th>
                                                 <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach($sellers as $seller)
                                            {
                                            
                                            ?>
                                            <tr>
                                                <td><?php echo $seller['Username']; ?></td>
                                                <td><?php echo $seller['Address']; ?></td>
                                                <td><?php echo $seller['PhoneNumber']; ?></td>
                                                <td><?php echo $seller['Email']; ?></td>
                                                <td><a type="submit" class="btn detail-view" href="profile/<?php echo $seller['id'];?>">Detail</a></td>
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
        
   