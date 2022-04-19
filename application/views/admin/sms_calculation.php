 <div class="row bg-title">
                        <div class="col-lg-12 col-md-4 col-sm-4 col-xs-12">
                            <h4 class="page-title">sms calculation</h4>
                        </div>
                        
                    </div>
                    
                    <?php
                                                $error = $this->session->flashdata('error');
                                                if($error)
                                                {
                                                    ?>
                                                    <div class="alert alert-danger alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                        <?php echo $error; ?>                    
                                                    </div>
                                                <?php }
                                                $success = $this->session->flashdata('success');
                                                if($success)
                                                {
                                                ?>
                                                <div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                    <?php echo $success; ?>                    
                                                </div>
                                                <?php } ?> 
                    <?php $this->load->helper('form'); ?>
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12">
                                        <div class="white-box">
                                            <form class="form-inline row sms-form" method="post" role="form" action="<?php echo base_url();?>SaveSmsCalculation">
                                              <div class="form-group col-sm-6">
                                                <label for="exampleInputName2">Gateway (%)</label>
                                                <input type="text" name="gateway" class="form-control" id="exampleInputName2" placeholder="">
                                              </div>
                                              <div class="form-group col-sm-6">
                                                <label for="exampleInputEmail2">Gateway Fixed Cost (AED)</label>
                                                <input type="text" name="fixedCost" class="form-control" id="exampleInputEmail2" placeholder="">
                                              </div>


                                              <div class="form-group col-sm-6">
                                                <label for="exampleInputName2">Base Cost (AED)</label>
                                                <input type="text" name="baseCost" class="form-control" id="exampleInputName2" placeholder="">
                                              </div>
                                              <div class="form-group col-sm-6">
                                                <label for="exampleInputEmail2">SMS Cost (AED)</label>
                                                <input type="text" name="smsCost" class="form-control" id="exampleInputEmail2" placeholder="">
                                              </div>


                                              <div class="form-group col-sm-6">
                                                <label for="exampleInputName2">Profit (%)</label>
                                                <input type="text" name="profit" class="form-control" id="exampleInputName2" placeholder="">
                                              </div>
                                              <div class="form-group col-sm-6">
                                                <label for="exampleInputEmail2">Adjusted (%)</label>
                                                <input type="text" name="adjusted" class="form-control" id="exampleInputEmail2" placeholder="">
                                              </div>


                                              <div class="col-sm-12" style="text-align: right;">
                                                  <button type="submit" name="Submit" class="btn btn-primary view-profile">Submit</button>
                                              </div>


                                            </form>
                                        </div>
                                    </div>
                        <!-- ============================================================== -->
                        <!-- chat-listing & recent comments -->
                        <!-- ============================================================== -->
                    </div>
                    <!-- /.container-fluid -->
                    <footer class="footer text-center">2020 &copy; Sahalat. All rights are reserved.</footer>