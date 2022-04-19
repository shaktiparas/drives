<?php
 
error_reporting(0);
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Dashboard extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        define('HTTP_OK', '200');
        $this->load->database();
        $this->load->helper('url');
        //$this->load->model('Home_model');
        $this->load->model('Users_model');
        $this->load->model('Dashboard_model');
        $this->isLoggedIn();
        
        $this->data = array(
            'imagePath' => "http://amandeep.parastechnologies.in/barberapp/"
            
        );
    }
    public function index()
    {
        
        $result['totalBuyer']=$this->Dashboard_model->totalBuyer();
        $result['totalSeller']=$this->Dashboard_model->totalSeller();
        $result['totalBookings']=$this->Dashboard_model->totalBookings();
        $this->loadViews('admin/dashboard',$result);
        
    }
    public function logout()
    {
        $this->session->sess_destroy();
		redirect ( 'login' );
    }
   
    public function buyer()
    {
       
        $result['activeBuyer']=$this->Dashboard_model->activeBuyer();
       $this->loadViews('admin/buyer',$result);
        
    }
    
     public function seller()
    {
       
        $result['sellers']=$this->Dashboard_model->activeSeller();
       $this->loadViews('admin/sellers',$result);
        
    }
  
	public function userProfile($id)
	{
	     $data['user_data']=$this->Dashboard_model->userProfileData($id);
       
        $this->loadViews("admin/profile",$data);
	}
	
	   public function CarManagement()
    {
       
        $result['cars']=$this->Dashboard_model->carListings();
       $this->loadViews('admin/car_management',$result);
        
    }
    
    public function cardetails($id)
	{
	     $data['car_details']=$this->Dashboard_model->carDetails($id);
       
        $this->loadViews("admin/car_details",$data);
	}
	
	public function block($id)
	{
	   if($this->Dashboard_model->blockUser($id))
	   {
	       redirect('blockusers');
	   }
	   else
	   {
	       redirect('users');
	   }
       
    
	}
	
	public function unblock($id)
	{
	   if($this->Dashboard_model->unblockUser($id))
	   {
	       redirect('users');
	   }
	   else
	   {
	       redirect('blockusers');
	   }
       
    
	}
	
	public function SmsCalculation()
    {
       
       $this->loadViews('admin/sms_calculation');
        
    }
    
    public function SaveSmsCalculation()
    {
           $gateway = strtolower($this->security->xss_clean($this->input->post('gateway')));
           $fixedCost = strtolower($this->security->xss_clean($this->input->post('fixedCost')));
           $baseCost = strtolower($this->security->xss_clean($this->input->post('baseCost')));
           $smsCost = strtolower($this->security->xss_clean($this->input->post('smsCost')));
           $profit = strtolower($this->security->xss_clean($this->input->post('profit')));
           $adjusted = strtolower($this->security->xss_clean($this->input->post('adjusted')));
            
            if($gateway=='' || $fixedCost==''|| $baseCost==''|| $smsCost==''|| $profit=='' || $adjusted=='')
            {
                $this->session->set_flashdata('error', 'PLease enter all field');
               redirect('SmsCalculation');
            }
            else
            {
            $result = $this->Dashboard_model->SaveSmsField($gateway,$fixedCost, $baseCost,$smsCost,$profit,$adjusted);
            if($result)
            {
               
               $this->session->set_flashdata('success', 'Successfully Saved');
               redirect('SmsCalculation');
            }
            else
            {
                $this->session->set_flashdata('error', 'Problem in Database');
                redirect('SmsCalculation');
            }  
            }
        
    }
    
      public function reportManagement()
    {
       
        $result['reports']=$this->Dashboard_model->reportManagement();
        $this->loadViews('admin/report_management',$result);
        
    }
    
      public function transactionHistory()
    {
        $result['transaction']=$this->Dashboard_model->transactionHistory();
        $this->loadViews('admin/transaction_history',$result);
        
    }


     public function TransactionDetails($id)
	{
	     $data['TransactionDetails']=$this->Dashboard_model->transactionDetails($id);
       
        $this->loadViews("admin/transaction_details",$data);
	}
    
       public function outrightTestDriveRequest()
    {
       
        $result['testdrives']=$this->Dashboard_model->outrightTestDriveRequestListing();
        $this->loadViews('admin/outright_testdrive',$result);
        
    }
    
    
      public function TestDriveDetails($id)
	{
	     $data['TestDriveDetails']=$this->Dashboard_model->outrightTestDriveRequestDetails($id);
       
        $this->loadViews("admin/testdrive_details",$data);
	}
    
       public function RTOTestDriveRequest()
    {
       
        $result['RTOtestdrives']=$this->Dashboard_model->RTOTestDriveRequestListing();
        $this->loadViews('admin/RTOtestdrive',$result);
        
    }
    
    public function changePassword()
    {
         
        $this->loadViews('admin/changePassword');
        
    }
    
     public function changePasswordInDB(){ 
         
         $sessionUserID = $this->session->userdata('id');
         
        $this->load->library('form_validation');
        $this->form_validation->set_rules('newPassword', 'Password', 'required|max_length[32]');
        $this->form_validation->set_rules('confirmNewPassword', 'Confirm Password', 'required|matches[newPassword]');
        if($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', 'password and  connfirm passsword does not match');
        }
        else{
             $oldPassword = md5($this->input->post('oldPassword'));
             $newPassword = $this->input->post('newPassword');
            $data  =$this->Dashboard_model->updatePasswordByUserID($sessionUserID,$newPassword);
         if($data == 1){
             $this->session->set_flashdata('success', 'Your password reset successfully, Please login with your new password.');
        }else{
             $this->session->set_flashdata('error', 'Password not updated, Please, do not use your previous password.');
        }
        }
        redirect('changePassword');
    }
}