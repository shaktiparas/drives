<?php
 
error_reporting(0);
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class Test extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        define('HTTP_OK', '200');
        $this->load->database();
        $this->load->helper('url');
        $this->load->model('Dashboard_model');
        $this->load->model('Test_model');
        $this->isLoggedIn();
        
        $this->data = array(
            'imagePath' => "http://amandeep.parastechnologies.in/barberapp/"
            
        );
    }
    public function getListOfpaymentTransaction()
    {
        $data['barberBookingCompleted']=$this->Test_model->completedAppointmentsByBarber();
        $data['clientBookingCompleted']=$this->Test_model->completedPaymentByClient();
        $this->loadViews('admin/paymentTransactions',$data);
    }
}