<?php error_reporting(0); if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Login (LoginController)
 */
class Login extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    { 
        parent::__construct();
       // $this->load->database();
        $this->load->library('session');
        $this->load->model('login_model');
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->load->view('welcome');
    }
    
    /**
     * This function used to check the user is logged in or not
     */
    function isLoggedIn()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('admin/login');
        }
        else
        {
            redirect('/dashboard');
           
        }
    }
    
    /**
     * This function used to login view 
     */
    public function login()
    {
        $this->isLoggedIn(); 
    }

    /**
     * This function used to logged in user
     */
    public function loginMe()
    {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[128]|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->isLoggedIn(); 
        }
        else 
        {
            //Login for Super-admin
            $email = strtolower($this->security->xss_clean($this->input->post('email')));
            //$remember = strtolower($this->security->xss_clean($this->input->post('remember')));
            $pwd=$this->input->post('password');
            $password = md5($this->input->post('password'));
            $result = $this->login_model->loginMe($email, $password);
            if(!empty($result))
            {
               
                $sessionArray = array('id'=>$result['ID'],                    
                                        'email'=>$result['email'],
                                        'isLoggedIn' => TRUE
                                );

                $this->session->set_userdata($sessionArray);
                
              
                
                redirect('/dashboard');
               
            }
            else
            {
                $this->session->set_flashdata('error', 'Email or password mismatch');
                $this->isLoggedIn();
            }    
            }
        }
    /**
     * This function used to generate reset password request link
     */
        public function forgot_password()
        {
            $this->load->view('admin/forgot_password');
        }
        public function forgotPasswordMail(){ 
            $this->load->library('form_validation');
        
        $this->form_validation->set_rules('login_email','Email','trim|required|valid_email');
        
                
        if($this->form_validation->run() == FALSE)
        {      
             echo 2;
            // return true;
        }
        else 
        {
      $email = strtolower($this->security->xss_clean($this->input->post('login_email')));
      $email_check = $this->login_model->checkExistEmail($email);
      if($email_check){
          echo 3;
      }else{
           require 'vendor/autoload.php';
            $API_KEY='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';
            $FROM_EMAIL = 'shakti.parastechnologies@gmail.com';
            $TO_EMAIL = $email; 
            $subject = "Forgot Password Request"; 
            $from = new SendGrid\Email(null, $FROM_EMAIL);
            $to = new SendGrid\Email(null, $TO_EMAIL);
            $decode= base64_encode($TO_EMAIL);
            $htmlContent = 'Dear '.$TO_EMAIL.',  
                              <br/>Recently a request was submitted to reset a password for your account. If this was a mistake, just ignore this email and nothing will happen to your account.
                              <br/>To reset your password, click the following link and the url redirect to your mobile change password screen: <a href="http://amandeep.parastechnologies.in/barberapp/resetPassword?email='.$decode.'">Click here to reset your password</a>
                              <br/><br/>Regards,
                              <br/>ECUTZ';
            $content = new SendGrid\Content("text/html",$htmlContent);
            $mail = new SendGrid\Mail($from, $subject, $to, $content);
            $sg = new \SendGrid($API_KEY);
            $response = $sg->client->mail()->send()->post($mail);
             if($response->statusCode() == 202)
                {
                    echo "1";
                }
                else 
                {
                    echo "4";  
                }
            //echo json_encode(array('Response'=>'true', 'message'=>'Please check your e-mail, we have sent a password reset link to your registered Email.'));
      }
        }
    }
       /**
     * This function used to load forgot password view
     */
   public function resetPassword()
    { 
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('admin/resetPassword');
        }
        else
        {
            redirect('/dashboard');
        }
    }
    /*Start forgotResetPassword API*/  
    public function forgotResetPassword(){ 
         $encode = $this->input->post("email");
         $email = base64_decode($this->input->post("email"));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        if($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', 'password and  connfirm passsword does not match');
        }
        else{
             $newPassword = md5($this->input->post('password'));
            $data  =$this->login_model->resetPassword($email,$newPassword);
         if($data == 1){
             $this->session->set_flashdata('success', 'Your password reset successfully, Please login with your new password.');
        }else{
             $this->session->set_flashdata('error', 'Password not updated, Please, do not use your previous password.');
        }
        }
        redirect('resetPassword?email='.$encode);
    }
/*End forgotResetPassword API*/ 
}

?>