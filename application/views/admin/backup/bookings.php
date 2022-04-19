
 
 <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <nav class="breadcrumb-one page_breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Home</a></li>
                        <li class="breadcrumb-item " aria-current="page">Bookings</li>
                    </ol>
                </nav>

                <div class="row layout-top-spacing">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing mt-3">
                        
                        <form class="d-flex pull-right tabale_head"  method="post" action="<?php echo base_url(); ?>Dashboard/booking_csv" >
                            <input type="hidden" name="type" value="user"  >
                            <button class="btn btn-secondary mb-4 common_btn">
                                <svg style="margin-right: 10px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512 512" xml:space="preserve" fill="white">
                                
                                            <path d="M472,313v139c0,11.028-8.972,20-20,20H60c-11.028,0-20-8.972-20-20V313H0v139c0,33.084,26.916,60,60,60h392    c33.084,0,60-26.916,60-60V313H472z"></path>
                   
                                            <polygon points="352,235.716 276,311.716 276,0 236,0 236,311.716 160,235.716 131.716,264 256,388.284 380.284,264   "></polygon>
                                
                                    </svg>
                                <span>Extract and Download</span></button>
                        
                                <!--<label><input type="search" class="form-control" placeholder="Search..." aria-controls="zero-config"></label>-->
                          </form>
                           
                        <div class="widget widget-table-two table_padding">

                  
                            <div class="widget-content">
                                <div class="table-responsive">
                                    <table class="table" id="datatable">
                                        <thead>
                                            <tr class="bg_th"> 
                                                <th ><div class="th-content">ID</div></th>
                                                <th><div class="th-content">Barber Name</div></th>
                                                <th><div class="th-content">User Name</div></th>
                                                <th><div class="th-content th-heading">Status</div></th>
                                                <th><div class="th-content">Request Type</div></th>
                                                <th><div class="th-content">Date</div></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                <?php
                                                $i=1;
                                                foreach($bookingdata as $data)
                                                {
                                                ?>
                                                <tr>
                                                    <td><div class="td-content product-brand"><?php echo $i++; ?></div></td>
                                                    <td><div class="td-content customer-name"><?php echo $data['barber_firstname'].' '.$data['barber_lastname'] ?></div></td>
                                                    <td><div class="td-content product-brand"><?php echo $data['user_firstname'].' '.$data['user_lastname'] ?></div></td>
                                                    <td><div class="td-content"><?php 
                                                    if($data['status'] == 0)
                                                    {
                                                        echo "Pending";
                                                    }
                                                    if($data['status'] == 1)
                                                    {
                                                        echo "Accepted";
                                                    }
                                                    if($data['status'] == 2)
                                                    {
                                                        echo "Completed";
                                                    }
                                                    if($data['status'] == 3)
                                                    {
                                                        echo "Cancelled";
                                                    }
                                                    ?></div></td>
                                                    <td><div class="td-content pricing"><?php echo $data['requestType']; ?></div></td>
                                                    <td><div class="td-content"> <?php echo $data['requestBookingDate']; ?></div></td>
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
        <!--  END CONTENT AREA  -->


    </div>
    <!-- END MAIN CONTAINER -->
    <script>
    function get_suspend_status(id) {
	   
     var idd = $('#read' + id).val();
    var dataString="status="+idd +"&id="+id;

    $.ajax({
            url: 'dashboard/update_suspend_status',
            method:"POST",
            data:dataString,
            success:function(responsedata){
                 if(idd == 0)
                 {
                     Swal.fire({
                      icon: 'success',
                      title: 'Profile suspend successfully',
                      showCancelButton: false,
                      timer: 10000
                            }).then((result) => {
                      if (result.value) {
                       window.location.href = "<?php echo base_url(); ?>user";
                      }
                    })
                 }
                 else{
                    Swal.fire({
                      icon: 'success',
                      title: 'Profile unsuspend successfully',
                      showCancelButton: false,
                      timer: 10000
                            }).then((result) => {
                      if (result.value) {
                       window.location.href = "<?php echo base_url(); ?>user";
                      }
                    })
                 }
            }
        });
    }
    </script>