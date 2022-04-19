
 
 <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <nav class="breadcrumb-one page_breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Home</a></li>
                        <li class="breadcrumb-item " aria-current="page">User Management</li>
                    </ol>
                </nav>

                <div class="row layout-top-spacing">

                
                    
             

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing mt-3">
                        
                        <form class="d-flex pull-right tabale_head"  method="post" action="<?php echo base_url(); ?>Dashboard/export_csv" >
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

                                                <th><div class="th-content">Name</div></th>
                                                <th><div class="th-content">Email</div></th>
                                                <th><div class="th-content">Phone Number</div></th>
                                                <th><div class="th-content th-heading">Location</div></th>
                                                <th><div class="th-content">Suspend</div></th>
                                                <th><div class="th-content">Details</div></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $i=1;
                                                foreach($data as $dt)
                                                {
                                            ?>
                                            <tr>
                                                <td><div class="td-content product-brand"><?php echo $i++; ?></div></td>
                                                <td><div class="td-content customer-name"><?php echo $dt['firstName']; ?> <?php echo $dt['lastName'] ?></div></td>
                                                <td><div class="td-content product-brand"><?php echo $dt['email']; ?></div></td>
                                                <td><div class="td-content"><?php echo $dt['phoneNumber']; ?></div></td>
                                                <td><div class="td-content pricing"><?php echo $dt['address']; ?></td>
                                                <td>
                                                <div class="td-content"> 
                                                <?php
                                                    if($dt['suspendedStatus'] == 1)
                                                    {
                                                ?>
                                                <label class="switch">
                                                    <input type="checkbox" id="read<?php echo $dt['id'];?>"  checked value="1" onclick="get_suspend_status(<?php echo $dt['id'];?>)">
                                                    <span class="slider round"></span>
                                                </label> 
                                                <?php
                                                    }
                                                    else
                                                    {
                                                    ?>
                                                    <label class="switch">
                                                        <input type="checkbox" id="read<?php echo $dt['id'];?>" value="0" onclick="get_suspend_status(<?php echo $dt['id'];?>)">
                                                        <span class="slider round"></span>
                                                    </label>
                                                    <?php
                                                    }
                                                ?>
                                                </div>
                                                </td>
                                                <td><div class="td-content pricing"><a href="<?php echo base_url(); ?>userProfile/<?php echo $dt['id']; ?>"><button class="btn btn-secondary mb-4 common_btn"> View</button></td>
                                            </tr>
                                           <?php
                                                }
                                           ?>
                                        </tbody>
                                      
                                    </table>
                                    
                                </div>
                                
                            </div>
                            
                            
                        
                        </div>


                        <!--<nav aria-label="Page navigation example " class=" pagination_custom" >
                            <ul class="pagination justify-content-end">
                              <li class="page-item ">
                                <a class="page-link" href="#" tabindex="-1">Previous</a>
                              </li>
                              <li class="page-item disabled" ><a class="page-link" href="#">1</a></li>
                              <li class="page-item disabled"><a class="page-link" href="#">2</a></li>
                              <li class="page-item disabled"><a class="page-link" href="#">3</a></li>
                              <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                              </li>
                            </ul>
                          </nav>-->
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