<style> 
    .user_img_div img.edit{
    width: 70px;
    height: 70px;
    object-fit: scale-down;
    position: absolute;
    top: 85px;
    left: 131px;
    background: #EBEBEB;
    border: 4px solid #fff;
    padding: 10px;}

        .upload-btn-wrapper input[type=file] {
                font-size: 100px;
                width: 20%;
                position: absolute;top: 0;
                opacity: 0;
              }
        
              
              .upload-btn-wrapper  .btn {
                background: transparent;
    color: gray;
    padding: 5px 20px;
    border-radius: 8px;
    position: relative;
    font-size: 20px;
    display: inline-block;
    color: #fff;
  
    font-weight: bold;
           }
          </style>
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <nav class="breadcrumb-one page_breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item " aria-current="page">  Settings</li>
                    </ol>
                </nav>
                <div class="row">
                  <div class="col-12">
                      <form id="uploadForm" action="<?php echo base_url(); ?>updatePasswordAndImageOfAdmin" method="post">
                    <div class="card mt_99 setting_card position-relative">
                        <!--<div class="user_img_div mx-auto"> <img src="<?php echo $data['profile_image']; ?>" alt="" id="admin_img">
                            <img src="assets/img/edit.svg" class="edit" alt="">
                            <input type="file" name="admin_profile" class="user_img_edit" >
                        </div>-->
                        <div class="user_img_div mx-auto"> <img src="<?php echo $data['profile_image']; ?>" alt="" id="admin_img">
                        <div class="upload-btn-wrapper">
                            <button class="btn"> <img src="assets/img/edit.svg" class="edit" alt=""></button>
                           <input type="file" name="admin_profile" >
                            </div>
                        
                        </div>
                        <div class="w-43 mx-auto mt-5"  >
                            <h4>Change Password</h4>
                            <div class="form-group  position-relative">
                                <input type="password" name="old_password" class="form-control" id="inputPassword4" required="" placeholder="Current Password"> 
                                <span class="icon_form"> <img  src="assets/img/password.svg"> </span>
                            </div>
                            <div class="form-group position-relative mt-4">
                                <input type="password" name="new_password" class="form-control" id="inputPassword4" required="" placeholder="New Password">
                                <span class="icon_form"> <img  src="assets/img/password.svg"> </span>
                            </div>
                            <div class="field-wrapper pt-3">
                                <!--<a href="#" class="btn btn-primary main_btn mt-4" value="">Update Password</a>-->
                                <input type="submit" class="btn btn-primary main_btn mt-4" value="Update Password">
                            </div>
                        </div>
                    </div> 
                    </form>
                    </div>
                    </div>

                </div>
                    <!--User Graph Start-->
                   
                </div>

            </div>

        </div>
        <!--  END CONTENT AREA  -->


    </div>
    <!-- END MAIN CONTAINER -->
    
    <script>
     $(document).ready(function (e){
    $("#uploadForm").on('submit',(function(e){
        e.preventDefault();
        $.ajax({
        url: "<?php echo base_url();?>dashboard/updatePasswordAndImageOfAdmin",
        type: "POST",
        data:  new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success: function(data){
        if(data !=0){
            Swal.fire({
                      icon: 'success',
                      title: 'Successfully updated',
                      showCancelButton: true
                    }).then((result) => {
              if (result.value) {
               $('#admin_img').attr('src', data);
                window.location.href = "settings";
              }
            })
                
            }
            else
            {
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Please recheck your current password!',
                })
            }
        },
        error: function(){} 	        
    });
    }));
});
</script>