<div class="row bg-title">
                        <div class="col-lg-12 col-md-4 col-sm-4 col-xs-12">
                            <h4 class="page-title">User Management</h4>
                        </div>
                       
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12">
                                        <div class="white-box">
                                            <h3 class="box-title">Users</h3>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>PROFILE PICTURE</th>
                                                            <th>NAME</th>
                                                            <th>DATE</th>
                                                            <th>ACTION</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $i=1;
                                                        foreach($inactiveUsers as $inactiveUser)
                                                        {
                                                            $image=$inactiveUser['image'];
                                                        ?>
                                                        
                                                        <tr>
                                                            <td><?php echo $i;?></td>
                                                            <td>
                                                                <div class="image-cover">
                                                                     <?php
                                                                    if($image=='')
                                                                    {
                                                                    ?>
                                                                    <img class="img-fluid" src="<?php echo base_url();?>assets/plugins/images/dummy-image.jpeg" alt="">
                                                                    <?php
                                                                    }
                                                                    else
                                                                    {
                                                                    ?>
                                                                    <img class="img-fluid" src="<?php echo $image;?>" alt="">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                   
                                                                </div>
                                                            </td>
                                                            <td class="txt-oflo"><?php echo $inactiveUser['email'];?></td>
                                                            <td class="txt-oflo"><?php echo $inactiveUser['user_created_date'];?></td>
                                                           <td>
                                                                <a href="<?php echo base_url(); ?>unblock/<?php echo $inactiveUser['id']; ?>" class="btn btn-primary view-profile">Unblock
                                                                    <!--<img src="<?php echo base_url(); ?>assets/plugins/images/ban-user.svg" alt="home" class="user-ban">-->
                                                                </a>
                                                            </td>
                                                            <td>
                                                                
                                                                <a href="<?php echo base_url(); ?>userProfile/<?php echo $inactiveUser['id']; ?>" class="btn btn-primary view-profile">View Profile</a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                        <!-- ============================================================== -->
                        <!-- chat-listing & recent comments -->
                        <!-- ============================================================== -->
                    </div>
                    <!-- /.container-fluid -->
                    <footer class="footer text-center">2020 &copy; Sahalat. All rights are reserved.</footer>