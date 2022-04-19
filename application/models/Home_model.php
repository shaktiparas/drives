<?php
class Home_model extends CI_model{
    
    public function __construct() {
        parent::__construct();
          $this->data = array(
            'geocodeURL' => $this->config->item('geocode_url'),
            'key' =>  $this->config->item('api_key'),
            'imagePath' => '/uploads/barberRatingImages/',
            'amountSign' => '$'
        );
    } 
   /*Start getOderAddressByLatAndLongAPI*/
         /*public function getOderAddressByLatAndLongAPI(){
             $geocode =   $this->data['geocodeURL'];
             $key =   $this->data['key'];
             $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=8.059230,7.981400&key=AIzaSyBiXr8kaCmndp8J7y8s2IsOedod9ZzOJnw";//$geocode.$lat.','.$long.'&key='.$key;
             $json = @file_get_contents($url);
             $data=json_decode($json);
                                       print_r($data);
            echo $status = $data->status;
             $result = $data->results[0];
             if($status=="OK")
             {     
                 echo "dsd";
                return $result;
             }
             else {
                 echo "nop";
             }
         }*/
    /*End*/
    /*Start contactUs API*/  
    public function contactUs($userId,$type,$email,$subject,$message){
        $data = array(
            'userID' => $userId,
            'email' => $email,
            'subject' =>$subject,
            'message' => $message,
            'userRole' => $type
        );
        $this->db->insert('tbl_contactUs',$data);
        $id = $this->db->insert_id();
        $data = $this->contactUsById($id);
        return $data;
    }
    public function contactUsById($id){
        $this->db->select('email,subject,message');
        $this->db->where('id',$id);
        $query = $this->db->get('tbl_contactUs');
        $data = $query->row_array();
        return $data;
    }
    /*End contactUs API*/
    
    /*Start barberReviewList API*/  
    public function barberReviewListData($barberID){
        $this->db->select('rating.*');
        $this->db->from('tbl_customerRatingToBarber as rating');
        $this->db->where('rating.barberID',$barberID);
        $this->db->where('rating.status',1);
        $this->db->order_by('rating.created_date','desc');
        $query = $this->db->get();
       // echo $this->db->last_query();
        $data = $query->result_array();
        foreach($data as $value)
		{
			$reviewID = $value['id'];
			$imagesData = $this->getCustomerRatingImages($reviewID);
		    if($imagesData){
		        $value['images'] = $imagesData;
		    }
 			$response[]=$value;
		}
        return $response;
    }
     public function clientReviewListData($clientID){
        $this->db->select('rating.*');
        $this->db->from('tbl_barberRatingToCustomer as rating');
        $this->db->where('rating.clientID',$clientID);
        $this->db->where('rating.status',1);
        $query = $this->db->get();
       // echo $this->db->last_query();
        $response = $query->result_array();
        return $response;
    }
    public function barberReviewListImages($id){
        $this->db->select('images.images');
        $this->db->from('tbl_barberReviewImages as images');
        $this->db->where('images.reviewID',$id);
        $query = $this->db->get();
        $data = $query->result_array();
        $images[] = $data['images'];
        return $images;
    }
    /*End barberReviewList API*/
    /*Start barberReviewListImages API*/  
  /*  public function barberReviewList($barberID){
        $this->db->select('*');
        $this->db->where('barberID',$barberID);
        $this->db->where('status',1);
       // $this->db->group_by('tbl_customerRatingToBarber.userID');
        $query = $this->db->get('tbl_customerRatingToBarber');
        $data = $query->result();
        return $data;
    } */
   
    /*public function getBarberAvaialbleSlotByDate($userID,$date){
        $this->db->select('t.id as timeId,t.title,t.startDate,t.endDate');
        $this->db->where('userID',$userID);
        $this->db->where('startDate',$date);
        $this->db->order_by('id','DESC');
        $this->db->from('tbl_barberTimeSlot as t');
        $query = $this->db->get();
        $data = $query->result_array();
        foreach($data as $value){
            $timeId = $value['timeId'];
            $slotData = $this->slotListById($timeId);
            foreach($slotData as $slotVal){
                $slotId = $slotVal['slotId'];
               $checkSlot = $this->isAlreadySelectedTime($userID,$slotId);
               if($checkSlot['selectedTimeID'] != $slotId){
                   $slotWithoutSelected[] = $slotVal;
               } 
            }
            $value['slots'] = $slotWithoutSelected;
            $response[] = $value;

           // print_r($test);
        }
        /*foreach(){
            
        }*/
        //return $response;
        /*$this->db->select('id,title,startTime,endTime,date');
        $this->db->where('userID',$userID);
        $this->db->where('date',$date);
        $this->db->order_by('id','DESC');
        $query = $this->db->get('tbl_barberTimeSlot');
        $data = $query->result_array();
        return $data;
    }*/
    public function isAlreadySelectedTime($userID,$slotId){
        $sql = "SELECT selectedTimeID FROM tbl_request_bookings WHERE barberID = '$userID' AND selectedTimeID = '$slotId' AND
        (status = 1 OR status = 0) AND requestType = 'Scheduled'";
      //$this->db->select('');
       // $this->db->where('',);
        ///$this->db->where('',);
        //$this->db->where('status','1');
        //$this->db->or_where('status','0');
       /// $this->db->where('()');
        //$this->db->where('','Scheduled');
    //    $this->db->from('tbl_request_bookings');
      //  $query = $this->db->get();
       // echo $this->db->last_query();
        //$data = $query->row_array();
        $data = $this->db->query($sql)->row_array();
        //$query->row_array();
        return $data;
    }
    public function getBarberAvaialbleSlotByDate($userID,$date){
        $this->db->select('t.title,d.date_id,d.date,TRIM(LEADING 0 FROM TRIM(s.startSlot)) as startSlot,TRIM(LEADING 0 FROM TRIM(s.endSlot)) as endSlot,s.id  as slot_id');
        $this->db->where('d.userID',$userID);
        $this->db->where('d.date',$date);
        $this->db->from('tbl_date as d');
        $this->db->join('tbl_barberTimeSlot as t','d.dateTimeId = t.id','left');
        $this->db->join('tbl_slot as s','s.timeSlotID = d.date_id','left');
        $query = $this->db->get();
        //echo  $this->db->last_query();
        $data = $query->result_array();
        foreach($data as $value){
            $dateId = $value['date_id'];
           /* $slotData = $this->slotListById($dateId);
            foreach($slotData as $slotVal){
                $slotId = $slotVal['slotId'];*/
               $slotId =  $value['slot_id'];
               $checkSlot = $this->isAlreadySelectedTime($userID,$slotId);
               if($checkSlot['selectedTimeID'] != $slotId){
                   $response[] = $value;
                  // $slotWithoutSelected[] = $slotVal;
               }
          //  }
            /*if($slotWithoutSelected) {
                 $value['slots'] = $slotWithoutSelected;
            } */
            //$response[] = $value;

           // print_r($test);
        }
        return $response;
    }
    public function getBarberAvaialbleSlotForClient($barberID,$date){
        $data  = $this->getBarberAvaialbleSlotByDate($barberID,$date);
        return $data;
        /*$this->db->select('id,title,startTime,endTime,date');
        $this->db->where('userID',$barberID);
        $this->db->where('date',$date);
        $this->db->order_by('id','DESC');
        $query = $this->db->get('tbl_barberTimeSlot');
        $data = $query->result_array();
        return $data;*/
    }
    /*Start add_calender API*/  
    public function timeDetailByUserid($userID){
        $this->db->select('title,startTime,endTime,startDate,endDate');
        $this->db->where('userID',$userID);
        $this->db->order_by('id','DESC');
        $query = $this->db->get('tbl_barberTimeSlot');
        $data = $query->result();
        return $data;
    }
    /*End barberReviewList API*/
    
    /*Start onlineStatus API*/  
    public function onlineStatus($userID,$onlineStatus){
        if($onlineStatus == 1){
            $data = array(
                "latitude" => $_POST['latitude'],
                "longitude" => $_POST['longitude'],
                "onlineStatus"  => 1,
            );
        }
        else{
            $data = array(
               // "latitude" =>  NULL,
               // "longitude" => NULL,
                "onlineStatus"  => 0
            );
        }
        $this->db->where('id',$userID);
        $this->db->update('tbl_users',$data);
        $this->db->select('latitude,longitude');
        $this->db->where('id',$userID);
        $query = $this->db->get('tbl_users');
        $data = $query->result();
        return $data;
    }
    /*End barberReviewList API*/
    public function listOfNearByUsers($type,$latitude,$longitude){
        if($type == 2){
            $role = 3;
        }
        else {
            $role = 2;
        }
        if($latitude && $longitude){
           $sql = "SELECT id,firstName,lastName,email,phoneNumber,alternatePhoneNumber,userProfile,onlineStatus,latitude,longitude,distance FROM (
        SELECT *, 
            (
                (
                    (
                        acos(
                            sin(( $latitude * pi() / 180))
                            *
                            sin(( `latitude` * pi() / 180)) + cos(( $latitude * pi() /180 ))
                            *
                            cos(( `latitude` * pi() / 180)) * cos((( $longitude - `longitude`) * pi()/180)))
                    ) * 180/pi()
                ) * 60 * 1.1515 * 1.609344
            )
        as distance FROM `tbl_users`
    ) `tbl_users`
    WHERE tbl_users.distance <= 700 and tbl_users.onlineStatus = 1 and tbl_users.userRole = $role";
    
        $data = $this->db->query($sql)->result_array();
        if($type == 3){
            $response = $this->barberTotalReviewRating($data);
        }
        return $type == 3 ? $response : $data;
        }
        else{
            return [];
        }
       // return $data ? $data : []; 
    }
    public function getbookingID($userID,$barberID){
        $sql = "SELECT requestBookingID,requestBookingDate,status as bookingStatus,barberStatus,clientStatus FROM  tbl_request_bookings 
                WHERE barberID = '$barberID' AND userID = '$userID' 
                AND ((requestType = 'Scheduled' AND status = 1) OR
                    (requestType = 'Normal' AND (status = 0 OR status = 1)))
                ORDER BY requestBookingID desc";
        $response =  $this->db->query($sql)->row_array();
        return $response;
    }
    
    public function getAllNearByBarber($latitude,$longitude){
        if($latitude && $longitude){
           $sql = "SELECT id,firstName,lastName,email,phoneNumber,alternatePhoneNumber,userProfile,onlineStatus,latitude,longitude,distance FROM (
        SELECT *, 
            (
                (
                    (
                        acos(
                            sin(( $latitude * pi() / 180))
                            *
                            sin(( `latitude` * pi() / 180)) + cos(( $latitude * pi() /180 ))
                            *
                            cos(( `latitude` * pi() / 180)) * cos((( $longitude - `longitude`) * pi()/180)))
                    ) * 180/pi()
                ) * 60 * 1.1515 * 1.609344
            )
        as distance FROM `tbl_users`
    ) tbl_users
    WHERE tbl_users.distance <= 700  and userRole = 2 and latitude != '' and longitude != ''";
    
        $data = $this->db->query($sql)->result_array();
        return $data;
        }
        else{
            return [];
        }
    }
    public function barberTotalReviewRating($data){
        foreach($data as $val){
            $responseReview = $this->barberReviewListData($val['id']);
            $countData  = count($responseReview);
            $max = 0;
            foreach ($responseReview as $rate => $count) { 
                $max = $max+$count['rating'];
            }
             $rate = round($max / $countData,2);
           // echo (4.6699999999999999289457264239899814128875732421875,2);
            $val['rating'] = $max ?  $rate : 0;
            $val['review'] = $countData;
            $response[] = $val;
        }
        return $response;    
    }
    public function allBarberList(){
        $search = $_POST['search'];
        $this->db->select('id,firstName,lastName,email,phoneNumber,userProfile,onlineStatus,latitude,longitude');
        $this->db->where('accountStatus',1);
        $this->db->where('userRole',2);
        $this->db->where('latitude !=','');
        $this->db->where('longitude !=','');
        $this->db->like('firstName',$search);
        
        $query = $this->db->get('tbl_users');
       // echo $this->db->last_query();
        $data = $query->result_array();
        //$response = $this->barberTotalReviewRating($data);
        return $data;
    }
    public function getBarberProfileDetailsForCustomer($id){
        $this->db->select('u.id,u.phoneNumber,u.firstName,u.lastName,u.latitude,u.longitude,u.userProfile,u.onlineStatus,u.countryCode');
        $this->db->where('u.id',$id);
        $this->db->where('u.accountStatus',1);
        $this->db->from('tbl_users as  u');
        if($query=$this->db->get())
        {
          $data =  $query->row_array();
         // $value = $this->getBarberAndCustomerStatus($bookingID);
         // $barberdata['barberStatus'] = $value['barberStatus'];
         // $response = $barberdata;
          
          //print_r($response);
          return $data;
        }
        else{
          return false;
        } 
    }
    public function getBarberAndCustomerStatus($bookingID){
        $this->db->select('barberstatus,clientStatus');
        $this->db->where('requestBookingID',$bookingID);
        $this->db->from('tbl_request_bookings');
        if($query=$this->db->get())
        {
          return $query->row_array();
        }
        else{
          return false;
        } 
    }
        /*Start addAppointments API*/  
    public function addAppointments($userID){
        $data = array(
            "userID" => $userID,
            "barberID" => $_POST['barberID'],
            "selectedTimeID" =>$_POST['selectedTimeID'],
            "appintmentDate" => date("Y-m-d"),
            "status" => 1,
            "created_date" => date("Y-m-d H:i:s"),
            );
        $this->db->insert('tbl_appointments',$data);
        $insertID = $this->db->insert_id();
        $res = $this->addAppointmentsByID($insertID);
        return $res;
    }
    public function addAppointmentsByID($id){
        $this->db->select('a.*,c.startTime,c.endTime,c.date');
        $this->db->from('tbl_appointments as  a');
        $this->db->join('tbl_barberTimeSlot as  c','c.id = a.selectedTimeID','left');
        $this->db->where('a.id',$id);
        if($query=$this->db->get())
        {
          return $query->row_array();
        }
        else{
          return false;
        } 
    }
    public function getAppointmentByDate($day,$id){
        $sql = "SELECT a.*,c.startTime,c.endTime,c.date FROM tbl_appointments as  a 
                LEFT JOIN tbl_barberTimeSlot as  c ON c.id = a.selectedTimeID 
                WHERE a.appointmentDate = '$day' AND c.userID = $id AND a.barberID = $id";

        if($query=$this->db->query($sql))
        {
            $data = $query->result_array();
           /* foreach($data as $val){
                if($val['appointmentDate'] == $day){
                    $test[]= $val;
                }
            } 
            echo '<pre>';
            print_r($data);*/
            return $data;
        }
        else{
          return false;
        } 
    }
    public function getAppointments($id){
        $this->db->select('a.appointmentDate');
        $this->db->from('tbl_appointments as  a');
        $this->db->where('a.barberID',$id);
        if($query=$this->db->get())
        {
          //  echo $this->db->last_query();
            $data = $query->result_array();
            foreach($data as $val){
                //echo $val['appointmentDate'];
               $res[] = $this->getAppointmentByDate($val['appointmentDate'],$id);
            }
            print_r($res);
            return $res;
        }
        else{
          return false;
        } 
    }
    /*End addAppointments API*/
    
    
    
    public function ifCheckBookingAlreadyOnGoing($userID){
        $this->db->select('requestBookingID');
        $this->db->where('userID',$userID);
        $this->db->where('status',1);
        //$this->db->where('requestType','Normal');
        $this->db->from('tbl_request_bookings');
        $query = $this->db->get();
        $results = $query->row_array();
        $count=count($results);
        if($count>0){
          return false;
        }else{
          return true;
        }
    }
    public function ifCheckBookingAlready($userID){
        $this->db->select('requestBookingID');
        $this->db->where('userID',$userID);
        $this->db->where('status',0);
        $this->db->where('requestType','Normal');
        $this->db->from('tbl_request_bookings');
        $query = $this->db->get();
        $results = $query->row_array();
        //foreach($results as $val){
            $requestBooking = $results['requestBookingID'];
            if($requestBooking){
                $this->db->where('requestBookingID',$requestBooking);
                $this->db->update('tbl_request_bookings',array("status"=> 3));
            }
        //}
        return $requestBooking;
    }
    
    /*Start Add request booking API*/  
    
    public function addRequestBarberBooking($userID,$barberID,$clientLat,$clientLong){
        if($userID && $barberID){
            $oldBookingID = $this->ifCheckBookingAlready($userID);
        }
        $barberData = $this->getBarberProfileDetailsForCustomer($barberID);
        $barberLatitude = $barberData['latitude'];
        $barberLongitude = $barberData['longitude'];
        $data = array(
            "userID" => $userID,
            "barberID" => $barberID,
            "status" => 0,
            "selectedTimeID" =>0,
            "requestType" => 'Normal',
            "appointmentDate" => date("Y-m-d"),
            "specialNotes" => $_POST['specialNotes'],
            "wearSafetyProduct" => $_POST['wearSafetyProduct'],
            "intialBarberLatitude" => $barberLatitude,
            "intialBarberLongitude" => $barberLongitude,
            "intialClientLatitude" => $clientLat,
            "intialClientLongitude" => $clientLong,
            "requestBookingDate" => date("Y-m-d H:i:s"),
            );
        $this->db->insert('tbl_request_bookings',$data);
        $insertID = $this->db->insert_id();
        if($insertID){
            $this->addedSelectedServices($insertID);
            $res = $this->addRequestBarberBookingByID($insertID);
            $array = array("res"=>$res,"oldBookingID"=>$oldBookingID);
            return $array;
        }
        else{
             return false;
        }    
    }
    
    public function addedSelectedServices($insertID){
        $services = $_POST['services'];
        if($services){
            $newArray = explode(",",$services);
            foreach($newArray as $value){
                $dataArray = array(
                "bookingID" => $insertID,
                "servicesID" => $value,
                "status" => 1
            );
            $this->db->insert('tbl_selectedServices',$dataArray);
            }  
        }
        
    }
    
 
    public function checkExistRequestBooking($userID,$barberID){
        $query = $this->db->query("SELECT requestBookingID FROM tbl_request_bookings WHERE userID ='".$userID."' AND barberID ='".$barberID."' AND requestType = 'Normal' 
        AND (status = 0 OR status = 1)");
        $results = $query->result_array();
         $count=count($results);
       
        if($count>0){
          return false;
        }else{
          return true;
        }
    }
    
     public function checkBarberIsOnline($barberID){
        $this->db->select('onlineStatus');
        $this->db->where('onlineStatus',1);
        $this->db->where('id',$barberID);
        $this->db->from('tbl_users');
        $query = $this->db->get();
        $data = $query->row_array();
        return $data; 
    }
    
   public function selectedServicesList($bookingID){
        $this->db->select('ss.servicesID,s.name,s.description,s.price');
        $this->db->where('ss.bookingID',$bookingID);
        //$this->db->where('userID',$userID);
        $this->db->from('tbl_selectedServices as ss');
        $this->db->join('tbl_services as s','s.id = ss.servicesID','left');
        $query = $this->db->get();
        $data = $query->result_array();
        //print_r($data);
        return $data; 
    }
    
    public function addRequestBarberBookingByID($id){
        $this->db->select('a.requestBookingID,a.userID,a.barberID,a.status,a.requestType,a.specialNotes,a.requestBookingDate');
        $this->db->from('tbl_request_bookings as  a');
        $this->db->where('a.requestBookingID',$id);
        if($query=$this->db->get())
        {
          $data =  $query->row_array();
          $bookingID = $data['requestBookingID'];
          $slectedServices = $this->selectedServicesList($bookingID);
          if($slectedServices){
              $data['services'] = $slectedServices;
          }
          
          $response = $data;
          return $response;
        }
        else{
          return false;
        } 
    }
     
     public function checkExistscheduledBooking($userID,$barberID,$selectedTimeID){
        $query = $this->db->query("SELECT requestBookingID FROM tbl_request_bookings 
        WHERE userID ='".$userID."' AND barberID ='".$barberID."' AND selectedTimeID = '$selectedTimeID' AND (status = 0 OR status = 1) AND requestType = 'Scheduled'");
        $results = $query->result_array();
        $count=count($results);
       
        if($count>0){
          return false;
        }else{
          return true;
        }
  }
    
    public function getDateByselectedTimeID($selectedTimeID){
        $this->db->select("d.date");
        $this->db->where("id",$selectedTimeID); 
        $this->db->from("tbl_slot as s");
        $this->db->join("tbl_date as d","d.date_id=s.timeSlotID","join");
        $query = $this->db->get();
        $row = $query->row_array();
        $date = $row['date'];
       return $date;
    }
    public function getStateIDByStateName($state){
        $this->db->select('id');
        $this->db->where('name',$state);
        $this->db->from('tbl_state');
        $query = $this->db->get();
        $row = $query->row_array();
        return $row ? $row['id'] : 3;
    }
      public function addScheduleRequestBarberBooking($userID,$clientLat,$clientLong){
       /* $selectedTimeID =  $_POST['selectedTimeID'];
        $barberId = $_POST['barberID']; 
        $this->db->select("id");
        $this->db->where("selectedTimeID",$selectedTimeID); 
        $this->db->where("barberID",$barberId); 
        $query = $this->db->get("tbl_request_bookings");
        $row = $this->db->num_rows();
        { */
        
        $selectedTimeID =  $_POST['selectedTimeID'];
        $date = $this->getDateByselectedTimeID($selectedTimeID);
        $barberId = $_POST['barberID'];
        $barberData = $this->getBarberProfileDetailsForCustomer($barberId);
        $barberLatitude = $barberData['latitude'];
        $barberLongitude = $barberData['longitude'];
        $data = array(
            "userID" => $userID,
            "barberID" => $barberId,
            "status" => 0,
            "selectedTimeID" =>$selectedTimeID,
            "requestType" => 'Scheduled',
            "appointmentDate" => $date ? $date : date("Y-m-d"),
            "specialNotes" => $_POST['specialNotes'],
            "wearSafetyProduct" => $_POST['wearSafetyProduct'],
            "intialBarberLatitude" => $barberLatitude,
            "intialBarberLongitude" => $barberLongitude,
            "intialClientLatitude" => $clientLat,
            "intialClientLongitude" => $clientLong,
            "requestBookingDate" => date("Y-m-d H:i:s"),
            );
        $this->db->insert('tbl_request_bookings',$data);
        $insertID = $this->db->insert_id();
        if($insertID){
            $bookingID = $insertID;
            $this->addedSelectedServices($insertID);
            $clientRecord = $this->getClientDetailByID($bookingID);
            $barerRecord = $this->getBarberDetailByID($bookingID);
            $services = $this->selectedServicesList($bookingID);
            $servicesName = $this->servicesTitleString($services);
            $appoinmentDate = $date;  
			$createDate = new DateTime($appoinmentDate);
			$ADate = $createDate->format('M d, Y');
            $slotID = $selectedTimeID;
            $slot = $this->getSlotByID($slotID);
            $clientID = $clientRecord['userID'];
            $barberID = $clientRecord['barberID'];
            $type = 'ScheduledBooking';
            $title = 'Scheduled Booking';
           // $clientName = $clientRecord['firstName'].' '.$clientRecord['lastName'];
            $barberName = $barerRecord['firstName'].' '.$barerRecord['lastName'];
            $clientMessage = ' You have been sent request to schedule booking with '.$barberName.' for '.$servicesName.' on '.$ADate.' at '.$slot['startSlot'];
           // $barbertMessage = $clientName.'  has been sent request to schedule booking with  you for '.$servicesName;
            
            //$this->addNotification($barberID,0,$bookingID,$type,$title,$barbertMessage);
            $this->addNotification(0,$clientID,$bookingID,$type,$title,$clientMessage);
            
            $res = $this->GetSceduledBookingByID($insertID);
            
            return $res;
        }
        //}
    }
    
    public function GetSceduledBookingByID($id){
        $this->db->select('a.*,c.startSlot,c.endslot');
        $this->db->from('tbl_request_bookings as  a');
        $this->db->join('tbl_slot as  c','c.id = a.selectedTimeID','left');
        $this->db->where('a.requestBookingID',$id);
        if($query=$this->db->get())
        {
          $data =  $query->row_array();
          $bookingID = $data['requestBookingID'];
          $slectedServices = $this->selectedServicesList($bookingID);
            if($slectedServices){
                
                $data['services'] = $slectedServices;
            }
          
            $response = $data;
            return $response;
        }
        else{
          return false;
        } 
    }
       public function GetRequestedBookingUserSingle($barberID,$userID)
     {
      $query1="SELECT tbl_request_bookings.requestBookingID,tbl_request_bookings.requestBookingDate, tbl_request_bookings.status as bookingStatus,
       tbl_request_bookings.barberStatus, tbl_request_bookings.clientStatus
       FROM tbl_request_bookings
       WHERE (tbl_request_bookings.barberID ='$barberID' AND tbl_request_bookings.userID ='$userID')
       AND  ( (requestType	 = 'Scheduled' AND tbl_request_bookings.status = 1)
       OR (requestType	 = 'Normal' AND(tbl_request_bookings.status = 0 OR tbl_request_bookings.status = 1))) order by requestBookingID desc";
     
        if($query=$this->db->query($query1))
        {
              
      
          return $query->row_array();
        }
        else{
          return false;
        } 
        
    }
    
     public function GetRequestedBookingUser($barberID)
     {
        
        $this->db->select('c.*,a.requestBookingID,a.requestBookingDate');
        $this->db->from('tbl_request_bookings as a');
        $this->db->join('tbl_users as  c','c.id = a.userID','left');
        $this->db->where('a.barberID',$barberID);
        //$this->db->where('a.status','3');
        
      $query1="SELECT tbl_users.*,tbl_request_bookings.requestBookingID,tbl_request_bookings.requestBookingDate, tbl_request_bookings.status as bookingStatus,
       tbl_request_bookings.barberStatus, tbl_request_bookings.clientStatus
       FROM tbl_request_bookings LEFT JOIN tbl_users ON tbl_users.id=tbl_request_bookings.userID 
       WHERE tbl_request_bookings.barberID ='".$barberID."' 
       AND  ( (requestType	 = 'Scheduled' AND tbl_request_bookings.status = 1)
       OR (requestType	 = 'Normal' AND(tbl_request_bookings.status = 0 OR tbl_request_bookings.status = 1)))";
     
        if($query=$this->db->query($query1))
        {
              
      
          return $query->result_array();
        }
        else{
          return false;
        } 
        
    }
    
     public function CancelBookingRequestStatus($userID)
     {
         $BookingId=$_POST['requestBookingID'];
        $accountStatus=array( 
            'status'=> 3,
            ); 
          $this->db->where('requestBookingID', $BookingId);
          $this->db->update('tbl_request_bookings', $accountStatus);
        /*  if($query=$this->db->affected_rows())
        {
          return true;
        }
        else
        {
            return false;
        }*/
         return true;
     }
     
    public function CancelBookingRequestStatusWhileOffline($UserId,$type)
    {
        //$barberquery = "UPDATE tbl_request_bookings set status = 3 WHERE barberID = $UserId AND (status = 1 OR status = 0)";
        //$accountStatus=array('status'=> 3); 
        if($type==2)
        {
            $update = "UPDATE tbl_request_bookings set status = 3 WHERE barberID = $UserId AND (((status = 1 OR status = 0) AND requestType = 'Normal') OR (status = 1 AND requestType = 'Scheduled'))";
        }
        else
        {
            $update = "UPDATE tbl_request_bookings set status = 3 WHERE userID = $UserId AND (((status = 1 OR status = 0) AND requestType = 'Normal') OR (status = 1 AND requestType = 'Scheduled'))";
            //$this->db->where('userID', $UserId);
        }
        //$this->db->where('status', 0);
        //$this->db->where('status', 1);
       // $this->db->where('requestType', 'Normal');
         
        //$this->db->update('tbl_request_bookings', $accountStatus);
        if($query=$this->db->query($update))
        {
          return true;
        }
        else
        {
            return false;
        }
        
     }
    
     public function DeleteBookingStatusByCronJOb()
     {
        
         $sql = "SELECT id,firstName,lastName,email,phoneNumber,alternatePhoneNumber,userProfile,onlineStatus,latitude,longitude,distance FROM (
        SELECT *, 
            (
                (
                    (
                        acos(
                            sin(( $latitude * pi() / 180))
                            *
                            sin(( `latitude` * pi() / 180)) + cos(( $latitude * pi() /180 ))
                            *
                            cos(( `latitude` * pi() / 180)) * cos((( $longitude - `longitude`) * pi()/180)))
                    ) * 180/pi()
                ) * 60 * 1.1515 * 1.609344
            )
        as distance FROM `tbl_users`
    ) tbl_users
    WHERE tbl_users.distance <= 300  and userRole = 2";
    
        $data = $this->db->query($sql)->result_array();
    }
    
    /*Start getBookingDetail*/
    public function getBookingDetail($userID,$bookingID,$type){
        $this->db->select("*");
        $this->db->where('requestBookingID',$bookingID);
        if($type == 2){
            $this->db->where('barberID',$userID);
        }else{
            $this->db->where('userID',$userID);
        }
        $this->db->from('tbl_request_bookings');
        $query = $this->db->get();
        //echo $this->db->last_query();
        $result = $query->row_array();
        if($result){
        $bookingID = $result['requestBookingID'];
        $selectedTimeID = $result['selectedTimeID'];
        
        $result['isbookingcancelled'] = $result['status'] == 3 ? 1 : 0;
        
        $slectedServices = $this->selectedServicesList($bookingID);
        $title =  $this->servicesTitleString($slectedServices);
        $servicesTotal = $this->sumOfServices($slectedServices);
        $slotTime = $this->getSlotByID($selectedTimeID);
        
        $result['title'] = $title;
        $result['startSlot'] = $slotTime['startSlot'];
        $result['endSlot'] =   $slotTime['endSlot'];
       
        $result['services'] = $slectedServices;
          
        $result['servicesTotalSum'] = round($servicesTotal);
        $result['totalSumUpServicesinStr'] = number_format($servicesTotal,2);
        $response = $result;
        return $result;
        }
        else{
        return false;
        }
    }

    /*end getBookingDetail*/
    /*start barberAcceptBooking*/
    public function  barberAcceptBooking($barberID,$bookingID){
        $this->db->select("b.*");
        $this->db->where('b.requestBookingID',$bookingID);
        $this->db->where('b.barberID',$barberID);
        $this->db->where('b.status',0);
        $this->db->where('u.onlineStatus',1);
        $this->db->from('tbl_request_bookings as b');
        $this->db->join('tbl_users as u','u.id = b.userID','left');
        $query = $this->db->get();
        //echo $this->db->last_query();
        $result = $query->row_array();
       // print_r($result);
        if($result){
            $this->db->where('requestBookingID',$bookingID);
            $this->db->where('barberID',$barberID);
            $this->db->update('tbl_request_bookings',array("status"=> 1));
            $data = $this->getBookingDetail($barberID,$bookingID,'2');
            return $data;
        }
       /* else{
            return 
        }
        return $result;*/
    }
    /*end barberAcceptBooking*/
    /*calcualte slot according to 30min*/
    public function calculate($startTime,$endTime){
        ///$startTime = '09:00'; 
        //$endTime = '17:00';  
        $duration = '30';  
        $start = new DateTime($startTime);
        $end = new DateTime($endTime);
        $interval = new DateInterval("PT" . $duration. "M");
        $period = new DatePeriod($start, $interval, $end);
        $periods = array();
        $slots = array();
        $slot_counter = 0;
        foreach ($period as $dt) {
        	$slots[] = $dt;
        }
        foreach ($slots as $key => $dt) {
            $slot_counter++;
          if($slot_counter == count($slots)) {
            $current = $end;
          } else if($slot_counter <= count($slots)) {
            $current = $slots[$key+1];  
          }
          $previous = $slots[$key];
          $s = $previous->format('h:i A');
          $e = $current->format('h:i A');
          $periods[] = array('slot_timing' => $previous->format('h:i A') . ' - ' . $current->format('h:i A'));
        }
        return $periods;
    }   
    /*End barberReviewList API*/
    public function checkExistTimeSlotByBarberID($userID,$startTime,$endTime,$startDate,$endDate){
     //   $this->db->select("*");
     //   $this->db->from("tbl_barberTimeSlot");
     //   $this->db->where('userID',$userID);
      //  $this->db->where('startTime >=',$startTime);
      // $this->db->where('endTime <=',$endTime);
      //  $this->db->where($startDate, '>= startDate');
        //$this->db->where('endDate >=',$endDate);
       // $query = $this->db->get();
         $sql = "SELECT * FROM `tbl_barberTimeSlot`
                WHERE `userID` = '$userID'
                AND `startTime` >= '$startTime'
                AND `endTime` <= '$endTime'
                AND '$startDate' >= `startDate`
                AND `endDate` >= '$endDate'";
                
       // echo $this->db->last_query();
        $numRows = $this->db->query($sql)->num_rows();
       // $numRows = $query->num_rows();
        return $numRows;
    }
    /*Start add_calender API*/  
    public function postFreeTimeSlotByBarber($userID){
        $isAllDaySelected = $_POST['isAllDaySelected'];
        if($isAllDaySelected == 0){
            $startTime = $_POST['startTime'];
            $endTime = $_POST['endTime'];
        }
        else{
            $startTime = '08:00AM';
            $endTime = '05:00PM';
        }
        
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $datesRange = $_POST['datesRange'];
        $datesRangeArray = explode(",",$datesRange);
        $rows = $this->checkExistTimeSlotByBarberID($userID,$startTime,$endTime,$startDate,$endDate);
        if($rows == 0){
            $data = array(
                "userID" => $userID,
                "title" => $_POST['title'],
                "startTime" => $startTime,
                "endTime" => $endTime,
                "startDate" => $startDate,
                "endDate" => $endDate,
                "isAllDaySelected" => $isAllDaySelected,
                "status" => 1,
                "created_date" => date("Y-m-d H:i:s")
                );
                $this->db->insert('tbl_barberTimeSlot',$data);
                $lastID = $this->db->insert_id();
            if($lastID) {
                $slot = $this->calculate($startTime,$endTime);
                foreach($datesRangeArray as $datesRangeValue){
                    //echo $datesRangeValue;
                    $dateData = array(
                        "userID" =>$userID,
                        "dateTimeId" => $lastID,
                        "date" => $datesRangeValue,
                        "status" => 1
                    );
                    $this->db->insert('tbl_date',$dateData);
                    $dateLastId = $this->db->insert_id();
                    foreach($slot as $tSlot){
                    $split =  explode("-",$tSlot['slot_timing']);
                    $startSlot = $split['0'];
                    $endSlot = $split['1'];
                    $slotData = array(
                        "timeSlotID" => $dateLastId,
                        "startSlot" => $startSlot,
                        "endSlot" => $endSlot,
                        "status" => 1
                    );
                   // print_r($slotData);
                    $this->db->insert('tbl_slot',$slotData);
                    //echo $this->
                    $res = $this->timeDetailByid($lastID);
                    $response = array("msg"=>"Time slot added successfully","data"=>$res);
                }
                }
            }
        }    
        else{
            //$res = $this->timeDetailByid(51);
            $response = array("msg"=>"Time slot already added successfully","data"=>NULL);
        }
        return $response; 
        //return TRUE;
    }   
        
      /* $rows = $this->checkExistTimeSlotByBarberID($userID,$startTime,$endTime,$date); 
        if($rows == 0){*/
          /* $data = array(
            "userID" => $userID,
            "title" => $_POST['title'],
            "startTime" => $startTime,
            "endTime" => $endTime,
            "date" => $date,
            "status" => 1,
            "created_date" => date("Y-m-d H:i:s")
            );
            $this->db->insert('tbl_barberTimeSlot',$data);
            $lastID = $this->db->insert_id();
            $res = $this->timeDetailByid($lastID);
            $response = array("msg"=>"Time slot added successfully","data"=>$res);*/
        /*}
       else {
           $response = array("msg"=>"Time slot already added successfully","data"=>[]);
        } */
        //return TRUE;
        //return $response;

        /*$opening_hours = $_POST['opening_hours'];
        $time = json_decode($opening_hours, true);
        foreach($time as $time1){
            $startTime =  $time1['start_time'];
            $endTime = $time1['start_time'];
            $day = $time1['day'];
            $data = array(
                "userID" => $userID,
                "title" => $_POST['title'],
                "startTime" => $startTime,
                "endTime" => $endTime,
                "day" => "$day",
                "status" => 1
                );
            $this->db->insert('tbl_calender',$data);
        } */
    //}
    public function slotListById($lastID){
        $this->db->select('id as slotId,startSlot,endSlot');
        $this->db->where('timeSlotID',$lastID);
        $this->db->from('tbl_slot');
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }
    /*End barberReviewList API*/
    public function timeDetailByid($lastID){
        $this->db->select('date_id,date');
        $this->db->where('dateTimeId',$lastID);
        $this->db->order_by('date_id','ASC');
        $this->db->from('tbl_date');
        $query = $this->db->get();
        $data = $query->result_array();
        foreach($data as $value){
            $slotData =  $this->slotListById($value['date_id']);
            $value['slots']= $slotData;
            $response[] = $value;
        }
         return $response;
        /*$res = $this->slotListById($lastID);
        $data['slots']= $res;
        $response = $data;
        return $response;*/
        
        /*$this->db->select('t.title,t.startDate,t.endDate');
        $this->db->where('t.id',$lastID);
        $this->db->order_by('t.id','DESC');
        $this->db->from('tbl_barberTimeSlot as t');
        $query = $this->db->get();
        $data = $query->row_array();
        $res = $this->slotListById($lastID);
        $data['slots']= $res;
        $response = $data;
        return $response;*/
    }
    public function getDatesFromRange($start, $end) {
        $format = 'Y-m-d';
        $array = array(); 
        $interval = new DateInterval('P1D'); 
        $realEnd = new DateTime($end); 
        $realEnd->add($interval); 
        $period = new DatePeriod(new DateTime($start), $interval, $realEnd); 
        foreach($period as $date) {                  
            $dates[] = $date->format($format);  
        } 
       return $dates; 
    } 
    
    public function cancelBookingByCronJobs(){
         $sql = "select tbl_request_bookings.*,DATE_ADD(tbl_request_bookings.requestBookingDate, INTERVAL 15 MINUTE) as checkdate 
                FROM tbl_request_bookings
                where DATE_ADD(tbl_request_bookings.requestBookingDate, INTERVAL 15 MINUTE) <= UTC_TIMESTAMP() AND tbl_request_bookings.status='0' AND requestType = 'Normal'";
                
        $data =  $this->db->query($sql)->result_array();
        foreach($data as $val){
            $this->db->where('requestBookingID',$val['requestBookingID']);
            $this->db->update('tbl_request_bookings',array("status"=> 3));         
        }
        return $data;
    }
    public function updateLatAndLongOfBarber($barberID){
        $data = array(
            "latitude" => $_POST['latitude'],
            "longitude" => $_POST['longitude'],
        );
        $this->db->where('id',$barberID);
        $this->db->where('accountStatus',1);
        $this->db->where('userRole',2);
        $this->db->update('tbl_users',$data);
        //if($query=$this->db->affected_rows()){
            $this->db->select('latitude,longitude');
            $this->db->where('id',$barberID);
            $query = $this->db->get('tbl_users');
            $data = $query->result();
            return $data;
       // }
    }
    
    public function getcancelReason($userType){
        if($userType == 2){
           $type = 2; 
        }
        else{
            $type = 3;
        }
        $this->db->select('reasonID,reasonTitle');
        $this->db->where('type',$type);
        $query = $this->db->get('tbl_reason');
        $data = $query->result_array();
        return $data;
    }
    public function isCheckAlreadyCancel($bookingID,$userID,$userType,$table){
        $this->db->select('*');
        $this->db->where('bookingID',$bookingID);
        $this->db->where('userID',$userID);
        $this->db->from($table);
        $query = $this->db->get();
        $row = $query->num_rows();
        return $row;
    }
    public function getCancelBookingByID($bookingID,$userID,$table){
        $this->db->select('*');
        $this->db->where('bookingID',$bookingID);
        $this->db->where('userID',$userID);
        $this->db->from($table);
        $query = $this->db->get();
        $row = $query->row_array();
        return $row;
    }
    public function postCancelBookingWithReason($userID,$userType){
        if($userType == 2){
           $table ='tbl_cancelBookingByBarber'; 
        }
        else{
            $table ='tbl_cancelBookingByCustomer'; 
        }
        $bookingID  = $_POST['bookingID'];
        $arrayData = array(
            "userID" => $userID,
            "bookingID" => $bookingID,
            "isCancelled" => $_POST['isCancelled'],
            "ReasonID" => $_POST['ReasonID'],
            "status" => 1    
        );
        $rows =  $this->isCheckAlreadyCancel($bookingID,$userID,$userType,$table);
        if($rows == 0){
            $this->db->insert($table,$arrayData);
            $lastID  = $this->db->insert_id();
            if($lastID){
                $this->db->where('requestBookingID',$bookingID);
                $this->db->update('tbl_request_bookings',array('status'=> 3));
                $data = $this->getCancelBookingByID($bookingID,$userID,$table);
                $response =  array("data"=>$data,"success"=> 1,"message"=>"booking cancel successfully");
            }  
        }
        else{
            $response = array("data"=>NULL,"success"=>0,"message"=>"You have already cancel this booking");
        }
         return $response;
    }
    public function postUpdateBarberStatus($userID){
        $barberStatus = $_POST['barberStatus'];
        $data = array(
            "barberStatus" => $barberStatus
        );
          $bookingID  = $_POST['bookingID'];
          $sql = "SELECT * FROM tbl_request_bookings WHERE requestBookingID = '$bookingID' AND (status = 3 || status = 2)";
          $rows = $this->db->query($sql)->num_rows();
          if($rows == 0){
              $this->db->where('requestBookingID', $bookingID);
              $this->db->update('tbl_request_bookings', $data);
             /* if($barberStatus == 3){
                  $this->db->where('requestBookingID', $bookingID);
                 $this->db->update('tbl_request_bookings', array("status"=>2));
              }*/
               $response = array("status"=>$barberStatus,"success"=>1,"message"=>"barber status updated successfully");
          }
          else {
               $response = array("status"=>0,"success"=>0,"message"=>"booking is already cancel/completed");
          }
         
          return $response;
    }
    public  function PostUpdateClientStatus($userID,$clientStatus,$bookingID){
        $data = array(
            "clientStatus" => $clientStatus
        );
          $sql = "SELECT * FROM tbl_request_bookings WHERE requestBookingID = '$bookingID' AND (status = 3 || status = 2)";
          $rows = $this->db->query($sql)->num_rows();
          if($rows == 0){
              $this->db->where('requestBookingID', $bookingID);
              $this->db->update('tbl_request_bookings', $data);
               $response = array("status"=>$clientStatus,"success"=>1,"message"=>"status updated successfully");
          }
          else {
               $response = array("status"=>0,"success"=>0,"message"=>"booking is already cancel/completed");
          }
         
          return $response;
    }
 
    public function getBarberServicesList($userId,$bookingID){
        $this->db->select('id as servicesID,name,description,price');
        $this->db->where('userID',$userId);
        $this->db->from('tbl_services');
        $query = $this->db->get();
        $data = $query->result_array();
        foreach($data as $value){
            $servicesID = $value['servicesID'];
            $isSelected = $this->checkIsSelected($servicesID,$bookingID);
           // print_r($isSelected);
           // echo $isSelected['servicesID'];
            if($isSelected['servicesID'] == $servicesID) {
                $value['isSelected'] = 1;
                $response[] = $value;
            }
            else{
                $value['isSelected'] = 0;
                $response[] = $value;
            }
        }
        return $response;
    }
    
    public function checkIsSelected($servicesID,$bookingID){
        $this->db->select('servicesID');
        $this->db->where('servicesID',$servicesID);
        $this->db->where('bookingID',$bookingID);
        $this->db->from('tbl_selectedServices');
        
        $query = $this->db->get();
       // echo $this->db->last_query();        
        $data = $query->row_array();
        return $data;   
    }
    
    public function isAlreadyPaymentRequest($userID,$bookingID){
        $this->db->select('*');
        $this->db->where('bookingID',$bookingID);
        $this->db->where('userID',$userID);
        $this->db->from('tbl_paymentRequestByBarber');
        $query = $this->db->get();
        $row = $query->num_rows();
        return $row; 
    } 
    /*public function addedServices($lastID){
        $services = $_POST['services'];
        $newArray = explode(",",$services);
        foreach($newArray as $value){
            $dataArray = array(
            "paymentRequestID" => $lastID,
            "servicesID" => $value,
            "status" => 1
        );
        $this->db->insert('tbl_paymentServices',$dataArray);
        }
    }*/
    /*public function getPaymetRequestById($lastID){
        $this->db->select('*');
        $this->db->where('bookingID',$bookingID);
        $this->db->where('userID',$userID);
        $this->db->from('tbl_paymentRequestByBarber');
        $query = $this->db->get();
        $row = $query->num_rows();
        return $row;
    }*/
    public function deletSelectedServices($bookingID){
        $this->db->where('bookingID',$bookingID);
        if($this->db->delete('tbl_selectedServices')){
            $res = array("success"=>1);
            return $res;
        }
        else {
            return false;
        }
        
    }

    public function postPaymentRequestByBarber($userID){
        $bookingID = $_POST['bookingID'];
        $state = $_POST['state'];
        $dataArray = array(
            "userID" => $userID,
            "bookingID" => $bookingID,
            "totalAmount" => $_POST['totalAmount'],
            "barberstatus" =>  $_POST['barberStatus'],
            "state" => $this->getStateIDByStateName($state),
            "status" => 1,
            "date" => date("Y-m-d H:i:s")
        );
        $rows = $this->isAlreadyPaymentRequest($userID,$bookingID);
        if($rows == 0){
            $check = $this->postUpdateBarberStatus($userID);
            if($check['success'] == 1){
                $this->db->insert('tbl_paymentRequestByBarber',$dataArray);
                $lastID = $this->db->insert_id();
                if($lastID){
                    //$this->db->where('requestBookingID', $bookingID);
                     //   $this->db->update('tbl_request_bookings', $data);
                    $isDeleted = $this->deletSelectedServices($bookingID);
                    if($isDeleted['success'] == 1){
                        $this->addedSelectedServices($bookingID);
                    }
                    
                    //$this->addedServices($lastID);
                    $response = array("success" => 1, "message" => "Payment Request added successfully");
                }
            }    
            else {
                $response = array("success" => 0, "message" => "Booking is already cancel/completed");
            }
        }
        else{
            $response = array("success" => 0, "message" => "You have already added payment request on this bookingID");
        }
        return $response;
    }
    
    /*public function paymentServicesList($paymentRequestID){
        $this->db->select('ps.servicesID,s.name,s.description,s.price');
        $this->db->where('ps.paymentRequestID',$paymentRequestID);
        //$this->db->where('userID',$userID);
        $this->db->from('tbl_paymentServices as ps');
        $this->db->join('tbl_services as s','s.id = ps.servicesID','left');
        $query = $this->db->get();
        $data = $query->result_array();
       // print_r($data);
        return $data; 
    }*/
    //success,message,totalAmount,Date,ServicesUsed(array object),CardDetail object
    public function getTaxByStateID($stateID){
        $this->db->select('*');
        $this->db->where('id',$stateID);
        $query = $this->db->get('tbl_state');
        $data = $query->row_array();
        return $data ? $data['stateTaxRate'] : ''; 
    }
    public function getBookingPaymentDetail($userID,$bookingID){
        $this->db->select('id,bookingID,totalAmount,totalTax,date,state');
        $this->db->where('bookingID',$bookingID);
        //$this->db->where('userID',$userID);
        $this->db->from('tbl_paymentRequestByBarber');
        $query = $this->db->get();
       // echo $this->db->last_query();
        $row = $query->row_array();
        //$paymentRequestID = $row['id'];
        //$services = $this->paymentServicesList($paymentRequestID);
        $services = $this->selectedServicesList($bookingID);
        if($services){
            $row['services'] = $services;
        }
        $row['tax'] = $this->getTaxByStateID($row['state']); 
        $ressponse = $row;
        return $ressponse; 
    }
    
    public function isPaymentAlreadyPaid($bookingID){
        $this->db->select('*');
        $this->db->where('bookingID',$bookingID);
        $this->db->where('clientStatus',3);
        $this->db->from('tbl_paymentRequestByBarber');
        $query = $this->db->get();
        $num = $query->num_rows();
        return $num;
    }
    /*
    postUpdatePaymentbyClient(bookingID,totalAmount,totalTip,TotalamountDeduct,ClientStatus)
    */
    public function postUpdatePaymentbyClient($userID,$cardID,$paymentSuccessID,$balanceTransaction){
       // echo $userID;
        $bookingID = $_POST['bookingID'];
        $TotalamountDeduct = $_POST['TotalamountDeduct'];

        $clientStatus = 3;
        $dataArray = array(
            "clientID" => $userID,
            "totalAmount" => $_POST['totalAmount'],
            "totalTip" =>  $_POST['totalTip'],
            "totalTax" => $_POST['totalTax'],
            "TotalamountDeduct" => $TotalamountDeduct,
            "clientStatus" => $clientStatus,
            "cardID" => $cardID,
            "paymentSuccessID" => $paymentSuccessID,
            "balanceTransaction" => $balanceTransaction,
            "date" => date("Y-m-d H:i:s")
        );
        $row = $this->isPaymentAlreadyPaid($bookingID);
        if($row == 0){
            $this->db->where('bookingID',$bookingID);    
            $check = $this->db->update('tbl_paymentRequestByBarber',$dataArray);
            if($check){
                if($clientStatus == 3){
                    $this->db->where('requestBookingID', $bookingID);
                    $this->db->update('tbl_request_bookings', array("status"=>2,"clientStatus"=> 3));
                    
                    $clientRecord = $this->getClientDetailByID($bookingID);
                    $barerRecord = $this->getBarberDetailByID($bookingID);
                    $services = $this->selectedServicesList($bookingID);
                    $servicesName = $this->servicesTitleString($services);
                    $clientID = $clientRecord['userID'];
                    $barberID = $clientRecord['barberID'];
                    $type = 'completeBooking';
                   // $title = 'Complete Booking';
                    //$title = 'You Sent A Payment!';
                    //$clientName = $clientRecord['firstName'].' '.$clientRecord['lastName'];
                    //$barberName = $barerRecord['firstName'].' '.$barerRecord['lastName'];
                    //$clientMessage = 'Congratulations! You sent a payment of '.$this->data['amountSign'].number_format($TotalamountDeduct,2).' to '.$barberName;
                    //$clientMessage = 'You have paid '.$this->data['amountSign'].number_format($TotalamountDeduct,2).' to '.$barberName.' for '.$servicesName;
                   // $barbertMessage = 'you have received '.$this->data['amountSign'].number_format($TotalamountDeduct,2).' from '.$clientName.' for '.$servicesName;
                    
                   // $this->addNotification(0,$clientID,$bookingID,$type,$title,$clientMessage);
                    //$this->addNotification($barberID,0,$bookingID,$type,$title,$barbertMessage);
                  }
            }
            $response = array("success"=>1,"message"=>"You have paid successfully to this barber");
        }
        else{
            $response = array("success"=>0,"message"=>"You have already paid  to this barber");
        }
        return $response;
    }
    public function isAlreadyRatingToClient($userID,$clientID){
        $this->db->select("*");
        $this->db->where('userID',$userID);
        $this->db->where('clientID',$clientID);
        $this->db->from("tbl_barberRatingToCustomer");
        $query = $this->db->get();
        $nums = $query->num_rows();
        return $nums;
    }
    public function getBarberSendRatingByID($lastID){
        $this->db->select("userID,clientID,rating");
        $this->db->where('id',$lastID);
        $this->db->from("tbl_barberRatingToCustomer");
        $query = $this->db->get();
        
        $data = $query->row_array();
        return $data;
    }
    
    public function getBarberSendRatingByUserIDAndClient($userID,$clientID){
        $this->db->select("userID,clientID,rating");
        $this->db->where('userID',$userID);
        $this->db->where('clientID',$clientID);
        $this->db->from("tbl_barberRatingToCustomer");
        $query = $this->db->get();
        
        $data = $query->row_array();
        return $data;
    }
    
    public function postBarberRatingToClient($userID,$clientID){
        
        $rows  = $this->isAlreadyRatingToClient($userID,$clientID);
        if($rows == 0){
            $arrayData = array(
                "userID"  => $userID,
                "clientID" => $clientID,
                "rating"  => $_POST['rating'],
                "status"  => 1,
                "created_date" => date("Y-m-d H:i:s")
            );
            $this->db->insert("tbl_barberRatingToCustomer",$arrayData);
            $lastID = $this->db->insert_id();
            if($lastID){
                $data = $this->getBarberSendRatingByID($lastID);
                $response = array("data"=> $data,"success" => 1, "message" => "Rating added successfully");
            }
            
        }
        else{
            $arrayData = array(
                "rating"  => $_POST['rating'],
                 "created_date" => date("Y-m-d H:i:s")
            );
            $this->db->where('userID',$userID);
            $this->db->where('clientID',$clientID);
            $this->db->update("tbl_barberRatingToCustomer",$arrayData);
            $data = $this->getBarberSendRatingByUserIDAndClient($userID,$clientID);
            $response = array("data"=> $data,"success" => 1, "message" => "Rating updated successfully");
        }
        return $response;
    }
    public function isAlreadyRatingToBarber($userID,$barberID){
        $this->db->select("*");
        $this->db->where('userID',$userID);
        $this->db->where('barberID',$barberID);
        $this->db->from("tbl_customerRatingToBarber");
        $query = $this->db->get();
        $nums = $query->num_rows();
        return $nums;
    }
    public function getClientSendRatingByID($lastID){
        $this->db->select("userID,barberID,rating,comment");
        $this->db->where('id',$lastID);
        $this->db->from("tbl_customerRatingToBarber");
        $query = $this->db->get();
        $data = $query->row_array();
        return $data;
    }
  /*  public function uploadedRatingImages(){
        $currentDate = date('dmY');
        $data = array();
        $countfiles = count($_FILES['uploadImages']['name']);
        if($countfiles <= 3) {
            $imagePath = "./uploads/barberRatingImages/";
            for($i=0;$i<$countfiles;$i++){
                if(!empty($_FILES['uploadImages']['name'][$i])){
                    $baseName = $_FILES['uploadImages']['name'][$i];
                    $tmpName = $_FILES['uploadImages']['tmp_name'][$i];
                    $error = $_FILES['uploadImages']['error'][$i];
                    $imageName =  $currentDate.'_'.$baseName;
                    $imageSource= $imagePath.basename($imageName);
                    $result[]=move_uploaded_file($tmpName,$imageSource);
                    $arrayName = $_FILES['uploadImages']['name'];
                    $imaage_array[] = $arrayName;
                  
                }
            }
            if($result){
                    $response = $countfiles;
                }
                else{
                    $response = array("success" => "fail");
                }
        }
        else{
            $response = array("success" => "size");
        }
        return $response;
    }*/
     public function uploadedRatingSingleImages(){
        $currentDate = date('dmY');
        $data = array();
        $countfiles = 4;
            $imagePath = "./uploads/barberRatingImages/";
            for($i=1;$i<$countfiles;$i++){
                if(!empty($_FILES['uploadImages'.$i]['name'])){
                    $baseName = $_FILES['uploadImages'.$i]['name'];
                    $tmpName = $_FILES['uploadImages'.$i]['tmp_name'];
                    $error = $_FILES['uploadImages'.$i]['error'];
                    $imageName =  $currentDate.'_'.$baseName;
                    $imageSource= $imagePath.basename($imageName);
                    $result[]=move_uploaded_file($tmpName,$imageSource);
                    $arrayName = $_FILES['uploadImages'.$i]['name'];
                    $imaage_array[] = $arrayName;
                }
            }
            if($result){
                    $response = $imaage_array;
            }
        return $response;
    }
    /*public function addedMultipleImagesBarberRating($ratingID){
         $currentDate = date('dmY');
        $countfiles = $this->uploadedRatingImages();
        for($i=0;$i<$countfiles;$i++){
             $baseName = $_FILES['uploadImages']['name'][$i];
            $arrayData = array(
                "reviewID" => $ratingID,
                "images" => $currentDate.'_'.$baseName
            );
            $this->db->insert("tbl_barberReviewImages",$arrayData);
            echo $this->db->last_query();
            return TRUE;
        }
    } */
    public function getRatingToBarberByUserIDAndBarberID($userID,$barberID){
        $this->db->select("*");
        $this->db->where('userID',$userID);
        $this->db->where('barberID',$barberID);
        $this->db->from("tbl_customerRatingToBarber");
        $query = $this->db->get();
        $row = $query->row_array();
        $reviewID = $row['id'];
        $images = $this->getCustomerRatingImages($reviewID);
        foreach($images as $im){
            $imageName[] =   $im['images'];
        }
        $row['images'] = $imageName;
        unset($data['id']);
        $response = $row;
        return $response;
    }
    public function deleteatingSingleImages($reviewID){
         $this->db->where('reviewID',$reviewID);
         $this->db->delete('tbl_barberReviewImages');
         return true;
    }

    public function postClientRatingToBarber($userID,$barberID){
        
        $arrayData = array(
            "userID"  => $userID,
            "barberID" => $barberID,
            "rating"  => $_POST['rating'],
            "comment"  => $_POST['comment'],
            "status"  => 1,
            "created_date" => date("Y-m-d H:i:s")
        );
       $rows  = $this->isAlreadyRatingToBarber($userID,$barberID);
        if($rows == 0){
            $this->db->insert("tbl_customerRatingToBarber",$arrayData);
            $lastID = $this->db->insert_id();
            $currentDate = date('dmY');
            $countfiles = $this->uploadedRatingSingleImages();
            foreach($countfiles as $imaageVal){
                $baseName = $imaageVal;
                $arrayData = array(
                    "reviewID" => $lastID,
                    "images" => $currentDate.'_'.$baseName,
                );
            $this->db->insert("tbl_barberReviewImages",$arrayData);
            }
            $data = $this->getClientSendRatingByID($lastID);
            $response = array("data"=> $data,"success" => 1, "message" => "Rating added successfully");   
        }
        else{
            $data1 = $this->getRatingToBarberByUserIDAndBarberID($userID,$barberID);
            $reviewID = $data1['id'];
            
            $this->db->where('userID',$userID);
            $this->db->where('barberID',$barberID);
            $this->db->update("tbl_customerRatingToBarber",$arrayData);
            
            $currentDate = date('dmY');
            $countfiles1 = $this->uploadedRatingSingleImages();
            if(count($countfiles1) != 0){
                /*$imagesData = $this->getCustomerRatingImages($reviewID);
                 foreach($imagesData as $imageValue){
                    unlink($this->data['imagePath'].$imageValue['images']);
                }*/
                $this->deleteatingSingleImages($reviewID);
               
            }
            $countfiles = $this->uploadedRatingSingleImages();
            foreach($countfiles as $imaageVal){
                $baseName = $imaageVal;
                $arrayData = array(
                    "reviewID" => $reviewID,
                    "images" => $currentDate.'_'.$baseName
                );
            $this->db->insert("tbl_barberReviewImages",$arrayData);
            }
            $data = $this->getRatingToBarberByUserIDAndBarberID($userID,$barberID);
            $response = array("data"=> $data,"success" => 1, "message" => "Rating updated successfully"); 
            //$response = array("data"=> NULL,"success" => 0, "message" => "You have already rate to this barber");
        }
        /*$rows  = $this->isAlreadyRatingToBarber($userID,$barberID);
        if($rows == 0){
            $ImageUploaded = $this->uploadedRatingImages();
            if($ImageUploaded['success'] == "fail"){
                $response = array("data"=>NULL,"success" => 0,"message"=>"Upload file error");
            }
            else if($ImageUploaded['success'] == "size"){
                 $response = array("data"=>NULL,"success" => 0,"message"=>"You can only upload a maximum of 3 files");
            }
            else{
                $this->db->insert("tbl_customerRatingToBarber",$arrayData);
                $lastID = $this->db->insert_id();
                $currentDate = date('dmY');
                $countfiles = $this->uploadedRatingImages();
                for($i=0;$i<$countfiles;$i++){
                    $baseName = $_FILES['uploadImages']['name'][$i];
                    $arrayData = array(
                        "reviewID" => $lastID,
                        "images" => $currentDate.'_'.$baseName
                    );
                $this->db->insert("tbl_barberReviewImages",$arrayData);
                }
                $data = $this->getClientSendRatingByID($lastID);
                $response = array("data"=> $data,"success" => 1, "message" => "Rating added successfully");   
            }
        }
        else{
            $response = array("data"=> NULL,"success" => 0, "message" => "You have already rate to this barber");
        }*/
        return $response;
    }
    public function getCustomerRatingImages($reviewID){
        $this->db->select('images');
        $this->db->from('tbl_barberReviewImages');
        $this->db->where('reviewID',$reviewID);
        $query = $this->db->get();
        //echo $this->db->last_query();
        $data = $query->result_array();
        foreach($data as $value){
            $imageName = $this->data['imagePath'].$value['images'];
            $value1[] = $imageName;
        }
        return $value1;
    }
    public function getBarberRatingAccToClient($barberID,$clientID){
        $this->db->select('rating');
        $this->db->from('tbl_customerRatingToBarber');
        $this->db->where('barberID',$barberID);
        $this->db->where('userID',$clientID);
        $this->db->where('status',1);
        $query = $this->db->get();
        $data = $query->row_array();
        /*$reviewID = $data['id'];
        $images = $this->getCustomerRatingImages($reviewID);
        foreach($images as $im){
            $imageName[] =   $this->data['imagePath'].$im['images'];
        }
        $data['images'] = $imageName;
        unset($data['id']);
        $response = $data;*/
        return $data['rating'];
    }
    public function getClientRatingAccToBarber($barberID,$clientID){
        $this->db->select('rating');
        $this->db->from('tbl_barberRatingToCustomer');
        $this->db->where('userID',$barberID);
        $this->db->where('clientID',$clientID);
        $this->db->where('status',1);
        $query = $this->db->get();
        $data = $query->row_array();
        return $data['rating'];
    }
    public function getCompleteBookingDetail($userID,$bookingID,$type){
        $this->db->select("rb.*,b.totalAmount,b.totalTip,b.totalTax,b.TotalamountDeduct");
        $this->db->where('rb.requestBookingID',$bookingID);
        if($type == 2){
            $this->db->where('rb.barberID',$userID);
        }else{
            $this->db->where('rb.userID',$userID);
        }
        $this->db->where('rb.status',2);
        $this->db->from('tbl_request_bookings  as rb');
        $this->db->join('tbl_paymentRequestByBarber as b','b.bookingID = rb.requestBookingID','left');
        $query = $this->db->get();
        $result = $query->row_array();
        if($result){
        $bookingID = $result['requestBookingID'];
        $barberID = $result['barberID'];
        $clientID = $result['userID'];
        $selectedTimeID = $result['selectedTimeID'];
        $slectedServices = $this->selectedServicesList($bookingID);
        $barberRating = $this->getBarberRatingAccToClient($barberID,$clientID);
        $result['clientToBarberRate'] = $barberRating;
        $clientRating = $this->getClientRatingAccToBarber($barberID,$clientID);
        $result['BarberToClientRate'] = $clientRating;
        $slotTime = $this->getSlotByID($selectedTimeID);
        $result['startSlot'] = $slotTime['startSlot'];
        $result['endSlot'] =   $slotTime['endSlot'];
        

        $result['services'] = $slectedServices;
        $response = $result;
        return $result;
        }
        else {
            return false;
        }
    }
    public function  getSlotByID($slotID)
    {
        $this->db->select("TRIM(LEADING 0 FROM TRIM(startSlot)) as startSlot, TRIM(LEADING 0 FROM TRIM(endSlot)) as endSlot");
        $this->db->where('id',$slotID);
        $this->db->from('tbl_slot');
        $query =  $this->db->get();
        if($query){
            $response = $query->row_array();
            return $response;
        }
        else {
            return FALSE;
        }
    }
    public function servicesTitleString($services){
        $title = implode(', ', array_map(function ($entry) {
                            return $entry['name'];
                        }, $services));
        return       $title;          
    }
    public function sumOfServices($services){
        $sum = array_map(function ($entry) {
            
               //echo $t =sum($entry['price']);
                return $entry['price'];
            }, $services);
        return  array_sum($sum);   
    }
    public function getBarberScheduledBookings($userID){
        $date  =  date("Y-m-d H:i:s");
        $todayTime1 = $_POST['todayDateTime']; 
        $createDate11 = new DateTime($todayTime1);
        $ADate22 = $createDate11->format('Y-m-d');
        $todayDate  = $ADate22;
        
         $sql = "SELECT b.*,s.status as scheStatus FROM tbl_request_bookings as b 
                LEFT JOIN tbl_statusScheduleBookingByBarber as s ON s.bookingID = b.requestBookingID
                WHERE b.barberID = $userID AND b.status = 0 AND date(b.appointmentDate) >= $todayDate AND
                 b.requestType = 'Scheduled'";

        $query =  $this->db->query($sql);
        
        if($query){
            $data = $query->result_array();
            foreach($data as $value){
                if($value['scheStatus'] == null || $value['scheStatus'] == 1){
					 $appoinmentDate = $value['appointmentDate'];  
					$createDate = new DateTime($appoinmentDate);
					$ADate = $createDate->format('Y-m-d');
					$bookingID = $value['requestBookingID'];
				    $selectedTimeID = $value['selectedTimeID'];
					$services = $this->selectedServicesList($bookingID);
					$title =  $this->servicesTitleString($services);
					$slotTime = $this->getSlotByID($selectedTimeID);
					if($ADate >= $todayDate){
						$todayTime = strtotime(trim(str_replace(" ","",$createDate11->format('h:iA'))));
						 $startTime =  strtotime(trim(str_replace(" ","",$slotTime['startSlot'])));
						 $endTime = strtotime(trim(str_replace(" ","",$slotTime['endSlot'])));
						 
						    $date1=date_create($todayDate);
							$date2=date_create($ADate);
							$diff=date_diff($date1,$date2);
							$day =  $diff->format("%a");
							
						if($day == 0 && $todayTime > $endTime){
						  //  echo "no";
						}
						else
						{
						    //echo "yes";
						//}
						   // echo $value['requestBookingID'];
							$value['title'] = $title;
							$value['startSlot'] = $slotTime['startSlot'];
							$value['endSlot'] =   $slotTime['endSlot'];
							$value['services'] = $services;
							$servicesTotal = $this->sumOfServices($services);
							 //date_diff(date_create($todayDate),date_create($ADate));
							
                            
							$createDate11->format('h:iA');
							
							if($day == 0){
								if(($startTime <= $todayTime) && ($todayTime <= $endTime)) {								   
									$value['isAcceptBooking'] = 1;
								} else {
									$value['isAcceptBooking'] = 0;             
								}
							}
							else{
							   $value['isAcceptBooking'] = 0;
							}
							$value['servicesTotalSum'] = $servicesTotal;
							$response[] = $value;
						}
					}
               
				}
			}
            return $response;
        }
        else {
            return FALSE;
        }
    }
    public function isCheckAlreadyChangeStatus($bookingID,$userID){
        $this->db->select("*");
        $this->db->where('bookingID',$bookingID);
        $this->db->where('userID',$userID);
        $this->db->from("tbl_statusScheduleBookingByBarber");
        $query = $this->db->get();
        $nums = $query->num_rows();
        return $nums;
    }
    public function postBarberScheduledBooking($userID,$bookingID,$isApproved){

        if($isApproved == 1){
            $message = "booking accept successfully";
            $status = 1;
        }
        else{
            $message = "booking reject successfully";
            $status = 0;
        }
        $arrayData = array(
            "userID" => $userID,
            "bookingID" => $bookingID,
            "status" => $status    
        );
        $rows =  $this->isCheckAlreadyChangeStatus($bookingID,$userID);
        if($rows == 0){
            $this->db->insert('tbl_statusScheduleBookingByBarber',$arrayData);
            $lastID  = $this->db->insert_id();
            if($lastID){
                if($isApproved == 1){
                    $this->db->where('requestBookingID',$bookingID);
                    $this->db->update('tbl_request_bookings',array("status"=>"1"));
                }
                //$data = $this->getCancelBookingByID($bookingID,$userID,$table);
                $response =  array("success"=> 1,"message"=> $message);
            }  
        }
        else{
            $response = array("success"=>0,"message"=>"You have already change status this booking");
        }
         return $response;
    }
    public function getClientCardDetailById($cardID){
        $this->db->select("*");
        $this->db->where('id',$cardID);
        $this->db->from("tbl_customerpaymentMethod");
        $query = $this->db->get();
        //echo $this->db->last_query();
        $row = $query->row_array();
        return $row;
    }
    
    /*
    getAllCompleteBookingHistory
    bookingID,Date,TotalAmount,ServicesTitle
    */
    public function getAllCompleteBookingHistory($userID){
        $this->db->select("py.id,py.bookingID,py.totalAmount,py.TotalamountDeduct,py.date,b.requestType,b.status");
        $this->db->where('py.clientID',$userID);
        $this->db->where('py.clientStatus',3);
        $this->db->where('b.status',2);
        $this->db->order_by('py.id','desc');
        $this->db->from('tbl_paymentRequestByBarber  as py');
        $this->db->join('tbl_request_bookings as b','b.requestBookingID = py.bookingID','left');
        $query = $this->db->get();
       //echo $this->db->last_query();
        $result = $query->result_array();
        foreach($result as $value){
            if($value){
                $bookingID = $value['bookingID'];
                $slectedServices = $this->selectedServicesList($bookingID);
                $title =  $this->servicesTitleString($slectedServices);
                $value['title'] = $title;
                $value['services'] = $slectedServices;
                $response[] = $value;
            }
        }
        
        return $response;
    }
     /*
    getTodayCompleteBookingHistory
    bookingID,Date,TotalAmount,ServicesTitle

    */
    public function getTodayCompleteBookingHistory($userID,$currentDate){
       
        $this->db->select("py.id,py.bookingID,py.totalAmount,py.totalTax,py.TotalamountDeduct,py.totalTip,py.date,b.requestType,b.status");
        $this->db->where('py.userID',$userID);
        $this->db->where('b.barberStatus',4);
        $this->db->where('b.clientStatus',3);
        $this->db->where('b.status',2);
        $this->db->where('date(date)', $currentDate);
         $this->db->order_by('py.id','desc');
        $this->db->from('tbl_paymentRequestByBarber  as py');
        $this->db->join('tbl_request_bookings as b','b.requestBookingID = py.bookingID','left');
        
        $query = $this->db->get();
       //echo $this->db->last_query();
        $result = $query->result_array();
        foreach($result as $value){
            if($value){
                $bookingID = $value['bookingID'];
                $slectedServices = $this->selectedServicesList($bookingID);
                $title =  $this->servicesTitleString($slectedServices);
                $value['title'] = $title;
                $value['services'] = $slectedServices;
                $response[] = $value;
            }
        }
        
        return $response;
    }
    
    
    public function totalRatingOfClient($userID){
        $this->db->select("AVG(rating) as rating");
        $this->db->where('clientID',$userID);
        $this->db->from('tbl_barberRatingToCustomer');
        $query = $this->db->get();
        return  $query->row_array();
    }
    public function totalBookings($userID,$userType){
        $this->db->select("count(requestBookingID) as total");
        if($userType == 2){
            $this->db->where('barberID',$userID);
        }
        else{
            $this->db->where('userID',$userID);
        }
        $this->db->from('tbl_request_bookings');
        $query = $this->db->get();
        $data =   $query->row_array();

        
        $cancelBooking = $this->totalCancelBookings($userID,$userType);
        $cancelPercentage = $cancelBooking['cancel'] == 0 ? 0 : ($cancelBooking['cancel']/$data['total'])*100;  
        $data1['cancel'] = $cancelPercentage;
        $acceptBooking = $this->totalAcceptlBookings($userID,$userType);
         
        $acceptPercentage = $acceptBooking['accept'] == 0 ? 0 :($acceptBooking['accept']/$data['total'])*100;  
        
        $data1['accept'] = $acceptPercentage;
        $data1['total'] = $data['total'];
        
        return $data1;
    }
    public function totalCancelBookings($userID,$userType){
        $this->db->select("count(requestBookingID) as cancel");
        if($userType == 2){
            $this->db->where('barberID',$userID);
        }
        else{
            $this->db->where('userID',$userID);
        }
        $this->db->where('status',3);
        $this->db->from('tbl_request_bookings');
        
        $query = $this->db->get();

        $data =   $query->row_array();
        
        return $data;
    }
        
    public function totalAcceptlBookings($userID,$userType){
        $this->db->select("count(requestBookingID) as accept");
        $this->db->where('barberID',$userID);
        if($userType == 2){
            $this->db->where('barberID',$userID);
        }
         $this->db->where('status',2);
        $this->db->from('tbl_request_bookings');
        $query = $this->db->get();
        $data =  $query->row_array();
        return $data;
    }
    
     /*public function totalEarningOfBarber($userID){

        $this->db->select("AVG(TotalamountDeduct) as totalEarning");
        $this->db->where('userID',$userID);
        $this->db->where('clientStatus',3);
        $this->db->from('tbl_paymentRequestByBarber');
        $query = $this->db->get();
        return  $query->row_array();
    }*/
    
    
    public function average($data,$col){
       // print_r($data);
        $max = 0;
        $countData  = count($data);
        foreach ($data as $rate => $count) { 
             $max = $max+$count[$col];
        }
        return number_format($max / $countData,2);
    }
     /*Start barberReviewList API*/  
    public function GetAverageData($userID,$userType,$deviceToken){
       // echo  $userID;
        $this->db->where('id',$userID);
        $this->db->update('tbl_users',array("deviceToken"=>$deviceToken));
        if($userType == 2){
            $res = $this->totalBookings($userID,2);
           // print_r($res);
            $date = date('Y-m-d');
            //$acceptBooking = $this->totalAcceptlBookings($userID);
            $barberRatingData = $this->barberReviewListData($userID);
            //$cancelBooking = $this->totalCancelBookings($userID,$userType);
            //$totalEarning = $this->totalEarningOfBarber($userID);
            $result = $this->getTodayBookingEarningsHistory($userID,$date);
            //print_r($result);
            
            $data['Rating'] = $barberRatingData ? $this->average($barberRatingData,'rating') : 0; 
            $data['Acceptance'] = $res ? number_format($res['accept'],2)."%" : 0; 
            $data['Cancellation'] = $res ? number_format($res['cancel'],2)."%" : 0;
            $data['TodayEarning'] = $result ? $result['TotalAmountEarnByBarber'] : 0;
            $data['TodayDate'] = $date;
        }
        else{
            $res = $this->totalBookings($userID,3);
            $clientRatingData =  $this->totalRatingOfClient($userID);
           // $cancelBooking = $this->totalCancelBookings($userID,$userType);
            
            $data['Cancellation'] = $res ? number_format($res['cancel'],2)."%" : 0;
            $data['Rating'] =$clientRatingData ?  number_format($clientRatingData['rating'],2) : 0; 
        }
        
        return $data;
    }
  //  public function currentPlan
    public function getTodayBookingEarningsHistory($userID,$currentDate){
       // echo $userID;
        //$currentDate = date('Y-m-d');
       // echo date_default_timezone_set("Asia/Calcutta");
        //echo $currentDate = date('Y-m-d h:i:sA');
        $data = $this->getTodayCompleteBookingHistory($userID,$currentDate);
        //print_r($data);
        $percent = $this->getPlanPercentByid($userID);
        $fee = $percent['adminPercent'];
        if($data){
            foreach($data as $value){
              //  echo $value['bookingID'];
             //   echo "<br>";
                $totalAmount += $value['totalAmount'];
                $TotalamountDeduct += $value['TotalamountDeduct'];
                $totalTip  += $value['totalTip'];
                $totalTax  += $value['totalTax'];
                $totalServices += count($value['bookingID']);
                $t = $value['totalAmount'] + $value['totalTax'];
                $new_fee = ($fee / 100) * $t ;
                $totalFee = $value['totalAmount'] - $new_fee;
                $TotalAmountEarnByBarber += ((($value['totalAmount'] + $value['totalTax']) - $new_fee) + $value['totalTip']);
                //$TotalAmountEarnByBarber += ($value['totalAmount'] + $value['totalTip'] - $new_fee);
                $APPFee  += $new_fee;
            }
            //echo (76/190)*100;
            // $a = ''
            $onlinehrs = $this->calculateOnlineHours();
            $ifNotOnlinehrs = $onlinehrs ? $onlinehrs : '00:00';
            $response['TotalServicesAmount'] = $totalAmount ? number_format($totalAmount,2) : "0.00";
            $response['TotalTip'] = number_format($totalTip,2);
            $response['TotalTax'] = number_format($totalTax,2);
            $response['TotalamountDeductByClient'] = number_format($TotalamountDeduct,2);
            $response['TotalBooking'] = $totalServices;
            $response['date'] = date('Y-m-d');
            $response['TotalOnlineHrs'] = $ifNotOnlinehrs;
            $response['TotalAmountEarnByBarber'] = number_format($TotalAmountEarnByBarber,2);
            $response['TotalAppFee'] = number_format($APPFee,2);
            $response['barberPlan'] = $percent['subTitle'];
            return $response;
        }
        else {
            return false;
       }
       
    }
    public function getPlanPercentByid($userID){
        $this->db->select('subscriptionList.percent,subscriptionList.subTitle,subscriptionList.adminPercent');
        $this->db->from('tbl_plan');
        $this->db->where('tbl_plan.userID',$userID);
        $this->db->where('tbl_plan.planStatus',1);
        $this->db->join('subscriptionList','subscriptionList.id = tbl_plan.planID','left');
        $query=$this->db->get();
        //echo $this->db->last_query();
        $userResult=$query->row_array();
        //print_r($userResult);
        return $userResult;
    } 
    public function calculateOnlineHours(){
     //   echo $date2 = strtotime(date("Y-m-d h:i:sA"));
        $startTime = strtotime("08:00AM");
        $endTime = strtotime("05:00PM");
        $todayTime =  strtotime(date('h:iA'));
        $todayLastTime = strtotime('11:59PM');
        if(($startTime <= $todayTime) && ($todayTime <= $endTime)) {
            
            $startdate = date('Y-m-d 8:00:00A');
            $enddate = date('Y-m-d h:i:sA');
            
        	$starttimestamp = strtotime($startdate);
        	$endtimestamp = strtotime($enddate);
        	
        //	 $date1 = strtotime(date("Y-m-d 08:00:00A"));  
           //  $date2 = strtotime(date("Y-m-d h:i:sA"));  
        	
        	 $diff = abs($endtimestamp - $starttimestamp);  
  
  

            $years = floor($diff / (365*60*60*24));  
            $months = floor(($diff - $years * 365*60*60*24) 
                               / (30*60*60*24)); 
  
            $days = floor(($diff - $years * 365*60*60*24 -  
             $months*30*60*60*24)/ (60*60*24));
             
            $hours = floor(($diff - $years * 365*60*60*24  
                - $months*30*60*60*24 - $days*60*60*24) 
                                   / (60*60));  
  
            $minutes = floor(($diff - $years * 365*60*60*24  
                     - $months*30*60*60*24 - $days*60*60*24  
                                      - $hours*60*60)/ 60);  
  
              //$hours
             $difference =  $hours.':'.$minutes;
           /*  $datetime1 = new DateTime(date('Y-m-d 8:00:00A'));
            $datetime2 = new DateTime(date('Y-m-d h:i:sA'));
            $interval = $datetime1->diff($datetime2);
           echo $interval->format('%h')." Hours ".$interval->format('%i')." Minutes";*/
            //echo number_format(abs($endtimestamp - $starttimestamp)/3600,2);
        	//$difference = number_format(abs($endtimestamp - $starttimestamp)/3600,2);
        }
       else if(($endTime <= $todayTime) && ($todayTime <= $todayLastTime)){
            $difference =  "9:00";
        }
        else{
            $difference =  "0";
        }
        return $difference;
    }
    
    
    /*
    getWeeklyBookingEarningsHistory
    parameter (token)
    TotalBooking
    TotalOnlineHrs(currentTime - week start day Monday 8am )
    TotalServicesAmount
    TotalTip
    TotalTax
    TotalAppFee
    TotalAmountEarnByBarber(TotalServicesAmount + TotalTip - TotalAppFee)
    DayWiseMondayToSunday - object
    [{dayID 1 - 7(M to S),
    ToatalDayEarningByBarber(Per day Calculation)}]
    */
    public function getWeeklyBookingEarningsHistory($userID){
       //echo $userID;
       $date  =  date('Y-m-d');
        $sql = "SELECT `py`.`bookingID`, `py`.`totalAmount`, `py`.`totalTax`, `py`.`TotalamountDeduct`, `py`.`totalTip`, `py`.`date`, `b`.`requestType`, `b`.`status`
            FROM `tbl_paymentRequestByBarber` as `py`
            LEFT JOIN `tbl_request_bookings` as `b` ON `b`.`requestBookingID` = `py`.`bookingID`
            WHERE `py`.`userID` = '$userID'
            AND `b`.`barberStatus` = 4
            AND `b`.`clientStatus` = 3
            AND `b`.`status` = 2
            AND YEARWEEK(py.date,1) = YEARWEEK('$date', 1)";
            
        $data = $this->db->query($sql)->result_array();
        $percent = $this->getPlanPercentByid($userID);
        $fee = $percent['adminPercent'];
        if($data){
            foreach($data as $value){
                $Date = $value['date'];  
                $createDate = new DateTime($Date);
                $date = $createDate->format('Y-m-d');
                $totalAmount += $value['totalAmount'];
                $TotalamountDeduct += $value['TotalamountDeduct'];
                $totalTip  += $value['totalTip'];
                $totalTax  += $value['totalTax'];
                $totalServices += count($value['bookingID']);
                //$new_fee = ($fee / 100) * $value['totalAmount'];
                $t = $value['totalAmount'] + $value['totalTax'];
                $new_fee = ($fee / 100) * $t ;
               // $totalFee = $value['totalAmount'] - $new_fee;
                $TotalAmountEarnByBarber += ((($value['totalAmount'] + $value['totalTax']) - $new_fee) + $value['totalTip']);
                //$TotalAmountEarnByBarber += ($value['totalAmount'] + $value['totalTip'] - $new_fee);
                $APPFee  += $new_fee;
               // $totalFee = $value['totalAmount'] - $new_fee;
               // $TotalAmountEarnByBarber += ($value['totalAmount'] + $value['totalTip'] - $new_fee);
               // $APPFee  += $new_fee;
        }  
      
            $response['TotalServicesAmount'] = number_format($totalAmount,2);
            $response['TotalTip'] = number_format($totalTip,2);
            $response['TotalTax'] = number_format($totalTax,2);
            $response['TotalamountDeductByClient'] = number_format($TotalamountDeduct,2);
            $response['TotalBooking'] = $totalServices;
            


            
            $response['date'] = $date;
            $response['TotalOnlineHrs'] = $this->weeklyTimeCount();
            $response['TotalAmountEarnByBarber'] = number_format($TotalAmountEarnByBarber,2);
            $response['TotalAppFee'] = number_format($APPFee,2);
            $response['barberPlan'] = $percent['subTitle'];
            $dataArray = $this->daysArray($userID);
            $response['ToatalDayEarningByBarber'] = $dataArray;
            
            

            return $response;
        }
        else {
            return false;
       }
        
        //return $response;
    }
    public function weeklyTimeCount(){
        $date = date('y-m-d');
        $dayOfWeek = date("w", strtotime($date));
        $wTime = ($dayOfWeek-1)*9;
        $todayTime =  $this->calculateOnlineHours();
        $timeExect = explode(':',$todayTime);
        //$lastTime = $timeExect[1] ? $timeExect[1] : '00';
        $weekTime  = $wTime+$timeExect[0];
        //$tWeekTime = $weekTime ? $weekTime : '00';
        return $weekTime.':'.$timeExect[1];
    }
    public function daysArray($userID){
        $monday = strtotime("last monday");
        $monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
        $tue = strtotime(date("Y-m-d",$monday)." +1 days");
        $wed = strtotime(date("Y-m-d",$monday)." +2 days");
        $thr = strtotime(date("Y-m-d",$monday)." +3 days");
        $fri = strtotime(date("Y-m-d",$monday)." +4 days");
        $sat = strtotime(date("Y-m-d",$monday)." +5 days");
        $sunday = strtotime(date("Y-m-d",$monday)." +6 days");
        $array = array($monday,$tue,$wed,$thr,$fri,$sat,$sunday);
        foreach($array as $vl){
            $date =  date('Y-m-d',$vl);
            $day_numeric = date('w',$vl);
            $day_text = date('D',$vl);
            $todayDate = $this->getTodayBookingEarningsHistory($userID,$date);
            $dataArray[] = array("dayID"=>$day_numeric,"dayName"=>$day_text,"ToatalDayEarningByBarber"=>$todayDate['TotalAmountEarnByBarber']);
        }
        return $dataArray;
    }
    public function addNotification($barberID,$clientID,$BookingID,$type,$title,$message){
        $data = array(
            "barberID" => $barberID,
            "clientID" => $clientID,
            "NotificationBookingID" => $BookingID,
            "NotificationType" => $type,
            "NotificationTitle" => $title,
            "NotificationDescription" => $message,
            "status" => 1,
            "NotificationDate" =>  date("Y-m-d H:i:s")
        );
        if($this->db->insert("tbl_notification",$data)){
           // echo $this->db->last_query();
            return true;
        } 
        else {
            return false;
        }
        
    }
    public function getClientDetailByID($bookingID){
        $this->db->select("b.userID,u.firstName,u.lastName,b.barberID,u.deviceToken,b.requestType,b.selectedTimeID,b.appointmentDate,u.deviceType");
        $this->db->where("b.requestBookingID",$bookingID);
        $this->db->from("tbl_request_bookings as b");
        $this->db->join("tbl_users as u","u.id = b.userID","left");
        $query = $this->db->get();
        $data = $query->row_array();
        return $data;
    }
    public function getBarberDetailByID($bookingID){
        $this->db->select("b.userID,u.firstName,u.lastName,b.barberID,u.deviceToken,b.requestType,u.deviceType");
        $this->db->where("b.requestBookingID",$bookingID);
        $this->db->from("tbl_request_bookings as b");
        $this->db->join("tbl_users as u","u.id = b.barberID","left");
        $query = $this->db->get();
        $data = $query->row_array();
        return $data;
    }
    public function getNotificationData($userID,$userType){
       
        $this->db->select("*");
        if($userType == 2){
           $this->db->where("barberID",$userID); 
        }
        else{
            $this->db->where("clientID",$userID);
        }
        //$this->db-("id",'desc');
        $this->db->order_by("notificationID",'desc');
        $this->db->from("tbl_notification");
        $query = $this->db->get();
       // echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }
    public function getPage($type){
        $this->db->select("*");
        $this->db->where("type",$type); 
        $this->db->from("tbl_page");
        $query = $this->db->get();
        $data = $query->row_array();
        return $data;
    }
    public function getMessageByID($lastID){
        $this->db->select('c.*,u.userProfile');
        $this->db->where('c.id',$lastID);
        $this->db->from('tbl_chat as c');
        $this->db->join("tbl_users as u","u.id = c.senderID","left");
        $query = $this->db->get();
        return $query->row_array();
    }
    public function postMessagesforBooking($userID,$userType,$receiverID,$bookingID){
    
        $message = $_POST['message'];
        $arrayData = array(
            "bookingID" => $bookingID,
            "senderID" => $userID,
            "receiverID" => $receiverID,  
            "message" => $message,
            "type" => $userType,
            "status"  => 1,
            "created_date" => date("Y-m-d H:i:s"),
        );
        $this->db->insert('tbl_chat',$arrayData);
        $lastID = $this->db->insert_id();
        $data = $this->getMessageByID($lastID);
        return $data;
    }
    public function allgetChatCoversation($bookingID){
        $sql = "SELECT c.* FROM tbl_chat as c  WHERE bookingID = $bookingID ";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    public function getChatCoversation($bookingID){
        $pageNo = $_POST['pageNo']  * $_POST['pageSize'];
        $pageSize = $_POST['pageSize'] + $pageNo;
        $sql = "SELECT c.*,u.userProfile FROM tbl_chat as c LEFT JOIN tbl_users as u ON u.id = c.senderID
        WHERE bookingID = $bookingID ORDER BY id DESC LIMIT $pageNo,$pageSize";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    public function ifAlreadyCancel($bookingID){
        $this->db->select("b.requestBookingID,b.status");
        $this->db->where("b.requestBookingID",$bookingID);
        $this->db->where("b.status",3);
        $this->db->from("tbl_request_bookings as b");
        $query = $this->db->get();
        $data = $query->row_array();
        return $data;
    }
    public function ifAlreadyAccept($barberID){
        $this->db->select("b.requestBookingID,b.status");
        $this->db->where("b.barberID",$barberID);
        $this->db->where("b.status",1);
        $this->db->from("tbl_request_bookings as b");
        $query = $this->db->get();
        //echo $this->db->last_query();
        $data = $query->row_array();
        return $data;
    }
    /*public function CURL($url,$payload)
    {   
        $headers = array
		(
			'Authorization: '.$this->config->item('checkrAuth'),
			'Content-Type: application/json'
		);
        $data_string = json_encode($payload);
		$method = $payload == "" ? "GET" : "POST";
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		//curl_setopt($ch, CURLOPT_HTTPGET, 1);
		$payload && curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);     
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        $output = curl_exec($ch);
		$resultsArray=json_decode($output);
        return $resultsArray;
    }*/
    public function getAddressOfBarberByLatAndLongAPI($lat,$long){
        $geocode =   $this->data['geocodeURL'];
        $key =   $this->data['key'];
       // $url = $geocode.$lat.','.$long.'&key='.$key;
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=30.7363,76.7688133&key=AIzaSyA6Xti-C9Mz4BKQDDk9mJCfvpB8a1BI0jk';
        $json = @file_get_contents($url);
        $data=json_decode($json);
        $status = $data->status;
        $result = $data->results[0];
        $components = $result->address_components;
        foreach ($components as $key) {  
            $street[] =  ($key->types[0] == 'street_number') ?  $key->long_name : "" ;
            $route[]  = ($key->types[0] == 'route') ?  $key->long_name : "" ;
            $city[] =  ($key->types[2] == 'sublocality_level_1') ?  $key->short_name : "" ;
            $state[] =  ($key->types[0] == 'administrative_area_level_1') ?  $key->short_name : "" ;
            $country[] =  ($key->types[0] == 'country') ?  $key->short_name : "";
            $postalCode[] =  ($key->types[0] == 'postal_code') ?  $key->long_name : "" ;
        }  
            $address  = array_merge(array_filter($street),array_filter($route),array_filter($city),array_filter($state),array_filter($country),array_filter($postalCode));
            return $address;
        }
    public function CURL($url,$payload)
    {   
        $headers = array
		(
			'Authorization: '.$this->config->item('checkrAuth'),
			'Content-Type: application/json'
		);
        $data_string = json_encode($payload);
		$method = $payload == "" ? "GET" : "POST";
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		//curl_setopt($ch, CURLOPT_HTTPGET, 1);
		$payload && curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);     
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        $output = curl_exec($ch);
		$resultsArray=json_decode($output);
        return $resultsArray;
    }
}
?>




