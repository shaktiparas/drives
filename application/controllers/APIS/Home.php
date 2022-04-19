
<?php
error_reporting(0);
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
use Restserver\Libraries\REST_Controller;

// header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Home extends CI_Controller
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
            'mailApiKey' => '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',
            'fromMail' => 'shakti.parastechnologies@gmail.com',
            'serverKey' => $this->config->item('serverKey'),
            'stripe_secret' => $this->config->item('stripe_client_test_secret'),
            'currency' => $this->config->item('client_currency')
        );
    }
    
    /*start decode token*/
    public function decodeToken($token){
        $decoded = JWT::decode($token, $this->config->item('jwt_key'), array('HS256'));
        $userDetail = $this->Users_model->userDetailByMobile($decoded->phoneNumber);
        return $userDetail;
    }    
    /*end*/
    public function encodeToken($moblie){
        $userInfo = $this->Users_model->getUserProfileInfo($moblie);
        $token = JWT::encode($userInfo, $this->config->item('jwt_key'));
        return $token;
    }
    public function stripeCredenatils(){
		require_once('application/libraries/stripe-php-master/init.php');
        \Stripe\Stripe::setApiKey($this->data['stripe_secret']);
	}
    /*start mail function*/
    public function mail($fromMail,$type,$email,$subject,$message){
        require 'vendor/autoload.php';
        $API_KEY='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';
        $FROM_EMAIL = 'shakti.parastechnologies@gmail.com'; 
        $TO_EMAIL = $email; 
        $subject = "Ecutz $type ContactUs - $subject"; 
        $from = new SendGrid\Email(null, $FROM_EMAIL);
        $to = new SendGrid\Email(null, $FROM_EMAIL);
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
    /*end*/
    

  
    /*Start allCustomerList API*/  
    public function notificationAndroid($title,$message,$type,$bookingID,$FIREBASETOKEN){
        define( 'API_ACCESS_KEY', $this->config->item('serverKey'));
        $field = array("title" => $title,"message" => $message,"image"=> "","type" => $type, "bookingID"=>$bookingID);
 		$fields = array
      (
		'to' => $FIREBASETOKEN,
        'data'  => $field            
	  );  
   		$headers = array
		(
				'Authorization: key=' . API_ACCESS_KEY,
				'Content-Type: application/json'
		); 
        //print_r($fields);    
        $ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, $this->config->item('FCM'));
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers ); 
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields) );
		$results=curl_exec($ch);
		$resultsArray=json_decode($results);
		//print_r($resultsArray);
		 $success=$resultsArray->success;	
		curl_close( $ch ); 
        return $success=$resultsArray->success;
    }
    public function notificationIOS($title,$message,$type,$bookingID,$FIREBASETOKEN){
      //  echo $FIREBASETOKEN;
        $url = $this->config->item('FCM');
        $serverKey = $this->config->item('serverKey');
        
        $alert = array("body" => $message,"title" => $title,"bookingID"=>$bookingID,"type" => $type,"sound" => "default","badge" => "1");
        
        $arrayToSend = array('to' => $FIREBASETOKEN,'notification' => $alert,'priority'=>'high');
        
      //  print_r($arrayToSend);
        
        $json = json_encode($arrayToSend);
        //print_r($json);
        $headers = array();
        $headers[] = 'Content-Type: application/json'; 
        $headers[] = 'Authorization: key='. $serverKey; 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers); 
        $results=curl_exec($ch);
        $resultsArray=json_decode($results);	
        //print_r($resultsArray);
        $success = $resultsArray->success;	
        curl_close( $ch ); 
        return $success; 
    }
    /*End forgotResetPassword API*/ 
    public function crossPlateform($title,$message,$type,$bookingID,$FIREBASETOKEN,$reciDeviceType){
        if($reciDeviceType == 'Android')
        {
            //echo "yes";
            $status = $this->notificationAndroid($title,$message,$type,$bookingID,$FIREBASETOKEN);
            //print_r($status);
        }
        else {
            //echo "no";
            $status = $this->notificationIOS($title,$message,$type,$bookingID,$FIREBASETOKEN);
           // print_r($status);
        }
        return $status;
    }
     /*Start contactUs API*/  
    public function contactUs(){
        if($_POST['token'] == ""){
             $data = array(
                  'success' => 0,
                  'message'   =>  'Please add token'
              );
        }
        else {
            $token = $_POST['token'];
            $email = $_POST['email'];
            $subject = $_POST['subject'];
            $message = $_POST['message'];
            $userDetail = $this->decodeToken($token);
            $fromMail = $userDetail['email'];
            $type = $userDetail['userRole'];
            $userId = $userDetail['id'];
            $isMail = $this->mail($fromMail,$type,$email,$subject,$message);
            if($isMail)
            {
                $response = $this->Home_model->contactUs($userId,$type,$email,$subject,$message);
                $data = array("data" => $response, "success"=> 1, "message"=>"Mail sent successfully");
            }
            else {
                 $data = array("success"=> 0, "message"=>"Mail sent not successfully");
            }
            echo json_encode($data);
        }
    }
    /*End contactUs API*/ 
    /*Start allCustomerList API*/  
    public function barberReviewList(){
        $token =  $token = $_POST["token"]; 
        $userDetail = $this->decodeToken($token);
        $barberID = $userDetail['id'];
        $userID = $barberID;
        $response = $this->Home_model->barberReviewListData($barberID);
        $countData  = count($response);
        $max = 0;
        foreach ($response as $rate => $count) { 
            $max = $max+$count['rating'];
        }
        $totalTrips = $this->Home_model->totalBookings($userID,2);
        if($response){
            $data = array(
            'data'=>$response,
            'users'=> $countData,
            'averageRating' => number_format($max / $countData,2),
            'totalTrips' => $totalTrips['total'],
            'success'=> 1,
            'message'=>'Review list found.');
        }else{
            $data = array('data'=> [],'success'=> 0,'message'=>'Reviews list not found.');
        }
        echo json_encode($data); 
    }
    /*End forgotResetPassword API*/ 
    /*Start postFreeTimeSlotByBarber API*/  
    public function postFreeTimeSlotByBarber(){
        if($_POST['token'] == ""){
             $data = array(
                  'success' => 0,
                  'message'   =>  'Please add token'
              );
        }
        else {
            $token =  $_POST["token"]; 
            $userDetail = $this->decodeToken($token);
            $userID = $userDetail['id'];
            $response = $this->Home_model->postFreeTimeSlotByBarber($userID);
             if($response){
                 $data = array('data'=>$response['data'],'success'=> 1,'message'=>$response['msg']);
             }else{
                $data = array('success'=> 0,'message'=>'Something went wrong');
             }
        } 
           echo json_encode($data); 
    }
    /*End postFreeTimeSlotByBarber API*/
    
    /*Start getBarberAvaialbleSlot API*/
    
    public function getBarberAvaialbleSlot(){
        $token =  $token = $_POST["token"]; 
        $userDetail = $this->decodeToken($token);
         $userID = $userDetail['id'];
        $date = $_POST['date'];
        $response = $this->Home_model->getBarberAvaialbleSlotByDate($userID,$date);
        //print_r($response);
        if($response){
             $data = array('data'=>$response,'success'=> 1,'message'=>'Time Slot List successfully');
        }else{
            $data = array('success'=> 0,'message'=>'Time slot not found');
        }
        echo json_encode($data); 
    }
    
    /*End getBarberAvaialbleSlot API*/
    
    public function getBarberAvaialbleSlotForClient(){
        $token =  $token = $_POST["token"]; 
        $userDetail = $this->decodeToken($token);
        $userID = $userDetail['id'];
        $barberID = $_POST['barberID'];
        $date = $_POST['date'];
        $response = $this->Home_model->getBarberAvaialbleSlotForClient($barberID,$date);
        if($response){
             $data = array('data'=>$response,'success'=> 1,'message'=>'Time Slot List successfully');
        }else{
            $data = array('success'=> 0,'message'=>'Time slot not found');
        }
        echo json_encode($data); 
    }
    /*Start allCustomerList API*/  
    public function getTimeList(){
        $token =  $token = $_POST["token"]; 
        $userDetail = $this->decodeToken($token);
        $userID = $userDetail['id'];
        $response = $this->Home_model->timeDetailByUserid($userID);
         if($response){
             $data = array('data'=>$response,'success'=> 1,'message'=>'Time List successfully');
         }else{
            $data = array('data'=> '','success'=> 0,'message'=>'Something went wrong');
         }
           echo json_encode($data); 
    }
    /*End forgotResetPassword API*/ 
    
    /*Start allCustomerList API*/  
    public function onlineStatus(){
        $onlineStatus = $_POST["onlineStatus"];
        $token = $_POST["token"]; 
        $userDetail = $this->decodeToken($token);
        $userID = $userDetail['id'];
        $user_type = $userDetail['userRole'];
        
        
        $response = $this->Home_model->onlineStatus($userID,$onlineStatus);
        if($response){
            
            if($onlineStatus==0)
            {
                 $cancel_request_response = $this->Home_model->CancelBookingRequestStatusWhileOffline($userID,$user_type);
                
            }
          
            $data = array(
                'data'=> $onlineStatus == 1 ? $response : "",
                'onlineStatus' => $onlineStatus,
                'success'=> $onlineStatus == 1 ? 1 : 0,
                'message'=> $onlineStatus == 1 ? 'online' : 'offline');
        }else{
            $data = array('data'=> NULL,'success'=> 0,'message'=>'Something went wrong');
        }
        echo json_encode($data); 
    }
    /*End forgotResetPassword API*/ 
     /*Start listOfNearByCustomer API*/  
    public function listOfNearByUsers(){
        $token = $_POST["token"]; 
        $userDetail = $this->decodeToken($token);
       // print_r($userDetail);
        $userID = $userDetail['id'];
        $latitude = $userDetail['latitude'];
        $longitude = $userDetail['longitude'];
        $type = $userDetail['userRole'];
        $response = $this->Home_model->listOfNearByUsers($type,$latitude,$longitude);
        foreach($response as $value){
            $token =  $this->encodeToken($value['phoneNumber']);
            $barberID = $value['id'];
            $bookingID = $this->Home_model->getbookingID($userID,$barberID);
            $value['requestBookingID'] = $bookingID['requestBookingID'];
            $value['requestBookingDate'] = $bookingID['requestBookingDate'];
            $value['bookingStatus'] = $bookingID['bookingStatus'];
            $value['barberStatus'] = $bookingID['barberStatus'];
            $value['clientStatus'] = $bookingID['clientStatus'];
            $value['token'] = $token;
            $dataBarber[] = $value;
        }
        if($response){
            $data = array(
                'data'=>$type == 3 ? $dataBarber : $response,
                'success'=> 1,
                'message'=> $type == 2 ? 'List of near by customer' : 'List of near by barber'
            );
        }else{
            $data = array('data'=> [],'success'=> 0,'message'=>'List not found');
        }
        echo json_encode($data); 
    }
    /*End listOfNearByUsers API*/ 
    
      /*Start listOfNearByCustomer API*/  
    public function getAllNearByBarber(){
        $token = $_POST["token"]; 
        $userDetail = $this->decodeToken($token);
        $userID = $userDetail['id'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $response = $this->Home_model->getAllNearByBarber($latitude,$longitude);
        if($response){
            $dataBarber =  $this->barberTotalReviewRating($response,$userID);
            $data = array(
                'data'=> $dataBarber,
                'success'=> 1,
                'message'=> 'List of near by barber'
            );
        }else{
            $data = array('data'=> [],'success'=> 0,'message'=>'List not found');
        }
        echo json_encode($data); 
    }
    /*End listOfNearByUsers API*/ 
    
    
    
    public function barberTotalReviewRating($data,$userID){
        foreach($data as $val){
            $barberID = $val['id'];
            $bookingID = $this->Home_model->GetRequestedBookingUserSingle($barberID,$userID);
            //$val['booking'] = $bookingID;
            $val['requestBookingID'] = $bookingID['requestBookingID'];
            $val['requestBookingDate'] = $bookingID['requestBookingDate'];
            $val['bookingStatus'] = $bookingID['bookingStatus'];
            $val['barberStatus'] = $bookingID['barberStatus'];
            $val['clientStatus'] = $bookingID['clientStatus']; 
            
            $responseReview = $this->Home_model->barberReviewListData($val['id']);
            $countData  = count($responseReview);
            $max = 0;
            foreach ($responseReview as $rate => $count) { 
                $max = $max+$count['rating'];
            }
            
            $val['rating'] = $max ? round($max / $countData,2) : 0;
            $val['review'] = $countData;
            $token =  $this->encodeToken($val['phoneNumber']);
            $val['token'] = $token;
            $response[] = $val;
        }
        return $response;    
    }
    /*Start allBarberList API*/  
    public function allBarberList(){
        $token = $_POST["token"]; 
        $userDetail = $this->decodeToken($token);
        $userID = $userDetail['id'];
        $res = $this->Home_model->allBarberList();
        if($res){
           $response =  $this->barberTotalReviewRating($res,$userID);
            $data = array(
                'data'=> $response,
                'success'=> 1,
                'message'=> 'Data found');
        }else{
            $data = array('success'=> 0,'message'=>'Data not found');
        }
        echo json_encode($data); 
          
    }
    /*End allBarberList API*/ 
    /*Start allBarberList API*/  
    public function getBarberProfileDetailsForCustomer(){
        $id = $_POST['barberID'];
        $response = $this->Home_model->getBarberProfileDetailsForCustomer($id);
        if($response){
            $responseReview = $this->Home_model->barberReviewListData($id);
            $responseServices = $this->Users_model->allServicesDetailByid($id) ; 
            foreach($responseServices as $responseServicesValues){
                //unset($responseServicesValues->id);
                unset($responseServicesValues['userID']);
                unset($responseServicesValues['servicesStatus']);
                unset($responseServicesValues['created_date']);
                $responseServicesValues['servicesID'] = $responseServicesValues['id'];
                unset($responseServicesValues['id']);
                $responseServicesValue[] =  $responseServicesValues;
                
            }
            
           // $responseTime = $this->Home_model->timeDetailByUserid($id);
            $countData  = count($responseReview);
            $max = 0;
            foreach ($responseReview as $rate => $count) { 
                $max = $max+$count['rating'];
            }
            $response['services'] = $responseServices ? $responseServicesValue : [];
            $response['barberrating'] =  $responseReview ? number_format($max / $countData,2) : "0";
            //$response['timing'] = $responseTime ? $responseTime : [];
            $response['token'] = $this->encodeToken($response['phoneNumber']);
            unset($response['phoneNumber']);
            $data = array(
                'barberData'=> $response,
                'success'=> 1,
                'message'=> 'Data found');
        }else{
            $data = array('data'=> '','success'=> 0,'message'=>'Data not found');
        }
        echo json_encode($data); 
          
    }
    /*Start addAppointments API*/  
    public function addAppointments(){
        $token = $_POST['token'];
        $userDetail = $this->decodeToken($token);
        $userID = $userDetail['id'];
        $response = $this->Home_model->addAppointments($userID);
        if($response){
            $data = array(
                'data'=> $response,
                'success'=> 1,
                'message'=> "appointment added successfully"
            );
        }else{
            $data = array('data'=> '','success'=> 0,'message'=>'Something went wrong');
        }
        echo json_encode($data);  
    }
    /*End addAppointments API*/
    
    /*Start addAppointments API*/  
    public function getAppointments(){
        $token = $_POST['token'];
        $userDetail = $this->decodeToken($token);
         $userID = $userDetail['id'];
        $response = $this->Home_model->getAppointments($userID);
        if($response){
            $data = array(
                'data'=> $response,
                'success'=> 1,
                'message'=> "Data Found"
            );
        }else{
            $data = array('data'=> '','success'=> 0,'message'=>'Data not found');
        }
        echo json_encode($data);  
    }
    /*End addAppointments API*/
    
    /*  Add request barber booking */
    public function postrequestbarberBooking()
    {
        $token = $_POST['token'];
        $barberID=$_POST['barberID'];
        $userDetail = $this->decodeToken($token);
        $userID = $userDetail['id'];
        $clientLat = $userDetail['latitude'];
        $clientLong = $userDetail['longitude'];
        $deviceType = $userDetail['deviceType'];
        $clientName = $userDetail['firstName'].' '.$userDetail['lastName'];
        
        $barberExistence= $this->Home_model->checkBarberIsOnline($barberID);
        if($barberExistence['onlineStatus'] == 1){
            //$checkExistence= $this->Home_model->checkExistRequestBooking($userID,$barberID);
            //if($checkExistence)
            //{  
            $checkExistence= $this->Home_model->ifCheckBookingAlreadyOnGoing($userID);
            if($checkExistence)
            { 
                $response = $this->Home_model->addRequestBarberBooking($userID,$barberID,$clientLat,$clientLong);
                if($response){
                    if($response['oldBookingID']){
                        $barberRecord = $this->Home_model->getBarberDetailByID($response['oldBookingID']);
                        $title = 'Client has Cancelled Booking';
                        $message = $clientName.' has cancelled booking request';
                        $type = 'cancelBooking';
                        $FIREBASETOKEN = $barberRecord['deviceToken'];
                        $reciDeviceType = $barberRecord['deviceType'];
                        $success = $this->crossPlateform($title,$message,$type,$response['oldBookingID'],$FIREBASETOKEN,$reciDeviceType);
                        /*if($deviceType == 'Android'){
                            $androidStatus  = $this->notificationAndroid($title,$message,$type,$response['oldBookingID'],$FIREBASETOKEN);
                        }
                        if($deviceType == 'IOS'){
                            $iosStatus  = $this->notificationIOS($title,$message,$type,$bookingID,$FIREBASETOKEN);
                        }*/
                    }
                    if($response['res']){
                        $bookingID = $response['res']['requestBookingID'];
                        $barberRecord = $this->Users_model->userDetailByid($barberID);
                        $services = $this->Home_model->selectedServicesList($bookingID);
                        $servicesName = $this->Home_model->servicesTitleString($services);
                        //$title = 'Request Booking';
                        //$message = $clientName.' sent you booking request';
                        $title = 'You Have A New Request';
                        $message = $clientName.' Has requested a ('.$servicesName.') from You.  Accept Now ';
                        $type = 'requestBooking';
                        $FIREBASETOKEN = $barberRecord['deviceToken'];
                        $reciDeviceType = $barberRecord['deviceType'];
                        $success = $this->crossPlateform($title,$message,$type,$bookingID,$FIREBASETOKEN,$reciDeviceType);
                        /*if($deviceType == 'Android'){
                            $androidStatus  = $this->notificationAndroid($title,$message,$type,$bookingID,$FIREBASETOKEN);
                        }
                        if($deviceType == 'IOS'){
                            $iosStatus  = $this->notificationIOS($title,$message,$type,$bookingID,$FIREBASETOKEN);
                        }*/
                    }
                    $data = array(
                        'data'=> $response['res'],
                        'success'=> 1,
                        'message'=> "Request booking added successfully"
                    );
                }else{
                    $data = array('data'=> NULL,'success'=> 0,'message'=>'Something went wrong');
                }
            }
            else
            {
             $data = array('data'=> NULL,'success'=> 0,'message'=>'Your other booking is already in process');
            }    
           /* }
            else
            {
             $data = array('data'=> NULL,'success'=> 0,'message'=>'You have already sent booking request to this barber');
            }*/
        }    
        else
        {
         $data = array('data'=> NULL,'success'=> 0,'message'=>'ECUTZ pro in offline mode');
        }
        echo json_encode($data); 
    }
    
    /*  Schedule booking */
    
    public function postScheduleBookingBarber()
    {
         $token = $_POST['token'];
        $userDetail = $this->decodeToken($token);
        $userID = $userDetail['id'];
        $selectedTimeID =  $_POST['selectedTimeID'];
        $barberID = $_POST['barberID'];
        $clientLat = $userDetail['latitude'];
        $clientLong = $userDetail['longitude'];
        $deviceType = $userDetail['deviceType'];
        $clientName = $userDetail['firstName'].' '.$userDetail['lastName'];
        $checkExistence = $this->Home_model->checkExistscheduledBooking($userID,$barberID,$selectedTimeID);
        if($checkExistence)
        {
            $response = $this->Home_model->addScheduleRequestBarberBooking($userID,$clientLat,$clientLong);
            if($response){
                $bookingID = $response['requestBookingID'];
            	$appoinmentDate = $response['appointmentDate'];  
				$createDate = new DateTime($appoinmentDate);
				$ADate = $createDate->format('M d, Y');
                $slotID = $response['selectedTimeID'];
                $slot = $this->Home_model->getSlotByID($slotID);
                $services = $this->Home_model->selectedServicesList($bookingID);
                $servicesName = $this->Home_model->servicesTitleString($services);
                $barberRecord = $this->Home_model->getBarberDetailByID($bookingID);
                //$title = 'Scheduled Booking';
               // $message = $clientName.' scheduled appointment for '.$servicesName.' on '.$ADate.' at '.$slot['startSlot'];
                $title = 'You Have A New Appointment Request';
                $message = $clientName.' Has scheduled an appointment with you for '.$servicesName.' on '.$ADate.' at '.$slot['startSlot'];
                $type = 'ScheduledBooking';
                $reciDeviceType = $barberRecord['deviceType'];
                $FIREBASETOKEN = $barberRecord['deviceToken'];
                $success = $this->crossPlateform($title,$message,$type,$bookingID,$FIREBASETOKEN,$reciDeviceType);
                //if($success == 1){
                    $this->Home_model->addNotification($barberID,0,$bookingID,$type,$title,$message);
                //}
                
                $data = array(
                    'data'=> $response,
                    'success'=> 1,
                    'message'=> "Request booking scheduled successfully"
                );
            }else{
                $data = array('data'=> NULL,'success'=> 0,'message'=>'Something went wrong');
            }
        }
        else{
             $data = array('data'=> NULL,'success'=> 0,'message'=>'You have already sent booking request to this barber and time Slot');
        }
            echo json_encode($data); 
    }
    
    
  /* Get all user who requested the barber*/
    
     public function GetRequestedBookingUsers()
    {
         $token = $_POST['token'];
        $userDetail = $this->decodeToken($token);
        $userID = $userDetail['id'];
       
        $response = $this->Home_model->GetRequestedBookingUser($userID);
        /*foreach($data as $value){
            $value['UTC'] = new DateTime($value['requestBookingDate'], new DateTimeZone('UTC'));
            $response[] = $value;
        }
        */
        if($response){
            $data = array(
                'data'=> $response,
                'success'=> 1,
                'message'=> "Data Found"
            );
        }else{
            $data = array('data'=> NULL,'success'=> 0,'message'=>'Data not found');
        }
        echo json_encode($data); 
    }
    
    public function CancelBookingRequestStatus()
    {
        $token = $_POST['token'];
        $userDetail = $this->decodeToken($token);
        $userID = $userDetail['id'];
        $BookingId=$_POST['requestBookingID'];
        $name = $userDetail['firstName'].''.$userDetail['lastName'];
        $deviceType = $userDetail['deviceType'];
        $userType = $userDetail['userRole'];
        $ifCancel = $this->Home_model->ifAlreadyCancel($BookingId);
        if($ifCancel['status'] == 3){
            $data = array('data'=> NULL,'success'=> 1,'message'=>'Booking already Cancelled');
        }
        else{
            $response = $this->Home_model->CancelBookingRequestStatus($userID);
            if($response){
                if($userType == 2){
                    $clientRecord = $this->Home_model->getClientDetailByID($BookingId);
                    $title = 'Request Cancelled';
                    $message = $name.' Has cancelled your request.';
                    $type = 'cancelBooking';
                    $FIREBASETOKEN = $clientRecord['deviceToken'];
                    $reciDeviceType = $clientRecord['deviceType'];
                    $success = $this->crossPlateform($title,$message,$type,$BookingId,$FIREBASETOKEN,$reciDeviceType);
                }
                else if($userType == 3){
                    $barberRecord = $this->Home_model->getBarberDetailByID($BookingId);
                    $services = $this->Home_model->selectedServicesList($BookingId);
                    $servicesName = $this->Home_model->servicesTitleString($services);
                    $title = 'Request Cancelled';
                    $message = $name.' Has cancelled their ( '.$servicesName.' ).';
                    $type = 'cancelBooking';
                    $FIREBASETOKEN = $barberRecord['deviceToken'];
                    $reciDeviceType = $barberRecord['deviceType'];
                    $success = $this->crossPlateform($title,$message,$type,$BookingId,$FIREBASETOKEN,$reciDeviceType);
                }
                $data = array(
                    'data'=> NULL,
                    'success'=> 1,
                    'message'=> "Request cancelled"
                );
            }else{
                $data = array('data'=> NULL,'success'=> 0,'message'=>'Request not Cancelled');
            }
        }
        echo json_encode($data); 
    }
    public function overllRating($rating){
        $countData  = count($rating);
        $max = 0;
        foreach ($rating as $rate => $count) { 
            $max = $max+$count['rating'];
        }
        $val = $max ? number_format($max / $countData,2) : 0;
        return $val;
    }
    public function getBookingDetail(){
        $token = $_POST['token'];
        $userDetail = $this->decodeToken($token);
        $userID = $userDetail['id'];
        $bookingID = $_POST['bookingID'];
        $type = $userDetail['userRole'];
        $response = $this->Home_model->getBookingDetail($userID,$bookingID,$type);
        $clientID = $response['userID'];
        $barberID = $response['barberID'];
        $clientData = $this->Home_model->getBarberProfileDetailsForCustomer($clientID,$bookingID,$type);
        
        $barberData = $this->Home_model->getBarberProfileDetailsForCustomer($barberID,$bookingID,$type);
        
        $value = $this->Home_model->getBarberAndCustomerStatus($bookingID);
        
        $clientData['clientUpdateStatus'] =  $value['clientStatus'];
        $ratingClient = $this->Home_model->clientReviewListData($clientID);
        $clientData['overallRating'] =  $this->overllRating($ratingClient);
        $clientDataRes = $clientData;
        
        $barberData['barberUpdateStatus'] =  $value['barberstatus'];
        $ratingBarber = $this->Home_model->barberReviewListData($barberID);

        $barberData['overallRating'] =  $this->overllRating($ratingBarber);
        $barberDataRes = $barberData;
        
        if($response){
            $data = array(
                'data'=> $response ? array("bookingDetail"=>$response,"clientDetail"=>$clientDataRes,"barberDetail"=>$barberData) : NULL,
                'success'=> 1,
                'message'=> "Booking Detail found"
            );
        }else{
            $data = array('success'=> 0,'message'=>'Data not found');
        }
        echo json_encode($data);
    }
    
    public function barberAcceptBooking(){
        $token = $_POST['token'];
        $userDetail = $this->decodeToken($token);
        $barberID = $userDetail['id'];
        $bookingID = $_POST['bookingID'];
        $barberName = $userDetail['firstName'].' '.$userDetail['lastName'];
        $deviceType = $userDetail['deviceType'];
        $ifAlreadyAccept = $this->Home_model->ifAlreadyAccept($barberID);
        if($ifAlreadyAccept['status'] == 1){
            $data = array('success'=> 2,'message'=>'You cannot accept multiple request at same time');
        }
        else{
            $alraedyCancel = $this->Home_model->ifAlreadyCancel($bookingID);
            if($alraedyCancel['status'] != 3){
                $response = $this->Home_model->barberAcceptBooking($barberID,$bookingID);
                if($response){
                    $clientRecord = $this->Home_model->getClientDetailByID($bookingID);
                    $services = $this->Home_model->selectedServicesList($bookingID);
                    $servicesName = $this->Home_model->servicesTitleString($services);
                    //$title = 'Accept Booking';
                    //$message = $barberName.' has accepted your booking request';
                    $title = 'Request Accepted!';
                    $message = $barberName.' Has accepted your  ( '.$servicesName.' ) request.';
                    $type = 'barberAcceptBooking';
                    $FIREBASETOKEN = $clientRecord['deviceToken'];
                    $reciDeviceType = $clientRecord['deviceType'];
                    $success = $this->crossPlateform($title,$message,$type,$bookingID,$FIREBASETOKEN,$reciDeviceType);
                    /*if($deviceType == 'Android'){
                        $androidStatus  = $this->notificationAndroid($title,$message,$type,$bookingID,$FIREBASETOKEN);
                    }
                    if($deviceType == 'IOS'){
                        $iosStatus  = $this->notificationIOS($title,$message,$type,$bookingID,$FIREBASETOKEN);
                    }*/
                    $data = array(
                        'data'=> $response,
                        'success'=> 1,
                        'message'=> "Accept booking successfully"
                    );
                }else{
                    $data = array('success'=> 0,'message'=>'Barber offline so you can not accept booking');
                }
            }else{
                    $data = array('success'=> 3,'message'=>'Booking already cancelled by client');
            }   
        }
        echo json_encode($data);    
    }
    
    public function news()
    {
        return $this->Home_model->checkExistTimeSlotByBarberID();
    }
    /*
    Note: cancel booking automatically withing 15 minutes by cron jobs
    */
    public function cancelBookingByCronJobs(){
        $this->Home_model->cancelBookingByCronJobs();
    }
    
    public function updateLatAndLongOfBarber(){
        if($_POST['token'] == ""){
             $data = array(
                  'success' => 0,
                  'message'   =>  'Please add token'
              );
        }
        else {
            $token = $_POST['token'];
            $userDetail = $this->decodeToken($token);
            $barberID = $userDetail['id'];
            $response = $this->Home_model->updateLatAndLongOfBarber($barberID);
            if($response){
                $data = array(
                    'data'=> $response,
                    'success'=> 1,
                    'message'=> "Location updated successfully"
                );
            }else{
                $data = array('success'=> 0,'message'=>'somthing went wrong');
            }
        }
        echo json_encode($data);
    }
      public function updateArrivedStatusByBarber(){
        if($_POST['token'] == ""){
             $data = array(
                  'success' => 0,
                  'message'   =>  'Please add token'
              );
        }
        else {
            $token = $_POST['token'];
            $userDetail = $this->decodeToken($token);
            $barberID = $userDetail['id'];
            $response = $this->Home_model->updateLatAndLongOfBarber($barberID);
            if($response){
                $data = array(
                    'data'=> $response,
                    'success'=> 1,
                    'message'=> "Location updated successfully"
                );
            }else{
                $data = array('success'=> 0,'message'=>'somthing went wrong');
            }
        }
        echo json_encode($data);
    }
    
    public function getcancelReason(){
        if($_POST['token'] == ""){
             $data = array(
                  'success' => 0,
                  'message'   =>  'Please add token'
              );
        }
        else {
            $token = $_POST['token'];
            $userDetail = $this->decodeToken($token);
            $userID = $userDetail['id'];
            $userType = $userDetail['userRole'];
            //$type = $_POST['type'];
            $response = $this->Home_model->getcancelReason($userType);
            if($response){
                $data = array(
                    'data'=> $response,
                    'success'=> 1,
                    'message'=> "Reasons List found"
                );
            }else{
                $data = array('success'=> 0,'message'=>'List not found');
            }
        }
        echo json_encode($data);
    }
    public function postCancelBookingWithReason(){
        if($_POST['token'] == ""){
             $data = array(
                  'success' => 0,
                  'message'   =>  'Please add token'
              );
        }
        else {
            $token = $_POST['token'];
            $userDetail = $this->decodeToken($token);
            $userID = $userDetail['id'];
            $userType = $userDetail['userRole'];
            //$type = $_POST['type'];
            $bookingID  = $_POST['bookingID'];
            $name = $userDetail['firstName'].' '.$userDetail['lastName'];
            $deviceType = $userDetail['deviceType'];
            $response = $this->Home_model->postCancelBookingWithReason($userID,$userType);
            if($response){
                if($userType == 2){
                    if($response['success'] == 1){
                        $clientRecord = $this->Home_model->getClientDetailByID($bookingID);
                        //$title = 'ECUTZ Pro has Cancelled Booking';
                        //$message = $name.' has cancelled booking request';
                        $title = 'Request Cancelled';
                        $message = $name.' Has cancelled your request.';
                        $type = 'cancelBooking';
                        $FIREBASETOKEN = $clientRecord['deviceToken'];
                        $reciDeviceType = $clientRecord['deviceType'];
                        $success = $this->crossPlateform($title,$message,$type,$bookingID,$FIREBASETOKEN,$reciDeviceType);
                        /*if($deviceType == 'Android'){
                            $androidStatus  = $this->notificationAndroid($title,$message,$type,$bookingID,$FIREBASETOKEN);
                        }
                        if($deviceType == 'IOS'){
                            $iosStatus  = $this->notificationIOS($title,$message,$type,$bookingID,$FIREBASETOKEN);
                        }*/
                    }
                }
                else if($userType == 3){
                     if($response['success'] == 1){
                        $barberRecord = $this->Home_model->getBarberDetailByID($bookingID);
                        $services = $this->Home_model->selectedServicesList($bookingID);
                        $servicesName = $this->Home_model->servicesTitleString($services);
                        $title = 'Request Cancelled';
                        $message = $name.' Has cancelled their ( '.$servicesName.' ).';
                        $type = 'cancelBooking';
                        $FIREBASETOKEN = $barberRecord['deviceToken'];
                        $reciDeviceType = $barberRecord['deviceType'];
                        $success = $this->crossPlateform($title,$message,$type,$bookingID,$FIREBASETOKEN,$reciDeviceType);
                        /*if($deviceType == 'Android'){
                            $androidStatus  = $this->notificationAndroid($title,$message,$type,$bookingID,$FIREBASETOKEN);
                        }
                        if($deviceType == 'IOS'){
                            $iosStatus  = $this->notificationIOS($title,$message,$type,$bookingID,$FIREBASETOKEN);
                        }*/
                    }
                }
                $data = array(
                    'data'=> $response['data'],
                    'success'=> $response['success'],
                    'message'=> $response['message']
                );
            }else{
                $data = array('success'=> 0,'message'=>'List not found');
            }
        }
        echo json_encode($data);
    }
    /*
    postUpdateBarberStatus(token,bookingId,barberstatus)//update barberstatus under barberObject
     Response: success,message
    //Note : clientUpdateStatus(0 default,1 startjob,2 inRoute,3 confirmArrived,4 donepayment)
    */
    public function postUpdateBarberStatus(){
        if($_POST['token'] == ""){
             $data = array(
                  'success' => 0,
                  'message'   =>  'Please add token'
              );
        }
        else {
            $token = $_POST['token'];
            $userDetail = $this->decodeToken($token);
            $userID = $userDetail['id'];
            $bookingID  = $_POST['bookingID'];
            $deviceType = $userDetail['deviceType'];
            $barberStatus = $_POST['barberStatus'];
            $barberName = $userDetail['firstName'].' '.$userDetail['lastName'];
            $response = $this->Home_model->postUpdateBarberStatus($userID);
            if($response){
                if($response['success'] == 1){
                    $services = $this->Home_model->selectedServicesList($bookingID);
                    $servicesName = $this->Home_model->servicesTitleString($services);
                    $record = $this->Home_model->getClientDetailByID($bookingID);
                    if($barberStatus == 1){
                        //$title = 'ECUTZ Pro Has Started Job';
                        $title = 'In Route';
                        $type = 'BarberStartJob';
                        $message =  $barberName.' is in route to your location.';
                        $FIREBASETOKEN = $record['deviceToken'];
                        $reciDeviceType = $record['deviceType'];
                        $success = $this->crossPlateform($title,$message,$type,$bookingID,$FIREBASETOKEN,$reciDeviceType);
                        //$message = $barberName. ' has started requested '.$servicesName;
                    }
                    else if($barberStatus == 2){
                        //$title = 'ECUTZ Pro has Arrived';
                        $title = 'Arrived';
                        $type = 'BarberArrived';
                        $message = $barberName.' has arrived at your location';
                        $FIREBASETOKEN = $record['deviceToken'];
                        $reciDeviceType = $record['deviceType'];
                        $success = $this->crossPlateform($title,$message,$type,$bookingID,$FIREBASETOKEN,$reciDeviceType);
                        //$message = $barberName. ' has arrived at your location. Please confirm once you meet them.';
                    }
                }
                $data = array(
                    'status' => $response['status'],
                    'success'=> $response['success'],
                    'message'=> $response['message']
                );
            }else{
                $data = array('success'=> 0,'message'=>'somthing went wrong');
            } 
        }
       // return true;
        echo json_encode($data);
    }
    
    /*
    PostUpdateClientStatus(token,bookingId,barberstatus)//update clientStatus under client object
        Response: success,message
        //Note : barberUpdateStatus (0 default,1 Arrived, 2 Complete,3 requestPayment)
    
    */
    public function PostUpdateClientStatus(){
        if($_POST['token'] == ""){
             $data = array(
                  'success' => 0,
                  'message'   =>  'Please add token'
              );
        }
        else {
            $token = $_POST['token'];
            $userDetail = $this->decodeToken($token);
            $userID = $userDetail['id'];
            $deviceType = $userDetail['deviceType'];
            $clientName = $userDetail['firstName'].' '.$userDetail['lastName'];
            $bookingID  = $_POST['bookingID'];
            $clientStatus = $_POST['clientStatus'];
            $response = $this->Home_model->PostUpdateClientStatus($userID,$clientStatus,$bookingID);
            if($response){
                $barberRecord = $this->Home_model->getBarberDetailByID($bookingID);
                if($clientStatus == 1){
                   // $title = 'In Route';
                    //$message = $clientName.' is waiting for your arrival.';
                    $title = 'In Route';
                    $message = $clientName.' is waiting for your arrival.';
                    $type = 'inRoute';   
                }
                else if($clientStatus == 2){
                    $title = 'Confirm Arrival';
                    $message = $clientName.' has confirmed your arrival.';
                    $type = 'confirmArrival';   
                }
                $FIREBASETOKEN = $barberRecord['deviceToken'];
                $reciDeviceType = $barberRecord['deviceType'];
                $success = $this->crossPlateform($title,$message,$type,$bookingID,$FIREBASETOKEN,$reciDeviceType);
               /* if($deviceType == 'Android'){
                    $androidStatus  = $this->notificationAndroid($title,$message,$type,$bookingID,$FIREBASETOKEN);
                }
                if($deviceType == 'IOS'){
                    $iosStatus  = $this->notificationIOS($title,$message,$type,$bookingID,$FIREBASETOKEN);
                }*/
                $data = array(
                    'status' => $response['status'],
                    'success'=> $response['success'],
                    'message'=> $response['message']
                );
            }else{
                $data = array('success'=> 0,'message'=>'somthing went wrong');
            }
        }
        echo json_encode($data);
    }
    
    /*
    getBarberServicesList(token)
    Response: success,message,services arraylist)
    getBarberServicesListAccToBooking
    */
    
    public function getBarberServicesListAccToBooking(){
        if($_POST['token'] == ""){
             $data = array(
                  'success' => 0,
                  'message'   =>  'Please add token'
              );
        }
        else {
            $token = $_POST['token'];
            $userDetail = $this->decodeToken($token);
            $userID = $userDetail['id'];
            $bookingID = $_POST['bookingID'];
            $response = $this->Home_model->getBarberServicesList($userID,$bookingID);
            if($response){
                $data = array(
                    'services' => $response,
                    'success'=> 1,
                    'message'=> "Services List found"
                );
            }else{
                $data = array('success'=> 0,'message'=>'List not found');
            }
        }
        echo json_encode($data);
    }
    /*
    postPaymentRequestByBarber(bookingID,token,totalAmount,ServicesArray,barberstatus) 
    Response: success,message
    */
    public function postPaymentRequestByBarber(){
        if($_POST['token'] == ""){
             $data = array(
                  'success' => 0,
                  'message'   =>  'Please add token'
              );
        }
        else {
            $token = $_POST['token'];
            $userDetail = $this->decodeToken($token);
            $userID = $userDetail['id'];
            $barberStatus = $_POST['barberStatus'];
            $totalPayment = $_POST['totalAmount'];
            $barberName = $userDetail['firstName'].' '.$userDetail['lastName'];
            $deviceType = $userDetail['deviceType'];
            $bookingID = $_POST['bookingID'];
			$lat = $userDetail['latitude'];
			$long = $userDetail['longitude'];
			$response = $this->Home_model->postPaymentRequestByBarber($userID);
            if($response){
                $this->updateConnectAccount($userID,$lat,$long);
                if($response['success'] == 1){
                   // $this->updateConnectAccount($userID,$lat,$long);
                    if($barberStatus == 4){
                        //$title = 'Request For Payment';
                        $title = 'New Payment Request';
                        $type = 'BarberRequestForPayment';
                        $message = $barberName. ' Has sent you a payment request of ' .$this->data['amountSign'].number_format($totalPayment,2). ' Pay Now.';
                        //$message = $barberName. ' has generated payment receipt of ' .$this->data['amountSign'].number_format($totalPayment,2). ' Pay Now.';
                        $record = $this->Home_model->getClientDetailByID($bookingID);
                        $FIREBASETOKEN = $record['deviceToken'];
                        $reciDeviceType = $record['deviceType'];
                        $success = $this->crossPlateform($title,$message,$type,$bookingID,$FIREBASETOKEN,$reciDeviceType);
                       /* if($deviceType = 'Android'){
                            $success = $this->notificationAndroid($title,$message,$type,$bookingID,$FIREBASETOKEN);
                        }
                        if($deviceType = 'IOS'){
                            $success = $this->notificationIOS($title,$message,$type,$bookingID,$FIREBASETOKEN);
                        }*/
                    }
                }    
                $data = array(
                    //'services' => $response,
                    'success'=> $response['success'],
                    'message'=> $response['message'],
                );
            }else{
                $data = array('success'=> 0,'message'=>'something went wrong');
            }
        }
        echo json_encode($data);
    }
    /*
    getBookingPaymentDetail(token,bookingId)
    Response: success,message,totalAmount,Date,ServicesUsed(array object),CardDetail object.
    */
    public function getBookingPaymentDetail(){
        if($_POST['token'] == ""){
             $data = array(
                  'success' => 0,
                  'message'   =>  'Please add token'
              );
        }
        else {
            $token = $_POST['token'];
            $userDetail = $this->decodeToken($token);
            $userID = $userDetail['id'];
            $bookingID = $_POST['bookingID'];
            $response = $this->Home_model->getBookingPaymentDetail($userID,$bookingID);
            if($response){
                $carDetail = $this->Users_model->customerPaymentDetailByid($userID);
                unset($carDetail['status']);
                unset($carDetail['created_date']);
                $response['CardDetail'] = $carDetail;
                $data = array(
                    'data' => $response,
                    'success'=> 1,
                    'message'=> "Data found",
                );
            }else{
                $data = array('success'=> 0,'message'=>'Data not found');
            }
        }
        echo json_encode($data);
    }
    
    /*
    postUpdatePaymentbyClient(bookingID,totalAmount,totalTip,TotalamountDeduct,ClientStatus)
    Response: success,message
    */
    public  function generateToken($cardID)
    {
        $this->stripeCredenatils();
        $card = $this->Home_model->getClientCardDetailById($cardID);
        $split = explode("/",$card['expDate']);
        try{
        $stripetoken = \Stripe\Token::create([ 
                'card' => [
                    'number' => $card['cardNumber'],
                    'exp_month' => $split[0],
                    'exp_year' =>  $split[1],
                    'cvc' =>  $card['cvv']
                ]
            ]);
            $response = array("success"=>1,"token"=>$stripetoken->id);
        }
        catch (Exception $e) {
            
            $messages=$e->getError()->message;
            $response = array("success"=>0,"message"=>$messages);
        }
        return $response;
    }
    public function successPayment($token,$totalPayment,$barberID,$bookingID)
    {   
        $this->stripeCredenatils();
        $stirpAccountID = $this->Users_model->getBarberStripeAccountID($barberID);
        try{
            $payment =  \Stripe\Charge::create ([
                "amount" => $totalPayment*100,
                "currency" => $this->data['currency'],
                "source" => $token,
                "description" => "Payment for services" 
            ]);
        $response = array(
            "success"=>1,
            "paymentSuccessID"=>$payment['id'],
            "balanceTransaction"=>$payment['balance_transaction'],
            "captured"=>$payment['captured']
            );
           $stirpAccountID = $this->Users_model->getBarberStripeAccountID($barberID);
           if($stirpAccountID['accountID']){
                $percent = $this->Home_model->getPlanPercentByid($barberID);
                $value = $this->Home_model->getBookingPaymentDetail('',$bookingID);
                $fee = $percent['adminPercent'];
                $t = $value['totalAmount'] + $value['totalTax'];
                $new_fee = ($fee / 100) * $totalPayment ;
                $barberAmount = $totalPayment - $new_fee;
                if($new_fee == 0) {
                    $this->transferAmountToBarberAccount($stirpAccountID['accountID'],$barberAmount*100,$payment['id'],'premium');
                }
                else{
                    $this->transferAmountToBarberAccount($stirpAccountID['accountID'],$barberAmount*100,$payment['id'],'other');
                }    
            }
        }
        catch (Exception $e) {
            
            $messages=$e->getError()->message;
            $response = array("success"=>0,"message"=>$messages);
        }
        return $response;
    }
    public function postUpdatePaymentbyClient(){
        if($_POST['token'] == ""){
             $data = array(
                  'success' => 0,
                  'message'   =>  'Please add token'
              );
        }
        else {
            $token = $_POST['token'];
            $userDetail = $this->decodeToken($token);
            $userID = $userDetail['id'];
            $cardID = $_POST['cardID'];
            $bookingID = $_POST['bookingID'];
            $clientName = $userDetail['firstName'].' '.$userDetail['lastName'];
            $totalPayment = $_POST['TotalamountDeduct'];
            $CardToken = $this->generateToken($cardID);
             $deviceType = $userDetail['deviceType'];
            if($CardToken['success'] == 1){
                $cardToken =  $CardToken['token'];
                $barberRecord = $this->Home_model->getBarberDetailByID($bookingID);
                $barberID = $barberRecord['barberID'];
                $payment = $this->successPayment($cardToken,$totalPayment,$barberID,$bookingID);
                if($payment['success'] == 1){
                    $paymentSuccessID = $payment['paymentSuccessID'];
                    $balanceTransaction = $payment['balanceTransaction'];
                    $response = $this->Home_model->postUpdatePaymentbyClient($userID,$cardID,$paymentSuccessID,$balanceTransaction);
                    if($response){
                        if($response['success'] == 1){
                            $type = 'completeBooking';
                           // $title = 'Complete Booking';
                            $title = 'You Received A Payment!';
                            
                            $message = 'Congratulations! You have received a payment of '.$this->data['amountSign'].number_format($totalPayment,2).' from '.$clientName;
                            //$message = $clientName.' has paid '.$this->data['amountSign'].number_format($totalPayment,2);
                            $FIREBASETOKEN = $barberRecord['deviceToken'];
                            $reciDeviceType = $barberRecord['deviceType'];
                            $success = $this->crossPlateform($title,$message,$type,$bookingID,$FIREBASETOKEN,$reciDeviceType);
                            if($success == 1){
                                $this->Home_model->addNotification($barberID,0,$bookingID,$type,$title,$message);
                            }
                            $title1 = 'You Sent A Payment!';
                            $barberName = $barberRecord['firstName'].' '.$barberRecord['lastName'];
                            $clientMessage = 'Congratulations! You sent a payment of '.$this->data['amountSign'].number_format($totalPayment,2).' to '.$barberName;
                            $FIREBASETOKEN1 = $userDetail['deviceToken'];
                            
                            $success1 = $this->crossPlateform($title1,$clientMessage,$type,$bookingID,$FIREBASETOKEN1,$deviceType);
                            if($success1 == 1){
                                $this->Home_model->addNotification(0,$userID,$bookingID,$type,$title1,$clientMessage);
                            }
                        }
                        $data = array(
                            'success'=> $response['success'],
                            'message'=> $response['message'],
                        );
                    }else{
                        $data = array('success'=> 0,'message'=>'payment not updated in database');
                    }
                }
                else{
                    $data = array(
                        'success'=> 0,
                        'message'=> $payment['message'],
                    );
                }
            }
            else{
                 $data = array(
                    'success'=> 0,
                    'message'=> $CardToken['message'],
                );
            }
        }
        echo json_encode($data);
    }
    
    public function postClientRatingToBarber(){
        if($_POST['token'] == ""){
            $data = array(
                'success' => 0,
                'message'   =>  'Please add token'
            );
        }
        else {
            $token = $_POST['token'];
            $userDetail = $this->decodeToken($token);
            $userID = $userDetail['id'];
            $clientName = $userDetail['firstName'].' '.$userDetail['lastName'];
            $barberID = $_POST['barberID'];
            $response = $this->Home_model->postClientRatingToBarber($userID,$barberID);
            if($response){
                 if($response['success'] == 1){
                    $barberRecord = $this->Users_model->userDetailByid($barberID);
                    $type = 'BarberRating';
                    $title = 'You Received A New Review!';
                    $barberID = $barberRecord['id'];
                    $message = 'Congratulations! You have received a new review from '.$clientName ;
                    $FIREBASETOKEN = $barberRecord['deviceToken'];
                    $reciDeviceType = $barberRecord['deviceType'];
                    $success = $this->crossPlateform($title,$message,$type,$bookingID,$FIREBASETOKEN,$reciDeviceType);
                }
                $data = array(
                    'data'=> $response['data'],
                    'success'=> $response['success'],
                    'message'=> $response['message']
                );
            }else{
                $data = array('success'=> 0,'message'=>'Rating not added successfully');
            }
        }
        echo json_encode($data);
    }
    public function postBarberRatingToClient(){
        if($_POST['token'] == ""){
            $data = array(
                'success' => 0,
                'message'   =>  'Please add token'
            );
        }
        else {
            $token = $_POST['token'];
            $userDetail = $this->decodeToken($token);
            $userID = $userDetail['id'];
            $barberName = $userDetail['firstName'].' '.$userDetail['lastName'];
            $clientID = $_POST['clientID'];
            $response = $this->Home_model->postBarberRatingToClient($userID,$clientID);
            if($response){
                if($response['success'] == 1){
                    $clientRecord = $this->Users_model->userDetailByid($clientID);
                    $type = 'ClientRating';
                    $title = 'You Received A New Rating!';
                    $barberID = $clientRecord['id'];
                    $message = 'Congratulations! You have received a new rating from '.$barberName ;
                    $FIREBASETOKEN = $clientRecord['deviceToken'];
                    $reciDeviceType = $clientRecord['deviceType'];
                    $success = $this->crossPlateform($title,$message,$type,$bookingID,$FIREBASETOKEN,$reciDeviceType);
                }
                $data = array(
                    'data'=> $response['data'],
                    'success'=> $response['success'],
                    'message'=> $response['message']
                );
            }else{
                $data = array('success'=> 0,'message'=>'Rating not added successfully');
            }
        }
        echo json_encode($data);
    }
    public function getCompleteBookingDetail (){
         $token = $_POST['token'];
        $userDetail = $this->decodeToken($token);
        $userID = $userDetail['id'];
        $bookingID = $_POST['bookingID'];
        $type = $userDetail['userRole'];
        $response = $this->Home_model->getCompleteBookingDetail($userID,$bookingID,$type);
        $clientID = $response['userID'];
        $barberID = $response['barberID'];
        $clientData = $this->Home_model->getBarberProfileDetailsForCustomer($clientID,$bookingID,$type);
        
        $barberData = $this->Home_model->getBarberProfileDetailsForCustomer($barberID,$bookingID,$type);
        
        $value = $this->Home_model->getBarberAndCustomerStatus($bookingID);
        
        $clientData['clientUpdateStatus'] =  $value['clientStatus'];
        $clientDataRes = $clientData;
        $barberData['barberUpdateStatus'] =  $value['barberstatus'];
        $barberDataRes = $barberData;
        
        if($response){
            $data = array(
                'data'=> $response ? array("bookingDetail"=>$response,"clientDetail"=>$clientDataRes,"barberDetail"=>$barberData) : "",
                'success'=> 1,
                'message'=> "Booking Detail found"
            );
        }else{
            $data = array('success'=> 0,'message'=>'Data not found');
        }
        echo json_encode($data);
        
    }
    
    public function  getBarberScheduledBookings(){
        if($_POST['token'] == ""){
            $data = array(
                'success' => 0,
                'message'   =>  'Please add token'
            );
        }
        else {
            $token = $_POST['token'];
            $userDetail = $this->decodeToken($token);
            $userID = $userDetail['id'];
            $response = $this->Home_model->getBarberScheduledBookings($userID);
            if($response){
                $data = array(
                    'data'=> $response,
                    'success'=> 1,
                    'message'=> "Services list found"
                );
            }else{
                $data = array('success'=> 0,'message'=>'List not found');
            }
        }
        echo json_encode($data);
    }
    
    public function  postBarberScheduledBookingStatus(){
        if($_POST['token'] == ""){
             $data = array(
                  'success' => 0,
                  'message'   =>  'Please add token'
              );
        }
        else {
            $token = $_POST['token'];
            $userDetail = $this->decodeToken($token);
            $userID = $userDetail['id'];
            $userType = $userDetail['userRole'];
            $bookingID  = $_POST['bookingID'];
            $isApproved = $_POST['isApproved'];
            $deviceType  = $userDetail['deviceType'];
            $barberName = $userDetail['firstName'].' '.$userDetail['lastName'];
            //$type = $_POST['type'];
            $ifAlreadyAccept = $this->Home_model->ifAlreadyAccept($userID);
            if($ifAlreadyAccept['status'] == 1 && $isApproved == 1){
                $data = array('success'=> 0,'message'=>'You cannot accept multiple request at same time');
            }
            else{
                $response = $this->Home_model->postBarberScheduledBooking($userID,$bookingID,$isApproved);
                if($response){
                    if($response['success'] == 1){ 
                        $clientRecord = $this->Home_model->getClientDetailByID($bookingID);
                        $clientID = $clientRecord['userID'];
                        $appoinmentDate = $clientRecord['appointmentDate'];  
        				$createDate = new DateTime($appoinmentDate);
        				$ADate = $createDate->format('m/d/Y');
                        $slotID = $clientRecord['selectedTimeID'];
                        $slot = $this->Home_model->getSlotByID($slotID); 
                        if($isApproved == 1){
                            $type = 'barberAcceptScheduledBooking';
                            $title = 'Your Appointment is Confirmed';
                            $message = $barberName.'  Has confirmed your scheduled appointment for '.$ADate.' at '.$slot['startSlot'];
                        }
                        else if($isApproved == 0){
                            $type = 'barberRejectScheduledBooking';
                            $title = 'Appointment Cancelled';
                            $message = $barberName.' Has cancelled your appointment for '.$ADate.' at '.$slot['startSlot'];
                        }
                        $FIREBASETOKEN = $clientRecord['deviceToken'];
                        $reciDeviceType = $clientRecord['deviceType'];
                        $success = $this->crossPlateform($title,$message,$type,$bookingID,$FIREBASETOKEN,$reciDeviceType);
                        if($success == 1 && $isApproved == 0){
                            $this->Home_model->addNotification(0,$clientID,$bookingID,$type,$title,$message);
                        }
                    }
                    $data = array(
                        'success'=> $response['success'],
                        'message'=> $response['message']
                    );
                }else{
                    $data = array('success'=> 0,'message'=>'something went wrong');
                }
            }
        }
        echo json_encode($data);
    }
    
    /*
    getAllCompleteBookingHistory
    bookingID,Date,TotalAmount,ServicesTitle
    */
    public function  getAllCompleteBookingHistory(){
       if($_POST['token'] == ""){
             $data = array(
                  'success' => 0,
                  'message'   =>  'Please add token'
              );
        }
        else {
            $token = $_POST['token'];
            $userDetail = $this->decodeToken($token);
            $userID = $userDetail['id'];
            $response = $this->Home_model->getAllCompleteBookingHistory($userID);
            if($response){
                $data = array(
                    'data'=> $response,
                    'success'=> 1,
                    'message'=> "List of complete bookings"
                );
            }else{
                $data = array('success'=> 0,'message'=>'List not found');
            }
        }
        echo json_encode($data);
    }
    
    
    
     /*
    getTodayCompleteBookingHistory
    bookingID,Date,TotalAmount,ServicesTitle

    */
    public function  getTodayCompleteBookingHistory(){
       if($_POST['token'] == ""){
             $data = array(
                  'success' => 0,
                  'message'   =>  'Please add token'
              );
        }
        else {
            $token = $_POST['token'];
            $userDetail = $this->decodeToken($token);
            $userID = $userDetail['id'];
             $currentDate = date('Y-m-d');
            $response = $this->Home_model->getTodayCompleteBookingHistory($userID,$currentDate);
            if($response){
                $data = array(
                    'data'=> $response,
                    'success'=> 1,
                    'message'=> "Today booking"
                );
            }else{
                $data = array('success'=> 0,'message'=>'List not found');
            }
        }
        echo json_encode($data);
    }
    
    //(Rating/ Cancellation / Acceptance / TodayEarning)
    
    public function GetAverageData (){
         if($_POST['token'] == ""){
             $data = array(
                  'success' => 0,
                  'message'   =>  'Please add token'
              );
        }
        else {
            $token = $_POST['token'];
            $deviceToken = $_POST['deviceToken'];
            $userDetail = $this->decodeToken($token);
            $userID = $userDetail['id'];
            $userType = $userDetail['userRole'];
            $response = $this->Home_model->GetAverageData($userID,$userType,$deviceToken);

            if($response){
                $data = array(
                    'data'=> $response,
                    'success'=> 1,
                    'message'=> "Total records"
                );
            }else{
                $data = array('success'=> 0,'message'=>'data not found');
            }
        }
        echo json_encode($data);
    }
    
    public function getTodayBookingEarningsHistory(){
        if($_POST['token'] == ""){
            $data = array(
                'success' => 0,
                'message'   =>  'Please add token'
            );
        }
        else {
            $token = $_POST['token'];
            $userDetail = $this->decodeToken($token);
            $userID = $userDetail['id'];
            $currentDate = date('Y-m-d');
            $response = $this->Home_model->getTodayBookingEarningsHistory($userID,$currentDate);

            if($response){
                $data = array(
                    'data'=> $response,
                    'success'=> 1,
                    'message'=> "Total records"
                );
            }else{
                $data = array('success'=> 0,'message'=>'data not found');
            }
        }
        echo json_encode($data);    
    }
    
     public function getWeeklyBookingEarningsHistory(){
        if($_POST['token'] == ""){
            $data = array(
                'success' => 0,
                'message'   =>  'Please add token'
            );
        }
        else {
            $token = $_POST['token'];
            $userDetail = $this->decodeToken($token);
            $userID = $userDetail['id'];
            $response = $this->Home_model->getWeeklyBookingEarningsHistory($userID);

            if($response){
                $data = array(
                    'data'=> $response,
                    'success'=> 1,
                    'message'=> "Total records"
                );
            }else{
                $data = array('success'=> 0,'message'=>'data not found');
            }
        }
        echo json_encode($data);    
    }
    /*
    NotificationID
    NotificationType
    NotificationTitle
    NotificationDescription
    NotificationDate
    NotificationBookingID(if notification reslated to booking)
    */
    public function getNotificationData(){
       if($_POST['token'] == ""){
        $data = array(
            'success' => 0,
            'message'   =>  'Please add token'
        );
        }
        else {
            $token = $_POST['token'];
            $userDetail = $this->decodeToken($token);
            $userID = $userDetail['id'];
            $userType = $userDetail['userRole'];
            $response = $this->Home_model->getNotificationData($userID,$userType);

            if($response){
                $data = array(
                    'data'=> $response,
                    'success'=> 1,
                    'message'=> "Notification list Found"
                );
            }else{
                $data = array('success'=> 0,'message'=>'data not found');
            }
        }
        echo json_encode($data);  
    }
    public function getPage(){
        $type = $_POST['pageType'];
        $response = $this->Home_model->getPage($type);
        if($response){
            $data = array(
                'data'=> $response,
                'success'=> 1,
                'message'=> "Data Found"
            );
        }else{
            $data = array('success'=> 0,'message'=>'data not found');
        }
        echo json_encode($data);  
    }
    public function postChatMessage(){
       if($_POST['token'] == ""){
        $data = array(
            'success' => 0,
            'message'   =>  'Please add token'
        );
        }
        else {
            $token = $_POST['token'];
            $userDetail = $this->decodeToken($token);
            $userID = $userDetail['id'];
            $userType = $userDetail['userRole'];
            $bookingID = $_POST['bookingID'];
            $deviceType = $userDetail['deviceType'];
            $receiverID = $_POST['receiverID'];
            $ifCancel = $this->Home_model->ifAlreadyCancel($bookingID);
            if($ifCancel['status'] == 3){
                $data = array('data'=> NULL,'success'=> 1,'message'=>'You can not send message becuase booking is cancelled');
            }
            else{
                $response1 = $this->Home_model->postMessagesforBooking($userID,$userType,$receiverID,$bookingID);
                if($response1){
                    if($userType == 2){
                        $record = $this->Home_model->getClientDetailByID($bookingID);
                        $barberName = $userDetail['firstName'].' '.$userDetail['lastName'];
                        $clientID = $receiverID;
                        $FIREBASETOKEN = $record['deviceToken'];
                        $title = 'New Message From '.$barberName;
                        $type = 'sendMessage';
                        $message = 'You have received a message reply now.';
                        //$message = $barberName. ' has send message to you';
                        $reciDeviceType = $record['deviceType'];
                        $success = $this->crossPlateform($title,$message,$type,$bookingID,$FIREBASETOKEN,$reciDeviceType);
                    }
                    if($userType == 3){
                        //$title = 'New Message From'.;
                        $clientName = $userDetail['firstName'].' '.$userDetail['lastName'];
                        $barerRecord = $this->Home_model->getBarberDetailByID($bookingID);
                        $title = 'New Message From '.$clientName;
                        $FIREBASETOKEN = $barerRecord['deviceToken'];
                        $type = 'sendMessage';
                        $message = 'You have received a message reply now.';
                        $barberID = $receiverID;
                        $reciDeviceType = $barerRecord['deviceType'];
                        $success = $this->crossPlateform($title,$message,$type,$bookingID,$FIREBASETOKEN,$reciDeviceType);
                    }
                    
                    $data = array(
                    'data' => $response1,
                    'success'=> 1,
                    'message'=> "Message added successfully"
                    );    
                } 
                else{
                    $data = array('success'=> 0,'message'=>'Message not added successfully');
                }
            }    
        }
        echo json_encode($data); 
    }
    public function getChatCoversation(){
        $bookingID = $_POST['bookingID'];
        if($_POST['bookingID'] == ""){
        $data = array(
            'success' => 0,
            'message'   =>  'Please add booking ID'
        );
        }
        else {
            $response = $this->Home_model->getChatCoversation($bookingID);
            if($response){
                $response1 = $this->Home_model->allgetChatCoversation($bookingID);
                $totalCount =  count($response1);
                $halfCount =  count($response);
                $data = array(
                    'data'=> $response,
                    'NoMoreRecords' => $totalCount == $halfCount ? true : false, 
                    'success'=> 1,
                    'message'=> "List found"
                );
            }else{
                $data = array('success'=> 0,'message'=>'List not found');
            }
        }
        echo json_encode($data);  
    }
	public function UpdateArrayOfStripeAccount($lat,$long,$dob,$ssn){
	   // $data = $this->getAddressOfBarber($lat,$long);
	    $dobData  = explode("-",$dob);
	    $ssnData  = explode("-",$ssn);
		$array  = ["individual" => [
                "id_number" => "98745".$ssnData['2'],
                "ssn_last_4" => $ssnData['2'],
                /*"address" => [
                    "city" => $data['city'],
                    "country"=> $data['country'],
                    "line1"=> $data['street'],
                    "line2"=> null,
                    "postal_code"=> $data['postalCode'],
                    "state"=> $data['state']
                ],
                */
                /*"address" => [
                    "city" => "Peoria",
                    "country"=> "US",
                    "line1"=> "11883 West Morning Vista Drive",
                    "line2"=> null,
                    "postal_code"=> "85383",
                    "state"=> "AZ"
                ],*/
                'dob' => [
                    'day' => $dobData['2'],
                    'month' => $dobData['1'],
                    'year' => $dobData['0'],
                ],
            ],
		];	
		return $array;
	}
	 
	public function updateConnectAccount($userID,$lat,$long){
		$this->stripeCredenatils();
	    $stirpAccountID = $this->Users_model->getBarberStripeAccountID($userID);
		$accountID = $stirpAccountID['accountID'];
		if($accountID){
		$candidateDetails = $this->getCandidateInfo($userID);
		$dob = $candidateDetails->dob ? $candidateDetails->dob : '1991-02-19';
		$ssn = $candidateDetails->ssn ? $candidateDetails->ssn : '987-45-2001';
		$array =  $this->UpdateArrayOfStripeAccount($lat,$long,$dob,$ssn);
		$Account=\Stripe\Account::update($accountID,$array);
		}
    }
    public function test(){
      //  $stirpAccountID = $this->Users_model->getBarberStripeAccountID(55);
        //if($stirpAccountID['accountID']){
            $totalPayment = 194.50;
            $percent = $this->Home_model->getPlanPercentByid(15);
           // $value = $this->Home_model->getBookingPaymentDetail('',133);
           // $value['totalAmount'];
            //$value['totalTax'];
             $fee = $percent['adminPercent'];
             //$t = $value['totalAmount'] + $value['totalTax'];
             echo $new_fee = ('5%' / 100) * $totalPayment ;
            echo  $barberAmount = $totalPayment - $new_fee;
           // $tesAccount =  1;
          // $balance = $this->retriveBalance();
           
        
           // $tet = $this->transferAmountToBarberAccount('acct_1HH53kLuGRaTt91k',$tesAccount,'ch_1HJZXsFrs9rrnFwzU0UhYqoX','premium');
            print_r($tet);
    // }
        //$tet = $this->transferAmountToBarberAccount($stirpAccountID,$amount,'ch_1HJYq2Frs9rrnFwzfmU9OUxf');
    }
	public function transferAmountToBarberAccount($stirpAccountID,$amount,$chargeID,$type){
		$this->stripeCredenatils();
		if($type == 'premium'){
		    $new_fee = ('5%' / 100) * $amount1 ;
            $barberAmount = $amount - $new_fee * 100;
		    //$balance = $this->retriveBalance();
		    //if($balance > $amount){
		    	$transfer = \Stripe\Transfer::create([
			    'amount' => $barberAmount,
			    'currency' => $this->data['currency'],
			    'source_transaction' => $chargeID,
			    'destination' => $stirpAccountID,
		    ]);
		    //}
		}
		else{
		    $transfer = \Stripe\Transfer::create([
			    'amount' => $amount,
			    'currency' => $this->data['currency'],
			    'source_transaction' => $chargeID,
			    'destination' => $stirpAccountID,
		    ]);
		}
	}
	public function getCandidateInfo($userID){
		$candidateID = $this->Users_model->getBarberCandidateAccountID($userID);
		$url = $this->config->item('checkrCandidateURL').'/'.$candidateID['candidateID'];
		$data = $this->Home_model->CURL($url,'');
		return $data;
	}
	public function getAddressOfBarber($lat,$long){
	    $data = $this->Home_model->getAddressOfBarberByLatAndLongAPI($lat,$long);
	    $street = $data[0] ? $data[0] : "11883";
	    $route = $data[1] ? $data[1] : "West Morning Vista Drive";
	    $city  = $data[2] ? $data[2] : "Brooklyn";
	    $state = $data[3] ? $data[3] : "AZ";
	    $country = $data[4] ? $data[4] : "US";
	    $postalCode = $data[5] ? $data[5] : "85383";
	    $array =  array("street"=>$street.' '.$route,"city"=>$city,"state"=>$state,"country"=>$country,"postalCode"=>$postalCode);
	    return $array;
	}
	public function retriveBalance(){
	    $this->stripeCredenatils();
	    $balance = \Stripe\Balance::retrieve();
	    $amount = $balance['available'][0]->amount;
	    return $amount;
	}
}
?>