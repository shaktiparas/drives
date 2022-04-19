<?php
error_reporting(0);
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
use Restserver\Libraries\REST_Controller;

// header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        define('HTTP_OK', '200');
        $this->load->database();
        $this->load->helper('url');
        $this->load->model('Users_model');
        $this->load->model('Home_model');
        $this->load->helper(['jwt', 'authorization']);
        $this->data = array(
            'amountSign' => '$',
            'currency' => $this->config->item('client_currency'),
            'country' =>  $this->config->item('country'),
            'mailApiKey' => $this->config->item(''),
            'fromMail' => 'shakti.parastechnologies@gmail.com',
            'serverKey' => $this->config->item('serverKey'),
            'stripe_secret' => $this->config->item('stripe_client_test_secret'),
            'twilio_sid' =>  $this->config->item('twilio_sid'),
            'twilio_token' =>  $this->config->item('twilio_token'),
            'twilio_phone' => $this->config->item('twilio_phone'),
            'twilio_message' => 'Here is your ECUTZ One-Time Verification Code'
        );
    }
    
public function stripeCredenatils(){
	 require_once('application/libraries/stripe-php-master/init.php');
         \Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
	}

public function fcmNotificationAndroid($title,$message,$firebasetoken,$type,$data)
{
    	$serverKey = "AAAA3QN4OnQ:APA91bFaJIXiXu-sXY_nMfpq6qeviZU61KyeSwvDT8-I0OYhiX4--N0yf3lXQLDKr8aNyiVTaiPSOL0s_1YmthgxSVD90naB5A1M-wjMuyEKvnrkHZZ0Eesw9I95cbXxbdnxpMck0nml";
    	$message1 = array
							(
							'body' 	=> $message,
							'title'	=> $title
							);
							$field=array("title" => $title,"message" => $message,"type" =>$type,"id" => $data); 

	
							$fields = array

								(

									'to'		=> $firebasetoken,
									'data'  => $field           

								);
   
							$headers = array

									(

										'Authorization: key=' . $serverKey,

										'Content-Type: application/json'

									);
            
							$ch = curl_init();

							curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );

							curl_setopt( $ch,CURLOPT_POST, true );

							curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );

							curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );

							curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );

							curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields) );

							$results=curl_exec($ch );
						
							
							$resultsArray=json_decode($results);
						//print_r($resultsArray);
							
						 return $success=$resultsArray->success;
							
}

public function fcmNotificationIos($title,$message,$firebasetoken,$type,$data)
{
    
								$url = "https://fcm.googleapis.com/fcm/send";

					$serverKey = "AAAA3QN4OnQ:APA91bFaJIXiXu-sXY_nMfpq6qeviZU61KyeSwvDT8-I0OYhiX4--N0yf3lXQLDKr8aNyiVTaiPSOL0s_1YmthgxSVD90naB5A1M-wjMuyEKvnrkHZZ0Eesw9I95cbXxbdnxpMck0nml";
              	
					$notification=array("title" => $title,"message" => $message,"body" => $message,"type" =>$type,"id" => $data,"sound" => "default", "badge" => "1"); 		
					
					$arrayToSend = array('to' => $firebasetoken, 'notification' => $notification,'priority'=>'high');
					 $json = json_encode($arrayToSend);
					$headers = array();
					$headers[] = 'Content-Type: application/json';
					$headers[] = 'Authorization: key='. $serverKey;
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);

					curl_setopt($ch, CURLOPT_CUSTOMREQUEST,

					"POST");
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
					curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
					$results=curl_exec($ch);
					
							$resultsArray=json_decode($results);
			//print_r($resultsArray);
						 return $success=$resultsArray->success;
					curl_close($ch);	
	
		
							
}    
    
    
 public function demoNotification()
    {
        $title="Hello";
        $message="Testing";
        $firebasetoken="dKTgohRQR1WQf0J7Eq4yzJ:APA91bF-nHU5EmCAKw8BA9rjmfnG2-vacvOS2mg1ewf47X5g8PTLecDG396C1JvVtULT_FSgGfshkkBQ3bUyB0Bh7diQ94IJp6e1eEfI4PmHj0SckUspy3UhTgBeaPtX52Vwb7lMPSBo";

         echo $success=$this->fcmNotificationAndroid($title,$message,$firebasetoken,"BuyerSendTestDriveRequest",NULL);
        
    }
    
     public function register()
    {
        $FirstName=$_POST['FirstName'];
        $LastName=$_POST['LastName'];
        $City=$_POST['City'];
        $gender=$_POST['gender'];
        $address=$_POST['address'];
        $dob=$_POST['dob'];
        $DL_ISSUE_DATE=$_POST['DL_ISSUE_DATE'];
        $DL_EXPIRE_DATE=$_POST['DL_EXPIRE_DATE'];
        $PhoneNumber=$_POST['PhoneNumber'];
        $SSN=$_POST['SSN'];
        $Username=$_POST['Username'];
        $Password=$_POST['Password'];
        $Email=$_POST['Email'];
        $device_type=$_POST['device_type'];
        $firebasetoken=$_POST['firebasetoken'];
        $latitude=$_POST['latitude'];
        $longitude=$_POST['longitude'];
        $user_type=$_POST['user_type'];
        $EmailSendStatus=$_POST['EmailSendStatus'];
        $SmsSendStatus=$_POST['SmsSendStatus'];

        if ($user_type=='') 
        {
            $response = array("success" => 0,"msg" =>"Please send correct user type.","data" => NULL);
        } 
        else 
        {
             
                  $email_check = $this->Users_model->checkExistEmail($Email);
                  
                    if($email_check)
                    {
                       
                        if(!empty($_FILES['DL_frontImage']['tmp_name']) && !empty($_FILES['DL_backendImage']['tmp_name']) && !empty($_FILES['image']['tmp_name']))
		                    {
		                        
		                      $tmpDlBackendFilePath = $_FILES['DL_backendImage']['tmp_name'];
    		                  $DL_backendImage=rand(10,100).$_FILES['DL_backendImage']['name'];
    		                  $DL_backendImage = "uploads/DL_Images/".$DL_backendImage;
    		                  
    		                  $tmpDlFrontendFilePath = $_FILES['DL_frontImage']['tmp_name'];
    		                  $DL_FrontImage=rand(10,100).$_FILES['DL_frontImage']['name'];
    		                  $DL_FrontImage = "uploads/DL_Images/".$DL_FrontImage;
    		                  
    		                  $tmpMainFilePath = $_FILES['image']['tmp_name'];
    		                  $ProfileImage=rand(10,100).$_FILES['image']['name'];
    		                  $ProfileImage = "uploads/profileImages/".$ProfileImage;
    		                  
                                if(move_uploaded_file($tmpDlBackendFilePath, $DL_backendImage) && move_uploaded_file($tmpDlFrontendFilePath, $DL_FrontImage) && move_uploaded_file($tmpMainFilePath, $ProfileImage))
                                {
               
                                $saveuserDetail = $this->Users_model->register($FirstName,$LastName,$City,$PhoneNumber,$Username,$Password,$Email,$gender,$address,$dob,$SSN,$DL_ISSUE_DATE,$DL_EXPIRE_DATE,$DL_backendImage,$DL_FrontImage,$ProfileImage,$device_type,$firebasetoken,$latitude,$longitude,$user_type,$EmailSendStatus,$SmsSendStatus);
                        
                                    if(!empty($saveuserDetail))
                                    {
                                   
                                    $token = JWT::encode($saveuserDetail, $this->config->item('jwt_key'));
                                    $saveuserDetail['token'] = $token;
                                   
                                   
                                    $response = array("success" => 1, "msg" => "Done User added!","data" => $saveuserDetail);
                                       
                                    }
                                    else
                                    {
                                     $response = array("success" => 0, "msg" => "User Not added!","data" => NULL); 
                                    } 
                                }
                                else
                                {
                                  $response=array('success' => 0,'msg' => 'Image uploading error');    
                                }   
		                    }
                            else
                            {
                                  $response=array('success' => 0,'msg' => 'Please select all image');    
                            }  
                     
                       
                    }
                    else
                    {
                        $response = array("success" => 0, "msg" => "Email already exist!","data" => NULL);
                    }
                
                
           
  
            
        }
    echo json_encode($response);
 }
 
 
 
  /* LOGIN */
     
    public function login()
    {
        $email=$_POST['Email'];
        $password=$_POST['Password'];
        $device_type=$_POST['device_type'];
        $firebasetoken=$_POST['firebasetoken'];
        $latitude=$_POST['latitude'];
        $longitude=$_POST['longitude'];
        $user_type=$_POST['user_type'];
       
            $userDetail = $this->Users_model->userLoginByEmail($email, $password,$user_type);
            if(!empty($userDetail))
            {
                $userid=$userDetail['id'];
                $updateToken=$this->Users_model->updateLoginToken($userid,$latitude,$longitude,$device_type,$firebasetoken);
                $userInfo = $this->Users_model->getUserProfileInfo($userid);
                $token = JWT::encode($userInfo, $this->config->item('jwt_key'));
                $userInfo['token'] = $token;
                
                if(!empty($userInfo))
                {
                     $response=array("success" => 1,"msg" => "User Logged In","data" =>$userInfo);
                }
                else
                {
                     $response=array("success" => 0,"msg" => "User Not Logged In","data" => NULL);  
                }
            }
            else
            {
               $response=array("success" => 0,"msg" => "User Not Logged In","data" => NULL); 
            }
        
       
        
        echo json_encode($response);
    }
 
 
    public function GetUserIdByToken()
    {
         $file = APPPATH.'../uploads/profileImages/23622789690788.6749.jpg';
    
     $size = filesize($file);
    $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $power = $size > 0 ? floor(log($size, 1024)) : 0;
    echo number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    
    die();
         $Token=$_POST['token'];
       // $Token="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6Ijk0Iiwic29jaWFsX2lkIjoiIiwiZW1haWwiOiIiLCJwYXNzd29yZCI6IjEyMzQ1NiIsInBob25lX251bWJlciI6Iis5MTg4NzI2NTY2NzciLCJvdHAiOiIyNzAyIiwiZGV2aWNlX3R5cGUiOiJJb3MiLCJzb2NpYWxfdHlwZSI6IiIsInN0YXR1cyI6IjAiLCJmaXJlYmFzZXRva2VuIjoiZm5oWW44NnRSay1idnhYQmVnallJZzpBUEE5MWJGZ0F5a3BHREFIUXhjX3JPWldfV2taZ0F0UUUwQVJCeWNXdExJTUZiaHhBSGNzZ2JscVNDM05vbkVFRllVZ2NOMDRTeWh4bjFOQ0Z4Tlc0ZlB5anZLRFpVX1hxREpnc3FMNkMxaGViazRFRWFaUTR5bW56M2FYWkVxejdjVFFyb2ZFaUR0biIsImxhdGl0dWRlIjoiMC4wIiwibG9uZ2l0dWRlIjoiMC4wIiwiTm90aWZpY2F0aW9uU3RhdHVzIjoiMSIsInBvaW50cyI6Ijc5OTkiLCJ1c2VyX2NyZWF0ZWRfZGF0ZSI6IjIwMjAtMDktMTAgMTM6MjI6MzAifQ.1MmGMQwujmCbRWstW4yhcU2aOUmCafoKoEOdDI92vGw";
        
           
            $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
            echo"<pre>";
            print_r($decoded);
            $phone_number=$decoded->phone_number;
            
    }
 
 
 // Deep linking
 
     public function deeplinking()
     {
          $email_id=$this->input->get('email', TRUE);
        
         ?>
         <HTML>
    <head>
    <title></title>
    <script> var arr =[]; 
    var userAgent = navigator.userAgent || navigator.vendor || window.opera;
    </script>
    </head>
    <body>
    <script type="text/javascript">
    function changeLink(applink,) 
    {
    window.location.href=applink;
    }
    	
    if( userAgent.match( /iPad/i ) || userAgent.match( /iPhone/i ) || userAgent.match( /iPod/i ) ) {
    changeLink("Drives://shakti.parastechnologies.in/drivesProject?email_id=<?php echo $email_id;?>");
    	/*setInterval(function () {
                  window.location.replace("https://apps.apple.com/us/app/imingle-social-events/id1465063328?ls=1");
          }, 6000);*/
    }
    else if( userAgent.match( /Android/i ) )
    {
    //changeLink("vocally_local://details?email_id=<?php echo $email_id;?>;id=vocallylocal.app.vocally");
    	 changeLink("newpasswordrestaurant://details?email_id=+<?php echo $email_id;?>+");
    	setInterval(function () {
                  window.location.replace("http://play.google.com/store/apps/details?id=com.jackbrestaurant");
          }, 2000);
    	
    }
    else
    {
       
    }
    </script>
    </body>
    </HTML>
    
    <?php
    
     }
      
    // Forgot Password
 
    public function forgotPassword()
    {
         $email=$_POST['Email'];
         $email_check = $this->Users_model->checkExistEmail($email);
         
         $url="http://shakti.parastechnologies.in/drivesProject/APIS/user/deeplinking?email=".$email;
	     $link="<a href='".$url."'>$url</a>";
	     
	     $subject = "Forgot Password";
	     $htmlContent = '<div style="width: 90%; margin-left: auto; margin-right: auto; background-color: #fff;"><p style="font-size: 24px">'.$link.'</p></div>';
   
         if(!$email_check)
         {
              $sendMessagee = $this->SMTP_mail($email,$subject,$htmlContent); 
             if($sendMessagee)
             {
                 	$response=array('success' => 1,'msg' => 'Link sent to the mail');   
             }
             else
             {
                 $response=array('success' => 0,'msg' => 'Link not sent to the mail'); 
             }
         }
         else
         {
             $response=array('success' => 0,'msg' => 'No account associated with this email Id');
         }
         
         echo json_encode($response);
        
    }


       /*start mail function*/
    public function mail($email,$subject,$message)
    {
        require 'vendor/autoload.php';
        $API_KEY = "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";
        $FROM_EMAIL = 'shakti.parastechnologies@gmail.com'; 
        $TO_EMAIL = $email; 
        $subject = $subject; 
        $from = new SendGrid\Email(null, $FROM_EMAIL);
        $to = new SendGrid\Email(null, $TO_EMAIL);
        $htmlContent = $message;
        $content = new SendGrid\Content("text/html",$htmlContent);
        $mail = new SendGrid\Mail($from, $subject, $to, $content);
        $sg = new \SendGrid($API_KEY);
        $response = $sg->client->mail()->send()->post($mail);
       
        if($response->statusCode() == 202)
        {
            return true;
        }
        else 
        {
            return false;  
        }
    }
    
    public function SMTP_mail($email,$subject,$message){
        require 'PHPMailer/PHPMailerAutoload.php';
        
        $email="shakti@parastechnologies.com";
        $username="shakti";
        $mail = new PHPMailer;
        $mail->isSMTP();   
        $mail->Host = 'ws156.win.arvixe.com';                      
        $mail->SMTPAuth = true;    
        $mail->SMTPDebug = 0;                          
        $mail->Username = 'noreply@mlstricity.com';                  
        $mail->Password = '2gTmt59@';      
       // $mail->SMTPSecure =;                           
        $mail->Port = 26;                                    
         
        $mail->setFrom('michael.napolitano@ecutzapp.com', 'ECUTZ'); 
        $mail->addAddress($email,$username);  
        $mail->addReplyTo("no_reply@gmail.com", 'Reply');
       // $mail->addCC($email);
        //$mail->addBCC($email);
        $mail->WordWrap = 50;                                
        $mail->isHTML(true);                                
        $mail->Subject =$subject;
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        $TOTALMSG='<div style="width: 90%; margin-left: auto; margin-right: auto; background-color: #fff;"><p style="font-size: 24px">'.$message.'</p></div>';
        $mail->msgHTML($TOTALMSG);
        $isChecked =$mail->send();
        if($isChecked){
            $array =  array("success"=> 1);
        }
        else {
            $array =  array("success"=> 0);
        }
        return $array;
    }
    
    
    public function forgotPasswordStep2()
    {
         $email=$_POST['Email'];
         $password=$_POST['Password'];
         $email_check = $this->Users_model->checkExistEmail($email);
         
         
         if(!$email_check)
         {
         
            $updatePassword = $this->Users_model->updatePassword($email,$password);
             if($updatePassword)
             {
                  $response=array('success' => 1,'msg' => 'Password Successfully Updated');  
             }
             else
             {
                 $response=array('success' => 0,'msg' => 'Password not updated'); 
             }
         }
         else
         {
             $response=array('success' => 0,'msg' => 'No account associated with this email Id');
         }
         
         echo json_encode($response);
        
    }
    
     public function ChangePassword()
    {
        
        $Token=$_POST['token'];
        $oldPassword=$_POST['oldPassword'];
        $newPassword=$_POST['newPassword'];
        $confirmPassword=$_POST['confirmPassword'];
        
        if ($Token=='') 
        {
            $response = array(
				'success'	=>	0,
				'data'		=>	"Enter all params"
			) ;	
			
        } 
        else
        {
            if($newPassword==$confirmPassword)
            {
                $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
                    
                $userid=$decoded->id;
                $checkPassword = $this->Users_model->checkPassword($userid,$oldPassword); 
                 if($checkPassword)
                 {
                  
                    $updatePassword = $this->Users_model->updatePasswordByUserID($userid,$newPassword);
                     if($updatePassword)
                     {
                          $response=array('success' => 1,'msg' => 'Password Successfully Updated');  
                     }
                     else
                     {
                         $response=array('success' => 0,'msg' => 'Password not updated'); 
                     }
                 }
                 else
                 {
                     $response=array('success' => 0,'msg' => 'Old Password is wrong.Please try again');
                 }
         
            }
            else
            {
                $response=array('success' => 0,'msg' => 'New Password and Confirm password should be same');
            }
         
        }
         echo json_encode($response);
         
    }
         
        
    
    
    public function get_profile()
    {
       
         $Token=$_POST['token'];
        
        if ($Token=='') 
        {
            $response = array(
				'success'	=>	0,
				'data'		=>	"Enter all params"
			) ;	
			
        } 
        else 
        {
           
            $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
            
             $userid=$decoded->id;
            if ($userid) 
            {
                $userDetail = $this->Users_model->userDetailByid($userid);
               
               if (!empty($userDetail))
                {
                
                    $response=array("success" => 1,"msg"=>"Data Found","data" => $userDetail);
                }
                else 
                {
                    $response=array("success" => 0,"msg"=>"Data Not Found","data" => NULL);
                }
            } 
            else 
            {
                 $response=array("success" =>0 ,"msg"=>"Userid not present","data" => NULL);
            }
        }
        
         echo json_encode($response);
        
    }
    
    
    
    
    public function upload_profile_pic()
    {
       
         $Token=$_POST['token'];
         
        if ($Token=='') 
        {
            $response = array(
				'success'	=>	0,
				'data'		=>	"Enter all params"
			) ;	
			
        } 
        else 
        {
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
               
               if(!empty($_FILES['profile_image']['name']))
               {
               $tmpMainFilePath = $_FILES['profile_image']['tmp_name'];
    		                    $profileImages=rand(10,100).$_FILES['profile_image']['name'];
    		                     $profileimages = "uploads/profileImages/".$profileImages;
                                if(move_uploaded_file($tmpMainFilePath, $profileimages))
                                {
               
                                 $addCarDetails = $this->Users_model->updateProfilePic($userid,$profileimages);
                                 if($addCarDetails)
                                 {
                                    $response=array('success' => 1,'msg' => 'Profile pic updated');  
                                 }
                                 else
                                 {
                                    $response=array('success' => 0,'msg' => 'Profile pic not updated');  
                                 }
                                    
                                }
                                else
                                {
                                  $response=array('success' => 0,'msg' => 'Image uploading error');    
                                }
               }
               else
               {
                   $response=array('success' => 0,'msg' => 'Please select Image');  
               }
           
           
        }
        
         echo json_encode($response);
        
    }
    
    
      public function edit_profile()
    {
       
         $Token=$_POST['token'];
         $name=$_POST['name'];
         $gender=$_POST['gender'];
         $address=$_POST['address'];
         $state=$_POST['state'];
         $city=$_POST['city'];
         $zipcode=$_POST['zipcode'];
          $SSN=$_POST['SSN'];
        
        if ($Token=='') 
        {
            $response = array(
				'success'	=>	0,
				'data'		=>	"Enter all params"
			) ;	
			
        } 
        else 
        {
           
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
               
               if(!empty($_FILES['image']['tmp_name']))
		                    {
		                        
		                      $tmpMainFilePath = $_FILES['image']['tmp_name'];
    		                    $profileImages=rand(10,100).$_FILES['image']['name'];
    		                     $profileimages = "uploads/profileImages/".$profileImages;
                                if(move_uploaded_file($tmpMainFilePath, $profileimages))
                                {
               
                                 $profile = $this->Users_model->editProfile($name,$gender,$address,$state,$city,$zipcode,$profileimages,$SSN,$userid);
                                 if($profile)
                                 {
                                    $response=array('success' => 1,'msg' => 'Profile details updated','Image' => $profileimages);  
                                 }
                                 else
                                 {
                                    $response=array('success' => 0,'msg' => 'Profile details not updated');  
                                 }
                                    
                                }
                                else
                                {
                                  $response=array('success' => 0,'msg' => 'Image uploading error');    
                                }   
		                    }
		                    else
		                    {
		                        $profileimages="";
		                         $profile = $this->Users_model->editProfile($name,$gender,$address,$state,$city,$zipcode,$profileimages,$SSN,$userid);
                                
                                 if($profile)
                                 {
                                    $response=array('success' => 1,'msg' => 'Profile details updated','Image' => $profileimages);  
                                 }
                                 else
                                 {
                                    $response=array('success' => 0,'msg' => 'Profile details not updated1');  
                                 }
		                    }
               
           
           
        }
        
         echo json_encode($response);
        
    }
    
    
    
    public function UpdateNotificationStatus()
    {
         $Token=$_POST['token'];
         $status=$_POST['status'];
         
         if ($Token=='' || $status=='') 
        {
            $response = array(
				'success'	=>	0,
				'data'		=>	"Enter all params"
			) ;	
			
        } 
        else 
        {
        
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
               
              $updateStatus = $this->Users_model->ChangeNotificationStatus($userid,$status);
             if($updateStatus)
             {
                  $response=array('success' => 1,'msg' => 'Status Successfully Updated');  
             }
             else
             {
                 $response=array('success' => 0,'msg' => 'Status not updated'); 
             }
         }
         
         echo json_encode($response);
        
    }
    
    
    public function add_car()
    {
       
         $Token=$_POST['token'];
         $vehicleType=$_POST['vehicleType'];
         $carType=$_POST['carType'];
         $Model=$_POST['Model'];
         $Color=$_POST['Color'];
         $Brand=$_POST['Brand'];
         $Mileage=$_POST['Mileage'];
         $Seater=$_POST['Seater'];
         $Year=$_POST['Year'];
         $Price=$_POST['Price'];
         $Description=$_POST['Description'];
         
        if ($Token=='' || $vehicleType=='' || $carType=='') 
        {
            $response = array(
				'success'	=>	0,
				'data'		=>	"Enter all params"
			) ;	
			
        } 
        else 
        {
          
          
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
               
                $lastInsertId = $this->Users_model->add_car($vehicleType,$carType,$Model,$Color,$Brand,$Mileage,$Seater,$Year,$Price,$Description,$userid);
                                 if($lastInsertId)
                                 {
                                      if(!empty($_FILES['uploadedfile']['tmp_name']))
		                                {
                                                $total = count($_FILES['uploadedfile']['name']);
            	                          
                                               for( $i=0 ; $i < $total ; $i++ ) 
                                                {
                                        
                                                     $tmpFilePath = $_FILES['uploadedfile']['tmp_name'][$i];
                                                     if ($tmpFilePath != "")
                                                     {
                                                            $newImages=basename(rand(10,100).$_FILES['uploadedfile']['name'][$i]);
                                                            $images = "uploads/carImages/".$newImages;
                                                            if(move_uploaded_file($tmpFilePath, $images)) 
                                                            {
                                                                
                                                            $this->Users_model->add_car_image($images,$lastInsertId);
                                                            }
                                                     }
                                                }
		                                }
                                     
                                    $response=array('success' => 1,'msg' => 'Car added','carID' => $lastInsertId);  
                                 }
                                 else
                                 {
                                    $response=array('success' => 0,'msg' => 'Car not added');  
                                 } 
              
           
        }
        
         echo json_encode($response);
        
    }
    
    
    
    
      public function add_carV2()
    {
       
         $Token=$_POST['token'];
         $vehicleType=$_POST['vehicleType'];
         $carType=$_POST['carType'];
         $Model=$_POST['Model'];
         $Color=$_POST['Color'];
         $Brand=$_POST['Brand'];
         $Mileage=$_POST['Mileage'];
         $Seater=$_POST['Seater'];
         $Year=$_POST['Year'];
         $Price=$_POST['Price'];
         $Address=$_POST['Address'];
         $Description=$_POST['Description'];
         $uploadedfile=$_POST['uploadedfile'];
         
        if ($Token=='' || $vehicleType=='' || $carType=='') 
        {
            $response = array(
				'success'	=>	0,
				'data'		=>	"Enter all params"
			) ;	
			
        } 
        else 
        {
          
          
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
               
                $lastInsertId = $this->Users_model->add_car($vehicleType,$carType,$Model,$Color,$Brand,$Mileage,$Seater,$Year,$Price,$Address,$Description,$userid);
                                 if($lastInsertId)
                                 {
                                     
                                     $uploadedfile_array=explode(",",$uploadedfile);
                                    
                                     if(!empty($uploadedfile_array))
		                                {
                                                $total = count($uploadedfile_array);
            	                          
                                               for( $i=0 ; $i < $total ; $i++ ) 
                                                {
                                        
                                                          $images = $uploadedfile_array[$i];
                                                        $this->Users_model->add_car_image($images,$lastInsertId);
                                                }
		                                }
                                     /* if(!empty($_FILES['uploadedfile']['tmp_name']))
		                                {
                                                $total = count($_FILES['uploadedfile']['name']);
            	                          
                                               for( $i=0 ; $i < $total ; $i++ ) 
                                                {
                                        
                                                     $tmpFilePath = $_FILES['uploadedfile']['tmp_name'][$i];
                                                     if ($tmpFilePath != "")
                                                     {
                                                            $newImages=basename(rand(10,100).$_FILES['uploadedfile']['name'][$i]);
                                                            $images = "uploads/carImages/".$newImages;
                                                            if(move_uploaded_file($tmpFilePath, $images)) 
                                                            {
                                                                
                                                            $this->Users_model->add_car_image($images,$lastInsertId);
                                                            }
                                                     }
                                                }
		                                }*/
                                     
                                    $response=array('success' => 1,'msg' => 'Car added','carID' => $lastInsertId);  
                                 }
                                 else
                                 {
                                    $response=array('success' => 0,'msg' => 'Car not added');  
                                 } 
              
           
        }
        
         echo json_encode($response);
        
    }
    
    
    
      public function CarListingBuying()
    {
           $Token=$_POST['token'];
           
            $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
            $userid=$decoded->id;
               
           $carDetails = $this->Users_model->CarsBuyingListing($userid);
           if(!empty($carDetails))
           {
               
              $response=array('success' => 1,'msg' => 'Data Found','data' => $carDetails);    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Data not found','data' => NULL); 
           }
           
        
        
         echo json_encode($response);
        
    }
    
    // NEW API
    
      public function CarListingBuyingRTO_V1()
    {
           $Token=$_POST['token'];
           
            $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
            $userid=$decoded->id;
               
           $carDetails = $this->Users_model->CarListingBuyingRTO_V1($userid);
           if(!empty($carDetails))
           {
               
              $response=array('success' => 1,'msg' => 'Data Found','data' => $carDetails);    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Data not found','data' => NULL); 
           }
           
        
        
         echo json_encode($response);
        
    }
    
    
     public function CarListingBuyingByLocation()
    {
           $Token=$_POST['token'];
           $Latitude=$_POST['Latitude'];
           $Longitude=$_POST['Longitude'];
           
            $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
            $userid=$decoded->id;
               
           $carDetails = $this->Users_model->CarListingBuyingByLocation($Latitude,$Longitude,$userid);
           if(!empty($carDetails))
           {
               
              $response=array('success' => 1,'msg' => 'Data Found','data' => $carDetails);    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Data not found','data' => NULL); 
           }
           
        
        
         echo json_encode($response);
        
    }
    
    
      public function CarListingRent()
    {
       
          $Token=$_POST['token'];
          $Latitude=$_POST['Latitude'];
          $Longitude=$_POST['Longitude'];
         
            $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
            $userid=$decoded->id;
            
           $carDetails = $this->Users_model->CarsRentListing($userid,$Latitude,$Longitude);
           if(!empty($carDetails))
           {
               
              $response=array('success' => 1,'msg' => 'Data Found','data' => $carDetails);    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Data not found','data' => NULL); 
           }
           
        
        
         echo json_encode($response);
        
    }
    
    public function CarListingRentByLocation()
    {
          $Token=$_POST['token'];
          $Latitude=$_POST['Latitude'];
          $Longitude=$_POST['Longitude'];
           
            $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
            $userid=$decoded->id;
            
           $carDetails = $this->Users_model->CarRentListingByLocation($Latitude,$Longitude,$userid);
           if(!empty($carDetails))
           {
               
              $response=array('success' => 1,'msg' => 'Data Found','data' => $carDetails);    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Data not found','data' => NULL); 
           }
           
        
        
         echo json_encode($response);
        
    }
    
    
      public function CarListingTestDrive()
    {
           $Token=$_POST['token'];
       
        if ($Token=='') 
        {
            $response = array(
				'success'	=>	0,
				'data'		=>	"Enter all params"
			) ;	
			
        } 
        else 
        {
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
              
           $carDetails = $this->Users_model->CarsRTOListing($userid);
           if(!empty($carDetails))
           {
               
              $response=array('success' => 1,'msg' => 'Data Found','data' => $carDetails);    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Data not found','data' => NULL); 
           }
           
        }
        
         echo json_encode($response);
        
    }
    
    
    
      public function CarListingRTO()
    {
           $Token=$_POST['token'];
       
        if ($Token=='') 
        {
            $response = array(
				'success'	=>	0,
				'data'		=>	"Enter all params"
			) ;	
			
        } 
        else 
        {
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
              
           $carDetails = $this->Users_model->CarListingRTO($userid);
           if(!empty($carDetails))
           {
               
              $response=array('success' => 1,'msg' => 'Data Found','data' => $carDetails);    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Data not found','data' => NULL); 
           }
           
        }
        
         echo json_encode($response);
        
    }
    
    
    
      public function FilterCarListingAtBuyer()
    {
           $Token=$_POST['token'];
           $vehicleType=$_POST['vehicleType'];
           $minPrice=$_POST['minPrice'];
           $maxPrice=$_POST['maxPrice'];
           $Latitude=$_POST['Latitude'];
           $Longitude=$_POST['Longitude'];
           
             
        if ($Token=='') 
        {
            $response = array(
				'success'	=>	0,
				'data'		=>	"Enter all params"
			) ;	
			
        } 
        else 
        {
            $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
            $userid=$decoded->id;
              
           
           $carDetails = $this->Users_model->CarsBuyingListingFilter($userid,$vehicleType,$minPrice,$maxPrice,$Latitude,$Longitude);
           
           if(!empty($carDetails))
           {
               
              $response=array('success' => 1,'msg' => 'Data Found','data' => $carDetails);    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Data not found','data' => NULL); 
           }
           
        }
        
         echo json_encode($response);
        
    }
    
    
     public function FilterCarListingForRentAtBuyer()
    {
           $Token=$_POST['token'];
           $vehicleType=$_POST['vehicleType'];
           $minPrice=$_POST['minPrice'];
           $maxPrice=$_POST['maxPrice'];
           $Latitude=$_POST['Latitude'];
           $Longitude=$_POST['Longitude'];
           
             
        if ($Token=='') 
        {
            $response = array(
				'success'	=>	0,
				'data'		=>	"Enter all params"
			) ;	
			
        } 
        else 
        {
            $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
            $userid=$decoded->id;
              
           
           $carDetails = $this->Users_model->CarsBuyingListingFilterForRent($userid,$vehicleType,$minPrice,$maxPrice,$Latitude,$Longitude);
           
           if(!empty($carDetails))
           {
               
              $response=array('success' => 1,'msg' => 'Data Found','data' => $carDetails);    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Data not found','data' => NULL); 
           }
           
        }
        
         echo json_encode($response);
        
    }
    
    
       public function BookTestDrive()
    {
       date_default_timezone_set('UTC');
       
         $Token=$_POST['token'];
         $car_id=$_POST['carID'];
         $TestDriveDate=$_POST['TestDriveDate'];
         $TestDriveTime=$_POST['TestDriveTime'];
         $Name=$_POST['Name'];
         $Phone=$_POST['Phone'];
         $Location=$_POST['Location'];
         $TestDriveRequestType="OBP";
        if ($Token=='' || $car_id=='') 
        {
            $response = array(
				'success'	=>	0,
				'data'		=>	"Enter all params"
			) ;	
			
        } 
        else 
        {
           
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
               $currdate=date("Y-m-d H:i:s");
		                       
		                        $testDrive = $this->Users_model->BookTestDrive($car_id,$userid,$TestDriveDate,$TestDriveTime,$Name,$Phone,$Location,$TestDriveRequestType,$currdate);
                                 if($testDrive)
                                 {
                                    
                                    $BuyerDetailsN = $this->Users_model->userDetailByid1($userid);
                                    $BuyerUsernameN=$BuyerDetailsN['Username'];
                                     
                                      $SellerDetails = $this->Users_model->SellerDetailsByCarID($car_id);
                                  
                                      $device_type=$SellerDetails['device_type'];
                                      $NotificationStatus=$SellerDetails['NotificationStatus'];
                                      $firebasetoken=$SellerDetails['firebasetoken'];
                                      $SellerID=$SellerDetails['id'];
                                      $title="New OBP TestDrive Request";
                                      $message="Please ACCEPT or CHANGE the test-drive request for OBP sent by ".$BuyerUsernameN;
                         	if($device_type=='Android' && $NotificationStatus==1)
			                {
			                  
    				          $success=$this->fcmNotificationAndroid($title,$message,$firebasetoken,"BuyerSendTestDriveRequest",NULL);
    				            if($success==1)
    				            {
    				                 $SaveNotification = $this->Users_model->SaveNoification($userid,$SellerID,$message,"BuyerSendTestDriveRequest",$currdate);
    				            }
    		
					
			                }
			                
				            elseif($device_type=='Ios' && $NotificationStatus ==1)
						    {
					 
                                  $success=$this->fcmNotificationIos($title,$message,$firebasetoken,"BuyerSendTestDriveRequest",NULL);
    				            if($success==1)
    				            {
    				                $SaveNotification = $this->Users_model->SaveNoification($userid,$SellerID,$message,"BuyerSendTestDriveRequest",$currdate);
    				            }
    						
					        }
            				else
            				{
            		
            				}
                                                 
                                $response=array('success' => 1,'msg' => 'Test Drive Request Sent');  
                                 }
                                 else
                                 {
                                    $response=array('success' => 0,'msg' => 'Test Drive Request Not Sent');  
                                 }
		                
              
          
           
           
        }
        
         echo json_encode($response);
        
    }
    
    
    
      public function BookRTO()
    {
       date_default_timezone_set('UTC');
       
         $Token=$_POST['token'];
         $car_id=$_POST['carID'];
         $TestDriveDate=$_POST['TestDriveDate'];
         $TestDriveTime=$_POST['TestDriveTime'];
         $Name=$_POST['Name'];
         $Phone=$_POST['Phone'];
         $Location=$_POST['Location'];
         $TestDriveRequestType="RTO";
        if ($Token=='' || $car_id=='') 
        {
            $response = array(
				'success'	=>	0,
				'data'		=>	"Enter all params"
			) ;	
			
        } 
        else 
        {
           
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
               $currdate=date("Y-m-d H:i:s");
		                       
		                        $testDrive = $this->Users_model->BookTestDrive($car_id,$userid,$TestDriveDate,$TestDriveTime,$Name,$Phone,$Location,$TestDriveRequestType,$currdate);
                                 if($testDrive)
                                 {
                                      $response=array('success' => 1,'msg' => 'Test Drive Request Sent');  
                                    
                                      $SellerDetails = $this->Users_model->SellerDetailsByCarID($car_id);
                                  
                                      $device_type=$SellerDetails['device_type'];
                                      $NotificationStatus=$SellerDetails['NotificationStatus'];
                                      $firebasetoken=$SellerDetails['firebasetoken'];
                                      $SellerID=$SellerDetails['id'];
                                      $title="New RTO TestDrive Request";
                                      $message="Please ACCEPT or CHANGE the test-drive request for RTO sent by ".$Name;
                         	if($device_type=='Android' && $NotificationStatus==1)
			                {
			                  
    				          $success=$this->fcmNotificationAndroid($title,$message,$firebasetoken,"BuyerSendRTOTestDriveRequest",NULL);
    				            if($success==1)
    				            {
    				                 $SaveNotification = $this->Users_model->SaveNoification($userid,$SellerID,$message,"BuyerSendRTOTestDriveRequest",$currdate);
    				            }
    		
					
			                }
			                
				            elseif($device_type=='Ios' && $NotificationStatus ==1)
						    {
					 
                                  $success=$this->fcmNotificationIos($title,$message,$firebasetoken,"BuyerSendRTOTestDriveRequest",NULL);
    				            if($success==1)
    				            {
    				                $SaveNotification = $this->Users_model->SaveNoification($userid,$SellerID,$message,"BuyerSendRTOTestDriveRequest",$currdate);
    				            }
    						
					        }
            				else
            				{
            		
            				}
                                                 
                               
                                 }
                                 else
                                 {
                                    $response=array('success' => 0,'msg' => 'Test Drive Request Not Sent');  
                                 }
		                
              
          
           
           
        }
        
         echo json_encode($response);
        
    }
    
    
    
       public function BookCarOnRent()
    {
       date_default_timezone_set('UTC');
       
         $Token=$_POST['token'];
         $car_id=$_POST['carID'];
         $FromDate=$_POST['FromDate'];
         $ToDate=$_POST['ToDate'];
         $FromTime=$_POST['FromTime'];
         $ToTime=$_POST['ToTime'];
         $IsDeliveryMyPlace=$_POST['IsDeliveryMyPlace'];
         $IsPickupAfterUse=$_POST['IsPickupAfterUse'];
         
         $totalAmount=$_POST['totalAmount'];
         $DeliveryCost=$_POST['DeliveryCost'];
         $pickupCost=$_POST['pickupCost'];
         $PerDayCost=$_POST['PerDayCost'];
         $TotalDays=$_POST['TotalDays'];
         $FuelCostsTotal=$_POST['FuelCostsTotal'];
         $CleaningCostTotal=$_POST['CleaningCostTotal'];
         $ReservationFeeTotal=$_POST['ReservationFeeTotal'];
       
        if ($Token=='' || $car_id=='') 
        {
            $response = array(
				'success'	=>	0,
				'data'		=>	"Enter all params"
			) ;	
			
        } 
        else 
        {
           
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
              
               $userid=$decoded->id;
               $currdate=date("Y-m-d H:i:s");
		                       
		                        $testDrive = $this->Users_model->BookCarOnRent($userid,$car_id,$FromDate,$ToDate,$FromTime,$ToTime,$IsDeliveryMyPlace,$IsPickupAfterUse,$totalAmount,$DeliveryCost,$pickupCost,$PerDayCost,$TotalDays,$FuelCostsTotal,$CleaningCostTotal,$ReservationFeeTotal,$currdate);
                                 if($testDrive)
                                 {
                                     
                                     $BuyerDetailsN = $this->Users_model->userDetailByid1($userid);
                                     $BuyerUsernameN=$BuyerDetailsN['Username'];
                                     
                                      $SellerDetails = $this->Users_model->SellerDetailsByCarID($car_id);
                                  
                                      $device_type=$SellerDetails['device_type'];
                                      $NotificationStatus=$SellerDetails['NotificationStatus'];
                                      $firebasetoken=$SellerDetails['firebasetoken'];
                                      $SellerID=$SellerDetails['id'];
                                      
                                      $title="New Rent Request Received";
                                      $message="Please ACCEPT or Reject the rent request sent by ".$BuyerUsernameN;
                         	        if($device_type=='Android' && $NotificationStatus==1)
        			                {
        			                  
            				          $success=$this->fcmNotificationAndroid($title,$message,$firebasetoken,"RenterSendRentRequest",NULL);
            				            if($success==1)
            				            {
            				                 $SaveNotification = $this->Users_model->SaveNoification($userid,$SellerID,$message,"RenterSendRentRequest",$currdate);
            				            }
            		
        					
        			                }
        			                
        				            elseif($device_type=='Ios' && $NotificationStatus ==1)
        						    {
        					 
                                          $success=$this->fcmNotificationIos($title,$message,$firebasetoken,"RenterSendRentRequest",NULL);
            				            if($success==1)
            				            {
            				                $SaveNotification = $this->Users_model->SaveNoification($userid,$SellerID,$message,"RenterSendRentRequest",$currdate);
            				            }
            						
        					        }
        					        else
        					        {
        					            
        					        }
                                    $response=array('success' => 1,'msg' => 'Request Sent For Renting Car');  
                                 }
                                 else
                                 {
                                    $response=array('success' => 0,'msg' => 'Request Sent Problem');  
                                 }
		                
              
          
           
           
        }
        
         echo json_encode($response);
        
    }
    
 
 
 
       public function ShowStaticContent()
    {
          
           $Data = $this->Users_model->ShowStaticContent();
           if(!empty($Data))
           {
               
              $response=array('success' => 1,'msg' => 'Data Found','data' => $Data);    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Data not found','data' => NULL); 
           }
           
        
        
         echo json_encode($response);
        
    }
    
   
    
     public function CarImages()
    {
       
         $carID=$_POST['carID'];
       
        if ($carID=='') 
        {
            $response = array(
				'success'	=>	0,
				'data'		=>	"Enter all params"
			) ;	
			
        } 
        else 
        {
           
                $CarImages= $this->Users_model->CarImages($carID);
               
               if (!empty($CarImages))
                {
                
                    $response=array("success" => 1,"msg"=>"Data Found","data" => $CarImages);
                }
                else 
                {
                    $response=array("success" => 0,"msg"=>"Data Not Found","data" => NULL);
                }
           
        }
        
         echo json_encode($response);
        
    }
    
    
       public function delete_car_image()
    {
       
    
         $imageID=$_POST['imageID'];
        
        if ($imageID=='') 
        {
            $response = array(
				'success'	=>	0,
				'data'		=>	"Enter all params"
			) ;	
			
        } 
        else 
        {
          
           $carDelete = $this->Users_model->DeleteCarImage($imageID);
           if($carDelete)
           {
              
              $response=array('success' => 1,'msg' => 'Image deleted');    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Image not deleted'); 
           }
           
           
           
        }
        
         echo json_encode($response);
        
    }
    
    

      public function edit_car()
    {
       
         $Token=$_POST['token'];
         $carID=$_POST['carID'];
         $vehicleType=$_POST['vehicleType'];
         $carType=$_POST['carType'];
         $Model=$_POST['Model'];
         $Color=$_POST['Color'];
         $Brand=$_POST['Brand'];
         $Mileage=$_POST['Mileage'];
         $Seater=$_POST['Seater'];
         $Year=$_POST['Year'];
         $Price=$_POST['Price'];
         $Address=$_POST['Address'];
         $Description=$_POST['Description'];
         $uploadedfile=$_POST['uploadedfile'];
        
        if ($Token=='' || $carID=='') 
        {
            $response = array(
				'success'	=>	0,
				'data'		=>	"Enter Token & carID"
			) ;	
			
        } 
        else 
        {
           
           $checkCar = $this->Users_model->checkExistCar($carID);
           if($checkCar)
           {
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
               
              
		                        $profileimages="";
		                        $addCarDetails = $this->Users_model->EditCar($vehicleType,$carType,$Model,$Color,$Brand,$Mileage,$Seater,$Year,$Price,$Address,$Description,$userid,$carID);
                                 if($addCarDetails)
                                 {
                                    
                                    $uploadedfile_array=explode(",",$uploadedfile);
                                    
                                     if(!empty($uploadedfile_array))
		                                {
                                                $total = count($uploadedfile_array);
            	                          
                                               for( $i=0 ; $i < $total ; $i++ ) 
                                                {
                                        
                                                          $images = $uploadedfile_array[$i];
                                                         $this->Users_model->add_car_image($images,$carID);
                                                }
		                                }
                                    $response=array('success' => 1,'msg' => 'Car details updated');  
                                 }
                                 else
                                 {
                                    $response=array('success' => 0,'msg' => 'Car details not updated');  
                                 }
		                  
              
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Car Not Exist'); 
           }
           
           
           
        }
        
         echo json_encode($response);
        
    }
    
    
      public function delete_car()
    {
       
         $Token=$_POST['token'];
         $car_id=$_POST['carID'];
        
        if ($Token=='' || $car_id=='') 
        {
            $response = array(
				'success'	=>	0,
				'data'		=>	"Enter all params"
			) ;	
			
        } 
        else 
        {
           $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));  
           $userid=$decoded->id;
           $carDelete = $this->Users_model->DeleteCar($car_id);
           if($carDelete)
           {
              
              $response=array('success' => 1,'msg' => 'Car deleted');    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Car not deleted'); 
           }
           
           
           
        }
        
         echo json_encode($response);
        
    }
    
    
     public function help_center()
    {
         $token=$_POST['token'];
         $subject=$_POST['subject'];
         $message=$_POST['message'];
         
         $decoded = JWT::decode($token, $this->config->item('jwt_key'), array('HS256'));
         $userid=$decoded->id;
               
         $email = "appsdeveloper22@gmail.com";
	    // $subject = "Customer Help Center";
	     $htmlContent = '<div style="width: 90%; margin-left: auto; margin-right: auto; background-color: #fff;"><p style="font-size: 24px">'.$message.'</p></div>';
   
         
              $sendMessagee = $this->mail($email,$subject,$htmlContent); 
             if($sendMessagee)
             {
                   $carDetails = $this->Users_model->addMessageHelpCenter($subject,$message,$userid);
                 	$response=array('success' => 1,'msg' => 'Link sent to the mail');   
             }
             else
             {
                 $response=array('success' => 0,'msg' => 'Link not sent to the mail'); 
             }
        
         
         echo json_encode($response);
        
    }
    
    
     public function logout()
    {
         $token=$_POST['token'];
         
         $decoded = JWT::decode($token, $this->config->item('jwt_key'), array('HS256'));
         $userid=$decoded->id;
               
         
        $logout = $this->Users_model->logout($userid);
             
        if($logout)
    {
       
    $response=array("success" => 1,
     "msg" => "User Logged Out");
     
    }
    else
    {
    $response=array("success" => 0,
     "msg" => "User Not Logged Out");
    }
         
         echo json_encode($response);
        
    }

 
 
     public function CarSellingListSellerSide()
        {
          
             $Token=$_POST['token'];
             
            
            if ($Token=='') 
            {
                $response = array(
    				'success'	=>	0,
    				'data'		=>	"Enter all params"
    			) ;	
    			
            } 
            else 
            {
               
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
               
               
               
           $carDetails = $this->Users_model->CarSellingListSellerSide($userid);
           if(!empty($carDetails))
           {
               
              $response=array('success' => 1,'msg' => 'Data Found','data' => $carDetails);    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Data not found','data' => NULL); 
           }
           
        
            }
         echo json_encode($response);
        
        }
        
        
    
      public function CarSoldListSellerSide()
        {
          
             $Token=$_POST['token'];
             //$Token="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjM3IiwiRmlyc3ROYW1lIjoiQmhhd2FuaSIsIkxhc3ROYW1lIjoiU2luZ2giLCJDaXR5IjoiTW9oYWxpIiwiUGhvbmVOdW1iZXIiOiI5ODE1NTA3ODk2IiwiVXNlcm5hbWUiOiJiaGF3YW5pc2luZ2giLCJQYXNzd29yZCI6ImUxMGFkYzM5NDliYTU5YWJiZTU2ZTA1N2YyMGY4ODNlIiwiRW1haWwiOiJ0ZXN0Ymhhd2FuaUBnbWFpbC5jb20iLCJHZW5kZXIiOiJNYWxlIiwiQWRkcmVzcyI6InNicCBob21lcyAzIiwiU3RhdGUiOiJQdW5qYWIiLCJaaXBjb2RlIjoiMTQwMzAxIiwiRE9CIjoiIiwiRExfSVNTVUVfREFURSI6IiIsIkRMX0VYUElSRV9EQVRFIjoiIiwiRExfRnJvbnRJbWFnZSI6InVwbG9hZHNcL0RMX0ltYWdlc1wvNzVjcm9wcGVkODY5OTkzMzQ3MzEzODIxMDcwNy5qcGciLCJETF9CYWNrZW5kSW1hZ2UiOiJ1cGxvYWRzXC9ETF9JbWFnZXNcLzUzY3JvcHBlZDUwMTQzODkwODc4OTgzNzc1MDAuanBnIiwiSW1hZ2UiOiJ1cGxvYWRzXC9wcm9maWxlSW1hZ2VzXC84NTE2MDk5MDk4OTI5NDAuanBnIiwiZGV2aWNlX3R5cGUiOiJBbmRyb2lkIiwiZmlyZWJhc2V0b2tlbiI6ImZSSDhvMHZ1U1hLUGpFcW5Eb1h6Ynk6QVBBOTFiR0tNTnhSaG83R0c3ZURjeVBnandyYzV3RF9ySTNPRl84R3hVU1k0SGlwdWVPMmZPZW9EcUY0OEpZTUFnSk94NXFfQ3BTb2JzcDdxOWpldlhOcml3dGZzei1iTzdfWHRFUHlXek5lVlFMRDkwWHlfUkltVE11MmZFSGRaeTdLUThYeG9mdXMiLCJsYXRpdHVkZSI6IiIsImxvbmdpdHVkZSI6IiIsInVzZXJUeXBlIjoiU2VsbGVyIiwiRW1haWxTZW5kU3RhdHVzIjoiMCIsIlNtc1NlbmRTdGF0dXMiOiIwIiwiTm90aWZpY2F0aW9uU3RhdHVzIjoiMSIsImFkZGVkRGF0ZSI6IjIwMjEtMDEtMDggMTI6NTM6MDAifQ.inflfLpIOGV9ceMX8xD1CRntw3yuakBmCBdzx92yKtI";
            
            if ($Token=='') 
            {
                $response = array(
    				'success'	=>	0,
    				'data'		=>	"Enter all params"
    			) ;	
    			
            } 
            else 
            {
               
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
                $userid=$decoded->id;
               
               
               
           $carDetails = $this->Users_model->CarSoldListSellerSide($userid);
           if(!empty($carDetails))
           {
               
              $response=array('success' => 1,'msg' => 'Data Found','data' => $carDetails);    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Data not found','data' => NULL); 
           }
           
        
            }
         echo json_encode($response);
        
        }
        
        
        
        
         public function SellerMyRentCarList()
        {
          
             $Token=$_POST['token'];
             //$Token="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjM3IiwiRmlyc3ROYW1lIjoiQmhhd2FuaSIsIkxhc3ROYW1lIjoiU2luZ2giLCJDaXR5IjoiTW9oYWxpIiwiUGhvbmVOdW1iZXIiOiI5ODE1NTA3ODk2IiwiVXNlcm5hbWUiOiJiaGF3YW5pc2luZ2giLCJQYXNzd29yZCI6ImUxMGFkYzM5NDliYTU5YWJiZTU2ZTA1N2YyMGY4ODNlIiwiRW1haWwiOiJ0ZXN0Ymhhd2FuaUBnbWFpbC5jb20iLCJHZW5kZXIiOiJNYWxlIiwiQWRkcmVzcyI6InNicCBob21lcyAzIiwiU3RhdGUiOiJQdW5qYWIiLCJaaXBjb2RlIjoiMTQwMzAxIiwiRE9CIjoiIiwiRExfSVNTVUVfREFURSI6IiIsIkRMX0VYUElSRV9EQVRFIjoiIiwiRExfRnJvbnRJbWFnZSI6InVwbG9hZHNcL0RMX0ltYWdlc1wvNzVjcm9wcGVkODY5OTkzMzQ3MzEzODIxMDcwNy5qcGciLCJETF9CYWNrZW5kSW1hZ2UiOiJ1cGxvYWRzXC9ETF9JbWFnZXNcLzUzY3JvcHBlZDUwMTQzODkwODc4OTgzNzc1MDAuanBnIiwiSW1hZ2UiOiJ1cGxvYWRzXC9wcm9maWxlSW1hZ2VzXC84NTE2MDk5MDk4OTI5NDAuanBnIiwiZGV2aWNlX3R5cGUiOiJBbmRyb2lkIiwiZmlyZWJhc2V0b2tlbiI6IiIsImxhdGl0dWRlIjoiIiwibG9uZ2l0dWRlIjoiIiwidXNlclR5cGUiOiJTZWxsZXIiLCJFbWFpbFNlbmRTdGF0dXMiOiIwIiwiU21zU2VuZFN0YXR1cyI6IjAiLCJOb3RpZmljYXRpb25TdGF0dXMiOiIxIiwiYWRkZWREYXRlIjoiMjAyMS0wMS0wOCAxMjo1MzowMCJ9.wUXz9hd7gkyndmKIOPmE-99rD02JqBbegM0JZs7Ov4g";
            
            if ($Token=='') 
            {
                $response = array(
    				'success'	=>	0,
    				'data'		=>	"Enter all params"
    			) ;	
    			
            } 
            else 
            {
               
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
               
               
               
           $carDetails = $this->Users_model->SellerMyRentCarList($userid);
           if(!empty($carDetails))
           {
               
              $response=array('success' => 1,'msg' => 'Data Found','data' => $carDetails);    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Data not found','data' => NULL); 
           }
           
        
            }
         echo json_encode($response);
        
        }
        
        
        
        
      public function SearchCarListingBuyerSide()
    {
          $type=$_POST['type'];
          $search=$_POST['search'];
           
           $token=$_POST['token'];
         
         $decoded = JWT::decode($token, $this->config->item('jwt_key'), array('HS256'));
         $userid=$decoded->id;
               
            if ($type=='') 
            {
                $response = array(
    				'success'	=>	0,
    				'data'		=>	"Enter all params"
    			) ;	
    			
            } 
            else 
            {
               
                 
               $carDetails = $this->Users_model->SearchCarListingAtBuyer($type,$search,$userid);
               if(!empty($carDetails))
               {
                   
                  $response=array('success' => 1,'msg' => 'Data Found','data' => $carDetails);    
                   
               }
               else
               {
                   $response=array('success' => 0,'msg' => 'Data not found','data' => NULL); 
               }
           
            }
        
         echo json_encode($response);
        
    }
    
    
      public function AddToFavouriteCar()
    {
       
         $Token=$_POST['token'];
         $carID=$_POST['carID'];
         $Status=$_POST['Status'];
         
         /*
         $Token="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjMyIiwiRmlyc3ROYW1lIjoiTXkgQnV5ZXIgTSIsIkxhc3ROYW1lIjoiTUIiLCJDaXR5IjoiY2hhbmRpZ2FyaCAiLCJQaG9uZU51bWJlciI6IjU0NDU1NDU0NTQ1NDU0NTQiLCJVc2VybmFtZSI6Im15YnV5ZXIiLCJQYXNzd29yZCI6ImUxMGFkYzM5NDliYTU5YWJiZTU2ZTA1N2YyMGY4ODNlIiwiRW1haWwiOiJteWJ1eWVyQGdtYWlsLmNvbSIsIkdlbmRlciI6IkZlbWFsZSIsIkFkZHJlc3MiOiIjMjUsU2VjdG9yIDI5IENoYW5kaWdhcmggIiwiU3RhdGUiOiIiLCJaaXBjb2RlIjoiMTIzNDU4IiwiRE9CIjoiIDA2LTA5LTg1IiwiRExfSVNTVUVfREFURSI6IjEwLTAxLTE2IiwiRExfRVhQSVJFX0RBVEUiOiIxMC0wMS0xOCIsIkRMX0Zyb250SW1hZ2UiOiJ1cGxvYWRzXC9ETF9JbWFnZXNcLzQ2MTYwODc4NDc0NS4wMDQ4MzUxLmpwZyIsIkRMX0JhY2tlbmRJbWFnZSI6InVwbG9hZHNcL0RMX0ltYWdlc1wvNDAxNjA4Nzg0NzQ0Ljk5NTk3NS5qcGciLCJJbWFnZSI6InVwbG9hZHNcL3Byb2ZpbGVJbWFnZXNcLzE5MTYwODk2Nzk0Ny44NjA5NzEuanBnIiwiZGV2aWNlX3R5cGUiOiJJb3MiLCJmaXJlYmFzZXRva2VuIjoiIiwibGF0aXR1ZGUiOiIwLjAiLCJsb25naXR1ZGUiOiIwLjAiLCJ1c2VyVHlwZSI6IkJ1eWVyIiwiRW1haWxTZW5kU3RhdHVzIjoiMSIsIlNtc1NlbmRTdGF0dXMiOiIxIiwiTm90aWZpY2F0aW9uU3RhdHVzIjoiMSIsImFkZGVkRGF0ZSI6IjIwMjAtMTItMjQgMDQ6Mzk6MDYifQ.Nx-5cQV_iq1ro_gWRSHqkzbwR60IHQMqxuli3nZ6hcA";
         $carID=20;
         $Status=1;
         */
         
        if ($Token=='' || $carID=='') 
        {
            $response = array(
				'success'	=>	0,
				'data'		=>	"Enter all params"
			) ;	
			
        } 
        else 
        {
          
          
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
               
                $currdate=date("Y-m-d H:i:s");
                $lastInsertId = $this->Users_model->AddToFavourite($carID,$userid,$Status,$currdate);
                
                if($Status==0)
                {
                    $message="Unfavourite";
                }
                else
                {
                    $message="Favourite"; 
                }
                                 if($lastInsertId)
                                 {
                                      
                                     
                                    $response=array('success' => 1,'msg' => 'Car added to '.$message);  
                                 }
                                 else
                                 {
                                    $response=array('success' => 0,'msg' => 'Car not added '.$message);  
                                 } 
              
           
        }
        
         echo json_encode($response);
        
    }
    
    
 
      public function FavouriteCarListing()
    {
          $Token=$_POST['token'];
          $Latitude=$_POST['Latitude'];
          $Longitude=$_POST['Longitude'];
          //$Token="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjM4IiwiRmlyc3ROYW1lIjoiVGVzdDEiLCJMYXN0TmFtZSI6IkJ1eWVyIiwiQ2l0eSI6Im1vaGFsaSIsIlBob25lTnVtYmVyIjoiNjI4MDU3NzYwNSIsIlVzZXJuYW1lIjoiIiwiUGFzc3dvcmQiOiJlMTBhZGMzOTQ5YmE1OWFiYmU1NmUwNTdmMjBmODgzZSIsIkVtYWlsIjoidGVzdGJoYXdhbmlAeW9wbWFpbC5jb20iLCJHZW5kZXIiOiJNYWxlIiwiQWRkcmVzcyI6ImQxODUgIGZpcnN0IGZsb29yLCBwaGFzZSA4YiBpbmR1c3RyaWFsIGFyZWEgbW9oYWxpIiwiU3RhdGUiOiJQdW5qYWIiLCJaaXBjb2RlIjoiMTQwMzAxIiwiRE9CIjoiIiwiRExfSVNTVUVfREFURSI6IiIsIkRMX0VYUElSRV9EQVRFIjoiIiwiRExfRnJvbnRJbWFnZSI6InVwbG9hZHNcL0RMX0ltYWdlc1wvMTBjcm9wcGVkOTEyOTA0OTQyODEwMDQ3NDMzNy5qcGciLCJETF9CYWNrZW5kSW1hZ2UiOiJ1cGxvYWRzXC9ETF9JbWFnZXNcLzk1Y3JvcHBlZDM5NDIyNjgxMjIzODU1NjY0NTMuanBnIiwiSW1hZ2UiOiJ1cGxvYWRzXC9wcm9maWxlSW1hZ2VzXC8xMGNyb3BwZWQ3NjAzNzEyNTgyNDk1NjY0MzcuanBnIiwiZGV2aWNlX3R5cGUiOiJBbmRyb2lkIiwiZmlyZWJhc2V0b2tlbiI6ImVuVUpfRWJ5UWwyTkNnN1JkSnA3bGQ6QVBBOTFiSFV4X05rV0o1ZXBFMFRVTXdaTm9faENyQXdib1RqOFNSTG15aDU1UUZIRXI2OERzWGxPM29hZXROdS11SjR1OVAwNUMyQnpaeExPWFpOaXpDbm1zRW9FODByMnNwS2swWHg2X3JtVHphNVkzbG1TX3hHeU5fbTJPRGhNdUNEa0syZklQdEUiLCJsYXRpdHVkZSI6IiIsImxvbmdpdHVkZSI6IiIsInVzZXJUeXBlIjoiQnV5ZXIiLCJFbWFpbFNlbmRTdGF0dXMiOiIxIiwiU21zU2VuZFN0YXR1cyI6IjAiLCJOb3RpZmljYXRpb25TdGF0dXMiOiIxIiwiYWRkZWREYXRlIjoiMjAyMS0wMS0yMCAwOToyNjo1NCJ9.LCeekkgePTcqmjfF4iON5NEJYdEB0nNDbm-Kl_ytodo";
            
        if ($Token=='') 
        {
            $response = array(
				'success'	=>	0,
				'data'		=>	"Enter all params"
			) ;	
			
        } 
        else 
        {
          
          
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
           $carDetails = $this->Users_model->FavouriteCarListing($userid,$Latitude,$Longitude);
           if(!empty($carDetails))
           {
               
              $response=array('success' => 1,'msg' => 'Data Found','data' => $carDetails);    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Data not found','data' => NULL); 
           }
           
        }
        
         echo json_encode($response);
        
    }
    
    // UPCOMING APPOINTMENT PENDING REQUEST
    
       public function TestDriveRequestListing()
        {
          
             $Token=$_POST['token'];
             
            if ($Token=='') 
            {
                $response = array(
    				'success'	=>	0,
    				'data'		=>	"Enter all params"
    			) ;	
    			
            } 
            else 
            {
               
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
               
               
               
           $carDetails = $this->Users_model->TestDriveRequestListing($userid);
           if(!empty($carDetails))
           {
               
              $response=array('success' => 1,'msg' => 'Data Found','data' => $carDetails);    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Data not found','data' => NULL); 
           }
           
        
            }
         echo json_encode($response);
        
        }
        
      
    
      // UPCOMING APPOINTMENT COMPLETED REQUEST
    
       public function TestDriveCompletedAppointment()
        {
          
             $Token=$_POST['token'];
             
            if ($Token=='') 
            {
                $response = array(
    				'success'	=>	0,
    				'data'		=>	"Enter all params"
    			) ;	
    			
            } 
            else 
            {
               
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
               
               
               
           $carDetails = $this->Users_model->CompletedTestdriveRequest($userid);
           if(!empty($carDetails))
           {
               
              $response=array('success' => 1,'msg' => 'Data Found','data' => $carDetails);    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Data not found','data' => NULL); 
           }
           
        
            }
         echo json_encode($response);
        
        }
        
        
          // UPCOMING APPOINTMENT Accepted REQUEST
    
       public function TestDriveAcceptedAppointment()
        {
          
             $Token=$_POST['token'];
            if ($Token=='') 
            {
                $response = array(
    				'success'	=>	0,
    				'data'		=>	"Enter all params"
    			) ;	
    			
            } 
            else 
            {
               
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
               
               
               
           $carDetails = $this->Users_model->TestDriveAcceptedAppointment($userid);
           if(!empty($carDetails))
           {
               
              $response=array('success' => 1,'msg' => 'Data Found','data' => $carDetails);    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Data not found','data' => NULL); 
           }
           
        
            }
         echo json_encode($response);
        
        }
        
    
    
    
         public function AcceptOrRejectTestDrive()
    {
       
         $Token=$_POST['token'];
         $TestBookRequestID=$_POST['TestBookRequestID'];
         $Status=$_POST['Status'];
       
         /*
         $Token="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjM3IiwiRmlyc3ROYW1lIjoiQmhhd2FuaSIsIkxhc3ROYW1lIjoiU2luZ2giLCJDaXR5IjoiTW9oYWxpIiwiUGhvbmVOdW1iZXIiOiI5ODE1NTA3ODk2IiwiVXNlcm5hbWUiOiJiaGF3YW5pc2luZ2giLCJQYXNzd29yZCI6ImUxMGFkYzM5NDliYTU5YWJiZTU2ZTA1N2YyMGY4ODNlIiwiRW1haWwiOiJ0ZXN0Ymhhd2FuaUBnbWFpbC5jb20iLCJHZW5kZXIiOiJNYWxlIiwiQWRkcmVzcyI6InNicCBob21lcyAzIiwiU3RhdGUiOiJQdW5qYWIiLCJaaXBjb2RlIjoiMTQwMzAxIiwiRE9CIjoiIiwiRExfSVNTVUVfREFURSI6IiIsIkRMX0VYUElSRV9EQVRFIjoiIiwiRExfRnJvbnRJbWFnZSI6InVwbG9hZHNcL0RMX0ltYWdlc1wvNzVjcm9wcGVkODY5OTkzMzQ3MzEzODIxMDcwNy5qcGciLCJETF9CYWNrZW5kSW1hZ2UiOiJ1cGxvYWRzXC9ETF9JbWFnZXNcLzUzY3JvcHBlZDUwMTQzODkwODc4OTgzNzc1MDAuanBnIiwiSW1hZ2UiOiJ1cGxvYWRzXC9wcm9maWxlSW1hZ2VzXC84NTE2MDk5MDk4OTI5NDAuanBnIiwiZGV2aWNlX3R5cGUiOiJBbmRyb2lkIiwiZmlyZWJhc2V0b2tlbiI6IiIsImxhdGl0dWRlIjoiIiwibG9uZ2l0dWRlIjoiIiwidXNlclR5cGUiOiJTZWxsZXIiLCJFbWFpbFNlbmRTdGF0dXMiOiIwIiwiU21zU2VuZFN0YXR1cyI6IjAiLCJOb3RpZmljYXRpb25TdGF0dXMiOiIxIiwiYWRkZWREYXRlIjoiMjAyMS0wMS0wOCAxMjo1MzowMCJ9.wUXz9hd7gkyndmKIOPmE-99rD02JqBbegM0JZs7Ov4g";
         $TestBookRequestID=80;
         $Status="Accepted";
         */
         
        if ($Token=='' || $TestBookRequestID=='') 
        {
            $response = array(
				'success'	=>	0,
				'data'		=>	"Enter all params"
			) ;	
			
        } 
        else 
        {
          
          
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
               
                 $currdate=date("Y-m-d H:i:s");
                $lastInsertId = $this->Users_model->AcceptOrRejectTestDrive($TestBookRequestID,$Status);
                                 if($lastInsertId)
                                 {
                                     
                                       $BuyerDetails = $this->Users_model->BuyerDetailsByRequestID($TestBookRequestID);
                                       $CarDetails = $this->Users_model->CarDetailsByID($car_id);
                                       $SellerDetails = $this->Users_model->userDetailByid($userid);
                                       
                                       $SellerName=$SellerDetails['Username'];
                                       $Sellerdevice_type=$SellerDetails['device_type'];
                                       $SellerNotificationStatus=$SellerDetails['NotificationStatus'];
                                       $Sellerfirebasetoken=$SellerDetails['firebasetoken'];
                                       $SellerID=$SellerDetails['id'];
                                  
                                       $Buyerdevice_type=$BuyerDetails['device_type'];
                                       $BuyerNotificationStatus=$BuyerDetails['NotificationStatus'];
                                      $Buyerfirebasetoken=$BuyerDetails['firebasetoken'];
                                       $BuyerID=$BuyerDetails['id'];
                                       $DriveDate=$BuyerDetails['TestDriveDate'];
                                       $DriveTime=$BuyerDetails['TestDriveTime'];
                                       
                                        if($Status=='Accepted')
                                     {
                                     $NTYPES="SellerAcceptTestDriveRequest";
                                     }
                                     elseif($Status=='Rejected')
                                     {
                                        $NTYPES="SellerRejectTestDriveRequest"; 
                                     }
                                     else
                                     {
                                         
                                     }
                                       
                                       $title="OBP testDrive ".$Status;
                                       $Buyermessage="Your OBP request ".$Status." by ".$SellerName;
                                     
                                     	if($Buyerdevice_type=='Android' && $BuyerNotificationStatus==1)
            			                {
            			                  
                				           $success=$this->fcmNotificationAndroid($title,$Buyermessage,$Buyerfirebasetoken,$NTYPES,NULL);
                				            if($success==1)
                				            {
                				                 $SaveNotification = $this->Users_model->SaveNoification($userid,$BuyerID,$Buyermessage,$NTYPES,$currdate);
                				            }
                		
            					
            			                }
            			                
            				            elseif($Buyerdevice_type=='Ios' && $BuyerNotificationStatus ==1)
            						    {
            					           
                                              $success=$this->fcmNotificationIos($title,$Buyermessage,$Buyerfirebasetoken,$NTYPES,NULL);
                				            if($success==1)
                				            {
                				                $SaveNotification = $this->Users_model->SaveNoification($userid,$BuyerID,$Buyermessage,$NTYPES,$currdate);
                				            }
                						
            					        }
                        				else
                        				{
                        		
                        				}
                                      
                                      
                                      
                                      
                                      /* $Sellermessage="Please dropoff vehicle items for a 24hr test drive, at the following DVSS address on date ".$DriveDate." & no less than 2hrs prior to time ".$DriveTime."";
                                     
                                     	if($Sellerdevice_type=='Android' && $SellerNotificationStatus==1)
            			                {
            			                  
                				          $success=$this->fcmNotificationAndroid($Sellermessage,$Sellerfirebasetoken,"MessageToSellerAfterAccept",NULL);
                				            if($success==1)
                				            {
                				                 $SaveNotification = $this->Users_model->SaveNoification($BuyerID,$userid,$Buyermessage,$currdate);
                				            }
                		
            					
            			                }
            			                
            				            elseif($Sellerdevice_type=='Ios' && $SellerNotificationStatus ==1)
            						    {
            					 
                                              $success=$this-> fcmNotificationIos($Sellermessage,$Sellerfirebasetoken,"MessageToSellerAfterAccept",NULL);
                				            if($success==1)
                				            {
                				                $SaveNotification = $this->Users_model->SaveNoification($BuyerID,$userid,$Buyermessage,$currdate);
                				            }
                						
            					        }
                        				else
                        				{
                        		
                        				}*/
                                     
                                    $response=array('success' => 1,'msg' => 'Test Drive Request '.$Status.'');  
                                 }
                                 else
                                 {
                                    $response=array('success' => 0,'msg' => 'Request Updation Problem');  
                                 } 
              
           
        }
        
         echo json_encode($response);
        
    }
    
    
    
    
        public function DeclineTestDriveByBuyer()
    {
       
         $Token=$_POST['token'];
         $TestBookRequestID=$_POST['TestBookRequestID'];
         $Status=$_POST['Status'];
         
         
        if ($Token=='' || $TestBookRequestID=='') 
        {
            $response = array(
				'success'	=>	0,
				'data'		=>	"Enter all params"
			) ;	
			
        } 
        else 
        {
          
          
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
               
                 $currdate=date("Y-m-d H:i:s");
                $lastInsertId = $this->Users_model->DeclineTestDriveByBuyer($TestBookRequestID,$Status);
                                 if($lastInsertId)
                                 {
                                     
                                      $CarDetails = $this->Users_model->GetCarIDByTestReqID($TestBookRequestID);
                                      $car_id=$CarDetails['carID'];
                                      $SellerDetails = $this->Users_model->SellerDetailsByCarID($car_id);
                                       
                                      $BuyerDetails = $this->Users_model->userDetailByid($userid);
                                      
                                       $SellerName=$SellerDetails['Username'];
                                       $Sellerdevice_type=$SellerDetails['device_type'];
                                       $SellerNotificationStatus=$SellerDetails['NotificationStatus'];
                                       $Sellerfirebasetoken=$SellerDetails['firebasetoken'];
                                       $SellerID=$SellerDetails['id'];
                                  
                                       $BuyerName=$BuyerDetails['Username'];
                                       
                                       $title="RTO TestDrive Request Declined";
                                       $Sellermessage="Request for RTO decline by ".$BuyerName;
                                     
                                     	if($Sellerdevice_type=='Android' && $SellerNotificationStatus==1)
            			                {
            			                  
                				           $success=$this->fcmNotificationAndroid($title,$Sellermessage,$Sellerfirebasetoken,"declineByBuyerAfterAcceptedRTORequest",NULL);
                				            if($success==1)
                				            {
                				                 $SaveNotification = $this->Users_model->SaveNoification($userid,$SellerID,$Sellermessage,"declineByBuyerAfterAcceptedRTORequest",$currdate);
                				            }
                		
            					
            			                }
            			                
            				            elseif($Buyerdevice_type=='Ios' && $BuyerNotificationStatus ==1)
            						    {
            					           
                                              $success=$this->fcmNotificationIos($title,$Sellermessage,$Sellerfirebasetoken,"declineByBuyerAfterAcceptedRTORequest",NULL);
                				            if($success==1)
                				            {
                				                $SaveNotification = $this->Users_model->SaveNoification($userid,$SellerID,$Sellermessage,"declineByBuyerAfterAcceptedRTORequest",$currdate);
                				            }
                						
            					        }
                        				else
                        				{
                        		
                        				}
                                      
                                      
                                      
                                     
                                    $response=array('success' => 1,'msg' => 'Test Drive Request '.$Status.'');  
                                 }
                                 else
                                 {
                                    $response=array('success' => 0,'msg' => 'Request Updation Problem');  
                                 } 
              
           
        }
        
         echo json_encode($response);
        
    }
    
 
    
     public function RentRequestListingSellerSide()
        {
          
             $Token=$_POST['token'];
             
            if ($Token=='') 
            {
                $response = array(
    				'success'	=>	0,
    				'data'		=>	"Enter all params"
    			) ;	
    			
            } 
            else 
            {
               
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
               
               
               
           $RentcarDetails = $this->Users_model->RentRequestListingAtSellerSide($userid);
           if(!empty($RentcarDetails))
           {
               
              $response=array('success' => 1,'msg' => 'Data Found','data' => $RentcarDetails);    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Data not found','data' => NULL); 
           }
           
        
            }
         echo json_encode($response);
        
        }
        
    
      public function AcceptedRentRequestListingSellerSide()
        {
          
             $Token=$_POST['token'];
             
            if ($Token=='') 
            {
                $response = array(
    				'success'	=>	0,
    				'data'		=>	"Enter all params"
    			) ;	
    			
            } 
            else 
            {
               
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
               
               
               
           $RentcarDetails = $this->Users_model->AcceptedRentRequestAtSellerSide($userid);
           if(!empty($RentcarDetails))
           {
               
              $response=array('success' => 1,'msg' => 'Data Found','data' => $RentcarDetails);    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Data not found','data' => NULL); 
           }
           
        
            }
         echo json_encode($response);
        
        }
        
    
    
    
    
    
    
    
    public function MyRentRequestCars()
        {
          
            $Token=$_POST['token'];
           //$Token ="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjM4IiwiRmlyc3ROYW1lIjoiVGVzdDEiLCJMYXN0TmFtZSI6IkJ1eWVyIiwiQ2l0eSI6Im1vaGFsaSIsIlBob25lTnVtYmVyIjoiNjI4MDU3NzYwNSIsIlVzZXJuYW1lIjoiIiwiUGFzc3dvcmQiOiJkODU3OGVkZjg0NThjZTA2ZmJjNWJiNzZhNThjNWNhNCIsIkVtYWlsIjoidGVzdGJoYXdhbmlAeW9wbWFpbC5jb20iLCJHZW5kZXIiOiJNYWxlIiwiQWRkcmVzcyI6ImQxODUgIGZpcnN0IGZsb29yLCBwaGFzZSA4YiBpbmR1c3RyaWFsIGFyZWEgbW9oYWxpIiwiU3RhdGUiOiJQdW5qYWIiLCJaaXBjb2RlIjoiMTQwMzAxIiwiRE9CIjoiIiwiRExfSVNTVUVfREFURSI6IiIsIkRMX0VYUElSRV9EQVRFIjoiIiwiRExfRnJvbnRJbWFnZSI6InVwbG9hZHNcL0RMX0ltYWdlc1wvMTBjcm9wcGVkOTEyOTA0OTQyODEwMDQ3NDMzNy5qcGciLCJETF9CYWNrZW5kSW1hZ2UiOiJ1cGxvYWRzXC9ETF9JbWFnZXNcLzk1Y3JvcHBlZDM5NDIyNjgxMjIzODU1NjY0NTMuanBnIiwiSW1hZ2UiOiJ1cGxvYWRzXC9wcm9maWxlSW1hZ2VzXC8xMGNyb3BwZWQ3NjAzNzEyNTgyNDk1NjY0MzcuanBnIiwiZGV2aWNlX3R5cGUiOiJBbmRyb2lkIiwiZmlyZWJhc2V0b2tlbiI6IiIsImxhdGl0dWRlIjoiIiwibG9uZ2l0dWRlIjoiIiwidXNlclR5cGUiOiJCdXllciIsIkVtYWlsU2VuZFN0YXR1cyI6IjEiLCJTbXNTZW5kU3RhdHVzIjoiMCIsIk5vdGlmaWNhdGlvblN0YXR1cyI6IjEiLCJhZGRlZERhdGUiOiIyMDIxLTAxLTIwIDA5OjI2OjU0In0.4vOwePzsoTMq5FYrRD8vhGjVnG_XDZnYVOLLesl5SPY";
            if ($Token=='') 
            {
                $response = array(
    				'success'	=>	0,
    				'data'		=>	"Enter all params"
    			) ;	
    			
            } 
            else 
            {
               
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
                $userid=$decoded->id;
               
               
               
           $RentcarDetails = $this->Users_model->MyRentRequestCars($userid);
           if(!empty($RentcarDetails))
           {
               
              $response=array('success' => 1,'msg' => 'Data Found','data' => $RentcarDetails);    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Data not found','data' => NULL); 
           }
           
        
            }
         echo json_encode($response);
        
        }
    
    
    
    
    
         public function AcceptOrRejectRentRequestCar()
    {
       
         $Token=$_POST['token'];
         $RentRequestID=$_POST['RentRequestID'];
         $Status=$_POST['Status'];
         
         
        if ($Token=='' || $RentRequestID=='') 
        {
            $response = array(
				'success'	=>	0,
				'data'		=>	"Enter all params"
			) ;	
			
        } 
        else 
        {
          
          
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
               
                 $currdate=date("Y-m-d H:i:s");
                $lastInsertId = $this->Users_model->AcceptOrRejectRentRequest($RentRequestID,$Status);
                                 if($lastInsertId)
                                 {
                                     
                                    $response=array('success' => 1,'msg' => 'Rent Request '.$Status.'');
                                    
                                     $GetBuyerID=$this->Users_model->GetCarIDByRentReqID($RentRequestID);
                                     $BuyerID=$GetBuyerID['userID'];
                                     $CarID=$GetBuyerID['carID'];
                                     
                                     $SellerDetails=$this->Users_model->userDetailByid($userid);
                                     $carDetails=$this->Users_model->SellerDetailsByCarID($CarID);
                                     $CarModel=$carDetails['Model'];
                                     $SellerName=$SellerDetails['Username'];
                                     
                                     $BuyerDetails=$this->Users_model->userDetailByid($BuyerID);
                                     $device_type=$BuyerDetails['device_type'];
                                     $NotificationStatus=$BuyerDetails['NotificationStatus'];
                                     $firebasetoken=$BuyerDetails['firebasetoken'];
                                      
                                     
                                      $title=$SellerName." ".$Status." rental request";
                                       $message="Your rental request for the ".$CarModel." is ".$Status." by".$SellerName;
                                     
                                     	if($device_type=='Android' && $NotificationStatus==1)
            			                {
            			                  
                				           $success=$this->fcmNotificationAndroid($title,$message,$firebasetoken,"SharerAcceptRejectRentRequest",NULL);
                				            if($success==1)
                				            {
                				                 $SaveNotification = $this->Users_model->SaveNoification($BuyerID,$userid,$message,"SharerAcceptRejectRentRequest",$currdate);
                				            }
                		
            					
            			                }
            			                
            				            elseif($device_type=='Ios' && $NotificationStatus ==1)
            						    {
            					           
                                              $success=$this->fcmNotificationIos($title,$message,$Buyerfirebasetoken,"SharerAcceptRejectRentRequest",NULL);
                				            if($success==1)
                				            {
                				                $SaveNotification = $this->Users_model->SaveNoification($BuyerID,$userid,$message,"SharerAcceptRejectRentRequest",$currdate);
                				            }
                						
            					        }
                        				else
                        				{
                        		
                        				}
                                 }
                                 else
                                 {
                                    $response=array('success' => 0,'msg' => 'Request Updation Problem');  
                                 } 
              
           
        }
        
         echo json_encode($response);
        
    }
    
     public function saveCards()
    {
         $token=$_POST['token'];
         $holder_name=$_POST['holder_name'];
         $cardNumber=$_POST['cardNumber'];
         $cvv=$_POST['cvv'];
         $expiaryDate=$_POST['expiaryDate'];
         
         
         $decoded = JWT::decode($token, $this->config->item('jwt_key'), array('HS256'));
         $userid=$decoded->id;
        $date=date("Y-m-d H:i:s");
        $cardsArray=array("HolderName"=>$holder_name, "CardNumber" => $cardNumber,"ExpireDate" => $expiaryDate,"CVV" => $cvv,"userID" => $userid,"DefaultStatus" => 0,"addedDate"=>$date);
        $addCards = $this->Users_model->saveCards($cardsArray);
             if($addCards)
             {
                   
                 	$response=array('success' => 1,'msg' => 'Card successfully added');   
             }
             else
             {
                 $response=array('success' => 0,'msg' => 'Card not added'); 
             }
        
         
         echo json_encode($response);
        
    }
    
    /*  Get Card Details */
    
      public function GetCardDetails()
    {
         $token=$_POST['token'];
         
         if($token!='')
         {
             $decoded = JWT::decode($token, $this->config->item('jwt_key'), array('HS256'));
              $userid=$decoded->id;
         
            $Cards = $this->Users_model->GetCardByUserID($userid); 
            if(!empty($Cards))
            {
               $response=array('success' => 1,'msg' => 'Data Found','data' =>$Cards);
                 
            }
            else
            {
               $response=array('success' => 0,'msg' => 'Data Not Found','data' =>NULL);
            }
         }
         else
         {
             $response=array('success' => 0,'msg' => 'Please send cardID','data' =>NULL);
         }
         echo json_encode($response);
        
    }
    
    
    /*    Upload Image */
    
    public function UploadImage()
    {
          if(!empty($_FILES['carImage']['name']))
               {
               $tmpMainFilePath = $_FILES['carImage']['tmp_name'];
    		                    $profileImages=rand(10,100).$_FILES['carImage']['name'];
    		                     $profileimages = "uploads/carImages/".$profileImages;
                                if(move_uploaded_file($tmpMainFilePath, $profileimages))
                                {
               
                                    $response=array('success' => 1,'msg' => 'Image Uploaded','image' => $profileimages);  
                                 
                                }
                                else
                                {
                                  $response=array('success' => 0,'msg' => 'Image uploading error');    
                                }
               }
               else
               {
                   $response=array('success' => 0,'msg' => 'Please select Image');  
               }
               echo json_encode($response);
    }
    
   
     public function HowItWorks()
    {
         
            $howData = $this->Users_model->howItWorks(); 
            if(!empty($howData))
            {
               $response=array('success' => 1,'msg' => 'Data Found','data' =>$howData);
                 
            }
            else
            {
               $response=array('success' => 0,'msg' => 'Data Not Found','data' =>NULL);
            }
        
         echo json_encode($response);
        
    }
    
    
     public function CarAlreadyRentBookDate()
    {
         
         $token=$_POST['token'];
         $carID=$_POST['carID'];
        
        if ($token=='' && $carID=='') 
        {
            $response = array(
				'success'	=>	0,
				'data'		=>	"Enter all params"
			) ;	
			
        } 
        else
        {
         $decoded = JWT::decode($token, $this->config->item('jwt_key'), array('HS256'));
         $userid=$decoded->id;
       
            $DateData = $this->Users_model->CarAlreadyRentBookDate($carID); 
            if(!empty($DateData))
            {
               $response=array('success' => 1,'msg' => 'Data Found','data' =>$DateData);
                 
            }
            else
            {
               $response=array('success' => 0,'msg' => 'Data Not Found','data' =>NULL);
            }
        }
         echo json_encode($response);
        
    }
    
    
    
     public function PendingRentRequestCars()
        {
          
             $Token=$_POST['token'];
             
            if ($Token=='') 
            {
                $response = array(
    				'success'	=>	0,
    				'data'		=>	"Enter all params"
    			) ;	
    			
            } 
            else 
            {
               
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
               
               
               
           $RentRequestcarDetails = $this->Users_model->PendingRentRequestCars($userid);
           if(!empty($RentRequestcarDetails))
           {
               
              $response=array('success' => 1,'msg' => 'Data Found','data' => $RentRequestcarDetails);    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Data not found','data' => NULL); 
           }
           
        
            }
         echo json_encode($response);
        
        }
        
        
    
         public function CancelledRentRequestBuyerSide()
    {
       
         $Token=$_POST['token'];
         $RentRequestID=$_POST['RentRequestID'];
        
         
        if ($Token=='' || $RentRequestID=='') 
        {
            $response = array(
				'success'	=>	0,
				'data'		=>	"Enter all params"
			) ;	
			
        } 
        else 
        {
          
          
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
               
                 $currdate=date("Y-m-d H:i:s");
                $lastInsertId = $this->Users_model->CancelledRentRequestBuyerSide($RentRequestID);
                                 if($lastInsertId)
                                 {
                                      
                                     
                                    $response=array('success' => 1,'msg' => 'Rent Request Cancelled');  
                                 }
                                 else
                                 {
                                    $response=array('success' => 0,'msg' => 'Request Cancellation Problem');  
                                 } 
              
           
        }
        
         echo json_encode($response);
        
    }
        
    
    
      
         public function CancelledRentRequestOnGoingRenterSide()
    {
       
         $Token=$_POST['token'];
         $RentRequestID=$_POST['RentRequestID'];
        
         
        if ($Token=='' || $RentRequestID=='') 
        {
            $response = array(
				'success'	=>	0,
				'data'		=>	"Enter all params"
			) ;	
			
        } 
        else 
        {
          
          
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
               
                 $currdate=date("Y-m-d H:i:s");
                $lastInsertId = $this->Users_model->CancelledRentRequestBuyerSide($RentRequestID);
                                 if($lastInsertId)
                                 {
                                      
                                     
                                    $response=array('success' => 1,'msg' => 'Rent Request Cancelled');  
                                 }
                                 else
                                 {
                                    $response=array('success' => 0,'msg' => 'Request Cancellation Problem');  
                                 } 
              
           
        }
        
         echo json_encode($response);
        
    }
        
    
    
    
     public function OngoingRentRequestCars()
        {
          
             $Token=$_POST['token'];
             
            if ($Token=='') 
            {
                $response = array(
    				'success'	=>	0,
    				'data'		=>	"Enter all params"
    			) ;	
    			
            } 
            else 
            {
               
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
               
              
               
           $RentRequestcarDetails = $this->Users_model->OngoingRentRequestCars($userid);
           if(!empty($RentRequestcarDetails))
           {
               
              $response=array('success' => 1,'msg' => 'Data Found','data' => $RentRequestcarDetails);    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Data not found','data' => NULL); 
           }
           
        
            }
         echo json_encode($response);
        
        }
    
    
     public function UpcomingRentRequestCars()
        {
          
             $Token=$_POST['token'];
             
            if ($Token=='') 
            {
                $response = array(
    				'success'	=>	0,
    				'data'		=>	"Enter all params"
    			) ;	
    			
            } 
            else 
            {
               
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
                $userid=$decoded->id;
               
               
               
           $RentRequestcarDetails = $this->Users_model->UpcomingRentRequestCars($userid);
           if(!empty($RentRequestcarDetails))
           {
               
              $response=array('success' => 1,'msg' => 'Data Found','data' => $RentRequestcarDetails);    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Data not found','data' => NULL); 
           }
           
        
            }
         echo json_encode($response);
        
        }
        
        
        
        
         public function CancelledRentRequestCars()
        {
          
             $Token=$_POST['token'];
            if ($Token=='') 
            {
                $response = array(
    				'success'	=>	0,
    				'data'		=>	"Enter all params"
    			) ;	
    			
            } 
            else 
            {
               
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
               
               
               
           $RentRequestcarDetails = $this->Users_model->CancelledRentRequestCars($userid);
           if(!empty($RentRequestcarDetails))
           {
               
              $response=array('success' => 1,'msg' => 'Data Found','data' => $RentRequestcarDetails);    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Data not found','data' => NULL); 
           }
           
        
            }
         echo json_encode($response);
        
        }
        
        
        
        
        
           public function CompletedRentRequestCars()
        {
          
             $Token=$_POST['token'];
             
            if ($Token=='') 
            {
                $response = array(
    				'success'	=>	0,
    				'data'		=>	"Enter all params"
    			) ;	
    			
            } 
            else 
            {
               
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
                $userid=$decoded->id;
               
               
               
           $RentRequestcarDetails = $this->Users_model->CompletedRentRequestCars($userid);
           if(!empty($RentRequestcarDetails))
           {
               
              $response=array('success' => 1,'msg' => 'Data Found','data' => $RentRequestcarDetails);    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Data not found','data' => NULL); 
           }
           
        
            }
         echo json_encode($response);
        
        }
        
        
        
        
        
       public function OngoingSellerRentCars()
        {
          
             $Token=$_POST['token'];
             
            if ($Token=='') 
            {
                $response = array(
    				'success'	=>	0,
    				'data'		=>	"Enter all params"
    			) ;	
    			
            } 
            else 
            {
               
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
                $userid=$decoded->id;
               
              
               
           $RentcarDetails = $this->Users_model->OngoingSellerRentCars($userid);
         
           if(!empty($RentcarDetails))
           {
               
              $response=array('success' => 1,'msg' => 'Data Found','data' => $RentcarDetails);    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Data not found','data' => NULL); 
           }
           
        
            }
         echo json_encode($response);
        
        }
    
    
    
    
       
        
     
     
      public function CompletedSellerRentCars()
        {
          
             $Token=$_POST['token'];
             
            if ($Token=='') 
            {
                $response = array(
    				'success'	=>	0,
    				'data'		=>	"Enter all params"
    			) ;	
    			
            } 
            else 
            {
               
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
               
              
               
           $RentcarDetails = $this->Users_model->CompletedSellerRentCars($userid);
           if(!empty($RentcarDetails))
           {
               
              $response=array('success' => 1,'msg' => 'Data Found','data' => $RentcarDetails);    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Data not found','data' => NULL); 
           }
           
        
            }
         echo json_encode($response);
        
        }
    
    
       
    public function getBraintreeToken()
    {
        
        include("vendor1/autoload.php");
        $gateway = new Braintree_Gateway([
            'environment' => 'sandbox',
            'merchantId' => 'n7fdg2nm7z8f3hd2',
            'publicKey' => 'qs6gkpsm63hzs3wz',
            'privateKey' => 'c240228d2917f85af97b9b724a6fdc85'
        ]);
        
        $clientToken = $gateway->clientToken()->generate();
        echo json_encode(array("success" => 1,"token" => $clientToken));

    }
    
    public function generateRandomString($length = 10) 
    {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
    }
    
    public function transferAmountToSellerAccount($stirpAccountID,$amount,$chargeID){
		$this->stripeCredenatils();
		    
		    	$transfer = \Stripe\Transfer::create([
			    'amount' => $amount,
			    //'currency' => $this->data['currency'],
			     'currency' => "USD",
			    'source_transaction' => $chargeID,
			    'destination' => $stirpAccountID,
		    ]);
		    
		   return $transfer;

	}
	
    public function MakePayment()
    {
        
        //include("vendor1/autoload.php");
        
         require_once('application/libraries/stripe-php-master/init.php');
         \Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
      
        $Token=$_POST['token'];
        $RequestID=$_POST['RequestID'];
        $Amount=$_POST['amount']*100; // Total amount
        $DeliveryCost=$_POST['DeliveryCost'];
        $pickupCost=$_POST['pickupCost'];
        $PerDayCost=$_POST['PerDayCost'];
        $PaymentType=$_POST['PaymentType'];
        $RequestType=$_POST['RequestType']; // Sell or Rent
        $nonceFromTheClient=$_POST['nonceFromTheClient'];  // Its stripe token
        $cardID=$_POST['cardID'];
        
        $SellerAmount=$Amount*70/100;
        
        $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
        $userid=$decoded->id;
        $TransactionNumber="TRANS".$this->generateRandomString();
       $currdate=date("Y-m-d H:i:s");
       if($PaymentType=='Online')
       {
              
               try
               {  
                   
                 $payment = \Stripe\Charge::create ([
            "amount" => $Amount,
            "currency" => "USD",
            "source" => $nonceFromTheClient,
            "description" => "User payment" 
        ]);
                
                 $paymentResponse = array(
            "paymentSuccessID"=>$payment['id'],
            "balanceTransaction"=>$payment['balance_transaction'],
            "captured"=>$payment['captured']
            );
               
               // Payment for Seller
               
              if($RequestType=='Sell')
                        {
                            $CarDetails = $this->Users_model->GetCarIDByTestReqID($RequestID);
    		                $carID=$CarDetails['carID'];
                        }
                        else
                        {
                             $CarDetails = $this->Users_model->GetCarIDByRentReqID($RequestID);
    		                 $carID=$CarDetails['carID'];
                        }
                        
                        $SellerDetails = $this->Users_model->SellerDetailsByCarID($carID);
                        $SellerID=$SellerDetails['id'];
                        $SellerStripeAccountDetails = $this->Users_model->GetSellerStripeAccountID($SellerID);
                        $StripeAccountID=$SellerStripeAccountDetails['stripeAccountID'];
                        if($StripeAccountID)
                        {
                            $transferAmount=$this->transferAmountToSellerAccount($StripeAccountID,$SellerAmount,$payment['id']);
                        }
               
                
                     if($payment['id'])
                    {
                        
           $downPaymentAmount="";
           $EMIdeductDate="";
           $EMIPlanType="";
                    	 $PaymentCheck = $this->Users_model->SavePayment($RequestID,$TransactionNumber,$Amount,$DeliveryCost,$pickupCost,$PerDayCost,$downPaymentAmount,$EMIdeductDate,$EMIPlanType,$PaymentType,$RequestType,$userid,$carID,$cardID);
                         $BuyersDetails = $this->Users_model->userDetailByid($userid);
                        
                         $PaymentUpdateStatus = $this->Users_model->ChangePaymentStatus($RequestID,$RequestType);
                        if($PaymentCheck)
                        {
                            // For Notification
                            
                            if($RequestType=='Sell')
                            {
                                $CarDetails = $this->Users_model->GetCarIDByTestReqID($RequestID);
        		                         $carID=$CarDetails['carID'];
        		                         $TestDriveDate=$CarDetails['TestDriveDate'];
        		                         $TestDriveTime=$CarDetails['TestDriveTime'];
        		                         
        		                         $SellerDetails = $this->Users_model->SellerDetailsByCarID($carID);
                                             
                                          $device_type=$SellerDetails['device_type'];
                                          $NotificationStatus=$SellerDetails['NotificationStatus'];
                                          $firebasetoken=$SellerDetails['firebasetoken'];
                                          $SellerID=$SellerDetails['id'];
                                          $CarModel=$SellerDetails['Model'];
                                          $SellerAddress=$SellerDetails['address'];
                                          
                                          $title="Confirmed TestDrive for OBP";
                                          $message="Please dropoff vehicle item# ".$CarModel." for a 7-day test drive, at the following Seller address ".$SellerAddress." on date ".$TestDriveDate." &  no less than 2hrs prior to time ".$TestDriveTime." You will earn ".$Amount." for this test-drive";
                             	if($device_type=='Android' && $NotificationStatus==1)
    			                {
    			                  
        				          $success=$this->fcmNotificationAndroid($title,$message,$firebasetoken,"BuyerMakePaymentTestDriveCase",NULL);
        				            if($success==1)
        				            {
        				                 $SaveNotification = $this->Users_model->SaveNoification($userid,$SellerID,$message,"BuyerMakePaymentTestDriveCase",$currdate);
        				            }
        		
    					
    			                }
    			                
    				            elseif($device_type=='Ios' && $NotificationStatus ==1)
    						    {
    					 
                                      $success=$this->fcmNotificationIos($title,$message,$firebasetoken,"BuyerMakePaymentTestDriveCase",NULL);
        				            if($success==1)
        				            {
        				                $SaveNotification = $this->Users_model->SaveNoification($userid,$SellerID,$message,"BuyerMakePaymentTestDriveCase",$currdate);
        				            }
        						
    					        }
                				else
                				{
                		
                				}
                            }
                            else
                            {
                                // For Rent
                                
                                         $BuyerDevice_type=$BuyersDetails['device_type'];
                                         $BuyerNotificationStatus=$BuyersDetails['NotificationStatus'];
                                         $Buyerfirebasetoken=$BuyersDetails['firebasetoken'];
                                          
                                          
                                         $CarDetails = $this->Users_model->GetCarIDByRentReqID($RequestID);
        		                         $carID=$CarDetails['carID'];
        		                         $FromDate=$CarDetails['FromDate'];
        		                         $ToDate=$CarDetails['ToDate'];
        		                         $FromTime=$CarDetails['FromTime'];
        		                         $ToTime=$CarDetails['ToTime'];
        		                         
        		                         $SellerDetails = $this->Users_model->SellerDetailsByCarID($carID);
                                             
                                          $device_type=$SellerDetails['device_type'];
                                          $NotificationStatus=$SellerDetails['NotificationStatus'];
                                          $firebasetoken=$SellerDetails['firebasetoken'];
                                          $SellerID=$SellerDetails['id'];
                                          $CarModel=$SellerDetails['Model'];
                                          $SellerAddress=$SellerDetails['address'];
                                          
                                          $title="Confirmed TestDrive for RTO";
                                          $message="Congratulations! You have earned ".$Amount." on your vehicle# ".$CarModel.". Your vehicle is scheduled for pickup or delivery on ".$ToDate." date at ".$ToTime." time. Please prepare your vehicle for this scheduled appointment";
                                          
                                          
                                          $BuyerMessage="Please pickup vehicle item ".$CarModel." for your 7-day test drive, at the following Seller address ".$SellerAddress." ".$FromDate." on date ".$FromTime." & time ".$Amount." & Cost";
                                         	if($device_type=='Android' && $NotificationStatus==1)
                			                {
                			                  
                    				          $success=$this->fcmNotificationAndroid($title,$message,$firebasetoken,"BuyerMakePaymentRTOTestDriveCase",NULL);
                    				            if($success==1)
                    				            {
                    				                 $SaveNotification = $this->Users_model->SaveNoification($userid,$SellerID,$message,"BuyerMakePaymentRTOTestDriveCase",$currdate);
                    				            }
                    		
                					
                			                }
                			                
                				            elseif($device_type=='Ios' && $NotificationStatus ==1)
                						    {
                					 
                                                  $success=$this->fcmNotificationIos($title,$message,$firebasetoken,"BuyerMakePaymentRTOTestDriveCase",NULL);
                    				            if($success==1)
                    				            {
                    				                $SaveNotification = $this->Users_model->SaveNoification($userid,$SellerID,$message,"BuyerMakePaymentRTOTestDriveCase",$currdate);
                    				            }
                    						
                					        }
                            				else
                            				{
                            		
                            				}
                            				
                            				
                            				
                            				if($BuyerDevice_type=='Android' && $BuyerNotificationStatus==1)
                			                {
                			                  
                    				          $success=$this->fcmNotificationAndroid($title,$BuyerMessage,$Buyerfirebasetoken,"BuyerMakePaymentRTOTestDriveCase",NULL);
                    				            if($success==1)
                    				            {
                    				                 $SaveNotification = $this->Users_model->SaveNoification($SellerID,$userid,$BuyerMessage,"BuyerMakePaymentRTOTestDriveCase",$currdate);
                    				            }
                    		
                					
                			                }
                			                
                				            elseif($device_type=='Ios' && $NotificationStatus ==1)
                						    {
                					 
                                                  $success=$this->fcmNotificationIos($title,$BuyerMessage,$Buyerfirebasetoken,"BuyerMakePaymentRTOTestDriveCase",NULL);
                    				            if($success==1)
                    				            {
                    				                $SaveNotification = $this->Users_model->SaveNoification($SellerID,$userid,$BuyerMessage,"BuyerMakePaymentRTOTestDriveCase",$currdate);
                    				            }
                    						
                					        }
                            				else
                            				{
                            		
                            				}
                                
                                
                            }
                        $response=array("success" => 1, "msg" => "Transaction successfully made","data" => $paymentResponse);
                        }
                        else
                        {
                            $response=array("success" => 0,"msg" =>"Payment DB error"); 
                        }
                        
                    }
                    else
                    {
                       $response=array("success" => 0,"msg" =>"Transaction error"); 
                    }
               }
              catch (Exception $e) 
              {
            
            $messages=$e->getError()->message;
            $response = array("success"=>0,"msg"=>$messages);
             }
       }
       else
       {
           
                             $CarDetails = $this->Users_model->GetCarIDByRentReqID($RequestID);
    		                  $carID=$CarDetails['carID'];
    		                 
    		                
           $downPaymentAmount="";
           $EMIdeductDate="";
           $EMIPlanType="";
           $PaymentCheck = $this->Users_model->SavePayment($RequestID,$TransactionNumber,$Amount,$DeliveryCost,$pickupCost,$PerDayCost,$downPaymentAmount,$EMIdeductDate,$EMIPlanType,$PaymentType,$RequestType,$userid,$carID,0);
                              
                   
                     $PaymentUpdateStatus = $this->Users_model->ChangePaymentStatus($RequestID,$RequestType);
                    if($PaymentCheck)
                    {
                        
                        
                        
                        
                        // For Notification
                            
                            if($RequestType=='Rent')
                            {
                                $CarDetails = $this->Users_model->GetCarIDByRentReqID($RequestID);
        		                         $carID=$CarDetails['carID'];
        		                         $TestDriveDate=$CarDetails['TestDriveDate'];
        		                         $TestDriveTime=$CarDetails['TestDriveTime'];
        		                         
        		                         $SellerDetails = $this->Users_model->SellerDetailsByCarID($carID);
                                             
                                          $device_type=$SellerDetails['device_type'];
                                          $NotificationStatus=$SellerDetails['NotificationStatus'];
                                          $firebasetoken=$SellerDetails['firebasetoken'];
                                          $SellerID=$SellerDetails['id'];
                                          $CarModel=$SellerDetails['Model'];
                                          $SellerAddress=$SellerDetails['address'];
                                          
                                          $title="Make Payment to Admin";
                                          $message="Buyer has selected the Cash option, You have to pay 30% of this amount to the admin";
                             	if($device_type=='Android' && $NotificationStatus==1)
    			                {
    			                  
        				          $success=$this->fcmNotificationAndroid($title,$message,$firebasetoken,"PaymentToAdmin",NULL);
        				            if($success==1)
        				            {
        				                 $SaveNotification = $this->Users_model->SaveNoification($userid,$SellerID,$message,"PaymentToAdmin",$currdate);
        				            }
        		
    					
    			                }
    			                
    				            elseif($device_type=='Ios' && $NotificationStatus ==1)
    						    {
    					 
                                      $success=$this->fcmNotificationIos($title,$message,$firebasetoken,"PaymentToAdmin",NULL);
        				            if($success==1)
        				            {
        				                $SaveNotification = $this->Users_model->SaveNoification($userid,$SellerID,$message,"PaymentToAdmin",$currdate);
        				            }
        						
    					        }
                				else
                				{
                		
                				}
                            }
                            else
                            {
                                
                            }
                        
                    $response=array("success" => 1, "msg" => "Transaction successfully made");
                    }
                    else
                    {
                        $response=array("success" => 0,"msg" =>"Payment DB error"); 
                    }
       }
        echo json_encode($response);

    }

    	
    public function SellerMakePayment()
    {
        
        //include("vendor1/autoload.php");
        
         require_once('application/libraries/stripe-php-master/init.php');
         \Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
      
        $Token=$_POST['token'];
        $Amount=$_POST['amount']*100; // Total amount
        $nonceFromTheClient=$_POST['nonceFromTheClient'];  // Its stripe token
        $cardID=$_POST['cardID'];
        $RequestID=$_POST['RequestID'];
       
        
        $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
        $userid=$decoded->id;
        $TransactionNumber="TRANS".$this->generateRandomString();
        $currdate=date("Y-m-d H:i:s");
       
              
               try
               {  
                   
                 $payment = \Stripe\Charge::create ([
            "amount" => $Amount,
            "currency" => "USD",
            "source" => $nonceFromTheClient,
            "description" => "Seller payment" 
        ]);
                
              
                     if($payment['id'])
                    {
                        
                         $PaymentCheck = $this->Users_model->SaveSellerPaymentToAdmin($RequestID,$TransactionNumber,$Amount,$userid);           
                        $response=array("success" => 1, "msg" => "Transaction successfully made","data" => $payment);
                       
                    }
                    else
                    {
                       $response=array("success" => 0,"msg" =>"Transaction error"); 
                    }
               }
              catch (Exception $e) 
              {
            
            $messages=$e->getError()->message;
            $response = array("success"=>0,"msg"=>$messages);
             }
      
      
        echo json_encode($response);

    }

 public function recurringPayment()
    {
        
        //include("vendor1/autoload.php");
        
         require_once('application/libraries/stripe-php-master/init.php');
         \Stripe\Stripe::setApiKey('sk_test_51KCJV8JkHEu82wYZRW0mz5HNuHsBD7wtklKbNlLCz946AEYMyLIFjmugyvMELalpJK7hYxJ9Q2tlPYTF84MlWeb400rtdXflci');
      
        $email="swartesting1@gmail.com";
        $priceCents=700;
        $my_date_time = date("Y-m-d H:i:s", strtotime("+5 minutes"));
        
        /*
      
        
        $Token=$_POST['token'];
        $RequestID=$_POST['RequestId'];
        $Amount=$_POST['amount']*100; // Total amount
        $EMIdeductDate=$_POST['EMIdeductDate'];
        $daysCount=$_POST['daysCount'];
        $downPaymentAmount=$_POST['downPaymentAmount']*100;
        $nonceFromTheClient=$_POST['nonceFromTheClient'];
        $EMIPlanType=$_POST['EMIPlanType'];
        $subscriptionAmount=$_POST['subscriptionAmount']*100;
        $cardID=$_POST['cardID'];
      
        
        $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
        $userid=$decoded->id;
        
        $cards = $this->Users_model->GetCardDetails($userid);
        $ExpireDate=$cards['ExpireDate']; 
        $expireYear = substr($ExpireDate, strpos($ExpireDate, "/") + 1); 
        
        $arr = explode("/", $ExpireDate, 2);
        $expireMonth = $arr[0];
        
        $userDetail = $this->Users_model->userDetailByid($userid);
        $Email=$userDetail['Email'];
         
        $GetCarIDByTestReqID = $this->Users_model->GetCarIDByTestReqID($RequestID);
        $carID=$GetCarIDByTestReqID['carID']; 
        
        $SellerDetailsByCarID = $this->Users_model->SellerDetailsByCarID($carID);
        $SellerID=$SellerDetailsByCarID['id']; 
        
        
        */
          
             try
               {  
                   
                 $payment = \Stripe\Charge::create ([
            "amount" => $downPaymentAmount,
            "currency" => "USD",
            "source" => $nonceFromTheClient,
            "description" => "User Down payment" 
        ]);
                
                 $paymentResponse = array(
            "paymentSuccessID"=>$payment['id'],
            "balanceTransaction"=>$payment['balance_transaction'],
            "captured"=>$payment['captured']
            );
            
             $SellerStripeAccountDetails = $this->Users_model->GetSellerStripeAccountID($SellerID);
                        $StripeAccountID=$SellerStripeAccountDetails['stripeAccountID'];
                        if($StripeAccountID)
                        {
                            $transferAmount=$this->transferAmountToSellerAccount($StripeAccountID,$downPaymentAmount,$payment['id']);
                        }
               
            
               }
                catch (Exception $e) 
              {
            
                $messages=$e->getError()->message;
                $response = array("success"=>0,"msg"=>$messages);
             }
               
               
               
               
               try
               {  
                        
                            $cardTokenArray=\Stripe\Token::create([
              'card' => [
                'number' => $cards['CardNumber'],
                'exp_month' => $expireMonth,
                'exp_year' => $expireYear,
                'cvc' => $cards['CVV'],
              ],
            ]);
                  
                  
                 $CardToken=$cardTokenArray['id']; 
                 
                 $customer = \Stripe\Customer::create ([
                  'email' => $Email, 
                'source'  => $CardToken          
                ]);
                
                
                
                 $plan = \Stripe\Plan::create([
            "product" => [ 
                "name" => "Monthly Subscription1" 
            ], 
            "amount" => $subscriptionAmount, 
            "currency" => "USD", 
            "interval" => "month", 
            "interval_count" => 1 
        ]); 
                
                
                 $subscription = \Stripe\Subscription::create([
                "customer" => $customer['id'], 
                "items" => array( 
                    array( 
                        "plan" => $plan['id'], 
                    ), 
                ),
                "trial_end"=> strtotime($my_date_time),
                "metadata" => ["SellerID" => $SellerID]
            ]); 
            
            echo"<pre>";
            print_r($subscription);
               }
              catch (Exception $e) 
              {
            
            $messages=$e->getError()->message;
            $response = array("success"=>0,"msg"=>$messages);
             }
       
      
        echo json_encode($response);

    }


 public function StripePayment()  // For testing purpose
    {
        
        require_once('application/libraries/stripe-php-master/init.php');
         \Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
      
        /*$nonceFromTheClient="tok_1KRXHgJkHEu82wYZC0BWztAA";
        $Amount=1.5*100;
        $sellerAmount=1*100;
        $StripeAccountID="acct_1KQqMQR0Ly9NLvp7";
        */
         try
               {  
                   
                         $payment = \Stripe\Charge::create ([
                    "amount" => $Amount,
                    "currency" => "USD",
                    "source" => $nonceFromTheClient,
                    "description" => "User payment" 
                ]);
                        
                         $paymentResponse = array(
                    "paymentSuccessID"=>$payment['id'],
                    "balanceTransaction"=>$payment['balance_transaction'],
                    "captured"=>$payment['captured']
                    );
                    if($payment['id'])
                    {
                         $response = array("success"=>1,"msg"=>"paymentID  found","data" => $paymentResponse);  
                    $transferAmount=$this->transferAmountToSellerAccount($StripeAccountID,$sellerAmount,$payment['id']);
                    }
                    else
                    {
                        $response = array("success"=>0,"msg"=>"paymentID not found","data1" => $paymentResponse);  
                    }
               }
               catch (Exception $e) 
              {
            
            $messages=$e->getError()->message;
            $response = array("success"=>0,"msg"=>$messages);
             }
   
       echo json_encode($response);
    }
    public function deleteCard()
    {
       
    
         $cardID=$_POST['cardID'];
       
        if ($cardID=='') 
        {
            $response = array(
				'success'	=>	0,
				'data'		=>	"Enter all params"
			) ;	
			
        } 
        else 
        {
          
           $carDelete = $this->Users_model->DeleteCard($cardID);
           if($carDelete)
           {
              
              $response=array('success' => 1,'msg' => 'Card deleted');    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Card not deleted'); 
           }
           
           
           
        }
        
         echo json_encode($response);
        
    }
    
    
    
    public function arrayOfConnectAccount($firstName,$lastName,$phoneNumber,$email){
        $array =  [
            'type' => $this->config->item('connected_account_type'),
            'country' => $this->config->item('country'),
            'email' => $email,
            'business_type' => 'individual',
            'capabilities' => [
                'card_payments' => ['requested' => true],
                'transfers' => ['requested' => true],
            ],
            "business_profile" => [
                "url"=> $this->config->item('business_url'),
                "mcc"=> $this->config->item('mcc')
            ],
            "individual" => [
                "first_name"  => $firstName,
                "last_name" => $lastName,
                "email" => $email,
                "phone" => $phoneNumber,
                 "address" => [
                    "city" => "Peoria",
                    "country"=> "US",
                    "line1"=> "11883 West Morning Vista Drive",
                    "line2"=> null,
                    "postal_code"=> "85383",
                    "state"=> "AZ"
                ],
            ],
            "tos_acceptance" =>[
                "date"=> time(),
                "ip"=> $_SERVER['REMOTE_ADDR'],
                "user_agent"=> null
            ],
        ];
        return $array;
    }
	public function updatedArray($firstName,$lastName,$phoneNumber,$email){
		$array =  [
            'email' => $email,
            "individual" => [
                "first_name"  => $firstName,
                "last_name" => $lastName,
                "email" => $email,
                "phone" => $phoneNumber,
                "address" => [
                    "city" => "Peoria",
                    "country"=> "US",
                    "line1"=> "11883 West Morning Vista Drive",
                    "line2"=> null,
                    "postal_code"=> "85383",
                    "state"=> "AZ"
                ],
            ]
        ];
        return $array;
	}
	public function createFileVerificationId($accountId,$filename){
	    
	    //$filename = explode('/',$filename);
        $file = \Stripe\File::create([
            'purpose' => 'identity_document',
            'file' => fopen('uploads/'.$filename, 'r'),
            ], [
            'stripe_account' => $accountId,
        ]);
         $fileID = $file->id;
        if($fileID){
            $account = \Stripe\Account::update($accountId,[
				"individual" => [
					"verification"=> [
					"document"=> [
					"back"=> null,
					"details"=> null,
					"details_code"=> null,
					"front"=> $fileID
				],
				],
            ]
			]);
            return $account;
        }
    }
     
     
     public function retrieveAccountDetailFromStripe($accountId){
		$this->stripeCredenatils();
		$accountDetail = \Stripe\Account::retrieve($accountId);
		return $accountDetail;
	}
     /*   ADD CONNECT ACCOUNT */
     
     public function createConnectAccount($firstName,$lastName,$phoneNumber,$email,$filename,$accountHolderName,$accountNumber,$routingNumber){
		$this->stripeCredenatils();
		try{
			$TokenInfo=\Stripe\Token::create(array(
				"bank_account" => array(
					"country" => $this->data['country'],
					"currency" => $this->data['currency'],
					"account_holder_name" => $accountHolderName,
					"account_holder_type" => "individual",
					"routing_number" => $routingNumber,
					"account_number" => $accountNumber
				)
			));
			$TokenId=$TokenInfo->id;
			if($TokenId){
				$array =  $this->arrayOfConnectAccount($firstName,$lastName,$phoneNumber,$email);
				$Account=\Stripe\Account::create($array);
				$accountId=$Account->id;
				if($accountId){
					$external_account = \Stripe\Account::createExternalAccount($accountId,['external_account' => $TokenId]);
				    $accountDetail  = $this->createFileVerificationId($accountId,$filename);
				}
			}
			$response = array("success"=>1,"accountID"=>$accountId);
		}
		catch (Exception $e) {
            $messages=$e->getError()->message;
            $response = array("success"=>0,"message"=>$messages);
        }
        return $response;
    }
    
     /* UPDATE CONNECT ACCOUNT*/
     
     public function updateConnectAccount($stirpAccountID,$firstName,$lastName,$phoneNumber,$email,$filename,$accountHolderName,$accountNumber,$routingNumber){
		$this->stripeCredenatils();
		try{
			$TokenInfo=\Stripe\Token::create(array(
				"bank_account" => array(
					"country" => $this->data['country'],
					"currency" => $this->data['currency'],
					"account_holder_name" => $accountHolderName,
					"account_holder_type" => "individual",
					"routing_number" => $routingNumber,
					"account_number" => $accountNumber
				)
			));
			 $TokenId=$TokenInfo->id;
			if($TokenId){
				$array =  $this->updatedArray($firstName,$lastName,$phoneNumber,$email);
				$Account=\Stripe\Account::update($stirpAccountID,$array);
				$accountId=$Account->id;
				if($accountId){
					$external_account = \Stripe\Account::createExternalAccount($accountId,['external_account' => $TokenId]);
					$data = $this->retrieveAccountDetailFromStripe($accountId);
				    $photoStatus = $data['individual']['verification']->status;
					if($photoStatus != 'verified'){
					    $accountDetail  = $this->createFileVerificationId($accountId,$filename);
					}
				//	print_r($accountDetail);
				}
			}
			$response = array("success"=>1,"accountID"=>$accountId);
		}
		catch (Exception $e) {
            $messages=$e->getError()->message;
            $response = array("success"=>0,"message"=>$messages);
        }
        return $response;
    } 
    
      
      /* ADD BANK */
      
      public function AddBank()
    {
         $token=$_POST['token'];
         $BankID=$_POST['BankID'];
         $AccountNumber=$_POST['AccountNumber'];
         $RoutingNumber=$_POST['RoutingNumber'];
         
         
         $decoded = JWT::decode($token, $this->config->item('jwt_key'), array('HS256'));
         $userid=$decoded->id;
         $date=date("Y-m-d H:i:s");
         $userDetail = $this->Users_model->userDetailByid($userid);
         $firstName=$userDetail['FirstName'];
         $lastName=$userDetail['LastName'];
         $phoneNumber=$userDetail['PhoneNumber'];
         $email="swarntesting@gmail.com";
         $accountHolderName="Test";
         $filename="LwMgU6ZsOtW3AJEk1598611126324.jpg";
        
        
         $stirpAccountID = $this->Users_model->getStripeAccountID($userid);
				if($stirpAccountID['accountID']){
					$checkAccount = $this->updateConnectAccount($stirpAccountID['accountID'],$firstName,$lastName,$phoneNumber,$email,$filename,$accountHolderName,$AccountNumber,$RoutingNumber);
					
				}
				else{
					$checkAccount = $this->createConnectAccount($firstName,$lastName,$phoneNumber,$email,$filename,$accountHolderName,$AccountNumber,$RoutingNumber);
                    
					if($checkAccount['accountID'])
					{
					    
					     $BankArray=array("BankID"=>$BankID, "AccountNumber" => $AccountNumber,"RoutingNumber" => $RoutingNumber,"userID" => $userid,"DefaultStatus" => 0,"BankAddedDate"=>$date);
                         $addBank = $this->Users_model->AddBank($BankArray);
                             if($addBank)
                             {
                                   
                                 	$response=array('success' => 1,'msg' => 'Bank successfully added');   
                             }
                             else
                             {
                                 $response=array('success' => 0,'msg' => 'Bank not added'); 
                             }
					    $this->Users_model->addSellerStripeAccount($userid,$checkAccount['accountID']);
				    }
				    else
				    {
				        $response=$checkAccount;
				    }
				}
         
        
        
         
         echo json_encode($response);
        
    }
    
      
      /* DELETE BANK */
      
      
       public function deleteBank()
    {
       
    
         $bankID=$_POST['bankID'];
       
        if ($bankID=='') 
        {
            $response = array(
				'success'	=>	0,
				'data'		=>	"Enter all params"
			) ;	
			
        } 
        else 
        {
          
           $DeleteBank = $this->Users_model->DeleteBank($bankID);
           if($DeleteBank)
           {
              
              $response=array('success' => 1,'msg' => 'Bank deleted');    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Bank not deleted'); 
           }
           
           
           
        }
        
         echo json_encode($response);
        
    }
    
      
      
      
      
    /*  Get Bank Details */
    
      public function GetBankByUser()
    {
         $token=$_POST['token'];
         
         if($token!='')
         {
             $decoded = JWT::decode($token, $this->config->item('jwt_key'), array('HS256'));
              $userid=$decoded->id;
         
            $Banks = $this->Users_model->GetBankByUserID($userid); 
            if(!empty($Banks))
            {
               $response=array('success' => 1,'msg' => 'Data Found','data' =>$Banks);
                 
            }
            else
            {
               $response=array('success' => 0,'msg' => 'Data Not Found','data' =>NULL);
            }
         }
         else
         {
             $response=array('success' => 0,'msg' => 'Please send cardID','data' =>NULL);
         }
         echo json_encode($response);
        
    }
      
      
      
      
     /*  Get Bank Details */
    
      public function GetAllBank()
    {
         
        
            $Banks = $this->Users_model->GetAllBank(); 
            if(!empty($Banks))
            {
               $response=array('success' => 1,'msg' => 'Data Found','data' =>$Banks);
                 
            }
            else
            {
               $response=array('success' => 0,'msg' => 'Data Not Found','data' =>NULL);
            }
       
         echo json_encode($response);
        
    } 
      
      
      
      /*  Get Bank Details */
    
      public function GetVehicleType()
    {
         
        
            $Vehicle = $this->Users_model->GetVehicleType(); 
            if(!empty($Vehicle))
            {
               $response=array('success' => 1,'msg' => 'Data Found','data' =>$Vehicle);
                 
            }
            else
            {
               $response=array('success' => 0,'msg' => 'Data Not Found','data' =>NULL);
            }
       
         echo json_encode($response);
        
    }  
      
      
      
      
      
      /*  Get Bank Details */
    
      public function TransactionHistory()
    {
         $token=$_POST['token'];
         $usertype=$_POST['usertype'];
        //$token="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjM3IiwiRmlyc3ROYW1lIjoiQmhhd2FuaSIsIkxhc3ROYW1lIjoiU2luZ2giLCJDaXR5IjoiTW9oYWxpIiwiUGhvbmVOdW1iZXIiOiI5ODE1NTA3ODk2IiwiVXNlcm5hbWUiOiJiaGF3YW5pc2luZ2giLCJQYXNzd29yZCI6ImUxMGFkYzM5NDliYTU5YWJiZTU2ZTA1N2YyMGY4ODNlIiwiRW1haWwiOiJ0ZXN0Ymhhd2FuaUBnbWFpbC5jb20iLCJHZW5kZXIiOiJNYWxlIiwiQWRkcmVzcyI6InNicCBob21lcyAzIiwiU3RhdGUiOiJQdW5qYWIiLCJaaXBjb2RlIjoiMTQwMzAxIiwiRE9CIjoiIiwiRExfSVNTVUVfREFURSI6IiIsIkRMX0VYUElSRV9EQVRFIjoiIiwiRExfRnJvbnRJbWFnZSI6InVwbG9hZHNcL0RMX0ltYWdlc1wvNzVjcm9wcGVkODY5OTkzMzQ3MzEzODIxMDcwNy5qcGciLCJETF9CYWNrZW5kSW1hZ2UiOiJ1cGxvYWRzXC9ETF9JbWFnZXNcLzUzY3JvcHBlZDUwMTQzODkwODc4OTgzNzc1MDAuanBnIiwiSW1hZ2UiOiJ1cGxvYWRzXC9wcm9maWxlSW1hZ2VzXC84NTE2MDk5MDk4OTI5NDAuanBnIiwiZGV2aWNlX3R5cGUiOiJBbmRyb2lkIiwiZmlyZWJhc2V0b2tlbiI6ImNCejR0TllhU3h5UE1OSFp6Y3hocHE6QVBBOTFiRTkycUpraUltRmV0YTk0akJxcmtZbVFtTjBiZjZkT3ZYTXBfbndMOVktZFR2Q1JKdXNiZkMzMVoxNWpPWm1Scm1ZeWtFSzZTaFRiSTVmbXQzMWhjZmVuR1dOVGlNTHg4cklBTkdlcGtGdE1YM25iS1FhOGFzWWJoaUUzcVVRSC1yeV8zSnAiLCJsYXRpdHVkZSI6IiIsImxvbmdpdHVkZSI6IiIsInVzZXJUeXBlIjoiU2VsbGVyIiwiRW1haWxTZW5kU3RhdHVzIjoiMCIsIlNtc1NlbmRTdGF0dXMiOiIwIiwiTm90aWZpY2F0aW9uU3RhdHVzIjoiMSIsImFkZGVkRGF0ZSI6IjIwMjEtMDEtMDggMTI6NTM6MDAifQ.ioU50uVoNxvfII3lPwyUjHc-aSa767MqKOqYJO5W5WA";
         
         if($token!='')
         {
             $decoded = JWT::decode($token, $this->config->item('jwt_key'), array('HS256'));
              $userid=$decoded->id;
         
            $Transaction = $this->Users_model->transactionHistory($userid,$usertype); 
           
            if(!empty($Transaction))
            {
               $response=array('success' => 1,'msg' => 'Data Found','data' =>$Transaction);
                 
            }
            else
            {
               $response=array('success' => 0,'msg' => 'Data Not Found','data' =>NULL);
            }
         }
         else
         {
             $response=array('success' => 0,'msg' => 'Please send token','data' =>NULL);
         }
         echo json_encode($response);
        
    }
      
      
      
      /*  Get Update Request */
    
      public function UpdateHoldStatusTestDriveRequestBySeller()
    {
         $token=$_POST['token'];
         $TestDriveRequestID=$_POST['TestBookRequestID'];
         $Description=$_POST['Description'];
        $currdate=date("Y-m-d H:i:s");
         
         if($token!='' && $TestDriveRequestID!='')
         {
             $decoded = JWT::decode($token, $this->config->item('jwt_key'), array('HS256'));
              $userid=$decoded->id;
         
            $UpdateStatus = $this->Users_model->UpdateHoldStatusTestDriveRequestBySeller($TestDriveRequestID,$Description); 
            if($UpdateStatus)
            {
                
                                   
    		                         $BuyerDetails = $this->Users_model->BuyerDetailsByRequestID($TestDriveRequestID);
                                         
                                      $device_type=$BuyerDetails['device_type'];
                                      $NotificationStatus=$BuyerDetails['NotificationStatus'];
                                      $firebasetoken=$BuyerDetails['firebasetoken'];
                                      $BuyerID=$BuyerDetails['id'];
                                       $title="Outright Buying Process Change request";
                                      $message="Seller want to reschedule one of your Outright Buying Process request";
                         	if($device_type=='Android' && $NotificationStatus==1)
			                {
			                  
    				          $success=$this->fcmNotificationAndroid($title,$message,$firebasetoken,"OnHoldTestDriveRequest",NULL);
    				            if($success==1)
    				            {
    				                 $SaveNotification = $this->Users_model->SaveNoification($userid,$BuyerID,$message,"OnHoldTestDriveRequest",$currdate);
    				            }
    		
					
			                }
			                
				            elseif($device_type=='Ios' && $NotificationStatus ==1)
						    {
					 
                                  $success=$this->fcmNotificationIos($title,$message,$firebasetoken,"OnHoldTestDriveRequest",NULL);
    				            if($success==1)
    				            {
    				                $SaveNotification = $this->Users_model->SaveNoification($userid,$BuyerID,$message,"OnHoldTestDriveRequest",$currdate);
    				            }
    						
					        }
            				else
            				{
            		
            				}
               $response=array('success' => 1,'msg' => 'Hold Status Updated');
                 
            }
            else
            {
               $response=array('success' => 0,'msg' => 'Hold Status Not Updated');
            }
         }
         else
         {
             $response=array('success' => 0,'msg' => 'Please send Details');
         }
         echo json_encode($response);
        
    }  
    
    
    
    
    
       public function UpdateTestDrive()
    {
       date_default_timezone_set('UTC');
       
         $Token=$_POST['token'];
         $RequestID=$_POST['RequestID'];
         $TestDriveDate=$_POST['TestDriveDate'];
         $TestDriveTime=$_POST['TestDriveTime'];
         $Name=$_POST['Name'];
         $Phone=$_POST['Phone'];
         $Location=$_POST['Location'];
         
         /*$Token="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjM4IiwiRmlyc3ROYW1lIjoiVGVzdDEiLCJMYXN0TmFtZSI6IkJ1eWVyIiwiQ2l0eSI6Im1vaGFsaSIsIlBob25lTnVtYmVyIjoiNjI4MDU3NzYwNSIsIlVzZXJuYW1lIjoiIiwiUGFzc3dvcmQiOiJkODU3OGVkZjg0NThjZTA2ZmJjNWJiNzZhNThjNWNhNCIsIkVtYWlsIjoidGVzdGJoYXdhbmlAeW9wbWFpbC5jb20iLCJHZW5kZXIiOiJNYWxlIiwiQWRkcmVzcyI6ImQxODUgIGZpcnN0IGZsb29yLCBwaGFzZSA4YiBpbmR1c3RyaWFsIGFyZWEgbW9oYWxpIiwiU3RhdGUiOiJQdW5qYWIiLCJaaXBjb2RlIjoiMTQwMzAxIiwiRE9CIjoiIiwiRExfSVNTVUVfREFURSI6IiIsIkRMX0VYUElSRV9EQVRFIjoiIiwiRExfRnJvbnRJbWFnZSI6InVwbG9hZHNcL0RMX0ltYWdlc1wvMTBjcm9wcGVkOTEyOTA0OTQyODEwMDQ3NDMzNy5qcGciLCJETF9CYWNrZW5kSW1hZ2UiOiJ1cGxvYWRzXC9ETF9JbWFnZXNcLzk1Y3JvcHBlZDM5NDIyNjgxMjIzODU1NjY0NTMuanBnIiwiSW1hZ2UiOiJ1cGxvYWRzXC9wcm9maWxlSW1hZ2VzXC8xMGNyb3BwZWQ3NjAzNzEyNTgyNDk1NjY0MzcuanBnIiwiZGV2aWNlX3R5cGUiOiJBbmRyb2lkIiwiZmlyZWJhc2V0b2tlbiI6IiIsImxhdGl0dWRlIjoiIiwibG9uZ2l0dWRlIjoiIiwidXNlclR5cGUiOiJCdXllciIsIkVtYWlsU2VuZFN0YXR1cyI6IjEiLCJTbXNTZW5kU3RhdHVzIjoiMCIsIk5vdGlmaWNhdGlvblN0YXR1cyI6IjEiLCJhZGRlZERhdGUiOiIyMDIxLTAxLTIwIDA5OjI2OjU0In0.4vOwePzsoTMq5FYrRD8vhGjVnG_XDZnYVOLLesl5SPY";
         $RequestID=38;
         $TestDriveDate="2021-3-25";
         $TestDriveTime="14:00:19";
         $Name="bhawanisingh";
         $Phone="985363738383";
         $Location="TEST";*/
         
        if ($Token=='' || $RequestID=='') 
        {
            $response = array(
				'success'	=>	0,
				'data'		=>	"Enter all params"
			) ;	
			
        } 
        else 
        {
           
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
               $currdate=date("Y-m-d H:i:s");
		                       
		                        
		                        
		                        $testDrive = $this->Users_model->UpdateTestDrive($RequestID,$TestDriveDate,$TestDriveTime,$Name,$Phone,$Location,$currdate);
                                 if($testDrive)
                                 {
                                     $BuyerDetailsN = $this->Users_model->userDetailByid1($userid);
                                     $BuyerUsernameN=$BuyerDetailsN['Username']; 
                                     
                                     $CarDetails = $this->Users_model->GetCarIDByTestReqID($RequestID);
                                    
    		                         $carID=$CarDetails['carID'];
    		                         $SellerDetails = $this->Users_model->SellerDetailsByCarID($carID);
                                         
                                      $device_type=$SellerDetails['device_type'];
                                      $NotificationStatus=$SellerDetails['NotificationStatus'];
                                      $firebasetoken=$SellerDetails['firebasetoken'];
                                      $SellerID=$SellerDetails['id'];
                                      $title="Update OBP TestDrive Request";
                                      $message="Please ACCEPT or CHANGE the test-drive request for OBP sent by ".$BuyerUsernameN;
                         	if($device_type=='Android' && $NotificationStatus==1)
			                {
			                  
    				          $success=$this->fcmNotificationAndroid($title,$message,$firebasetoken,"updateTestDriveRequest",NULL);
    				            if($success==1)
    				            {
    				                 $SaveNotification = $this->Users_model->SaveNoification($userid,$SellerID,$message,"updateTestDriveRequest",$currdate);
    				            }
    		
					
			                }
			                
				            elseif($device_type=='Ios' && $NotificationStatus ==1)
						    {
					 
                                  $success=$this->fcmNotificationIos($title,$message,$firebasetoken,"updateTestDriveRequest",NULL);
    				            if($success==1)
    				            {
    				                $SaveNotification = $this->Users_model->SaveNoification($userid,$SellerID,$message,"updateTestDriveRequest",$currdate);
    				            }
    						
					        }
            				else
            				{
            		
            				}
                                    $response=array('success' => 1,'msg' => 'Test Drive Request Updated');  
                                 }
                                 else
                                 {
                                    $response=array('success' => 0,'msg' => 'Test Drive Request Not Updated');  
                                 }
		                
              
          
           
           
        }
        
         echo json_encode($response);
        
    }
    
    
     
       public function UpdateRTORequest()
    {
       date_default_timezone_set('UTC');
       
         $Token=$_POST['token'];
         $RequestID=$_POST['RequestID'];
         $TestDriveDate=$_POST['TestDriveDate'];
         $TestDriveTime=$_POST['TestDriveTime'];
         $Name=$_POST['Name'];
         $Phone=$_POST['Phone'];
         $Location=$_POST['Location'];
         
         /*$Token="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjM4IiwiRmlyc3ROYW1lIjoiVGVzdDEiLCJMYXN0TmFtZSI6IkJ1eWVyIiwiQ2l0eSI6Im1vaGFsaSIsIlBob25lTnVtYmVyIjoiNjI4MDU3NzYwNSIsIlVzZXJuYW1lIjoiIiwiUGFzc3dvcmQiOiJkODU3OGVkZjg0NThjZTA2ZmJjNWJiNzZhNThjNWNhNCIsIkVtYWlsIjoidGVzdGJoYXdhbmlAeW9wbWFpbC5jb20iLCJHZW5kZXIiOiJNYWxlIiwiQWRkcmVzcyI6ImQxODUgIGZpcnN0IGZsb29yLCBwaGFzZSA4YiBpbmR1c3RyaWFsIGFyZWEgbW9oYWxpIiwiU3RhdGUiOiJQdW5qYWIiLCJaaXBjb2RlIjoiMTQwMzAxIiwiRE9CIjoiIiwiRExfSVNTVUVfREFURSI6IiIsIkRMX0VYUElSRV9EQVRFIjoiIiwiRExfRnJvbnRJbWFnZSI6InVwbG9hZHNcL0RMX0ltYWdlc1wvMTBjcm9wcGVkOTEyOTA0OTQyODEwMDQ3NDMzNy5qcGciLCJETF9CYWNrZW5kSW1hZ2UiOiJ1cGxvYWRzXC9ETF9JbWFnZXNcLzk1Y3JvcHBlZDM5NDIyNjgxMjIzODU1NjY0NTMuanBnIiwiSW1hZ2UiOiJ1cGxvYWRzXC9wcm9maWxlSW1hZ2VzXC8xMGNyb3BwZWQ3NjAzNzEyNTgyNDk1NjY0MzcuanBnIiwiZGV2aWNlX3R5cGUiOiJBbmRyb2lkIiwiZmlyZWJhc2V0b2tlbiI6IiIsImxhdGl0dWRlIjoiIiwibG9uZ2l0dWRlIjoiIiwidXNlclR5cGUiOiJCdXllciIsIkVtYWlsU2VuZFN0YXR1cyI6IjEiLCJTbXNTZW5kU3RhdHVzIjoiMCIsIk5vdGlmaWNhdGlvblN0YXR1cyI6IjEiLCJhZGRlZERhdGUiOiIyMDIxLTAxLTIwIDA5OjI2OjU0In0.4vOwePzsoTMq5FYrRD8vhGjVnG_XDZnYVOLLesl5SPY";
         $RequestID=201;
         $TestDriveDate="2021-3-25";
         $TestDriveTime="14:00:19";
         $Name="bhawanisingh";
         $Phone="985363738383";
         $Location="TEST";
         */
        if ($Token=='' || $RequestID=='') 
        {
            $response = array(
				'success'	=>	0,
				'data'		=>	"Enter all params"
			) ;	
			
        } 
        else 
        {
           
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
               $currdate=date("Y-m-d H:i:s");
		                       
		                        
		                        
		                        $testDrive = $this->Users_model->UpdateTestDrive($RequestID,$TestDriveDate,$TestDriveTime,$Name,$Phone,$Location,$currdate);
                                 if($testDrive)
                                 {
                                      $response=array('success' => 1,'msg' => 'RTO Request Updated');  
                                      
                                     $CarDetails = $this->Users_model->GetCarIDByTestReqID($RequestID);
    		                         $carID=$CarDetails['carID'];
    		                         $SellerDetails = $this->Users_model->SellerDetailsByCarID($carID);
                                         
                                      $device_type=$SellerDetails['device_type'];
                                      $NotificationStatus=$SellerDetails['NotificationStatus'];
                                       $firebasetoken=$SellerDetails['firebasetoken'];
                                      $SellerID=$SellerDetails['id'];
                                      $title="Update RTO TestDrive Request";
                                      $message="Please ACCEPT or CHANGE the test-drive request for RTO sent by ".$Name;
                         	if($device_type=='Android' && $NotificationStatus==1)
			                {
			                  
    				          $success=$this->fcmNotificationAndroid($title,$message,$firebasetoken,"updateRTOTestDriveRequest",NULL);
    				            if($success==1)
    				            {
    				                 $SaveNotification = $this->Users_model->SaveNoification($userid,$SellerID,$message,"updateRTOTestDriveRequest",$currdate);
    				            }
    		
					
			                }
			                
				            elseif($device_type=='Ios' && $NotificationStatus ==1)
						    {
					 
                                  $success=$this->fcmNotificationIos($title,$message,$firebasetoken,"updateRTOTestDriveRequest",NULL);
    				            if($success==1)
    				            {
    				                $SaveNotification = $this->Users_model->SaveNoification($userid,$SellerID,$message,"updateRTOTestDriveRequest",$currdate);
    				            }
    						
					        }
            				else
            				{
            		
            				}
                                   
                                 }
                                 else
                                 {
                                    $response=array('success' => 0,'msg' => 'RTO Request Not Updated');  
                                 }
		                
              
          
           
           
        }
        
         echo json_encode($response);
        
    }
    
   
    
    
        public function updateBuyerInterested()
    {
       
         $Token=$_POST['token'];
         $TestBookRequestID=$_POST['TestBookRequestID'];
         $isBuyerInterested=$_POST['isBuyerInterested'];
         
         
        if ($Token=='' || $TestBookRequestID=='') 
        {
            $response = array(
				'success'	=>	0,
				'data'		=>	"Enter all params"
			) ;	
			
        } 
        else 
        {
          
          
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
               
                 $currdate=date("Y-m-d H:i:s");
                $lastInsertId = $this->Users_model->updateBuyerInterested($TestBookRequestID,$isBuyerInterested);
                                 if($lastInsertId)
                                 {
                                     
                                    
                                      // For Notification
                                     $BuyerDetails = $this->Users_model->userDetailByid1($userid);
                                     $BuyerUsername=$BuyerDetails['Username'];
                                     $CarDetails = $this->Users_model->GetCarIDByTestReqID($TestBookRequestID);
    		                         $carID=$CarDetails['carID'];
    		                         //$Brand=$CarDetails['Brand'];
    		                         $SellerDetails = $this->Users_model->SellerDetailsByCarID($carID);
                                         
                                      $device_type=$SellerDetails['device_type'];
                                      $NotificationStatus=$SellerDetails['NotificationStatus'];
                                      $firebasetoken=$SellerDetails['firebasetoken'];
                                      $SellerID=$SellerDetails['id'];
                                      $CarBrand=$SellerDetails['Brand'];
                                      
                                      
                                     
                                   
                                   
                                    
                                     if($isBuyerInterested==2)
                                     {
                                         
                                         $Rating=$_POST['Rating'];
                                         $Comment=$_POST['Comment'];
                                         
                                         $CheckRating = $this->Users_model->checkRatingOfCar($userid,$carID);
                                         if($CheckRating)
                                         {
                                              $SaveRating = $this->Users_model->saveRating($userid,$carID,$Rating,$Comment);
                                             
                                             if($SaveRating)
                                             {
                                             $response=array('success' => 1,'msg' => 'Rating submitted');  
                                             }
                                             else
                                             {
                                                $response=array('success' => 0,'msg' => 'Rating Updation Problem');  
                                             } 
                                         }
                                         else
                                         {
                                              $UpdateRating = $this->Users_model->UpdateRating($userid,$carID,$Rating,$Comment);
                                             
                                             if($UpdateRating)
                                             {
                                             $response=array('success' => 1,'msg' => 'Rating submitted');  
                                             }
                                             else
                                             {
                                                $response=array('success' => 0,'msg' => 'Rating Updation Problem');  
                                             } 
                                             
                                             
                                         }
                                         
                                           $title="Buyer is not intereested to buy";
                                              $message=$BuyerUsername." is not interested to purchase your car ".$CarBrand;
                                              
                                             	if($device_type=='Android' && $NotificationStatus==1)
                    			                {
                    			                  
                        				          $success=$this->fcmNotificationAndroid($title,$message,$firebasetoken,"isBuyerNotInterestedStatus",NULL);
                        				            if($success==1)
                        				            {
                        				                 $SaveNotification = $this->Users_model->SaveNoification($userid,$SellerID,$message,"isBuyerNotInterestedStatus",$currdate);
                        				            }
                        		
                    					
                    			                }
                    			                
                    				            elseif($device_type=='Ios' && $NotificationStatus ==1)
                    						    {
                    					 
                                                      $success=$this->fcmNotificationIos($title,$message,$firebasetoken,"isBuyerNotInterestedStatus",NULL);
                        				            if($success==1)
                        				            {
                        				                $SaveNotification = $this->Users_model->SaveNoification($userid,$SellerID,$message,"isBuyerNotInterestedStatus",$currdate);
                        				            }
                        						
                    					        }
                                				else
                                				{
                                		
                                				}
                                      
                                     }
                                     else
                                     {
                                                 $title="Buyer want to buy";
                                              $message=$BuyerUsername." interested to purchase your car ".$CarBrand;
                                              
                                             	if($device_type=='Android' && $NotificationStatus==1)
                    			                {
                    			                  
                        				          $success=$this->fcmNotificationAndroid($title,$message,$firebasetoken,"isBuyerInterestedStatus",NULL);
                        				            if($success==1)
                        				            {
                        				                 $SaveNotification = $this->Users_model->SaveNoification($userid,$SellerID,$message,"isBuyerInterestedStatus",$currdate);
                        				            }
                        		
                    					
                    			                }
                    			                
                    				            elseif($device_type=='Ios' && $NotificationStatus ==1)
                    						    {
                    					 
                                                      $success=$this->fcmNotificationIos($title,$message,$firebasetoken,"isBuyerInterestedStatus",NULL);
                        				            if($success==1)
                        				            {
                        				                $SaveNotification = $this->Users_model->SaveNoification($userid,$SellerID,$message,"isBuyerInterestedStatus",$currdate);
                        				            }
                        						
                    					        }
                                				else
                                				{
                                		
                                				}
                                                 $response=array('success' => 1,'msg' => 'Status Updated');  
                                     }
                                 }
                                 else
                                 {
                                    $response=array('success' => 0,'msg' => 'Request Updation Problem');  
                                 } 
              
           
        }
        
         echo json_encode($response);
        
    }
    
    
    
      // Add car Rating
      
     public function RatingToCar()
    {
         $Token=$_POST['token'];
         $carID=$_POST['carID'];
         $Rating=$_POST['Rating'];
         $Comment=$_POST['Comment'];
         
         
        if ($Token=='') 
        {
            $response = array(
				'success'	=>	0,
				'data'		=>	"Enter all params"
			) ;	
			
        } 
        else 
        {
          
          
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
               
                 $currdate=date("Y-m-d H:i:s");
                $CheckRating = $this->Users_model->checkRatingOfCar($userid,$carID);
                                 if($CheckRating)
                                 {
                                      $SaveRating = $this->Users_model->saveRating($userid,$carID,$Rating,$Comment);
                                     
                                     if($SaveRating)
                                     {
                                     $response=array('success' => 1,'msg' => 'Rating submitted');  
                                     }
                                     else
                                     {
                                        $response=array('success' => 0,'msg' => 'Rating Updation Problem');  
                                     } 
                                 }
                                 else
                                 {
                                      $UpdateRating = $this->Users_model->UpdateRating($userid,$carID,$Rating,$Comment);
                                     
                                     if($UpdateRating)
                                     {
                                     $response=array('success' => 1,'msg' => 'Rating submitted');  
                                     }
                                     else
                                     {
                                        $response=array('success' => 0,'msg' => 'Rating Updation Problem');  
                                     } 
                                     
                                     
                                 }
              
           
        }
        
         echo json_encode($response);
  
 }
 
 
 
 
 
   // Add car Rating
      
     public function CompleteTestDriveRequest()
    {
        
         $TestRequestID=$_POST['TestRequestID'];
         
         
                                      $SaveRating = $this->Users_model->CompleteRequest($TestRequestID);
                                     
                                     if($SaveRating)
                                     {
                                     $response=array('success' => 1,'msg' => 'Request completed');  
                                     }
                                     else
                                     {
                                        $response=array('success' => 0,'msg' => 'Request complete Problem');  
                                     } 
                                 
                                 
              
           
        
        
         echo json_encode($response);
  
 }
 
  public function CompleteTestDriveRequest_Ajax(){
    // POST data
     $postData = $this->input->post('requestID');
    $currdate=date("Y-m-d H:i:s");
    $SaveRating = $this->Users_model->CompleteRequestAjax($postData);
                                     
                                     if($SaveRating)
                                     {
                                         
                                     
                                     $CarDetails = $this->Users_model->GetCarIDByTestReqID($postData);
    		                         $carID=$CarDetails['carID'];
    		                         $userID=$CarDetails['userID'];
    		                         $TestDriveRequestType=$CarDetails['TestDriveRequestType'];
    		                         
    		                         if($TestDriveRequestType=='RTO')
    		                         {
    		                             $NOTFICATIONTYPE="AdminUpdateRTOTestDriveCompleted";
    		                         }
    		                         else
    		                         {
    		                            $NOTFICATIONTYPE="AdminUpdateTestDriveCompleted"; 
    		                         }
    		                         $BuyerDetails = $this->Users_model->userDetailByid($userID);
                                     $BuyerUsername=$BuyerDetails['Username'];
                                     $Buyerdevice_type=$BuyerDetails['device_type'];
                                     $BuyerNotificationStatus=$BuyerDetails['NotificationStatus'];
                                     $Buyerfirebasetoken=$BuyerDetails['firebasetoken'];
                                    
                                      
    		                         $SellerDetails = $this->Users_model->SellerDetailsByCarID($carID);
                                         
                                      $device_type=$SellerDetails['device_type'];
                                      $NotificationStatus=$SellerDetails['NotificationStatus'];
                                      $firebasetoken=$SellerDetails['firebasetoken'];
                                      $SellerID=$SellerDetails['id'];
                                      $CarBrand=$SellerDetails['Brand'];
                                      
                                      $title="Test-drive is complete";
                                      $message="The test-drive is complete. You will be notified within 24hrs if the buyer has decided to accept or decline the purchase of your vehicle";
                                              
                                             	if($device_type=='Android' && $NotificationStatus==1)
                    			                {
                    			                  
                        				          $success=$this->fcmNotificationAndroid($title,$message,$firebasetoken,$NOTFICATIONTYPE,NULL);
                        				            if($success==1)
                        				            {
                        				                 $SaveNotification = $this->Users_model->SaveNoification($userid,$SellerID,$message,$NOTFICATIONTYPE,$currdate);
                        				            }
                        		
                    					
                    			                }
                    			                
                    				            elseif($device_type=='Ios' && $NotificationStatus ==1)
                    						    {
                    					 
                                                      $success=$this->fcmNotificationIos($title,$message,$firebasetoken,$NOTFICATIONTYPE,NULL);
                        				            if($success==1)
                        				            {
                        				                $SaveNotification = $this->Users_model->SaveNoification($userID,$SellerID,$message,$NOTFICATIONTYPE,$currdate);
                        				            }
                        						
                    					        }
                                				else
                                				{
                                		
                                				}
                                				
                                				// Buyer Notification
                                				
                                				$Buyertitle="Test-drive is complete";
                                                $Buyermessage="The test-drive is complete. Please choose ,I want to purchase or I want to decline this vehicle at this time.";
                                         
                                					if($Buyerdevice_type=='Android' && $BuyerNotificationStatus==1)
                    			                {
                    			                  
                        				          $success=$this->fcmNotificationAndroid($Buyertitle,$Buyermessage,$Buyerfirebasetoken,$NOTFICATIONTYPE,NULL);
                        				            if($success==1)
                        				            {
                        				                 $SaveNotification = $this->Users_model->SaveNoification($userID,$SellerID,$Buyermessage,$NOTFICATIONTYPE,$currdate);
                        				            }
                        		
                    					
                    			                }
                    			                
                    				            elseif($Buyerdevice_type=='Ios' && $BuyerNotificationStatus ==1)
                    						    {
                    					 
                                                      $success=$this->fcmNotificationIos($Buyertitle,$Buyermessage,$Buyerfirebasetoken,$NOTFICATIONTYPE,NULL);
                        				            if($success==1)
                        				            {
                        				                $SaveNotification = $this->Users_model->SaveNoification($userID,$SellerID,$Buyermessage,$NOTFICATIONTYPE,$currdate);
                        				            }
                        						
                    					        }
                                				else
                                				{
                                		
                                				}
                                     $response=array('success' => 1,'msg' => 'Request completed');  
                                     }
                                     else
                                     {
                                        $response=array('success' => 0,'msg' => 'Request complete Problem.');  
                                     } 
                                     echo json_encode($response);
                                 
  }
 
 public function CompareImage()
 {
       $firstimage="http://massageplace.parastechnologies.in/cameraNew/images/test1006784767.jpg";
	   $secondimage="http://massageplace.parastechnologies.in/cameraNew/images/test1000844138.jpg";
		
		$data = array("FirstImage" => $firstimage,"SecondImage" => $secondimage);
		$data_string = json_encode($data);

		$ch = curl_init('https://dev.vend4you.com/ApiDevelopmentEnv/api/FaceDetect/FaceVerifiction');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($data_string))
		);
			
			 $result2 = curl_exec($ch);
		 
		 $result = curl_exec($ch);
			
		curl_close($ch);
		$resultArray=json_decode($result);
		
		$array = (array) $resultArray;
		echo"<pre>";
        print_r($array);
		 echo $FaceDetect=$array['Response'];
		 $FaceDetectId=0;
		 $messageResponse=$array['ErrorMessage'];
 }
    
    
 public function callbackUrl()
 {
     
       /*$json = file_get_contents('php://input');
        $obj = json_decode($json, TRUE);*/
        $obj=json_encode($_GET);
        $fp = fopen("file.txt","wb"); 
        fwrite($fp,$obj);
        fclose($fp);
        
 }
 
   // UPCOMING APPOINTMENT PENDING REQUEST
    
       public function RTORequestListing()
        {
          
             $Token=$_POST['token'];
             
            if ($Token=='') 
            {
                $response = array(
    				'success'	=>	0,
    				'data'		=>	"Enter all params"
    			) ;	
    			
            } 
            else 
            {
               
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
               
               
               
           $carDetails = $this->Users_model->RTODriveRequestListing($userid);
           if(!empty($carDetails))
           {
               
              $response=array('success' => 1,'msg' => 'Data Found','data' => $carDetails);    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Data not found','data' => NULL); 
           }
           
        
            }
         echo json_encode($response);
        
        }
        
        
        
           // UPCOMING APPOINTMENT Accepted REQUEST
    
       public function RTOAcceptedAppointment()
        {
          
             $Token=$_POST['token'];
            if ($Token=='') 
            {
                $response = array(
    				'success'	=>	0,
    				'data'		=>	"Enter all params"
    			) ;	
    			
            } 
            else 
            {
               
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
               
               
               
           $carDetails = $this->Users_model->TestDriveAcceptedAppointment($userid);
           if(!empty($carDetails))
           {
               
              $response=array('success' => 1,'msg' => 'Data Found','data' => $carDetails);    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Data not found','data' => NULL); 
           }
           
        
            }
         echo json_encode($response);
        
        }
        
    
    
      // UPCOMING APPOINTMENT COMPLETED REQUEST
    
       public function RTOCompletedAppointment()
        {
          
             $Token=$_POST['token'];
             
            if ($Token=='') 
            {
                $response = array(
    				'success'	=>	0,
    				'data'		=>	"Enter all params"
    			) ;	
    			
            } 
            else 
            {
               
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
               
               
               
           $carDetails = $this->Users_model->CompletedTestdriveRequest($userid);
           if(!empty($carDetails))
           {
               
              $response=array('success' => 1,'msg' => 'Data Found','data' => $carDetails);    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Data not found','data' => NULL); 
           }
           
        
            }
         echo json_encode($response);
        
        }
           
      
      
         public function AcceptOrRejectRTO()
    {
       
         $Token=$_POST['token'];
         $TestBookRequestID=$_POST['RTORequestID'];
         $Status=$_POST['Status'];
       
       
         
        if ($Token=='' || $TestBookRequestID=='') 
        {
            $response = array(
				'success'	=>	0,
				'data'		=>	"Enter all params"
			) ;	
			
        } 
        else 
        {
          
          
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
               
                 $currdate=date("Y-m-d H:i:s");
                $lastInsertId = $this->Users_model->AcceptOrRejectTestDrive($TestBookRequestID,$Status);
                                 if($lastInsertId)
                                 {
                                     if($Status=='Accepted')
                                     {
                                     $NTYPES="SellerAcceptRTOTestDriveRequest";
                                     }
                                     elseif($Status=='Rejected')
                                     {
                                        $NTYPES="SellerRejectRTOTestDriveRequest"; 
                                     }
                                     else
                                     {
                                         
                                     }
                                       $BuyerDetails = $this->Users_model->BuyerDetailsByRequestID($TestBookRequestID);
                                       $CarDetails = $this->Users_model->CarDetailsByID($car_id);
                                       $SellerDetails = $this->Users_model->userDetailByid($userid);
                                       
                                       $SellerName=$SellerDetails['Username'];
                                       $Sellerdevice_type=$SellerDetails['device_type'];
                                       $SellerNotificationStatus=$SellerDetails['NotificationStatus'];
                                       $Sellerfirebasetoken=$SellerDetails['firebasetoken'];
                                       $SellerID=$SellerDetails['id'];
                                  
                                       $Buyerdevice_type=$BuyerDetails['device_type'];
                                       $BuyerNotificationStatus=$BuyerDetails['NotificationStatus'];
                                      $Buyerfirebasetoken=$BuyerDetails['firebasetoken'];
                                       $BuyerID=$BuyerDetails['id'];
                                       $DriveDate=$BuyerDetails['TestDriveDate'];
                                       $DriveTime=$BuyerDetails['TestDriveTime'];
                                       
                                       $title="RTO testDrive ".$Status;
                                       $Buyermessage="Your RTO request ".$Status." by ".$SellerName;
                                     
                                     	if($Buyerdevice_type=='Android' && $BuyerNotificationStatus==1)
            			                {
            			                  
                				           $success=$this->fcmNotificationAndroid($title,$Buyermessage,$Buyerfirebasetoken,$NTYPES,NULL);
                				            if($success==1)
                				            {
                				                 $SaveNotification = $this->Users_model->SaveNoification($userid,$BuyerID,$Buyermessage,$NTYPES,$currdate);
                				            }
                		
            					
            			                }
            			                
            				            elseif($Buyerdevice_type=='Ios' && $BuyerNotificationStatus ==1)
            						    {
            					           
                                              $success=$this->fcmNotificationIos($title,$Buyermessage,$Buyerfirebasetoken,$NTYPES,NULL);
                				            if($success==1)
                				            {
                				                $SaveNotification = $this->Users_model->SaveNoification($userid,$BuyerID,$Buyermessage,$NTYPES,$currdate);
                				            }
                						
            					        }
                        				else
                        				{
                        		
                        				}
                                      
                                      
                                      
                                      
                                      /* $Sellermessage="Please dropoff vehicle items for a 24hr test drive, at the following DVSS address on date ".$DriveDate." & no less than 2hrs prior to time ".$DriveTime."";
                                     
                                     	if($Sellerdevice_type=='Android' && $SellerNotificationStatus==1)
            			                {
            			                  
                				          $success=$this->fcmNotificationAndroid($Sellermessage,$Sellerfirebasetoken,"MessageToSellerAfterAccept",NULL);
                				            if($success==1)
                				            {
                				                 $SaveNotification = $this->Users_model->SaveNoification($BuyerID,$userid,$Buyermessage,$currdate);
                				            }
                		
            					
            			                }
            			                
            				            elseif($Sellerdevice_type=='Ios' && $SellerNotificationStatus ==1)
            						    {
            					 
                                              $success=$this-> fcmNotificationIos($Sellermessage,$Sellerfirebasetoken,"MessageToSellerAfterAccept",NULL);
                				            if($success==1)
                				            {
                				                $SaveNotification = $this->Users_model->SaveNoification($BuyerID,$userid,$Buyermessage,$currdate);
                				            }
                						
            					        }
                        				else
                        				{
                        		
                        				}*/
                                     
                                    $response=array('success' => 1,'msg' => 'Test Drive Request '.$Status.'');  
                                 }
                                 else
                                 {
                                    $response=array('success' => 0,'msg' => 'Request Updation Problem');  
                                 } 
              
           
        }
        
         echo json_encode($response);
        
    }
    
    
    
    
    
      /*  Get Update Request */
    
      public function UpdateHoldStatusRTORequestBySeller()
    {
         $token=$_POST['token'];
         $TestDriveRequestID=$_POST['RTORequestID'];
         $Description=$_POST['Description'];
        $currdate=date("Y-m-d H:i:s");
         
         if($token!='' && $TestDriveRequestID!='')
         {
             $decoded = JWT::decode($token, $this->config->item('jwt_key'), array('HS256'));
              $userid=$decoded->id;
         
            $UpdateStatus = $this->Users_model->UpdateHoldStatusTestDriveRequestBySeller($TestDriveRequestID,$Description); 
            if($UpdateStatus)
            {
                
                                   
    		                         $BuyerDetails = $this->Users_model->BuyerDetailsByRequestID($TestDriveRequestID);
                                     $SellerDetails = $this->Users_model->userDetailByid($userid);  
                                     
                                      $device_type=$BuyerDetails['device_type'];
                                      $NotificationStatus=$BuyerDetails['NotificationStatus'];
                                      $firebasetoken=$BuyerDetails['firebasetoken'];
                                      $BuyerID=$BuyerDetails['id'];
                                      
                                      $SellerName=$SellerDetails['Username'];
                                      
                                       $title="OnHold RTO TestDrive Request";
                                      $message="Please CHANGE the test-drive request for RTO sent to ".$SellerName;
                         	if($device_type=='Android' && $NotificationStatus==1)
			                {
			                  
    				          $success=$this->fcmNotificationAndroid($title,$message,$firebasetoken,"OnHoldRTOTestDriveRequest",NULL);
    				            if($success==1)
    				            {
    				                 $SaveNotification = $this->Users_model->SaveNoification($userid,$BuyerID,$message,"OnHoldRTOTestDriveRequest",$currdate);
    				            }
    		
					
			                }
			                
				            elseif($device_type=='Ios' && $NotificationStatus ==1)
						    {
					 
                                  $success=$this->fcmNotificationIos($title,$message,$firebasetoken,"OnHoldRTOTestDriveRequest",NULL);
    				            if($success==1)
    				            {
    				                $SaveNotification = $this->Users_model->SaveNoification($userid,$BuyerID,$message,"OnHoldRTOTestDriveRequest",$currdate);
    				            }
    						
					        }
            				else
            				{
            		
            				}
               $response=array('success' => 1,'msg' => 'Hold Status Updated');
                 
            }
            else
            {
               $response=array('success' => 0,'msg' => 'Hold Status Not Updated');
            }
         }
         else
         {
             $response=array('success' => 0,'msg' => 'Please send Details');
         }
         echo json_encode($response);
        
    }  
    
    
    
     
    
         public function updateRTOPaymentByBuyer()
    {
          require_once('application/libraries/stripe-php-master/init.php');
         \Stripe\Stripe::setApiKey('sk_test_51KCJV8JkHEu82wYZRW0mz5HNuHsBD7wtklKbNlLCz946AEYMyLIFjmugyvMELalpJK7hYxJ9Q2tlPYTF84MlWeb400rtdXflci');
      
      
         //\Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
       
         $Token=$_POST['token'];
         $RentRequestID=$_POST['RequestId'];
         $downPaymentAmount=$_POST['downPaymentAmount']*100;
         $EMIdeductDate=$_POST['EMIdeductDate'];
         $daysCount=$_POST['daysCount'];
         $EMIPlanType=$_POST['EMIPlanType'];
         $nonceFromTheClient=$_POST['nonceFromTheClient'];
         $TotalAmount=$_POST['TotalAmount'];
         $recurringPrice=$_POST['recurringPrice']*100;
         $cardID=$_POST['cardID'];
         
         if($EMIPlanType=='Monthly')
         {
             $EmiInterval="month";
         }
         else
         {
             $EmiInterval="week";
         }
        if ($Token=='' || $RentRequestID=='') 
        {
            $response = array(
				'success'	=>	0,
				'data'		=>	"Enter all params"
			) ;	
			
        } 
        else 
        {
          
          
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
                $userid=$decoded->id;
               $TransactionNumber="TRANS".$this->generateRandomString();
                
                $cards = $this->Users_model->GetCardDetailsByID($cardID);
                $ExpireDate=$cards['ExpireDate']; 
                $expireYear = substr($ExpireDate, strpos($ExpireDate, "/") + 1); 
                
                $arr = explode("/", $ExpireDate, 2);
                $expireMonth = $arr[0];
               
               
               
                       
             /*$cardTokenArray=\Stripe\Token::create([
              'card' => [
                'number' => $cards['CardNumber'],
                'exp_month' => $expireMonth,
                'exp_year' => $expireYear,
                'cvc' => $cards['CVV'],
              ],
            ]);
                  
                  
                 echo $CardToken=$cardTokenArray['id']; 
                die();*/
                $userDetail = $this->Users_model->userDetailByid($userid);
                $Email=$userDetail['Email'];
                 
                
                $GetCarIDByTestReqID = $this->Users_model->GetCarIDByTestReqID($RentRequestID);
                 $carID=$GetCarIDByTestReqID['carID']; 
                
                $SellerDetailsByCarID = $this->Users_model->SellerDetailsByCarID($carID);
                 $SellerID=$SellerDetailsByCarID['id']; 
                
                $currdate=date("Y-m-d H:i:s");
                 $my_date_time = date("Y-m-d H:i:s", strtotime("+5 minutes"));
                
             try
               {  
                   
               $payment = \Stripe\Charge::create ([
            "amount" => $downPaymentAmount,
            "currency" => "USD",
            "source" => $nonceFromTheClient,
            "description" => "User Down payment" 
        ]);
                
                 $paymentResponse = array(
            "paymentSuccessID"=>$payment['id'],
            "balanceTransaction"=>$payment['balance_transaction'],
            "captured"=>$payment['captured']
            );
            
             $SellerStripeAccountDetails = $this->Users_model->GetSellerStripeAccountID($SellerID);
                        $StripeAccountID=$SellerStripeAccountDetails['stripeAccountID'];
                        if($StripeAccountID)
                        {
                            $PaymentCheck = $this->Users_model->SavePayment($RentRequestID,$TransactionNumber,$downPaymentAmount,'','','',$downPaymentAmount,'','','downPayment','',$userid,$carID,$cardID);
                            //this is payout code, uncomment it in live mode now we are using test mode
                            //$transferAmount=$this->transferAmountToSellerAccount($StripeAccountID,$downPaymentAmount,$payment['id']);
                        }
               
            
                       
             $cardTokenArray=\Stripe\Token::create([
              'card' => [
                'number' => $cards['CardNumber'],
                'exp_month' => $expireMonth,
                'exp_year' => $expireYear,
                'cvc' => $cards['CVV'],
              ],
            ]);
                  
                  
                  $CardToken=$cardTokenArray['id']; 
                
                 $customer = \Stripe\Customer::create ([
                  'email' => $Email, 
                'source'  => $CardToken          
                ]);
                
                //print_r($customer);
                // die();
                
                 $plan = \Stripe\Plan::create([
            "product" => [ 
                "name" => $EMIPlanType." Subscription" 
            ], 
            "amount" => $recurringPrice, 
            "currency" => "USD", 
            "interval" => $EmiInterval, 
            "interval_count" => 1 
        ]); 
                
                
                 $subscription = \Stripe\Subscription::create([
                "customer" => $customer['id'], 
                "items" => array( 
                    array( 
                        "plan" => $plan['id'], 
                    ), 
                ),
                "trial_end"=> strtotime($my_date_time),
                "metadata" => ["SellerID" => $SellerID]
            ]); 
            
                
                
                  if($subscription)
                {
                    $TransactionNumber="TRANS".$this->generateRandomString();
                    $PaymentCheck = $this->Users_model->SavePayment($RentRequestID,$TransactionNumber,$recurringPrice,'','','',$downPaymentAmount,$EMIdeductDate,$EMIPlanType,'recurring','',$userid,$carID,$cardID);
                	$lastInsertId = $this->Users_model->updateRTOPaymentByBuyer($RentRequestID,$downPaymentAmount,$EMIdeductDate,$EMIPlanType,$daysCount,$TotalAmount,$recurringPrice);
                                 if($lastInsertId)
                                 {
                                    $response=array('success' => 1,'msg' => 'Data updated'); 
                                    
                                    
                                    // Notification sent to seller
                                     $BuyerDetailsN = $this->Users_model->userDetailByid($userid);
                                     $device_type=$BuyerDetailsN['device_type'];
                                     $NotificationStatus=$BuyerDetailsN['NotificationStatus'];
                                     $firebasetoken=$BuyerDetailsN['firebasetoken'];
                                      
                                     $GetCarID=$this->Users_model->GetCarIDByTestReqID($RentRequestID);
                                     $CarID=$GetCarID['carID'];
                                     
                                    
                                     $carDetails=$this->Users_model->SellerDetailsByCarID($CarID);
                                     $CarModel=$carDetails['Model'];
                                     $SellerName=$carDetails['Username'];
                                     $SellerID=$carDetails['id'];
                                     
                                     
                                     $title="Downpayment done";
                                     $message="Congratulations, you have agreed to RTO vehicle item ".$CarModel." at the rate of $".$downPaymentAmount/100;
                                      
                                 	if($device_type=='Android' && $NotificationStatus==1)
        			                {
        			                  
            				          $success=$this->fcmNotificationAndroid($title,$message,$firebasetoken,"BuyerMakePaymentRTODownPayment ",NULL);
            				            if($success==1)
            				            {
            				                 $SaveNotification = $this->Users_model->SaveNoification($userid,$SellerID,$message,"BuyerMakePaymentRTODownPayment ",$currdate);
            				            }
            		
        					
        			                }
        			                
        				            elseif($device_type=='Ios' && $NotificationStatus ==1)
        						    {
        					 
                                          $success=$this->fcmNotificationIos($title,$message,$firebasetoken,"BuyerMakePaymentRTODownPayment ",NULL);
            				            if($success==1)
            				            {
            				                $SaveNotification = $this->Users_model->SaveNoification($userid,$SellerID,$message,"BuyerMakePaymentRTODownPayment ",$currdate);
            				            }
            						
        					        }
                    				else
                    				{
                    		
                    				}
                                    
                                 }
                                 else
                                 {
                                    $response=array('success' => 0,'msg' => 'Request Updation Problem');  
                                 } 
                                 
                }
                else
                {
                    $response=array('success' => 0,'msg' => 'Stripe Payment Problem');  
                }
              
                
                
               }
              catch (Exception $e) 
              {
            
            $messages=$e->getError()->message;
            $response = array('success'=>0,'msg'=>$messages);
             }
       
            
            
            
            
            
                
              
           
        }
        
         echo json_encode($response);
        
    }
    
    
    
    
     // BuyerNotificationList
    
       public function BuyerNotificationList()
        {
          
             $Token=$_POST['token'];
             
            if ($Token=='') 
            {
                $response = array(
    				'success'	=>	0,
    				'data'		=>	"Enter all params"
    			) ;	
    			
            } 
            else 
            {
               
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
               
               
               
           $NotificationsList = $this->Users_model->BuyerNotificationListDB($userid);
           if(!empty($NotificationsList))
           {
               
              $response=array('success' => 1,'msg' => 'Data Found','data' => $NotificationsList);    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Data not found','data' => NULL); 
           }
           
        
            }
         echo json_encode($response);
        
        }
           
      
      
     // SellerNotificationList
    
       public function SellerNotificationList()
        {
          
             $Token=$_POST['token'];
             
            if ($Token=='') 
            {
                $response = array(
    				'success'	=>	0,
    				'data'		=>	"Enter all params"
    			) ;	
    			
            } 
            else 
            {
               
               $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
               $userid=$decoded->id;
               
               
               
           $NotificationsList = $this->Users_model->SellerNotificationListDB($userid);
           if(!empty($NotificationsList))
           {
               
              $response=array('success' => 1,'msg' => 'Data Found','data' => $NotificationsList);    
               
           }
           else
           {
               $response=array('success' => 0,'msg' => 'Data not found','data' => NULL); 
           }
           
        
            }
         echo json_encode($response);
        
        }
        
        
        
        
        
         public function EmiPayment()
    {
        include("vendor1/autoload.php");
        
      
       /* $Token=$_POST['token'];
        $RequestID=$_POST['RequestID'];
        $Amount=$_POST['amount']; // Total amount
        $DeliveryCost=$_POST['DeliveryCost'];
        $pickupCost=$_POST['pickupCost'];
        $PerDayCost=$_POST['PerDayCost'];
        $PaymentType=$_POST['PaymentType'];
        $RequestType=$_POST['RequestType']; // Sell or Rent
        $nonceFromTheClient=$_POST['nonceFromTheClient'];
        $cardID=$_POST['cardID'];
        
       
        $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
        $userid=$decoded->id;
        $TransactionNumber="TRANS".$this->generateRandomString();
       $currdate=date("Y-m-d H:i:s");
       */
       $Amount=40;
       //$nonceFromTheClient="tokencc_bj_twspxq_wcr653_4ncjcn_9wzk68_kq4";
             $gateway = new Braintree_Gateway([
                    'environment' => 'sandbox',
                    'merchantId' => 'n7fdg2nm7z8f3hd2',
                    'publicKey' => 'qs6gkpsm63hzs3wz',
                    'privateKey' => 'c240228d2917f85af97b9b724a6fdc85'
                ]);
                	
               $result = $gateway->customer()->create([
    'firstName' => 'Mike',
    'lastName' => 'Jones',
    'company' => 'Jones Co.',
    'email' => 'mike.jones@example.com',
    'phone' => '281.330.8004',
    'fax' => '419.555.1235',
    'website' => 'http://example.com',
      'creditCard' => [
        'billingAddress' => [
            'firstName' => 'Jen',
            'lastName' => 'Smith',
            'company' => 'Braintree',
            'streetAddress' => '123 Address',
            'locality' => 'City',
            'region' => 'State',
            'postalCode' => '12345'
        ],
        'cardholderName' => 'Bhawani Singh',
        'cvv'=>'123',
        'expirationDate' => '02/25',
        'number' => '4242424242424242'
    ]
]);


$aCustomerId=$result->customer->id;


echo $clientToken = $result->customer->creditCards[0]->token;

                $results = $gateway->subscription()->create([
                'paymentMethodToken' => $clientToken,
                'planId' => 'm83m',
                'price' => $Amount,
                'numberOfBillingCycles' =>4,
                'firstBillingDate' => 'billingDate'
                ]);
                
                
            echo"<pre>";
            print_r($results);

    }
    
    
    
     /* DELETE BANK */
      
      
       public function DeleteNotification()
    {
       
    
        
         $NotificationType=$_POST['NotificationType'];
         $Token=$_POST['token'];
         $UserType=$_POST['UserType'];
         
        if ($UserType=='' && $NotificationType=='') 
        {
            $response = array(
				'success'	=>	0,
				'data'		=>	"Enter all params"
			) ;	
			
        } 
        else 
        {
             $decoded = JWT::decode($Token, $this->config->item('jwt_key'), array('HS256'));
             $userid=$decoded->id;
               
            if($NotificationType=='Single')
            {
                 $NotificationID=$_POST['NotificationID'];
                 $DeleteNotification = $this->Users_model->DeleteNotification($NotificationID);
                 
                   if($DeleteNotification)
                   {
                      
                      $response=array('success' => 1,'msg' => 'Notification deleted');    
                       
                   }
                   else
                   {
                       $response=array('success' => 0,'msg' => 'Notification not deleted'); 
                   }
           
            }
            else
            {
                $DeleteNotification = $this->Users_model->DeleteAllNotification($userid,$UserType);
                   if($DeleteNotification)
                   {
                      
                      $response=array('success' => 1,'msg' => 'All Notification deleted');    
                       
                   }
                   else
                   {
                       $response=array('success' => 0,'msg' => 'Notification not deleted'); 
                   }
            }
           
        }
        
         echo json_encode($response);
        
    }
    
        public function demo()
        {
            
          
            include("vendor1/autoload.php");
        
      
          
      
             $gateway = new Braintree_Gateway([
                    'environment' => 'sandbox',
                    'merchantId' => 'f6twxhqdcwv2bjy2',
                    'publicKey' => 'mfyp2stjf4n9thw3',
                    'privateKey' => 'fbff6af2076311f4da3b84368fe44064'
                ]);
                	
             
             
             
                     $merchantAccountParams = [
          'individual' => [
            'firstName' => 'Jane',
            'lastName' => 'Doe',
            'email' => 'jane@14ladders.com',
            'phone' => '5553334444',
            'dateOfBirth' => '1981-11-19',
            'ssn' => '456-45-4567',
            'address' => [
              'streetAddress' => '111 Main St',
              'locality' => 'Chicago',
              'region' => 'IL',
              'postalCode' => '60622'
            ]
          ],
          'business' => [
            'legalName' => 'Jane\'s Ladders',
            'dbaName' => 'Jane\'s Ladders',
            'taxId' => '98-7654321',
            'address' => [
              'streetAddress' => '111 Main St',
              'locality' => 'Chicago',
              'region' => 'IL',
              'postalCode' => '60622'
            ]
          ],
          'funding' => [
            'descriptor' => 'Blue Ladders',
            'destination' => Braintree\MerchantAccount::FUNDING_DESTINATION_BANK,
            'email' => 'funding@blueladders.com',
            'mobilePhone' => '5555555555',
            'accountNumber' => '1123581321',
            'routingNumber' => '071101307'
          ],
          'tosAccepted' => true,
          'masterMerchantAccountId' => "14ladders_marketplace",
          'id' => "blue_ladders_store"
        ];
        $result = $gateway->merchantAccount()->create($merchantAccountParams);

echo"<pre>";
print_r($result);



        }
        
        
        
           // Contact Us API
 
    public function contactUs()
    {
         $email=$_POST['Email'];
         $name=$_POST['name'];
         $subject=$_POST['subject'];
         $msg=$_POST['message'];
        
         
         
	     $link="<div>
	     <label>Name</label>:".$name." <br>
	     <label>Subject</label>:".$subject." <br>
	     <label>Message</label>:".$msg."
	     </div>";
	     
	     $subject = "Contact Us";
	     $htmlContent = '<div style="width: 90%; margin-left: auto; margin-right: auto; background-color: #fff;"><p style="font-size: 24px">'.$link.'</p></div>';
   
         
              $sendMessagee = $this->SMTP_mail($email,$subject,$htmlContent); 
             if($sendMessagee)
             {
                 	$response=array('success' => 1,'msg' => 'Contact Us Mail sent');   
             }
             else
             {
                 $response=array('success' => 0,'msg' => 'Mail send error'); 
             }
        
         
         echo json_encode($response);
        
    }
    
    public function stripeNotifyWebhook()
    {
       
    
         require_once('application/libraries/stripe-php-master/init.php');
         //require 'vendor/autoload.php';
         \Stripe\Stripe::setApiKey('sk_test_51KCJV8JkHEu82wYZRW0mz5HNuHsBD7wtklKbNlLCz946AEYMyLIFjmugyvMELalpJK7hYxJ9Q2tlPYTF84MlWeb400rtdXflci');
      
        
        // Replace this endpoint secret with your endpoint's unique secret
        // If you are testing with the CLI, find the secret by running 'stripe listen'
        // If you are using an endpoint defined with the API or dashboard, look in your webhook settings
        // at https://dashboard.stripe.com/webhooks
        //whsec_1V6isQYi9JjetY5VwXIKhe9Zz6rIDx3F
        $endpoint_secret = 'whsec_1V6isQYi9JjetY5VwXIKhe9Zz6rIDx3F';
        
        $payload = @file_get_contents('php://input');
        $event = null;
        //$this->Users_model->SaveWebhookResponse($payload);
        try {
          $event = \Stripe\Event::constructFrom(
            json_decode($payload, true)
          );
          
          
        } catch(\UnexpectedValueException $e) {
          // Invalid payload
         
          echo '⚠️  Webhook error while parsing basic request.';
          http_response_code(400);
          
          exit();
        }
        /*if ($endpoint_secret) {
          // Only verify the event if there is an endpoint secret defined
          // Otherwise use the basic decoded event
          $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
          try {
            $event = \Stripe\Webhook::constructEvent(
              $payload, $sig_header, $endpoint_secret
            );
            
            $this->Users_model->SaveWebhookResponse('success2');
          } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            $this->Users_model->SaveWebhookResponse($e);
            echo '⚠️  Webhook error while validating signature.';
            http_response_code(400);
            exit();
          }
        }*/
        $this->Users_model->SaveWebhookResponse($event->type);
        // Handle the event
        switch ($event->type) {
          case 'customer.created':
              $paymentMethodSucced = $event->data->object; 
            $paymentMethodSuccedJson=json_encode($paymentMethodSucced);
             // $this->Users_model->SaveWebhookResponse($paymentMethodSuccedJson);
            break;
          case 'payment_intent.succeeded':
            $paymentIntent = $event->data->object; // contains a \Stripe\PaymentIntent
            // Then define and call a method to handle the successful payment intent.
            // handlePaymentIntentSucceeded($paymentIntent);
            break;
          case 'payment_method.attached':
            $paymentMethod = $event->data->object; // contains a \Stripe\PaymentMethod
            // Then define and call a method to handle the successful attachment of a PaymentMethod.
            // handlePaymentMethodAttached($paymentMethod);
            break;
          case 'invoice.payment_succeeded':
            $paymentMethodSucced = $event->data->object; 
            $paymentMethodSuccedJson=json_encode($paymentMethodSucced);
            $chargeID=$paymentMethodSuccedJson->charge;
            $amount_paid=$paymentMethodSuccedJson->amount_paid;
            $amount_paid=$paymentMethodSuccedJson->amount_paid;
              $this->Users_model->SaveWebhookResponse($paymentMethodSuccedJson);
            
            break;
          default:
            // Unexpected event type
            error_log('Received unknown event type');
        }
       
        http_response_code(200);
            }
    
               
}
