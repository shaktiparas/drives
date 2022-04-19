
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
    <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <nav class="breadcrumb-one page_breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item " aria-current="page"> Report Management</li>
                    </ol>
                </nav>

                <div class="row layout-top-spacing">

                    <div class="statbox widget box box-shadow  p-0">
                        
                        <div class="widget-content  animated-underline-content p-0" >
                            
                            <ul class="nav nav-tabs  mb-3" id="animateLine" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="animated-underline-home-tab" data-toggle="tab" href="#animated-underline-home" role="tab" aria-controls="animated-underline-home" aria-selected="false"> Queries By Customers</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " id="animated-underline-profile-tab" data-toggle="tab" href="#animated-underline-profile" role="tab" aria-controls="animated-underline-profile" aria-selected="true"> Queries By ECUTZ PRO’s</a>
                                </li>
                               
                            </ul>

                            <div class="tab-content" id="animateLineContent-4">
                                <div class="tab-pane fade" id="animated-underline-home" role="tabpanel" aria-labelledby="animated-underline-home-tab">
                           
                                    <div class="widget-content widget-content-area">
                                        <ul class="list-group list-group-media">
                                       <?php
                                        foreach($customerreports as $creports)                                       
                                       {
                                        ?>                                            
                                            <li class="list-group-item list-group-item-action ">
                                                <div class="media">
                                                    <div class="mr-3">
                                                        <img alt="avatar" src="<?php echo base_url() .$creports['userProfile']; ?>" class="img-fluid rounded-circle">
                                                    </div>
                                                    <div class="media-body">
                                                        <h6 class="tx-inverse"> <?php echo $creports['message']; ?>  </h6>
                                                    
                                                    </div>
                                                    <div class="reply_btn">
                                                        <button class="btn btn-success reply" data-toggle="modal" data-target="#customerreplyReport<?php echo $creports['id']; ?>"  > Reply</button>
                                                    </div>
                                                </div>
                                            </li>
                                            <!--Ingredient Modal-->
                                             <div class="modal fade" id="customerreplyReport<?php echo $creports['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="item-modal">
                                              <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                  
                                                  <div class="modal-body">
                                                    <div class="ms-panel ms-panel-fh ms-widget ms-email-widget">
                                                      <div class="ms-panel-header">
                                                        <div class="media clearfix">
                                                          <div class="mr-3 align-self-center">
                                                        </div>
                                                          <div class="media-body">
                                                            
                                                          </div>
                                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                        </div>
                                          
                                                      </div>
                                                      <div class="ms-panel-body">
                                                        <form method="post" class="clearfix" id="Formdata" >
                                                            <div class="form-group mb-4">
                                                              <input type="text" class="form-control" id="email" name="email" value="<?php echo $creports['email']; ?>" placeholder="Recipients">
                                                            
                                                            </div>
                                                            <div class="form-group mb-4">
                                                              <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject">
                                                            </div>
                                                            <div class="form-group mb-2">
                                                              <textarea rows="5" class="form-control" id="message" name="message" placeholder="Message"></textarea>
                                                            </div>
                                                          <input class="btn btn-success float-right" type="submit" name="submit" id="submit" value="Send Mail">
                                                        </form>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            <?php
                                       }
                                            ?>
                                        </ul>
    
                                      
    
                                    </div>

                                    
                                </div>
                                <div class="tab-pane fade active show" id="animated-underline-profile" role="tabpanel" aria-labelledby="animated-underline-profile-tab">
                                    <div class="widget-content widget-content-area">
                                        <ul class="list-group list-group-media">
                                            <?php
                                            foreach($barberreports as $breports)
                                            {
                                            ?>
                                            <li class="list-group-item list-group-item-action ">
                                                <div class="media">
                                                    <div class="mr-3">
                                                        <img alt="avatar" src="<?php echo base_url() .$breports['userProfile']; ?>" class="img-fluid rounded-circle">
                                                    </div>
                                                    <div class="media-body">
                                                        <h6 class="tx-inverse"> <?php echo $breports['message']; ?></h6>
                                                    
                                                    </div>

                                                    <div class="reply_btn"> <button class="btn btn-success reply" data-toggle="modal" data-target="#replyReport<?php echo $breports['id']; ?>"  > Reply</button> </div>
                                                </div>
                                            </li>
                                             <!--Ingredient Modal-->
                                             <div class="modal fade" id="replyReport<?php echo $breports['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="item-modal">
                                              <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                  
                                                  <div class="modal-body">
                                                    <div class="ms-panel ms-panel-fh ms-widget ms-email-widget">
                                                      <div class="ms-panel-header">
                                                        <div class="media clearfix">
                                                          <div class="mr-3 align-self-center">
                                                            
                                                          </div>
                                                          <div class="media-body">
                                                            
                                                          </div>
                                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                        </div>
                                          
                                                      </div>
                                                      <div class="ms-panel-body">
                                                        <form class="clearfix" id="Formdata" >
                                                            <div class="form-group mb-4">
                                                              <input type="text" class="form-control" id="email" name="email" value="<?php echo $breports['email']; ?>" placeholder="Recipients">
                                                              <!--<div class="ms-cc">
                                                                <i class="material-icons">person</i> CC &amp; BCC
                                                              </div>-->
                                                            </div>
                                                            <div class="form-group mb-4">
                                                              <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject">
                                                            </div>
                                                            <div class="form-group mb-2">
                                                              <textarea rows="5" class="form-control" id="message" name="message" placeholder="Message"></textarea>
                                                            </div>
                                                          <input class="btn btn-success float-right" type="submit" name="submit" value="Send Mail" >
                                                        </form>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            <?php
                                            }
                                            ?>
                                        </ul>
    
                                      
    
                                    </div>

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
     $(document).ready(function (e){
    $("form").on('submit',(function(e){
        e.preventDefault();
        $.ajax({
        url: "<?php echo base_url();?>reportUserReply",
        type: "POST",
        data:  new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success: function(data){
        if(data){
           
            Swal.fire({
                      icon: 'success',
                      title: 'Mail successfully sent',
                      showCancelButton: true
                    }).then((result) => {
              if (result.value) {
               $('#admin_img').attr('src', data);
                window.location.href = "reportManagement";
              }
            })
                
            }
            else
            {
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Something is wrong so please try again!',
                })
            }
        },
        error: function(){} 	        
    });
    }));
});
</script>