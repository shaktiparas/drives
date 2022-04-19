<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
<div class="layout-px-spacing">
<nav class="breadcrumb-one page_breadcrumb" aria-label="breadcrumb">
   <ol class="breadcrumb">
      <li class="breadcrumb-item active"><a href="javascript:void(0);">Home</a></li>
      <li class="breadcrumb-item " aria-current="page">  Payment transaction</li>
   </ol>
</nav>
<div class="row layout-top-spacing">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing mt-3">
<form class="d-flex pull-right tabale_head" method="post" action="<?php echo base_url(); ?>Dashboard/Payment_csv">
   <button class="btn btn-secondary mb-4 common_btn">
      <svg style="margin-right: 10px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512 512" xml:space="preserve" fill="white">
         <path d="M472,313v139c0,11.028-8.972,20-20,20H60c-11.028,0-20-8.972-20-20V313H0v139c0,33.084,26.916,60,60,60h392    c33.084,0,60-26.916,60-60V313H472z"></path>
         <polygon points="352,235.716 276,311.716 276,0 236,0 236,311.716 160,235.716 131.716,264 256,388.284 380.284,264   "></polygon>
      </svg>
      <span>Extract and Download</span>
   </button>
   <!--<label><input type="search" class="form-control" placeholder="Search..." aria-controls="zero-config"></label>-->
</form>
<ul class="nav nav-tabs tabs2 " id="animateLine" role="tablist">
   <li class="nav-item w-50">
      <a class="nav-link active" id="animated-underline-home-tab" data-toggle="tab" href="#animated-underline-home" role="tab" aria-controls="animated-underline-home" aria-selected="true"> Barber Payment Request To Client</a>
   </li>
   <li class="nav-item w-50">
      <a class="nav-link" id="animated-underline-profile-tab" data-toggle="tab" href="#animated-underline-profile" role="tab" aria-controls="animated-underline-profile" aria-selected="false"> Client Payment To Barber</a>
   </li>
</ul>
<div class="tab-content" id="animateLineContent-4">
   <div class="tab-pane fade show active" id="animated-underline-home" role="tabpanel" aria-labelledby="animated-underline-home-tab">
      <div class="widget widget-table-two table_padding">
         <div class="widget-content">
            <div class="table-responsive">
               <table class="table" id="datatable">
                  <thead>
                     <tr class="bg_th">
                        <th >
                           <div class="th-content">ID</div>
                        </th>
                        <th>
                           <div class="th-content">Date/ Time</div>
                        </th>
                        <th>
                           <div class="th-content">Service</div>
                        </th>
                        <th>
                           <div class="th-content">Name</div>
                        </th>
                        <!--<th>
                           <div class="th-content th-heading">Location</div>
                        </th>-->
                        <th>
                           <div class="th-content">Price</div>
                        </th>
                     </tr>
                  </thead>
                  <tbody>
                    <?php $i = 1; foreach($barberBookingCompleted as $bookingBarber){ ?>  
                     <tr>
                        <td>
                           <div class="td-content product-brand">#<?php echo $i; ?></div>
                        </td>
                        <td>
                           <div class="td-content customer-name"><?php echo $bookingBarber['date']; ?></div>
                        </td>
                        <td>
                           <div class="td-content product-brand"><?php echo $bookingBarber['serviceName']; ?></div>
                        </td>
                        <td>
                           <div class="td-content"><?php echo $bookingBarber['firstName'].''. $bookingBarber['lastName']; ?></div>
                        </td>
                        <!--<td>
                           <div class="td-content pricing"></div>
                              
                        </td>-->
                        <td><div class="td-content pricing"> <?php echo $bookingBarber['totalAmount'] ? "$".$bookingBarber['totalAmount'] : ""; ?></div></td>
                     </tr>
                    <?php $i++; } ?> 
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
               <div class="tab-pane fade" id="animated-underline-profile" role="tabpanel" aria-labelledby="animated-underline-profile-tab">
                    <div class="widget widget-table-two table_padding">
         <div class="widget-content">
            <div class="table-responsive">
               <table class="table" id="paymenttable">
                  <thead>
                     <tr class="bg_th">
                        <th >
                           <div class="th-content">ID</div>
                        </th>
                        <th>
                           <div class="th-content">Date/ Time</div>
                        </th>
                        <th>
                           <div class="th-content">Service</div>
                        </th>
                        <th>
                           <div class="th-content">Name</div>
                        </th>
                       <!-- <th>
                           <div class="th-content th-heading">Location</div>
                        </th>-->
                        <th>
                           <div class="th-content">Price</div>
                        </th>
                     </tr>
                  </thead>
                  <tbody>
                    <?php $i = 1; foreach($clientBookingCompleted as $bookingClient){ ?>  
                     <tr>
                        <td>
                           <div class="td-content product-brand">#<?php echo $i; ?></div>
                        </td>
                        <td>
                           <div class="td-content customer-name"><?php echo $bookingClient['date']; ?></div>
                        </td>
                        <td>
                           <div class="td-content product-brand"><?php echo $bookingClient['serviceName']; ?></div>
                        </td>
                        <td>
                           <div class="td-content"><?php echo $bookingClient['firstName'].''. $bookingClient['lastName']; ?></div>
                        </td>
                        <!--<td>
                           <div class="td-content pricing"></div>
                              
                        </td>-->
                        <td><div class="td-content pricing"> <?php echo $bookingClient['TotalamountDeduct'] ? "$".$bookingClient['TotalamountDeduct'] : ""; ?></div></td>
                     </tr>
                    <?php $i++; } ?> 
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
      </div>
   </div>
   <!--  END CONTENT AREA  -->
</div>