<?php

//print_r($graphData);

foreach($graphData as $graph)
{
    $months[$graph['month']]=$graph['tcount'];
}
?>
<style>
    .widget-content.animated-underline-content.p-0 .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active{
        border: none;
        
    }
</style>
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <nav class="breadcrumb-one page_breadcrumb" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0);">Dashboard</a></li>
            </ol>
        </nav>

        <div class="row layout-top-spacing "  >
            <div class="nav nav-tabs"  id="border-tabs" role="tablist">
       
            
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing  nav-link active"  id="underline-home-tab" data-toggle="tab" href="#underline-home" role="tab" aria-controls="underline-home" aria-selected="true">
                <div class="widget widget-table-one cardhover">
                    <div class="widget-content">
                        <div class="t-company-name d-flex align-items-center">
                            <div class="t-icon">
                                <div class="icon blue">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                </div>
                            </div>
                            <div class="t-name">
                                <h4><?php echo $totalUserRegister; ?></h4>
                                <p class="meta-date">Total User Registered</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing nav-link "  id="underline-contact-tab"  data-toggle="tab" href="#underline-contact" role="tab" aria-controls="underline-contact" aria-selected="false">
                <div class="widget widget-table-one cardhover ">
                    <div class="widget-content">
                        <div class="t-company-name d-flex align-items-center">
                            <div class="t-icon">
                                <div class="icon yellow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                </div>
                            </div>
                            <div class="t-name">
                                <h4><?php echo $totalEcutzPro; ?></h4>
                                <p class="meta-date">Total Number of Ecutz Pro</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing  nav-link " data-toggle="tab" href="#underline-profile" role="tab" aria-controls="underline-profile" aria-selected="false" id="underline-profile-tab">
                <div class="widget widget-table-one cardhover " >
                    <div class="widget-content">
                        <div class="t-company-name d-flex align-items-center">
                            <div class="t-icon">
                                <div class="icon red">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                </div>
                            </div>
                            <div class="t-name">
                                <h4><?php echo $totalbookings ?></h4>
                                <p class="meta-date">Total Number of Bookings</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
           
            <div class="tab-content w-100" id="border-tabsContent">
                <div class="tab-pane fade show active" id="underline-home" role="tabpanel" aria-labelledby="underline-home-tab">
                  
                    <form method="post" action="<?php echo base_url(); ?>Dashboard/export_csv" >
                    <input type="hidden" name="type" value="user"  >
                    <div class="col-md-12 text-right">
                        <button class="btn btn-secondary mb-4 common_btn">
                            <svg style="margin-right: 10px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve" fill="white">
                            
                                        <path d="M472,313v139c0,11.028-8.972,20-20,20H60c-11.028,0-20-8.972-20-20V313H0v139c0,33.084,26.916,60,60,60h392    c33.084,0,60-26.916,60-60V313H472z"/>
               
                                        <polygon points="352,235.716 276,311.716 276,0 236,0 236,311.716 160,235.716 131.716,264 256,388.284 380.284,264   "/>
                            
                                </svg>
                            <span>Extract and Download</span></button>
                    </div>
                    </form>
                        <!--User Graph Start-->
    
    
    
                        
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                            <div class="widget widget-chart-one">
                                <div class="widget-heading d-flex justify-content-between">
                                    <h5 class="mb-5">Total User Registered</h5>
                                    <!--<ul class="tabs tab-pills">
                                        <li><a href="javascript:void(0);" id="tb_1" class="tabmenu active">All</a></li>
                                        <li><a href="javascript:void(0);" id="tb_1" class="tabmenu">Year</a></li>
                                        <li><a href="javascript:void(0);" id="tb_1" class="tabmenu">Month</a></li>
                                        <li><a href="javascript:void(0);" id="tb_1" class="tabmenu">Week</a></li>
                                        <li><a href="javascript:void(0);" id="tb_1" class="tabmenu">Day</a></li>
                                    </ul>-->
                                </div>
    
                                <div class="widget-content">
                                    <div class="tabs tab-content">
                                        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                                        <!--<div id="content_1" class="tabcontent"> 
                                            <div id="revenueMonthly"></div>
                                        </div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
    



                </div>



                <div class="tab-pane fade" id="underline-contact" role="tabpanel" aria-labelledby="underline-contact-tab">
                    <div class="row layout-top-spacing">
                    <div class="col-md-12 text-right">
                     <form method="post" action="<?php echo base_url(); ?>Dashboard/export_csv" >
                    <input type="hidden" name="type" value="barber"  >
                    
                        <button class="btn btn-secondary mb-4 common_btn">
                            <svg style="margin-right: 10px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve" fill="white">
                            
                                        <path d="M472,313v139c0,11.028-8.972,20-20,20H60c-11.028,0-20-8.972-20-20V313H0v139c0,33.084,26.916,60,60,60h392    c33.084,0,60-26.916,60-60V313H472z"/>
               
                                        <polygon points="352,235.716 276,311.716 276,0 236,0 236,311.716 160,235.716 131.716,264 256,388.284 380.284,264   "/>
                            
                                </svg>
                            <span>Extract and Download</span></button>
                    
                    </form>
                    </div>
                        <!--User Graph Start-->
    
    
    
                        
    
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing mt-3">
                            <div class="widget-heading head_table">
                                <h5 class="mb-5">Total Number of ECUTZ PRO’s</h5>
                                <!--<form>
                                <div class="input-group mb-5">
                                    <input type="text" class="form-control" placeholder="Search here..." aria-label="Recipient's username" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                      <span class="input-group-text" id="basic-addon6"> </span>
                                    </div>
                                  </div>
                                  </form>-->
                            </div>
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
                                                    <!--<th><div class="th-content th-heading">Experience</div></th>
                                                    <th><div class="th-content">Subscription Plan</div></th>-->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i=1;
                                                foreach($ecutzPro as $dt)
                                                {
                                                ?>
                                                <tr>
                                                    <td><div class="td-content product-brand"><?php echo $i++; ?></div></td>
                                                    <td><div class="td-content customer-name"><?php echo $dt['firstName']; ?> <?php echo $dt['lastName']; ?></div></td>
                                                    <td><div class="td-content product-brand"><?php echo $dt['email']; ?></div></td>
                                                    <td><div class="td-content"><?php echo $dt['phoneNumber']; ?></div></td>
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
                
                    <div class="tab-pane fade" id="underline-profile" role="tabpanel" aria-labelledby="underline-profile-tab">
                    <div class="row layout-top-spacing">
                     <div class="col-md-12 text-right">
                    <form   method="post" action="<?php echo base_url(); ?>Dashboard/booking_csv" >
                    <button class="btn btn-secondary mb-4 common_btn">
                            <svg style="margin-right: 10px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve" fill="white">
                            
                                        <path d="M472,313v139c0,11.028-8.972,20-20,20H60c-11.028,0-20-8.972-20-20V313H0v139c0,33.084,26.916,60,60,60h392    c33.084,0,60-26.916,60-60V313H472z"/>
               
                                        <polygon points="352,235.716 276,311.716 276,0 236,0 236,311.716 160,235.716 131.716,264 256,388.284 380.284,264   "/>
                            
                                </svg>
                            <span>Extract and Download</span></button>
                    </form>
                    </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing mt-3">
                            <div class="widget-heading head_table">
                                <h5 class="mb-5">Total Number of Bookings</h5>
                                <form>
                                <!--<div class="input-group mb-5">
                                    <input type="text" class="form-control" placeholder="Search here..." aria-label="Recipient's username" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                      <span class="input-group-text" id="basic-addon6"> </span>
                                    </div>
                                  </div>-->
                                  <!--<button class="btn btn-secondary  common_btn">
                                    <svg style="margin-right: 10px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve" fill="white">
                                    
                                                <path d="M472,313v139c0,11.028-8.972,20-20,20H60c-11.028,0-20-8.972-20-20V313H0v139c0,33.084,26.916,60,60,60h392    c33.084,0,60-26.916,60-60V313H472z"/>
                       
                                                <polygon points="352,235.716 276,311.716 276,0 236,0 236,311.716 160,235.716 131.716,264 256,388.284 380.284,264   "/>
                                    
                                        </svg>
                                    <span>Extract and Download</span></button>-->
                                  </form>
                            </div>
                            <div class="widget widget-table-two table_padding">
    
                              
    
                                <div class="widget-content">
                                    <div class="table-responsive">
                                        <table class="table" id="paymenttable">
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
                    </p>
                </div>
            </div>
        </div>
     
        </div>

    </div>

</div>
<!--  END CONTENT AREA  -->


</div>

    <script>
window.onload = function () {

var options = {
	animationEnabled: true,  
	title:{
	//	text: "Monthly Sales - 2017"
	},
	axisX: {
		valueFormatString: "MMM"
	},
	axisY: {
		//title: "Sales (in USD)",
		//prefix: "$"
	},
	data: [{
		yValueFormatString: "#,###",
		xValueFormatString: "MMMM",
		type: "spline",
		dataPoints: [
			{ x: new Date(2020, 0), y: <?php if(!empty($months[0])){ echo $months[0]; }else{ echo "0" ; } ?> },
			{ x: new Date(2020, 1), y: <?php if(!empty($months[1])){ echo $months[1]; }else{ echo "0" ; } ?> },
			{ x: new Date(2020, 2), y: <?php if(!empty($months[2])){ echo $months[2]; }else{ echo "0" ; } ?> },
			{ x: new Date(2020, 3), y: <?php if(!empty($months[3])){ echo $months[3]; }else{ echo "0" ; } ?> },
			{ x: new Date(2020, 4), y: <?php if(!empty($months[4])){ echo $months[4]; }else{ echo "0" ; } ?> },
			{ x: new Date(2020, 5), y: <?php if(!empty($months[5])){ echo $months[5]; }else{ echo "0" ; } ?> },
			{ x: new Date(2020, 6), y: <?php if(!empty($months[6])){ echo $months[6]; }else{ echo "0" ; } ?> },
			{ x: new Date(2020, 7), y: <?php if(!empty($months[7])){ echo $months[7]; }else{ echo "0" ; } ?> },
			{ x: new Date(2020, 8), y: <?php if(!empty($months[8])){ echo $months[8]; }else{ echo "0" ; } ?> },
			{ x: new Date(2020, 9), y: <?php if(!empty($months[9])){ echo $months[9]; }else{ echo "0" ; } ?> },
			{ x: new Date(2020, 10), y: <?php if(!empty($months[10])){ echo $months[10]; }else{ echo "0" ; } ?> },
			{ x: new Date(2020, 11), y: <?php if(!empty($months[11])){ echo $months[11]; }else{ echo "0" ; } ?> }
		]
	}]
};
$("#chartContainer").CanvasJSChart(options);

}
</script>
