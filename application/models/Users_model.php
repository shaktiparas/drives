<?php
class Users_model extends CI_model{
    
  public function __construct() {
      
        parent::__construct();
          $this->data = array(
            'geocodeURL' => $this->config->item('geocode_url'),
            'key' =>  $this->config->item('api_key'),
            'imagePath' => '/uploads/barberRatingImages/',
            'amountSign' => '$'
        );
        $this->load->helper('date');
    } 
    
  public function checkExistEmail($email){
        $this->db->select('id');
        $this->db->from('users');
        $this->db->where('Email',$email);
       
       
        $query=$this->db->get();
        if($query->num_rows()>0){
          return false;
        }else{
          return true;
        }
  }
  
  public function checkPassword($userID,$password){
        $this->db->select('users.id');
        $this->db->from('users');
        $this->db->where('id',$userID);
        $this->db->where('password',md5($password));
       
       
        $query=$this->db->get();
        if($query->num_rows()>0){
          return true;
        }else{
          return false;
        }
  }
  
  
  /* RETURN USER DETAIL BY CHECKING ID */
    public function userDetailByid($id){
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('id',$id);
     
        $query=$this->db->get();
        $userResult=$query->row_array();
        return $userResult;
    }
    
    
     /* RETURN USER DETAIL BY CHECKING ID */
    public function userDetailByid1($id){
        $this->db->select('users.Username, users.FirstName, users.LastName, users.PhoneNumber,
			users.Username, users.Address, users`.`Image');
        $this->db->from('users');
        $this->db->where('id',$id);
     
        $query=$this->db->get();
        $userResult=$query->row_array();
        return $userResult;
    }
    
    /* RETURN USER PROFILE DETAIL & SUBSCRIPTION PLAN AND PACKAGE BY CHECKING ID */
    
    public function userProfileDetailByid($id)
    {
        $this->db->select('users.id,users.social_id,users.email,users.phone_number,users.device_type,users.social_type,users.status,users.image,users.firebasetoken,
        users.latitude,users.longitude,users.NotificationStatus,users.points,users.user_created_date,user_subscription_plans.planID,user_subscription_plans.packageID');
        $this->db->from('users');
        $this->db->where('users.id',$id);
        $this->db->join('user_subscription_plans','user_subscription_plans.userID = users.id');
        $query=$this->db->get();
        $userResult=$query->row_array();
        return $userResult;
        
        
    }
    
  
  
    /*SAVE USER DETAIL*/
    public function register($FirstName,$LastName,$City,$PhoneNumber,$Username,$Password,$Email,$Gender,$Address,$DOB,$SSN,$DL_ISSUE_DATE,$DL_EXPIRE_DATE,$DL_backendImage,$DL_frontImage,$images,$device_type,$firebasetoken,$latitude,$longitude,$user_type,$EmailSendStatus,$SmsSendStatus){
       
        $data = array(
        'FirstName'           =>  $FirstName,
        'LastName'           =>  $LastName,
        'City'              =>  $City,
        'PhoneNumber'           =>  $PhoneNumber,
        'Username'                  =>  $Username,
        'Password'         =>  md5($Password),
        'Email'         => $Email,
        'Gender'       => $Gender,
        'Address'       => $Address,
        'State'       => '',
        'Zipcode'       => '',
        'DOB'          => $DOB,
        'SSN'          => $SSN,
        'DL_ISSUE_DATE' => $DL_ISSUE_DATE,
        'DL_EXPIRE_DATE' => $DL_EXPIRE_DATE,
        'DL_FrontImage' => $DL_backendImage,
        'DL_BackendImage'=> $DL_frontImage,
        'Image' => $images,
        'device_type'              => $device_type,
        'firebasetoken'              => $firebasetoken,
        'latitude' => $latitude,
        'longitude' => $longitude,
        'userType' => $user_type,
        'EmailSendStatus'    => $EmailSendStatus,
        'SmsSendStatus' => $SmsSendStatus,
        'NotificationStatus'=> 1,
        'addedDate'    =>  date("Y-m-d H:i:s")
        );
        $this->db->insert('users', $data);
        $userId= $this->db->insert_id();
        $userData=$this->Users_model->userDetailByid($userId);
        return $userData;
    }
    
    
  
  
   public function userLoginByEmail($email,$password,$userType){
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('Email',$email);
        $this->db->where('Password', md5($password));
        $this->db->where('userType', $userType);
      
        if($query=$this->db->get())
        { 
            $data =  $query->row_array();
            if($data)
            {
             return $data;
            }
            else
            {
                return false;
            }
        }
        else{
            return false;
        }
    }
    
    
   public function updateLoginToken($userid,$latitude,$longitude,$device_type,$firebasetoken){
        $accountStatus=array( 
            'latitude'=>$latitude,
            'longitude'=>$longitude,
            'device_type' => $device_type,
            'firebasetoken'=>$firebasetoken
            ); 
          $this->db->where('id', $userid);
          $this->db->update('users', $accountStatus);
          if($query=$this->db->affected_rows())
        {
          return true;
        }
        else
        {
            return false;
        }
   }
   
    
   public function ChangeNotificationStatus($userid,$status){
        $accountStatus=array( 
            'NotificationStatus'=>$status
            ); 
          $this->db->where('id', $userid);
          $this->db->update('users', $accountStatus);
          
          $this->db->trans_complete();
          if($query=$this->db->affected_rows())
        {
          return true;
        }
        else
        {
            if ($this->db->trans_status() === FALSE)
            {
        return false;
             }
             else
             {
            return true;
             }
        }
          
          
          /*if($query=$this->db->affected_rows())
        {
          return true;
        }
        else
        {
            return false;
        }*/
   }
   
   public function updateProfilePic($userid,$image){
        $accountStatus=array( 
            'image'=>$image
            ); 
          $this->db->where('id', $userid);
          $this->db->update('users', $accountStatus);
          if($query=$this->db->affected_rows())
        {
          return true;
        }
        else
        {
            return false;
        }
   }
   
    public function ShowStaticContent(){
     $this->db->select('*');
    $this->db->from('static_content');

    if($query=$this->db->get())
    { 
      return $query->row_array();
    }
    else{
      return false;
    } 
      
  }
  
   
   public function getUserProfileInfo($userid){
     $this->db->select('*');
    $this->db->from('users');
    $this->db->where('id',$userid);

    if($query=$this->db->get())
    { 
      return $query->row_array();
    }
    else{
      return false;
    } 
      
  }
  
  
   public function updatePassword($email,$password){
        $accountStatus=array( 
            'Password'=>md5($password),
            ); 
          $this->db->where('Email', $email);
          $this->db->update('users', $accountStatus);
          if($query=$this->db->affected_rows())
        {
          return true;
        }
        else
        {
            return false;
        }
   }

    
   public function updatePasswordByUserID($userid,$password){
        $accountStatus=array( 
            'password'=>md5($password),
            ); 
          $this->db->where('id', $userid);
          $this->db->update('users', $accountStatus);
          
         
          if($query=$this->db->affected_rows())
        {
          return true;
        }
        else
        {
            return false;
        }
   }


    
    /*SAVE CAR DETAIL*/
    public function add_car($vehicleType,$carType,$Model,$Color,$Brand,$Mileage,$Seater,$Year,$Price,$address,$Description,$userID){
       
        $data = array(
        'vehicleType'           =>  $vehicleType,
        'carType'           =>  $carType,
        'Model'              =>  $Model,
        'Color'           => $Color,
        'Brand'           => $Brand,
        'Mileage'         => $Mileage,
        'Seater'         => $Seater,
        'Year'           =>  $Year,
        'Price'         =>  $Price,
        'address'         =>  $address,
        'Description'         => $Description,
        'userID'              => $userID,
        'addedDate'    =>  date("Y-m-d H:i:s")
        );
        if($this->db->insert('Cars', $data))
        {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        else
        {
            return false;
        }
        
        
    }
    
     /*EDIT CAR DETAIL*/
    public function EditCar($vehicleType,$carType,$Model,$Color,$Brand,$Mileage,$Seater,$Year,$Price,$Address,$Description,$userID,$carID){
       
       $data = array(
        'vehicleType'           =>  $vehicleType,
        'carType'           =>  $carType,
        'Model'              =>  $Model,
        'Color'           => $Color,
        'Brand'           => $Brand,
         'Mileage'         => $Mileage,
        'Seater'         => $Seater,
        'Year'                  =>  $Year,
        'Price'         =>  $Price,
        'address'         =>  $Address,
        'Description'         => $Description,
        'addedDate'    =>  date("Y-m-d H:i:s")
        );
     
        
        
          $this->db->where('carID', $carID);
          $this->db->update('Cars', $data);
          $this->db->trans_complete();
          if($query=$this->db->affected_rows())
        {
          return true;
        }
        else
        {
            if ($this->db->trans_status() === FALSE)
            {
        return false;
             }
             else
             {
            return true;
             }
        }
        
        
    }
    
    
    /*Add car images*/
    public function add_car_image($imageName,$carID){
       
        $data = array(
        'name'           =>  $imageName,
        'carID'           =>  $carID
        );
        
        $this->db->select('imageID');
        $this->db->from('CarImages');
        $this->db->where('name',$imageName);
        $this->db->where('carID',$carID);
       
        $query=$this->db->get();
        if($query->num_rows()>0){
           return true;
        }
        else{
           if($this->db->insert('CarImages', $data))
        {
           return true;
        }
        else
        {
            return false;
        }
          
        }
        
        
      
        
        
    }
    
  
   /*SAVE Test Drive*/
    public function BookTestDrive($carID,$userID,$TestDriveDate,$TestDriveTime,$Name,$Phone,$Location,$TestDriveRequestType,$currDate){
       
        $data = array(
        'carID'           =>  $carID,
        'userID'           =>  $userID,
        'TestDriveDate'              =>  $TestDriveDate,
        'TestDriveTime'           => $TestDriveTime,
        'Name'                  =>  $Name,
        'Phone'         =>  $Phone,
        'Location'         => $Location,
        'TestDriveStatus'  => 'Pending',
        'TestDriveRequestType' => $TestDriveRequestType,
        'CarPaymentStatus'   => 'Pending',
        'DescriptionAddedBySeller'=>'',
        'addedDate'    =>  $currDate
        );
        if($this->db->insert('TestDriveRequestCars', $data))
        {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        else
        {
            return false;
        }
        
        
    }
    
    
     /*SAVE car on rent*/
    public function BookCarOnRent($userID,$carID,$FromDate,$ToDate,$FromTime,$ToTime,$IsDeliveryMyPlace,$IsPickupAfterUse,$totalAmount,$DeliveryCost,$pickupCost,$PerDayCost,$TotalDays,$FuelCostsTotal,$CleaningCostTotal,$ReservationFeeTotal,$currdate)
    {
       
        $data = array(
        'userID'           =>  $userID,
        'carID'           =>  $carID,
        'FromDate'              =>  $FromDate,
        'ToDate'           => $ToDate,
        'FromTime'       =>  $FromTime,
        'ToTime'         =>  $ToTime,
        'FromDateWithTime' => $FromDate." ".$FromTime,
        'ToDateWithTime' => $ToDate." ".$ToTime,
        'IsDeliveryMyPlace' => $IsDeliveryMyPlace,
        'IsPickupAfterUse' => $IsPickupAfterUse,
        'RentRequestSellerStatus' => 'Pending',
        'RentRequestBuyerCancelStatus' => 0,
        'PaymentStatus' => 'Pending',
        'totalAmount' => $totalAmount,
        'DeliveryCost' => $DeliveryCost,
        'pickupCost' => $pickupCost,
        'PerDayCost' => $PerDayCost,
        'TotalDays' => $TotalDays,
        'FuelCostsTotal' => $FuelCostsTotal,
        'CleaningCostTotal' => $CleaningCostTotal,
        'ReservationFeeTotal' => $ReservationFeeTotal,
        'RentRequestDate'    =>  $currdate
        );
        if($this->db->insert('RentRequestCars', $data))
        {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        else
        {
            return false;
        }
        
        
    }
    
    
    
    /*RETURN CAR OF USER */
    public function CarsListing($user_id){
        $this->db->select('Cars.*,users.Username');
        $this->db->from('Cars');
        $this->db->join('users','users.id=Cars.userID','Left');
        $query=$this->db->get();
        $userResult=$query->result_array();
      
        foreach($userResult as $value)
		{
			$carID = $value['carID'];
			$imagesData = $this->CheckCar_Is_RTO($carID);
		    if($imagesData){
		        $value['carTypeStatus'] = "RTO";
		        $value['RTO_STATUS'] = $imagesData['Status'];
		    }
		    else
		    {
		         $value['carTypeStatus'] = $value['carType'];
		    }
 			$response[]=$value;
		}
        return $response;
       
    }
    
    
    public function CheckCar_Is_RTO($carID){
        $this->db->select('ID,Status');
        $this->db->from('TestDriveRequestCars');
        $this->db->where('carID',$carID);
       
       
        $query=$this->db->get();
        if($query->num_rows()>0){
          return $query->row_array();
        }else{
          return false;
        }
  }
    
    
    /*RETURN Selling CAR OF USER */
    public function CarsBuyingListing($userID){
        $this->db->select('Cars.*,users.Username,users.PhoneNumber,users.Image,users.Address,users.FirstName,users.LastName');
        $this->db->from('Cars');
        $this->db->where('Cars.carType','Sell');
        //$this->db->where("carID NOT IN (select carID from TestDriveRequestCars where CarPaymentStatus='Completed')");
        $this->db->where("carID NOT IN (select carID from TestDriveRequestCars where isBuyerInterested='1')");
        $this->db->join('users','users.id=Cars.userID','Left');
        $this->db->order_by("Cars.carID", "desc");
       
     
        $query=$this->db->get();
         
        $userResult=$query->result_array();
         foreach($userResult as $value)
		{
			$carID = $value['carID'];
			$checkFavourite=$this->CarIsFavourite($carID,$userID);
			$checkBookingRequest=$this->IsBookingRequestAccepted($carID,$userID);
			 if($checkFavourite)
             {
                 $value['favoriteStatus'] = 1;
             }
             else
             {
                  $value['favoriteStatus'] = 0;
             }
             
             if($checkBookingRequest)
             {
                 $value['ShowSellerInfoStatus'] = 1;
             }
             else
             {
                  $value['ShowSellerInfoStatus'] = 0;
             }
             
			$imagesData = $this->CarImages($carID);
		    if($imagesData){
		        $value['images'] = $imagesData;
		       
		    }
		    else
		    {
		         $value['images'] = [];
		    }
		    
		    
		    // ADD RATING ARRAY
		     
		    $RatingData = $this->CarRating($carID);
		    if($RatingData){
		        $value['Rating'] = $RatingData;
		       
		    }
		    else
		    {
		         $value['Rating'] = [];
		    }
		    
		     $value['distance']=6;
 			$response[]=$value;
		}
        
        return $response;
       
       
    }
    
    
    
    
    
    
    
      /*RETURN Selling CAR OF USER */
    public function CarListingBuyingRTO_V1($userID){
        $this->db->select('Cars.*,users.Username,users.PhoneNumber,users.Image,users.Address,users.FirstName,users.LastName');
        $this->db->from('Cars');
        $this->db->where('Cars.carType','Sell');
        $this->db->where("carID NOT IN (select carID from TestDriveRequestCars where CarPaymentStatus='Completed')");
        $this->db->join('users','users.id=Cars.userID','Left');
        $this->db->order_by("Cars.carID", "desc");
       
     
        $query=$this->db->get();
         
        $userResult=$query->result_array();
         foreach($userResult as $value)
		{
			$carID = $value['carID'];
			$checkFavourite=$this->CarIsFavourite($carID,$userID);
			$checkBookingRequest=$this->IsBookingRequestAccepted($carID,$userID);
			 if($checkFavourite)
             {
                 $value['favoriteStatus'] = 1;
             }
             else
             {
                  $value['favoriteStatus'] = 0;
             }
             
             if($checkBookingRequest)
             {
                 $value['ShowSellerInfoStatus'] = 1;
             }
             else
             {
                  $value['ShowSellerInfoStatus'] = 0;
             }
             
			$imagesData = $this->CarImages($carID);
		    if($imagesData){
		        $value['images'] = $imagesData;
		       
		    }
		    else
		    {
		         $value['images'] = [];
		    }
		    
		     $value['distance']=6;
		   
 			$response[]=$value;
		}
        
        return $response;
       
       
    }
    
    
    
     /*RETURN Selling CAR OF USER */
    public function CarListingBuyingByLocation($Latitude,$Longitude,$userID){
        
        $query=$this->db->query("SELECT Cars.*,users.Username,users.PhoneNumber,users.Image,users.Address,users.latitude,users.longitude,(((acos(sin((".$Latitude."*pi()/180)) * sin((users.latitude*pi()/180)) + cos((".$Latitude."*pi()/180)) * cos((users.latitude*pi()/180)) * cos(((".$Longitude."- users.longitude)*pi()/180)))) * 180/pi()) * 60 * 1.1515) as distance FROM Cars LEFT JOIN users ON Cars.userID=users.id where Cars.carType='Sell' AND carID NOT IN (select carID from TestDriveRequestCars where isBuyerInterested='1') having distance>80");
        
        $userResult=$query->result_array();
         foreach($userResult as $value)
		{
			$carID = $value['carID'];
			$checkFavourite=$this->CarIsFavourite($carID,$userID);
			$checkBookingRequest=$this->IsBookingRequestAccepted($carID,$userID);
			 if($checkFavourite)
             {
                 $value['favoriteStatus'] = 1;
             }
             else
             {
                  $value['favoriteStatus'] = 0;
             }
             
             if($checkBookingRequest)
             {
                 $value['ShowSellerInfoStatus'] = 1;
             }
             else
             {
                  $value['ShowSellerInfoStatus'] = 0;
             }
             
			$imagesData = $this->CarImages($carID);
		    if($imagesData){
		        $value['images'] = $imagesData;
		       
		    }
		    else
		    {
		         $value['images'] = [];
		    }
		    
		    // ADD RATING ARRAY
		     
		    $RatingData = $this->CarRating($carID);
		    if($RatingData){
		        $value['Rating'] = $RatingData;
		       
		    }
		    else
		    {
		         $value['Rating'] = [];
		    }
		    
		     $value['distance'] = 29;
		  
		    
 			$response[]=$value;
		}
        
        return $response;
       
       
    }
    
    
    
    /*RETURN For filter Buying CAR OF USER */
    
    public function CarsBuyingListingFilter($userID,$carType,$minPrice,$maxPrice,$Latitude,$Longitude)
    {
        $q="CALL  FilterCars('$carType',$minPrice,$maxPrice,$Latitude,$Longitude,0)";
        $query=$this->db->query($q);
     
        $userResult=$query->result_array();
       
        $query->next_result(); 
        $query->free_result(); 
        
        
        if(!empty($userResult))
        {
         foreach($userResult as $value)
		{
			$carID = $value['carID'];
			$checkFavourite=$this->CarIsFavourite($carID,$userID);
			$checkBookingRequest=$this->IsBookingRequestAccepted($carID,$userID);
			$checkSold=$this->CarIsSold($carID);
			
			 if($checkFavourite)
             {
                 $value['favoriteStatus'] = 1;
             }
             else
             {
                  $value['favoriteStatus'] = 0;
             }
             
             if($checkBookingRequest)
             {
                 $value['ShowSellerInfoStatus'] = 1;
             }
             else
             {
                  $value['ShowSellerInfoStatus'] = 0;
             }
             
            // ADD IMAGE ARRAY
            
			$imagesData = $this->CarImages($carID);
		    if($imagesData)
		    {
		        $value['images'] = $imagesData;
		       
		    }
		    else
		    {
		         $value['images'] = [];
		    }
		    
		     // ADD RATING ARRAY
		     
		    $RatingData = $this->CarRating($carID);
		    if($RatingData){
		        $value['Rating'] = $RatingData;
		       
		    }
		    else
		    {
		         $value['Rating'] = [];
		    }
		    
		    
		    if($checkSold)
    			{
    			    
    			}
    			else
    			{
    			    $response[]=$value;
    			}
 			//$response[]=$value;
		}
        
       
        return $response;
        }
        else
        {
            return false;
        }
       
    }
    
    
    
     /*RETURN For filter Buying CAR OF USER */
    
    public function CarsBuyingListingFilterForRent($userID,$carType,$minPrice,$maxPrice,$Latitude,$Longitude)
    {
        $q="CALL  FilterCarRent('$carType',$minPrice,$maxPrice,$Latitude,$Longitude,0)";
        $query=$this->db->query($q);
     
        $userResult=$query->result_array();
       
        $query->next_result(); 
        $query->free_result(); 
        
        
        if(!empty($userResult))
        {
         foreach($userResult as $value)
		{
			$carID = $value['carID'];
			$checkFavourite=$this->CarIsFavourite($carID,$userID);
			$checkBookingRequest=$this->IsBookingRequestAccepted($carID,$userID);
			 if($checkFavourite)
             {
                 $value['favoriteStatus'] = 1;
             }
             else
             {
                  $value['favoriteStatus'] = 0;
             }
             
             if($checkBookingRequest)
             {
                 $value['ShowSellerInfoStatus'] = 1;
             }
             else
             {
                  $value['ShowSellerInfoStatus'] = 0;
             }
             
			$imagesData = $this->CarImages($carID);
		    if($imagesData){
		        $value['images'] = $imagesData;
		       
		    }
		    else
		    {
		         $value['images'] = [];
		    }
		    
		    // ADD RATING ARRAY
		     
		    $RatingData = $this->CarRating($carID);
		    if($RatingData){
		        $value['Rating'] = $RatingData;
		       
		    }
		    else
		    {
		         $value['Rating'] = [];
		    }
		    
		    $value['distance']=4;
		    $value['DeliveryCost']=40;
		    $value['PickUpCost']=40;
		    
		    $value['FuelCostsDaily']=30;
		    $value['CleaningCostDaily']=20;
		    $value['ReservationFeeDaily']=40;
		    
		    $value['FuelCostsWeekly']=30;
		    $value['CleaningCostWeekly']=20;
		    $value['ReservationFeeWeekly']=40;
		    
		    $value['FuelCostsMonthly']=30;
		    $value['CleaningCostMonthly']=20;
		    $value['ReservationFeeMonthly']=40;
		    
		    $AvgRating = $this->AvgCarRating($carID);
		    $value['averageRating'] = $AvgRating;
		    
 			$response[]=$value;
		}
        
       
        return $response;
        }
        else
        {
            return false;
        }
       
    }
   
    
     /*RETURN Rent CAR  */
    public function CarsRentListing($userID,$Latitude,$Longitude){
        $this->db->select("Cars.*,users.Username,users.PhoneNumber,users.Image,users.Address,(((acos(sin((".$Latitude."*pi()/180)) * sin((users.latitude*pi()/180)) + cos((".$Latitude."*pi()/180)) * cos((users.latitude*pi()/180)) * cos(((".$Longitude."- users.longitude)*pi()/180)))) * 180/pi()) * 60 * 1.1515) as distance");
        $this->db->from('Cars');
        $this->db->where('Cars.carType','Rent');
        $this->db->join('users','users.id=Cars.userID','Left');
        $this->db->order_by("Cars.carID", "desc");
        $query=$this->db->get();
        $userResult=$query->result_array();
         foreach($userResult as $value)
		{
			$carID = $value['carID'];
			$checkFavourite=$this->CarIsFavourite($carID,$userID);
			 if($checkFavourite)
             {
                 $value['favoriteStatus'] = 1;
             }
             else
             {
                  $value['favoriteStatus'] = 0;
             }
             
			$imagesData = $this->CarImages($carID);
		    if($imagesData){
		        $value['images'] = $imagesData;
		       
		    }
		    else
		    {
		         $value['images'] = [];
		    }
		    
		    if($value['distance']<=10)
		    {
		        $DeliveryCost=20;
		    }
		    elseif($value['distance']>10 && $value['distance']<=20)
		    {
		        $DeliveryCost=30;
		    }
		    else
		    {
		        $DeliveryCost=40;
		    }
		    
		    // ADD RATING ARRAY
		     
		    $RatingData = $this->CarRating($carID);
		    if($RatingData){
		        $value['Rating'] = $RatingData;
		       
		    }
		    else
		    {
		         $value['Rating'] = [];
		    }
		    
		    $value['DeliveryCost']=$DeliveryCost;
		    $value['PickUpCost']=$DeliveryCost;
		    $value['distance']=20;
		    
		    $value['FuelCostsDaily']=30;
		    $value['CleaningCostDaily']=20;
		    $value['ReservationFeeDaily']=40;
		    
		    $value['FuelCostsWeekly']=30;
		    $value['CleaningCostWeekly']=20;
		    $value['ReservationFeeWeekly']=40;
		    
		    $value['FuelCostsMonthly']=30;
		    $value['CleaningCostMonthly']=20;
		    $value['ReservationFeeMonthly']=40;
		    
		    $AvgRating = $this->AvgCarRating($carID);
		    $value['averageRating'] = $AvgRating; 
		    
		    
 			$response[]=$value;
		}
        
        return $response;
       
       
    }
    
    
     
     /*RETURN Selling CAR OF USER */
    public function CarRentListingByLocation($Latitude,$Longitude,$userID){
       $query=$this->db->query("SELECT Cars.*,users.Username,users.PhoneNumber,users.Image,users.Address,users.latitude,users.longitude,(((acos(sin((".$Latitude."*pi()/180)) * sin((users.latitude*pi()/180)) + cos((".$Latitude."*pi()/180)) * cos((users.latitude*pi()/180)) * cos(((76.717873- users.longitude)*pi()/180)))) * 180/pi()) * 60 * 1.1515) as distance FROM Cars LEFT JOIN users ON Cars.userID=users.id where Cars.carType='Rent' having distance>80");
        
       
        $userResult=$query->result_array();
         foreach($userResult as $value)
		{
			$carID = $value['carID'];
			$checkFavourite=$this->CarIsFavourite($carID,$userID);
			$checkBookingRequest=$this->IsBookingRequestAccepted($carID,$userID);
			 if($checkFavourite)
             {
                 $value['favoriteStatus'] = 1;
             }
             else
             {
                  $value['favoriteStatus'] = 0;
             }
             
             if($checkBookingRequest)
             {
                 $value['ShowSellerInfoStatus'] = 1;
             }
             else
             {
                  $value['ShowSellerInfoStatus'] = 0;
             }
             
			$imagesData = $this->CarImages($carID);
		    if($imagesData){
		        $value['images'] = $imagesData;
		       
		    }
		    else
		    {
		         $value['images'] = [];
		    }
		    
		       if($value['distance']<=10)
		    {
		        $DeliveryCost=20;
		    }
		    elseif($value['distance']>10 && $value['distance']<=20)
		    {
		        $DeliveryCost=30;
		    }
		    else
		    {
		        $DeliveryCost=40;
		    }
		    
		     $value['DeliveryCost'] = $DeliveryCost;
		     $value['PickupCost'] = $DeliveryCost;
		   
		    // ADD RATING ARRAY
		     
		    $RatingData = $this->CarRating($carID);
		    if($RatingData){
		        $value['Rating'] = $RatingData;
		       
		    }
		    else
		    {
		         $value['Rating'] = [];
		    }
		     $value['distance']=6;
		     
    		 $value['FuelCostsDaily']=30;
		    $value['CleaningCostDaily']=20;
		    $value['ReservationFeeDaily']=40;
		    
		    $value['FuelCostsWeekly']=30;
		    $value['CleaningCostWeekly']=20;
		    $value['ReservationFeeWeekly']=40;
		    
		    $value['FuelCostsMonthly']=30;
		    $value['CleaningCostMonthly']=20;
		    $value['ReservationFeeMonthly']=40;
		    
		    $AvgRating = $this->AvgCarRating($carID);
		    $value['averageRating'] = $AvgRating;
    		    
 			$response[]=$value;
		}
        
        return $response;
       
       
    }
    
    
    
     /*RETURN CAR OF USER */
    public function CarsRTOListing($userID){
        $this->db->select('Cars.*,users.Username,users.PhoneNumber,users.Image,users.Address,TestDriveRequestCars.ID as TestBookRequestID,TestDriveRequestCars.Name as TestDriveBuyerName,TestDriveRequestCars.Phone as TestDriveBuyerPhoneNumber,TestDriveRequestCars.TestDriveStatus,TestDriveRequestCars.TestDriveDate,TestDriveRequestCars.TestDriveTime,TestDriveRequestCars.DescriptionAddedBySeller,TestDriveRequestCars.addedDate,TestDriveRequestCars.Location,TestDriveRequestCars.isBuyerInterested');
        $this->db->from('TestDriveRequestCars');
        $this->db->where('TestDriveRequestCars.userID',$userID);
        $this->db->where('TestDriveRequestCars.TestDriveRequestType','OBP');
        $this->db->where('TestDriveRequestCars.TestDriveStatus !=','Discard');
        $this->db->join('Cars','TestDriveRequestCars.carID=Cars.carID','Left');
        $this->db->join('users','users.id=Cars.userID','Left');
        $this->db->order_by("TestDriveRequestCars.ID", "desc");
        $query=$this->db->get();
        $userResult=$query->result_array();
        
        foreach($userResult as $value)
		{
			$carID = $value['carID'];
			$TestBookRequestID = $value['TestBookRequestID'];
			$checkSold=$this->CarIsSold($carID);
			
			$checkFavourite=$this->CarIsFavourite($carID,$userID);
			 if($checkFavourite)
             {
                 $value['favoriteStatus'] = 1;
             }
             else
             {
                  $value['favoriteStatus'] = 0;
             }
             
             
              if($checkSold)
             {
                 $value['SoldStatus'] = 1;
             }
             else
             {
                  $value['SoldStatus'] = 0;
             }
             
			$imagesData = $this->CarImages($carID);
		    if($imagesData){
		        $value['images'] = $imagesData;
		       
		    }
		    else
		    {
		         $value['images'] = [];
		    }
		    
		    $PaymentQuery=$this->db->query("SELECT Payments.* FROM Payments where Payments.RequestID='".$TestBookRequestID."' AND RequestType='Sell'");
            $PaymentResult=$PaymentQuery->row_array();
            $value['PaymentData']=$PaymentResult;
		    
		    
 			$response[]=$value;
		}
        
        return $response;
       
    }
    
    
      /*Check recurring or Not */
    public function isRecurringActive($requestID)
    {
        $this->db->select('Payments.EMIdeductDate,Payments.Amount as recurringPrice,Payments.EMIPlanType');
        $this->db->from('Payments');
        $this->db->where('Payments.RequestID',$requestID);
        $this->db->where('Payments.PaymentType','recurring');
        
       
       
        $query=$this->db->get();
        if($query->num_rows()>0)
        {
            $userResult=$query->result_array();
          return $userResult;
        }else{
          return false;
        }
       
    }
    
 
    
     /*RETURN CAR OF USER */
    public function CarListingRTO($userID){
        $this->db->select('Cars.*,users.Username,users.PhoneNumber,users.Image,users.Address,TestDriveRequestCars.ID as TestBookRequestID,TestDriveRequestCars.Name as TestDriveBuyerName,TestDriveRequestCars.Phone as TestDriveBuyerPhoneNumber,TestDriveRequestCars.TestDriveStatus,TestDriveRequestCars.TestDriveDate,TestDriveRequestCars.TestDriveTime,TestDriveRequestCars.DescriptionAddedBySeller,TestDriveRequestCars.addedDate,TestDriveRequestCars.Location,TestDriveRequestCars.isBuyerInterested');
        $this->db->from('TestDriveRequestCars');
        $this->db->where('TestDriveRequestCars.userID',$userID);
        $this->db->where('TestDriveRequestCars.TestDriveRequestType','RTO');
        $this->db->where('TestDriveRequestCars.TestDriveStatus !=','Discard');
        $this->db->join('Cars','TestDriveRequestCars.carID=Cars.carID','Left');
        $this->db->join('users','users.id=Cars.userID','Left');
        $this->db->order_by("TestDriveRequestCars.ID", "desc");
        $query=$this->db->get();
        $userResult=$query->result_array();
        
        foreach($userResult as $value)
		{
			$carID = $value['carID'];
			$TestBookRequestID = $value['TestBookRequestID'];
			$checkSold=$this->CarIsSold($carID);
			$recurring=$this->isRecurringActive($TestBookRequestID);
			if($recurring)
			{
			    $value['recurringPaymentDetail']=$recurring;
			}
			else
			{
			    $value['recurringPaymentDetail']=NULL;
			}
			
			$checkFavourite=$this->CarIsFavourite($carID,$userID);
			 if($checkFavourite)
             {
                 $value['favoriteStatus'] = 1;
             }
             else
             {
                  $value['favoriteStatus'] = 0;
             }
             
             
              if($checkSold)
             {
                 $value['SoldStatus'] = 1;
             }
             else
             {
                  $value['SoldStatus'] = 0;
             }
             
			$imagesData = $this->CarImages($carID);
		    if($imagesData){
		        $value['images'] = $imagesData;
		       
		    }
		    else
		    {
		         $value['images'] = [];
		    }
		    
		    $PaymentQuery=$this->db->query("SELECT Payments.* FROM Payments where Payments.RequestID='".$TestBookRequestID."' AND RequestType='Sell'");
            $PaymentResult=$PaymentQuery->row_array();
            $value['PaymentData']=$PaymentResult;
		    
		    
 			$response[]=$value;
		}
        
        return $response;
       
    }
    
    
    
    
    
      /*RETURN SearchCarListingAtBuyer CAR  */
      
    public function SearchCarListingAtBuyer($type,$search,$userID)
    {
        $this->db->select('Cars.*,users.Username');
        $this->db->from('Cars');
        $this->db->like('Cars.Brand', $search);
        $this->db->or_like('Cars.Model',$search);
        $this->db->where('Cars.carType',$type);
        $this->db->join('users','users.id=Cars.userID','Left');
       
        $query=$this->db->get();
        $userResult=$query->result_array();
         foreach($userResult as $value)
		{
			$carID = $value['carID'];
			
			$checkFavourite=$this->CarIsFavourite($carID,$userID);
			 if($checkFavourite)
             {
                 $value['favoriteStatus'] = 1;
             }
             else
             {
                  $value['favoriteStatus'] = 0;
             }
             
			$imagesData = $this->CarImages($carID);
		    if($imagesData){
		        $value['images'] = $imagesData;
		       
		    }
		    else
		    {
		         $value['images'] = [];
		    }
 			$response[]=$value;
		}
        
        return $response;
       
       
    }
    
    
      /*RETURN Selling CAR OF USER */
    public function CarSellingListSellerSide($userID)
    {
        
             $this->db->select('Cars.*');
             $this->db->from('Cars');
             $this->db->where('Cars.carType','Sell');
             $this->db->where('Cars.userID',$userID);
             $this->db->where("carID NOT IN (select carID from TestDriveRequestCars where isBuyerInterested='1')");
             //$this->db->where("carID NOT IN (select carID from TestDriveRequestCars where CarPaymentStatus='Completed')");
             $this->db->order_by("Cars.carID", "desc");
             
              $query=$this->db->get();
      
            $userResult=$query->result_array();
             foreach($userResult as $value)
    		{
    			$carID = $value['carID'];
    			
    			$imagesData = $this->CarImages($carID);
    		    $value['distance']=6;
    		    if($imagesData)
    		    {
    		        $value['images'] = $imagesData;
    		    }
    		    else
    		    {
    		       $value['images'] = [];
    		    }
    		    
    		    // ADD RATING ARRAY
		     
    		    $RatingData = $this->CarRating($carID);
    		    if($RatingData){
    		        $value['Rating'] = $RatingData;
    		       
    		    }
    		    else
    		    {
    		         $value['Rating'] = [];
    		    }
    		    
    		    $response[]=$value;
    		    
    		  
     			
    		}
        
        return $response;
           
       
       
    }
    
    
    
    
      /*RETURN Sold CAR OF USER */
    public function CarSoldListSellerSide($userID)
    {
       
             $this->db->select('Cars.*,TestDriveRequestCars.ID,TestDriveRequestCars.userID as buyerID');
             $this->db->from('Cars');
             $this->db->where('Cars.carType','Sell');
             $this->db->where('Cars.userID',$userID);
             $this->db->where('TestDriveRequestCars.CarPaymentStatus','Completed');
             $this->db->where('TestDriveRequestCars.isBuyerInterested','1');
             $this->db->join('TestDriveRequestCars','TestDriveRequestCars.carID=Cars.carID','Left');
             $this->db->order_by("TestDriveRequestCars.ID", "desc");
             
             $query=$this->db->get();
           
        $payments=new stdClass();
        //$payments['soldOutDate']="2021-01-17 05:12:00";
       
        $userResult=$query->result_array();
         foreach($userResult as $value)
		{
			$carID = $value['carID'];
			$buyerID = $value['buyerID'];
			$TestDriveRequestID = $value['ID'];
			
			$imagesData = $this->CarImages($carID);
			$userDetailByid = $this->userDetailByid1($buyerID);
			
		    $value['distance']=6;
		    
		    $PaymentQuery=$this->db->query("SELECT Payments.* FROM Payments where Payments.RequestID='".$TestDriveRequestID."' AND RequestType='Sell'");
            $PaymentResult=$PaymentQuery->row_array();
            $value['PaymentData']=$PaymentResult;
		    
		    //$value['PaymentDetails']=$payments;
		    $value['BuyerDetails']=$userDetailByid;
		    if($imagesData){
		        $value['images'] = $imagesData;
		       
		    }
		    else
		    {
		       $value['images'] = [];
		    }
		    
		    // ADD RATING ARRAY
		     
		    $RatingData = $this->CarRating($carID);
		    if($RatingData){
		        $value['Rating'] = $RatingData;
		       
		    }
		    else
		    {
		         $value['Rating'] = [];
		    }
		    
 			$response[]=$value;
		}
        
        return $response;
       
      
       
       
    }
    
    
    
     /*RETURN Renting CAR OF SELLER */
     
    public function SellerMyRentCarList($userID)
    {
        
             $this->db->select('Cars.*');
             $this->db->from('Cars');
             $this->db->where('Cars.carType','Rent');
             $this->db->where('Cars.userID',$userID);
             $this->db->order_by("Cars.carID", "desc");
             
              $query=$this->db->get();
       
            $userResult=$query->result_array();
             foreach($userResult as $value)
    		{
    			$carID = $value['carID'];
    		
    			$imagesData = $this->CarImages($carID);
    		    $value['distance']=6;
    		    if($imagesData)
    		    {
    		        $value['images'] = $imagesData;
    		    }
    		    else
    		    {
    		       $value['images'] = [];
    		    }
    		    
    		    
    		  
    			    $response[]=$value;
    			
    		}
        
        return $response;
           
       
       
    }
    
    
     /*RETURN TESTDRIVE RESQUEST OF USER */
   
    public function TestDriveRequestListing($userID)
    {
       $query=$this->db->query("SELECT Cars.*,TestDriveRequestCars.ID as TestBookRequestID,TestDriveRequestCars.TestDriveStatus,TestDriveRequestCars.TestDriveDate,TestDriveRequestCars.TestDriveTime,TestDriveRequestCars.Location,TestDriveRequestCars.addedDate as testDriveRequestCreatedDate,TestDriveRequestCars.DescriptionAddedBySeller,TestDriveRequestCars.Name as BuyerNameAtRequestTime,TestDriveRequestCars.Phone as BuyerPhoneAtRequestTime,users.Username,users.Email,users.FirstName,users.Image,users.PhoneNumber FROM `TestDriveRequestCars`LEFT JOIN Cars ON Cars.carID=TestDriveRequestCars.carID LEFT JOIN users ON TestDriveRequestCars.userID=users.id WHERE TestDriveRequestCars.carID IN (SELECT carID from Cars where Cars.userID='".$userID."') AND (TestDriveRequestCars.TestDriveStatus='Pending' OR TestDriveRequestCars.TestDriveStatus='OnHold') AND TestDriveRequestCars.TestDriveRequestType='OBP' ORDER BY TestDriveRequestCars.ID DESC");
         
        $userResult=$query->result_array();
       
        foreach($userResult as $value)
		{
			$carID = $value['carID'];
			$imagesData = $this->CarImages($carID);
		    if($imagesData){
		        $value['images'] = $imagesData;
		       
		    }
		    else
		    {
		         $value['images'] = [];
		    }
 			$response[]=$value;
		}
        
        return $response;
       
    }
    
     /*RETURN TESTDRIVE RESQUEST OF USER */
   
    public function RTODriveRequestListing($userID)
    {
       $query=$this->db->query("SELECT Cars.*,TestDriveRequestCars.ID as TestBookRequestID,TestDriveRequestCars.TestDriveStatus,TestDriveRequestCars.TestDriveDate,TestDriveRequestCars.TestDriveTime,TestDriveRequestCars.Location,TestDriveRequestCars.addedDate as testDriveRequestCreatedDate,TestDriveRequestCars.DescriptionAddedBySeller,TestDriveRequestCars.Name as BuyerNameAtRequestTime,TestDriveRequestCars.Phone as BuyerPhoneAtRequestTime,users.Username,users.Email,users.FirstName,users.Image,users.PhoneNumber FROM `TestDriveRequestCars`LEFT JOIN Cars ON Cars.carID=TestDriveRequestCars.carID LEFT JOIN users ON TestDriveRequestCars.userID=users.id WHERE TestDriveRequestCars.carID IN (SELECT carID from Cars where Cars.userID='".$userID."') AND (TestDriveRequestCars.TestDriveStatus='Pending' OR TestDriveRequestCars.TestDriveStatus='OnHold') AND TestDriveRequestCars.TestDriveRequestType='RTO' ORDER BY TestDriveRequestCars.ID DESC");
         
        $userResult=$query->result_array();
       
        foreach($userResult as $value)
		{
			$carID = $value['carID'];
			$imagesData = $this->CarImages($carID);
		    if($imagesData){
		        $value['images'] = $imagesData;
		       
		    }
		    else
		    {
		         $value['images'] = [];
		    }
 			$response[]=$value;
		}
        
        return $response;
       
    }
    
    
     /*RETURN TESTDRIVE RESQUEST OF USER */
   
    public function CompletedTestdriveRequest($userID)
    {
       $query=$this->db->query("SELECT Cars.*,TestDriveRequestCars.ID as TestBookRequestID,TestDriveRequestCars.TestDriveStatus,TestDriveRequestCars.TestDriveDate,TestDriveRequestCars.TestDriveTime,TestDriveRequestCars.Location,TestDriveRequestCars.addedDate as testDriveRequestCreatedDate,TestDriveRequestCars.Name as BuyerNameAtRequestTime,TestDriveRequestCars.Phone as BuyerPhoneAtRequestTime,TestDriveRequestCars.isBuyerInterested,users.Username,users.Email,users.FirstName,users.Image,users.PhoneNumber FROM `TestDriveRequestCars`LEFT JOIN Cars ON Cars.carID=TestDriveRequestCars.carID LEFT JOIN users ON TestDriveRequestCars.userID=users.id WHERE TestDriveRequestCars.carID IN (SELECT carID from Cars where Cars.userID='".$userID."') AND TestDriveRequestCars.TestDriveStatus='Completed' ORDER BY TestDriveRequestCars.ID DESC");
         
        $userResult=$query->result_array();
       
        foreach($userResult as $value)
		{
			$carID = $value['carID'];
			$TestBookRequestID=$value['TestBookRequestID'];
			$imagesData = $this->CarImages($carID);
		    if($imagesData){
		        $value['images'] = $imagesData;
		       
		    }
		    else
		    {
		         $value['images'] = [];
		    }
		    
		    $PaymentQuery=$this->db->query("SELECT Payments.* FROM Payments where Payments.RequestID='".$TestBookRequestID."' AND RequestType='Sell'");
            $PaymentResult=$PaymentQuery->row_array();
            $value['PaymentData']=$PaymentResult;
		    
 			$response[]=$value;
		}
        
        return $response;
       
    }
    
    
     /*RETURN TESTDRIVE ACCEPTED RESQUEST OF USER */
   
    public function TestDriveAcceptedAppointment($userID)
    {
       $query=$this->db->query("SELECT Cars.*,TestDriveRequestCars.ID as TestBookRequestID,TestDriveRequestCars.TestDriveStatus,TestDriveRequestCars.TestDriveDate,TestDriveRequestCars.TestDriveTime,TestDriveRequestCars.Location,TestDriveRequestCars.addedDate as testDriveRequestCreatedDate,TestDriveRequestCars.Name as BuyerNameAtRequestTime,TestDriveRequestCars.Phone as BuyerPhoneAtRequestTime,users.Username,users.Email,users.FirstName,users.Image,users.PhoneNumber FROM `TestDriveRequestCars`LEFT JOIN Cars ON Cars.carID=TestDriveRequestCars.carID LEFT JOIN users ON TestDriveRequestCars.userID=users.id WHERE TestDriveRequestCars.carID IN (SELECT carID from Cars where Cars.userID='".$userID."') AND TestDriveRequestCars.TestDriveStatus='Accepted' ORDER BY TestDriveRequestCars.ID DESC");
         
        $userResult=$query->result_array();
       
        foreach($userResult as $value)
		{
			$carID = $value['carID'];
			$TestBookRequestID=$value['TestBookRequestID'];
			$imagesData = $this->CarImages($carID);
		    if($imagesData){
		        $value['images'] = $imagesData;
		       
		    }
		    else
		    {
		         $value['images'] = [];
		    }
		    
		     $PaymentQuery=$this->db->query("SELECT Payments.* FROM Payments where Payments.RequestID='".$TestBookRequestID."' AND RequestType='Sell'");
            $PaymentResult=$PaymentQuery->row_array();
            $value['PaymentData']=$PaymentResult;
            
 			$response[]=$value;
		}
        
        return $response;
       
    }
    
    
    /*RETURN CAR Image */
    public function CarImages($carID)
    {
        $this->db->select('CarImages.name,CarImages.imageID');
        $this->db->from('CarImages');
        $this->db->where('CarImages.carID',$carID);
        $query=$this->db->get();
        $userResult=$query->result_array();
        return $userResult;
       
    }
    
    
     /*Check Car Booking Request is Accepted or Not */
     
    public function IsBookingRequestAccepted($carID,$userID)
    {
        $this->db->select('TestDriveRequestCars.ID');
        $this->db->from('TestDriveRequestCars');
        $this->db->where('TestDriveRequestCars.carID',$carID);
        $this->db->where('TestDriveRequestCars.userID',$userID);
        $this->db->where('TestDriveRequestCars.TestDriveStatus','Accepted');
       
       
        $query=$this->db->get();
        if($query->num_rows()>0){
          return true;
        }else{
          return false;
        }
       
    }
    
     public function GetPaymentMode($requestID,$requestTYPE)
    {
        $this->db->select('Payments.PaymentType');
        $this->db->from('Payments');
        $this->db->where('Payments.RequestID',$requestID);
        $this->db->where('Payments.RequestType',$requestTYPE);
      
       
        $query=$this->db->get();
        if($query->num_rows()>0){
            $results=$query->row_array();
          return $results;
        }else{
          return false;
        }
       
    }
    
      public function CheckPaymentStatusSellerToAdmin($requestID)
    {
        $this->db->select('SellerPaymentID');
        $this->db->from('SellerPaymentToAdmin');
        $this->db->where('SellerPaymentToAdmin.RequestID',$requestID);
        
        $query=$this->db->get();
        if($query->num_rows()>0){
           
          return true;
        }else{
          return false;
        }
       
    }
    
     /*Check Car is Sold or Not */
    public function CarIsSold($carID)
    {
        $isInterested=1;
        $this->db->select('TestDriveRequestCars.ID');
        $this->db->from('TestDriveRequestCars');
        $this->db->where('TestDriveRequestCars.carID',$carID);
        $this->db->where('TestDriveRequestCars.CarPaymentStatus','Completed');
        $this->db->where('TestDriveRequestCars.isBuyerInterested',$isInterested);
       
       
        $query=$this->db->get();
        if($query->num_rows()>0){
          return true;
        }else{
          return false;
        }
       
    }
    
     /*Check Car is Sold or Not */
    public function RentCarIsSold($carID)
    {
        $this->db->select('RentRequestCars.RentRequestID');
        $this->db->from('RentRequestCars');
        $this->db->where('RentRequestCars.carID',$carID);
        $this->db->where('RentRequestCars.PaymentStatus','Completed');
       
       
        $query=$this->db->get();
        if($query->num_rows()>0){
          return true;
        }else{
          return false;
        }
       
    }
    
     /* Delete car */
    public function DeleteCar($car_id){
        
        $this->db->where('carID', $car_id);
        if($this->db->delete('Cars'))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
     /* Delete car Image*/
     
    public function DeleteCarImage($imageID){
        
        $this->db->where('imageID', $imageID);
        if($this->db->delete('CarImages'))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    


    public function CarDetailsByID($car_id){
        $this->db->select('Color,Model,Brand');
        $this->db->from('Cars');
        $this->db->where('carID',$car_id);
        $query=$this->db->get();
        $Result=$query->row_array();
        return $Result;
    }
    
    
    public function checkExistCar($carID){
        $this->db->select('carID');
        $this->db->from('Cars');
        $this->db->where('carID',$carID);
       
       
        $query=$this->db->get();
        if($query->num_rows()>0){
          return true;
        }else{
          return false;
        }
  }
  
  
  /*ADD TO favourite  */
  
    public function AddToFavourite($carID,$userID,$Status,$currDate)
    {
        $data = array(
        'carID'           =>  $carID,
        'userID'           =>  $userID,
        'Status'              =>  $Status,
        'addedDate'    =>  $currDate
        );
        
        $CHeckCar = $this->CheckFavouriteRecord($carID,$userID);
        
        if($CHeckCar)
        {
            
            $WhereArray = array('carID' => $carID, 'userID' => $userID);
              $accountStatus=array( 
                'Status'=>$Status
                ); 
              $this->db->where($WhereArray);
              $this->db->update('FavouriteCars', $accountStatus);
               $this->db->trans_complete();
                  if($query=$this->db->affected_rows())
                {
                  return true;
                }
                else
                {
                    if ($this->db->trans_status() === FALSE)
                    {
                    return false;
                    }
                    else
                    {
                    return true;
                    }
                }
        }
        else
        {
            if($this->db->insert('FavouriteCars', $data))
            {
                $insert_id = $this->db->insert_id();
                return $insert_id;
            }
            else
            {
                return false;
            }
        }
       
    }
    
    
   /*Check favourite or Not */
    public function CarIsFavourite($carID,$userID)
    {
        $this->db->select('FavouriteCars.FavoriteID');
        $this->db->from('FavouriteCars');
        $this->db->where('FavouriteCars.carID',$carID);
        $this->db->where('FavouriteCars.userID',$userID);
        $this->db->where('FavouriteCars.Status','1');
       
       
        $query=$this->db->get();
        if($query->num_rows()>0)
        {
          return true;
        }else{
          return false;
        }
       
    }
    
    
     /*Check favourite or Not */
    public function CheckFavouriteRecord($carID,$userID)
    {
        $this->db->select('FavouriteCars.FavoriteID');
        $this->db->from('FavouriteCars');
        $this->db->where('FavouriteCars.carID',$carID);
        $this->db->where('FavouriteCars.userID',$userID);
       
       
        $query=$this->db->get();
        if($query->num_rows()>0)
        {
          return true;
        }else{
          return false;
        }
       
    }
    
    
    /*RETURN FavouriteCarListing  */
    
    public function FavouriteCarListing($userID,$Latitude,$Longitude){
        $this->db->select('Cars.*,users.Username,users.PhoneNumber,users.FirstName,users.LastName,users.Image,users.Address,users.latitude,users.longitude,(((acos(sin(('.$Latitude.'*pi()/180)) * sin((users.latitude*pi()/180)) + cos(('.$Latitude.'*pi()/180)) * cos((users.latitude*pi()/180)) * cos((('.$Longitude.'- users.longitude)*pi()/180)))) * 180/pi()) * 60 * 1.1515) as distance');
        $this->db->from('FavouriteCars');
        $this->db->where('FavouriteCars.userID',$userID);
         $this->db->where('FavouriteCars.Status','1');
        $this->db->join('Cars','FavouriteCars.carID=Cars.carID','Left');
        $this->db->join('users','users.id=Cars.userID','Left');
        $this->db->order_by("FavouriteCars.FavoriteID", "desc");
       
        $query=$this->db->get();
        
        $userResult=$query->result_array();
       
         foreach($userResult as $value)
		{
			$carID = $value['carID'];
			$carType = $value['carType'];
			
			$imagesData = $this->CarImages($carID);
		    if($imagesData){
		        $value['images'] = $imagesData;
		       
		    }
		    else
		    {
		         $value['images'] = [];
		    }
		    
		    if($carType=='Sell')
		    {
    		    // ADD RATING ARRAY
		     
    		    $RatingData = $this->CarRating($carID);
    		    if($RatingData){
    		        $value['Rating'] = $RatingData;
    		       
    		    }
    		    else
    		    {
    		         $value['Rating'] = [];
    		    }
    		    
    		            $value['DeliveryCost']=0;
		                $value['PickUpCost']=0;
		    
            		    $value['FuelCostsDaily']=0;
            		    $value['CleaningCostDaily']=0;
            		    $value['ReservationFeeDaily']=0;
            		    
            		    $value['FuelCostsWeekly']=0;
            		    $value['CleaningCostWeekly']=0;
            		    $value['ReservationFeeWeekly']=0;
            		    
            		    $value['FuelCostsMonthly']=0;
            		    $value['CleaningCostMonthly']=0;
            		    $value['ReservationFeeMonthly']=0;
            		    
            		    $checkBookingRequest=$this->IsBookingRequestAccepted($carID,$userID);
		
                         if($checkBookingRequest)
                         {
                             $value['ShowSellerInfoStatus'] = 1;
                         }
                         else
                         {
                              $value['ShowSellerInfoStatus'] = 0;
                         }
             
		    }
		    else
		    {
    		     // ADD RATING ARRAY
        		     
        		    $RatingData = $this->CarRating($carID);
        		    if($RatingData){
        		        $value['Rating'] = $RatingData;
        		       
        		    }
        		    else
        		    {
        		         $value['Rating'] = [];
        		    }
        		    
        		   $GetRentRequestDetails = $this->GetRentRequestDetails($carID,$userID);
        		   if($GetRentRequestDetails)
        		   {
        		        $value['DeliveryCost']=40;
		                $value['PickUpCost']=40;
		    
            		    $value['FuelCostsDaily']=30;
            		    $value['CleaningCostDaily']=20;
            		    $value['ReservationFeeDaily']=40;
            		    
            		    $value['FuelCostsWeekly']=30;
            		    $value['CleaningCostWeekly']=20;
            		    $value['ReservationFeeWeekly']=40;
            		    
            		    $value['FuelCostsMonthly']=30;
            		    $value['CleaningCostMonthly']=20;
            		    $value['ReservationFeeMonthly']=40;
        		   }
        		   else
        		   {
        		        $value['DeliveryCost']=0;
		                $value['PickUpCost']=0;
		    
            		    $value['FuelCostsDaily']=0;
            		    $value['CleaningCostDaily']=0;
            		    $value['ReservationFeeDaily']=0;
            		    
            		    $value['FuelCostsWeekly']=0;
            		    $value['CleaningCostWeekly']=0;
            		    $value['ReservationFeeWeekly']=0;
            		    
            		    $value['FuelCostsMonthly']=0;
            		    $value['CleaningCostMonthly']=0;
            		    $value['ReservationFeeMonthly']=0;
        		   }
        		   
        		   
        		    $value['ShowSellerInfoStatus'] = 0;
		    }
		    
		    $value['favoriteStatus'] = 1;
		    $AvgRating = $this->AvgCarRating($carID);
		    $value['averageRating'] = $AvgRating;
		     
 			$response[]=$value;
		}
        
        return $response;
       
       
    }
    
    
    public function AcceptOrRejectTestDrive($TestBookRequestID,$Status)
    {
      
              $accountStatus=array( 
                'TestDriveStatus'=>$Status
                ); 
              $this->db->where('ID',$TestBookRequestID);
              $this->db->update('TestDriveRequestCars', $accountStatus);
               $this->db->trans_complete();
                  if($query=$this->db->affected_rows())
                {
                  return true;
                }
                else
                {
                    if ($this->db->trans_status() === FALSE)
                    {
                    return false;
                    }
                    else
                    {
                    return true;
                    }
                } 
    }
    
    
      public function DeclineTestDriveByBuyer($TestBookRequestID,$Status)
    {
      
              $accountStatus=array( 
                'TestDriveStatus'=>$Status
                ); 
              $this->db->where('ID',$TestBookRequestID);
              $this->db->update('TestDriveRequestCars', $accountStatus);
               $this->db->trans_complete();
                  if($query=$this->db->affected_rows())
                {
                  return true;
                }
                else
                {
                    if ($this->db->trans_status() === FALSE)
                    {
                    return false;
                    }
                    else
                    {
                    return true;
                    }
                } 
    }
    
    
    
    /*  
    
    Accept or Reject Rent Car Request
    */
    
    public function AcceptOrRejectRentRequest($RentRequestID,$Status)
    {
      
              $accountStatus=array( 
                'RentRequestSellerStatus'=>$Status
                ); 
              $this->db->where('RentRequestID',$RentRequestID);
              $this->db->update('RentRequestCars', $accountStatus);
               $this->db->trans_complete();
                  if($query=$this->db->affected_rows())
                {
                  return true;
                }
                else
                {
                    if ($this->db->trans_status() === FALSE)
                    {
                    return false;
                    }
                    else
                    {
                    return true;
                    }
                } 
    }
    
    public function getUserSubscriptionPlanByRefrenceNumber($refrenceNumber){
        $this->db->select('payments.userID,payments.planID as PackageID,subscription_plans.*');
        $this->db->from('payments');
        $this->db->where('refenceNumber',$refrenceNumber);
        $this->db->join('user_subscription_plans','user_subscription_plans.userID = payments.userID');
        $this->db->join('subscription_plans','subscription_plans.planID = user_subscription_plans.planID');
        $query=$this->db->get();
        $Result=$query->row_array();
        return $Result;
        
        
    }
    
  
   
     public function editProfile($name,$gender,$address,$state,$city,$zipcode,$image,$SSN,$userid){
       
       if($image=='')
       {
           $data = array(
        'FirstName'           =>  $name,
        'Gender'           =>  $gender,
        'Address'              =>  $address,
        'State'           => $state,
        'City'                  =>  $city,
        'Zipcode'         =>  $zipcode,
         'SSN'         =>  $SSN
        );
       }
       else
       {
          $data = array(
        'FirstName'           =>  $name,
        'Gender'           =>  $gender,
        'Address'              =>  $address,
        'State'           => $state,
        'City'                  =>  $city,
        'Zipcode'         =>  $zipcode,
        'image' => $image,
         'SSN'         =>  $SSN,
        );
       }
        
        
          $this->db->where('id', $userid);
          $this->db->update('users', $data);
          $this->db->trans_complete();
          if($query=$this->db->affected_rows())
        {
          return true;
        }
        else
        {
            if ($this->db->trans_status() === FALSE)
            {
        return false;
             }
            return true;
           
        }
   }
   
   
   
     public function logout($userid){
        $accountStatus=array( 
            'firebasetoken'=>''
            ); 
          $this->db->where('id', $userid);
          $this->db->update('users', $accountStatus);
           $this->db->trans_complete();
          if($query=$this->db->affected_rows())
        {
          return true;
        }
        else
        {
            if ($this->db->trans_status() === FALSE)
            {
        return false;
             }
             else
             {
            return true;
             }
        }
        
   }
   
  
     public function transactionHistory($userID,$usertype){
        
        if($usertype=='Seller')
        {
             
        $query=$this->db->query("SELECT Payments.*,Cards.cardID,Cards.HolderName,Cards.CardNumber FROM Payments LEFT JOIN Cars ON Cars.carID=Payments.carID LEFT JOIN Cards ON Cards.cardID=Payments.cardID where Cars.userID='".$userID."' order by Payments.PaymentID desc");
         
        }
        else
        {
          
        $query=$this->db->query("SELECT Payments.*,Cards.cardID,Cards.HolderName,Cards.CardNumber FROM Payments LEFT JOIN Cards ON Cards.cardID=Payments.cardID where Payments.userID='".$userID."' order by Payments.PaymentID desc");
         
        }
        
      
        $Result=$query->result_array();
        
        foreach($Result as $values)
        {
             $values['TransactionType']='Debit';
             if($values['EMIPlanType']=='')
             {
             $values['isEMIPayment']=0;
             }
             else
             {
                $values['isEMIPayment']=1; 
             }
             $results[]=$values;
        }
        return $results;
        
        
    }
   
   
   public function CarAlreadyRentBookDate($carID)
   {
        $this->db->select('FromDate,ToDate,FromTime,ToTime');
        $this->db->from('RentRequestCars');
        $this->db->where('carID',$carID);
         $this->db->where('RentRequestSellerStatus','Accepted');
        $query=$this->db->get();
        $Result=$query->result_array();
        return $Result;
   }
   
   
   /*RETURN RENT RESQUEST CARS OF USER */
   
    public function RentRequestListingAtSellerSide($userID){
       $query=$this->db->query("SELECT Cars.*,RentRequestCars.RentRequestID,RentRequestCars.FromDate,RentRequestCars.ToDate,RentRequestCars.FromTime,RentRequestCars.ToTime,RentRequestCars.RentRequestBuyerCancelStatus,RentRequestCars.RentRequestSellerStatus,RentRequestCars.PaymentStatus,RentRequestCars.totalAmount,RentRequestCars.DeliveryCost,RentRequestCars.pickupCost,RentRequestCars.PerDayCost,RentRequestCars.TotalDays,RentRequestCars.RentRequestDate,users.Username,users.Email,users.FirstName,users.Image,users.PhoneNumber FROM `RentRequestCars`LEFT JOIN Cars ON Cars.carID=RentRequestCars.carID LEFT JOIN users ON RentRequestCars.userID=users.id WHERE RentRequestCars.RentRequestSellerStatus='Pending' AND RentRequestCars.carID IN (SELECT carID from Cars where Cars.userID='".$userID."') ORDER BY RentRequestCars.RentRequestID DESC");
         
        $userResult=$query->result_array();
       
        foreach($userResult as $value)
		{
			$carID = $value['carID'];
			$imagesData = $this->CarImages($carID);
		    if($imagesData){
		        $value['images'] = $imagesData;
		       
		    }
		    else
		    {
		         $value['images'] = [];
		    }
 			$response[]=$value;
		}
        
        return $response;
       
    }
    
    
    /*RETURN RENT RESQUEST CARS OF USER */
   
    public function AcceptedRentRequestAtSellerSide($userID){
       $query=$this->db->query("SELECT Cars.*,RentRequestCars.RentRequestID,RentRequestCars.FromDate,RentRequestCars.ToDate,RentRequestCars.FromTime,RentRequestCars.ToTime,RentRequestCars.RentRequestBuyerCancelStatus,RentRequestCars.RentRequestSellerStatus,RentRequestCars.PaymentStatus,RentRequestCars.totalAmount,RentRequestCars.DeliveryCost,RentRequestCars.pickupCost,RentRequestCars.PerDayCost,RentRequestCars.TotalDays,RentRequestCars.RentRequestDate,users.Username,users.Email,users.FirstName,users.Image,users.PhoneNumber FROM `RentRequestCars`LEFT JOIN Cars ON Cars.carID=RentRequestCars.carID LEFT JOIN users ON RentRequestCars.userID=users.id WHERE RentRequestCars.RentRequestSellerStatus='Accepted' AND RentRequestCars.carID IN (SELECT carID from Cars where Cars.userID='".$userID."') ORDER BY RentRequestCars.RentRequestID DESC");
         
        $userResult=$query->result_array();
       
        foreach($userResult as $value)
		{
			$carID = $value['carID'];
			$RentRequestID = $value['RentRequestID'];
			$imagesData = $this->CarImages($carID);
		    if($imagesData){
		        $value['images'] = $imagesData;
		       
		    }
		    else
		    {
		         $value['images'] = [];
		    }
		    
		    $GetPaymentMode = $this->GetPaymentMode($RentRequestID,'Rent');
		    $SellerPaymentStatusToAdmin = $this->CheckPaymentStatusSellerToAdmin($RentRequestID);
		    if($SellerPaymentStatusToAdmin)
		    {
		        $value['sellerPaymentStatus']=1; 
		    }
		    else
		    {
		         $value['sellerPaymentStatus']=0;
		    }
		    $value['PaymentType']=$GetPaymentMode['PaymentType'];	
 			$response[]=$value;
		}
        
        return $response;
       
    }
    
    
    /* 
        Car listing of My Rent Request 
    
    */
    
     public function MyRentRequestCars($userID)
   {
        $query=$this->db->query("SELECT Cars.*,RentRequestCars.RentRequestID,RentRequestCars.FromDate,RentRequestCars.ToDate,RentRequestCars.FromTime,RentRequestCars.ToTime,RentRequestCars.RentRequestBuyerCancelStatus,RentRequestCars.RentRequestSellerStatus,RentRequestCars.PaymentStatus,RentRequestCars.totalAmount,RentRequestCars.DeliveryCost,RentRequestCars.pickupCost,RentRequestCars.PerDayCost,RentRequestCars.TotalDays,RentRequestCars.FuelCostsTotal,RentRequestCars.CleaningCostTotal,RentRequestCars.ReservationFeeTotal,RentRequestCars.RentRequestDate FROM `RentRequestCars`LEFT JOIN Cars ON Cars.carID=RentRequestCars.carID LEFT JOIN users ON Cars.userID=users.id WHERE RentRequestCars.userID='".$userID."' AND (RentRequestCars.RentRequestSellerStatus='Pending' OR RentRequestCars.RentRequestSellerStatus='Accepted') AND RentRequestCars.PaymentStatus='Pending' AND RentRequestCars.RentRequestBuyerCancelStatus=0 AND RentRequestCars.userID='".$userID."' ORDER BY RentRequestCars.RentRequestID DESC");
         
        $userResult=$query->result_array();
       
        foreach($userResult as $value)
		{
			$carID = $value['carID'];
			$RentRequestID= $value['RentRequestID'];
			
			$imagesData = $this->CarImages($carID);
		    if($imagesData){
		        $value['images'] = $imagesData;
		       
		    }
		    else
		    {
		         $value['images'] = [];
		    }
		    
		     
		    $PaymentQuery=$this->db->query("SELECT Payments.* FROM Payments where Payments.RequestID='".$RentRequestID."' AND RequestType='Rent'");
            $PaymentResult=$PaymentQuery->row_array();
            $value['PaymentData']=$PaymentResult;
		    
		     $value['distance'] = 29;
		     
		     
 			$response[]=$value;
		}
        
        return $response;
   }


     /*  
    
   Cancelled Rent Car Request Buyer side
    */
    
    public function CancelledRentRequestBuyerSide($RentRequestID)
    {
      
              $accountStatus=array( 
                'RentRequestBuyerCancelStatus'=>1,
                'RentRequestSellerStatus' => 'Rejected'
                ); 
              $this->db->where('RentRequestID',$RentRequestID);
              $this->db->update('RentRequestCars', $accountStatus);
               $this->db->trans_complete();
                  if($query=$this->db->affected_rows())
                {
                  return true;
                }
                else
                {
                    if ($this->db->trans_status() === FALSE)
                    {
                    return false;
                    }
                    else
                    {
                    return true;
                    }
                } 
    }    
    
    
    
     /* 
        Car listing of Ongoing Rent Request AT buyer
    
    */
    
     public function OngoingRentRequestCars($userID)
   {
       
        $query=$this->db->query("SELECT Cars.*,RentRequestCars.RentRequestID,RentRequestCars.FromDate,RentRequestCars.ToDate,RentRequestCars.FromTime,RentRequestCars.ToTime,RentRequestCars.RentRequestBuyerCancelStatus,RentRequestCars.RentRequestSellerStatus,RentRequestCars.PaymentStatus,RentRequestCars.totalAmount,RentRequestCars.DeliveryCost,RentRequestCars.pickupCost,RentRequestCars.PerDayCost,RentRequestCars.TotalDays,RentRequestCars.FuelCostsTotal,RentRequestCars.CleaningCostTotal,RentRequestCars.ReservationFeeTotal,RentRequestCars.RentRequestDate FROM `RentRequestCars`LEFT JOIN Cars ON Cars.carID=RentRequestCars.carID WHERE RentRequestCars.RentRequestSellerStatus='Accepted' AND RentRequestCars.RentRequestBuyerCancelStatus=0 AND RentRequestCars.PaymentStatus='Completed' AND UTC_TIMESTAMP() between RentRequestCars.FromDate and RentRequestCars.ToDate AND RentRequestCars.userID='".$userID."' ORDER BY RentRequestCars.RentRequestID DESC");
         
        $userResult=$query->result_array();
       
        foreach($userResult as $value)
		{
			$carID = $value['carID'];
			$RentRequestID= $value['RentRequestID'];
			
			$imagesData = $this->CarImages($carID);
		    if($imagesData){
		        $value['images'] = $imagesData;
		       
		    }
		    else
		    {
		         $value['images'] = [];
		    }
		    
		    
		    $PaymentQuery=$this->db->query("SELECT Payments.* FROM Payments where Payments.RequestID='".$RentRequestID."' AND RequestType='Rent'");
            $PaymentResult=$PaymentQuery->row_array();
            $value['PaymentData']=$PaymentResult;
            
 			$response[]=$value;
		}
        
        return $response;
   }
    
    
    /* 
        Car listing of upcoming Rent Request 
    
    */
    
     public function UpcomingRentRequestCars($userID)
   {
        $query=$this->db->query("SELECT Cars.*,users.FirstName,users.LastName,users.Image,users.PhoneNumber,users.Address,RentRequestCars.RentRequestID,RentRequestCars.FromDate,RentRequestCars.ToDate,RentRequestCars.FromTime,RentRequestCars.ToTime,RentRequestCars.RentRequestBuyerCancelStatus,RentRequestCars.RentRequestSellerStatus,RentRequestCars.PaymentStatus,RentRequestCars.totalAmount,RentRequestCars.DeliveryCost,RentRequestCars.pickupCost,RentRequestCars.PerDayCost,RentRequestCars.TotalDays,RentRequestCars.FuelCostsTotal,RentRequestCars.CleaningCostTotal,RentRequestCars.ReservationFeeTotal,RentRequestCars.RentRequestDate FROM `RentRequestCars`LEFT JOIN Cars ON Cars.carID=RentRequestCars.carID LEFT JOIN users ON users.id=RentRequestCars.userID WHERE RentRequestCars.RentRequestSellerStatus='Accepted' AND RentRequestCars.RentRequestBuyerCancelStatus=0 AND RentRequestCars.PaymentStatus='Completed' AND RentRequestCars.FromDateWithTime>UTC_TIMESTAMP() AND RentRequestCars.ToDateWithTime>UTC_TIMESTAMP() AND RentRequestCars.userID='".$userID."' ORDER BY RentRequestCars.RentRequestID DESC");
         
        $userResult=$query->result_array();
       
        foreach($userResult as $value)
		{
			$carID = $value['carID'];
			 $RentRequestID= $value['RentRequestID'];
			$imagesData = $this->CarImages($carID);
		    if($imagesData){
		        $value['images'] = $imagesData;
		       
		    }
		    else
		    {
		         $value['images'] = [];
		    }
		    
		    
		    $PaymentQuery=$this->db->query("SELECT Payments.* FROM Payments where Payments.RequestID='".$RentRequestID."' AND RequestType='Rent'");
            $PaymentResult=$PaymentQuery->row_array();
            $value['PaymentData']=$PaymentResult;
            
 			$response[]=$value;
		}
        
        return $response;
   }
   
   
   
   
   
   
     /* 
        Car listing of Rejected Rent Request 
    
    */
    
     public function CancelledRentRequestCars($userID)
   {
        $query=$this->db->query("SELECT Cars.*,RentRequestCars.RentRequestID,RentRequestCars.FromDate,RentRequestCars.ToDate,RentRequestCars.FromTime,RentRequestCars.ToTime,RentRequestCars.RentRequestBuyerCancelStatus,RentRequestCars.RentRequestSellerStatus,RentRequestCars.PaymentStatus,RentRequestCars.totalAmount,RentRequestCars.DeliveryCost,RentRequestCars.pickupCost,RentRequestCars.PerDayCost,RentRequestCars.TotalDays,RentRequestCars.FuelCostsTotal,RentRequestCars.CleaningCostTotal,RentRequestCars.ReservationFeeTotal,RentRequestCars.RentRequestDate FROM `RentRequestCars`LEFT JOIN Cars ON Cars.carID=RentRequestCars.carID LEFT JOIN users ON Cars.userID=users.id WHERE RentRequestCars.RentRequestSellerStatus='Rejected' AND RentRequestCars.userID='".$userID."' ORDER BY RentRequestCars.RentRequestID DESC");
         
        $userResult=$query->result_array();
       
        foreach($userResult as $value)
		{
			$carID = $value['carID'];
			$RentRequestID= $value['RentRequestID'];
			$imagesData = $this->CarImages($carID);
		    if($imagesData){
		        $value['images'] = $imagesData;
		       
		    }
		    else
		    {
		         $value['images'] = [];
		    }
		    
		   
		    $PaymentQuery=$this->db->query("SELECT Payments.* FROM Payments where Payments.RequestID='".$RentRequestID."' AND RequestType='Rent'");
            $PaymentResult=$PaymentQuery->row_array();
            $value['PaymentData']=$PaymentResult;
		     
		    $value['distance']=20;
		    
 			$response[]=$value;
		}
        
        return $response;
   }
   
   
   
   
   
   
    /* 
        Car listing of Completed Rent Request Buyer side
    
    */
    
     public function CompletedRentRequestCars($userID)
   {
        $query=$this->db->query("SELECT Cars.*,RentRequestCars.RentRequestID,RentRequestCars.FromDate,RentRequestCars.ToDate,RentRequestCars.FromTime,RentRequestCars.ToTime,RentRequestCars.RentRequestBuyerCancelStatus,RentRequestCars.RentRequestSellerStatus,RentRequestCars.PaymentStatus,RentRequestCars.totalAmount,RentRequestCars.DeliveryCost,RentRequestCars.pickupCost,RentRequestCars.PerDayCost,RentRequestCars.TotalDays,RentRequestCars.FuelCostsTotal,RentRequestCars.CleaningCostTotal,RentRequestCars.ReservationFeeTotal,RentRequestCars.RentRequestDate FROM `RentRequestCars`LEFT JOIN Cars ON Cars.carID=RentRequestCars.carID LEFT JOIN users ON Cars.userID=users.id WHERE RentRequestCars.RentRequestSellerStatus='Accepted' AND RentRequestCars.RentRequestBuyerCancelStatus=0 AND RentRequestCars.PaymentStatus='Completed' AND UTC_TIMESTAMP()>RentRequestCars.ToDateWithTime AND RentRequestCars.userID='".$userID."' ORDER BY RentRequestCars.RentRequestID DESC");
         
        $userResult=$query->result_array();
       
        foreach($userResult as $value)
		{
			$carID = $value['carID'];
			$RentRequestID= $value['RentRequestID'];
			
			$imagesData = $this->CarImages($carID);
		    if($imagesData){
		        $value['images'] = $imagesData;
		       
		    }
		    else
		    {
		         $value['images'] = [];
		    }
		    
		   
		    $PaymentQuery=$this->db->query("SELECT Payments.* FROM Payments where Payments.RequestID='".$RentRequestID."' AND RequestType='Rent'");
            $PaymentResult=$PaymentQuery->row_array();
            $value['PaymentData']=$PaymentResult;
            
		    $value['distance']=20;
		   
		   
		   $RatingsData = $this->CarRatingBySingleUser($carID,$userID);
		    if($RatingsData){
		        $value['Rating'] = $RatingsData;
		       
		    }
		    else
		    {
		         $value['Rating'] = NULL;
		    }
		    
 			$response[]=$value;
		}
        
        return $response;
   }
   
   
   
   
   
   
    /* 
        ONGOING RENT CAR AT SELLER SIDE
    
    */
    
     public function OngoingSellerRentCars($userID)
   {
        $query=$this->db->query("SELECT Cars.*,users.FirstName,users.LastName,users.Image,users.PhoneNumber,users.Address,RentRequestCars.RentRequestID,RentRequestCars.FromDate,RentRequestCars.ToDate,RentRequestCars.FromTime,RentRequestCars.ToTime,RentRequestCars.RentRequestBuyerCancelStatus,RentRequestCars.RentRequestSellerStatus,RentRequestCars.PaymentStatus,RentRequestCars.RentRequestDate,RentRequestCars.IsDeliveryMyPlace,RentRequestCars.IsPickupAfterUse FROM `RentRequestCars`LEFT JOIN Cars ON Cars.carID=RentRequestCars.carID LEFT JOIN users ON users.id=RentRequestCars.userID WHERE RentRequestCars.RentRequestSellerStatus='Accepted' AND RentRequestCars.RentRequestBuyerCancelStatus=0 AND RentRequestCars.PaymentStatus='Completed' AND UTC_DATE() between RentRequestCars.FromDate and RentRequestCars.ToDate AND Cars.userID='".$userID."' ORDER BY RentRequestCars.RentRequestID DESC");
         
        $userResult=$query->result_array();
       
        foreach($userResult as $value)
		{
			$carID = $value['carID'];
			$RentRequestID= $value['RentRequestID'];
			$imagesData = $this->CarImages($carID);
		    if($imagesData){
		        $value['images'] = $imagesData;
		       
		    }
		    else
		    {
		         $value['images'] = [];
		    }
		    
		    
		    $PaymentQuery=$this->db->query("SELECT Payments.* FROM Payments where Payments.RequestID='".$RentRequestID."' AND RequestType='Rent'");
            $PaymentResult=$PaymentQuery->row_array();
            $value['PaymentData']=$PaymentResult;
            
 			$response[]=$value;
		}
        
        return $response;
   }
    
    
    
     /* 
        Completed RENT CAR AT SELLER SIDE
    
    */
    
     public function CompletedSellerRentCars($userID)
   {
       
        $query=$this->db->query("SELECT Cars.*,users.FirstName,users.LastName,users.Image,users.PhoneNumber,users.Address,RentRequestCars.RentRequestID,RentRequestCars.FromDate,RentRequestCars.ToDate,RentRequestCars.FromTime,RentRequestCars.ToTime,RentRequestCars.RentRequestBuyerCancelStatus,RentRequestCars.RentRequestSellerStatus,RentRequestCars.PaymentStatus FROM `RentRequestCars`LEFT JOIN Cars ON Cars.carID=RentRequestCars.carID LEFT JOIN users ON users.id=RentRequestCars.userID WHERE  UTC_TIMESTAMP() > RentRequestCars.ToDate AND Cars.userID='".$userID."' ORDER BY RentRequestCars.RentRequestID DESC");
         
        $userResult=$query->result_array();
       
        foreach($userResult as $value)
		{
			$carID = $value['carID'];
			$RentRequestID= $value['RentRequestID'];
			
			$imagesData = $this->CarImages($carID);
		    if($imagesData){
		        $value['images'] = $imagesData;
		       
		    }
		    else
		    {
		         $value['images'] = [];
		    }
		   
		    $PaymentQuery=$this->db->query("SELECT Payments.* FROM Payments where Payments.RequestID='".$RentRequestID."' AND RequestType='Rent'");
            $PaymentResult=$PaymentQuery->row_array();
            $value['PaymentData']=$PaymentResult;
		    
 			$response[]=$value;
		}
        
        return $response;
   }
   
   
   
    public function saveCards($data)
    {
       
        if($this->db->insert('Cards',$data))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    /* RETURN Card DETAIL BY CHECKING ID */
    
    public function GetCardByUserID($id){
        $this->db->select('*');
        $this->db->from('Cards');
        $this->db->where('userID',$id);
     
        $query=$this->db->get();
        $userResult=$query->result_array();
        return $userResult;
    }

    public function GetCardDetailsByID($id){
        $this->db->select('*');
        $this->db->from('Cards');
        $this->db->where('cardID',$id);
     
        $query=$this->db->get();
        $userResult=$query->row_array();
        return $userResult;
    }

     /* Delete card */
     
    public function DeleteCard($cardID){
        
        $this->db->where('cardID', $cardID);
        if($this->db->delete('Cards'))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function addSellerStripeAccount($userId,$accountID){
		$this->db->select('*');
	    $this->db->where('userID',$userId);
	    $query = $this->db->get('SellerStripeAccount');
        $num = $query->num_rows();
		$data = array(
	        'userID'=> $userId,
            'stripeAccountID' => $accountID,
			//'bankID' => $bankID
         );
		if($num == 0){
			$this->db->insert('SellerStripeAccount',$data);
		}
		else{
			$data = array(
			'stripeAccountID' => $accountID
         );
		 $this->db->where('userID',$userId);
		 $this->db->update('SellerStripeAccount',$data);
		}
		return true;	
	}
	
	
	public function getStripeAccountID($userId){
		$this->db->select('*');
	    $this->db->where('userID',$userId);
	    $query = $this->db->get('SellerStripeAccount');
		$data =  $query->row_array();
		return $data;
	}
    
    public function AddBank($data)
    {
       
        if($this->db->insert('Banks',$data))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
     public function DeleteBank($bankID){
        
        $this->db->where('ID', $bankID);
        if($this->db->delete('Banks'))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    
     /* RETURN Bank DETAIL BY CHECKING ID */
    
    public function GetBankByUserID($userID){
        $this->db->select('Banks.*,UniversalBank.BankName,UniversalBank.BankImage');
        $this->db->from('Banks');
        $this->db->where('userID', $userID);
        $this->db->join('UniversalBank','UniversalBank.ID=Banks.BankID','Left');
       
        $query=$this->db->get();
        $userResult=$query->result_array();
        return $userResult;
    }
    
     /* RETURN Bank DETAIL BY CHECKING ID */
    
    public function GetAllBank(){
        $this->db->select('*');
        $this->db->from('UniversalBank');
       
        $query=$this->db->get();
        $userResult=$query->result_array();
        return $userResult;
    }
    
      /* RETURN Vehicle type */
    
    public function GetVehicleType(){
        $this->db->select('*');
        $this->db->from('VehicleType');
       
        $query=$this->db->get();
        $userResult=$query->result_array();
        return $userResult;
    }
    
    
      /*SAVE Payment DETAIL*/
    public function SavePayment($RequestID,$transactionNumber,$Amount,$DeliveryCost,$pickupCost,$PerDayCost,$downPaymentAmount,$EMIdeductDate,$EMIPlanType,$PaymentType,$RequestType,$userID,$carID,$cardID){
       
        $data = array(
        'RequestID'           =>  $RequestID,
        'TransactionNumber'   => $transactionNumber,
        'Amount'           =>  $Amount,
        'TotalAmount'      => '',
        'MonthlyAmount'    => '',
        'DeliveryCost'      =>  $DeliveryCost,
        'pickupCost'           => $pickupCost,
        'PerDayCost'           => $PerDayCost,
        'downPaymentAmount'    => $downPaymentAmount,
        'EMIdeductDate'    => $EMIdeductDate,
        'EMIPlanType'     => $EMIPlanType,
        'daysCount'    => '',
        'PaymentType'         => $PaymentType,
        'RequestType'         => $RequestType,
        'userID'              => $userID,
        'carID'              => $carID,
        'cardID'              => $cardID,
        'addedDate'    =>  date("Y-m-d H:i:s")
        );
        if($this->db->insert('Payments', $data))
        {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        else
        {
            return false;
        }
        
        
    }
    
    
    
     /*SAVE Seller Payment DETAIL*/
    public function SaveSellerPaymentToAdmin($RequestID,$transactionNumber,$Amount,$userID){
       
        $data = array(
        'RequestID'           =>  $RequestID,
        'TransactionNumber'   => $transactionNumber,
        'Amount'           =>  $Amount,
        'userID'              => $userID,
        'addedDate'    =>  date("Y-m-d H:i:s")
        );
        if($this->db->insert('SellerPaymentToAdmin', $data))
        {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        else
        {
            return false;
        }
        
        
    }
    
    
    
     /*SAVE Payment DETAIL*/
    public function SaveDownPayment($RequestID,$transactionNumber,$downPaymentAmount,$EMIdeductDate,$EMIPlanType,$daysCount,$PaymentType,$RequestType,$userID,$cardID){
       
        $data = array(
        'RequestID'           =>  $RequestID,
        'TransactionNumber'   => $transactionNumber,
        'Amount'           =>  '',
        'DeliveryCost'      =>  '',
        'pickupCost'           => '',
        'PerDayCost'           => '',
        'downPaymentAmount'    => $downPaymentAmount,
        'EMIdeductDate'    => $EMIdeductDate,
        'EMIPlanType'     => $EMIPlanType,
        'daysCount'    => $daysCount,
        'PaymentType'         => $PaymentType,
        'RequestType'         => $RequestType,
        'userID'              => $userID,
        'cardID'              => $cardID,
        'addedDate'    =>  date("Y-m-d H:i:s")
        );
        if($this->db->insert('Payments', $data))
        {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        else
        {
            return false;
        }
        
        
    }
    
    
     public function ChangePaymentStatus($RequestID,$RequestType)
   {
       if($RequestType=='Sell')
       {
            
                    $UpdateData=array(
	            "CarPaymentStatus"=>"Completed",
	            );
	            
           $this->db->where("ID",$RequestID);
           $result=$this->db->update("TestDriveRequestCars",$UpdateData);
       }
       else
       {
            
                    $UpdateData=array(
	            "PaymentStatus"=>"Completed",
	            );
            $this->db->where("RentRequestID",$RequestID);
            $result=$this->db->update("RentRequestCars",$UpdateData);
       }
       return $result;
   }
   
   
      public function updateRTOPaymentByBuyer($RequestID,$downPaymentAmount,$EMIdeductDate,$EMIPlanType,$daysCount,$TotalAmount,$MonthlyAmount)
   {
                  $UpdateData=array(
	            'downPaymentAmount'=>$downPaymentAmount,
	            'EMIdeductDate' => $EMIdeductDate,
	            'EMIPlanType' => $EMIPlanType,
	             'daysCount'=>$daysCount,
	             'TotalAmount'=>$TotalAmount,
	             'MonthlyAmount'=>$MonthlyAmount
	            );
	            
           $this->db->where("PaymentID",$RequestID);
           $result=$this->db->update("Payments",$UpdateData);
       
       return $result;
   }
   
   /*
   Update OnHold Status On Rent Request By SEller
  */
    
    public function UpdateHoldStatusTestDriveRequestBySeller($TestDriveRequestID,$Description)
    {
      
              $accountStatus=array( 
                'DescriptionAddedBySeller'=>$Description,
                'TestDriveStatus' => 'OnHold'
                ); 
              $this->db->where('ID',$TestDriveRequestID);
              $this->db->update('TestDriveRequestCars', $accountStatus);
               $this->db->trans_complete();
                  if($query=$this->db->affected_rows())
                {
                  return true;
                }
                else
                {
                    if ($this->db->trans_status() === FALSE)
                    {
                    return false;
                    }
                    else
                    {
                    return true;
                    }
                } 
    }    
    
    
      /*Update Test Drive*/
      
    public function UpdateTestDrive($RequestID,$TestDriveDate,$TestDriveTime,$Name,$Phone,$Location,$currDate){
       
       
        $data = array(
        'TestDriveDate'              =>  $TestDriveDate,
        'TestDriveTime'           => $TestDriveTime,
        'Name'                  =>  $Name,
        'Phone'         =>  $Phone,
        'Location'         => $Location,
        'DescriptionAddedBySeller'=>'',
        'addedDate'    =>  $currDate
        );
       
       
       
              $this->db->where('ID',$RequestID);
              $this->db->update('TestDriveRequestCars', $data);
               $this->db->trans_complete();
               
               
                  if($query=$this->db->affected_rows())
                {
                  return true;
                }
                else
                {
                    if ($this->db->trans_status() === FALSE)
                    {
                    return false;
                    }
                    else
                    {
                    return true;
                    }
                } 
       
        
    }
    
     /* Get Seller details by CarID */
     
    public function SellerDetailsByCarID($carID){
        $this->db->select('Cars.carID,Cars.Model,Cars.Brand,Cars.address,users.*');
        $this->db->from('Cars');
        $this->db->join('users','users.id=Cars.userID','Left');
        $this->db->where('Cars.carID',$carID);
        $query=$this->db->get();
        $userResult=$query->row_array();
      
        return $userResult;
       
    }
    
     public function GetCarIDByTestReqID($TestDriveReqID){
        $this->db->select('TestDriveRequestCars.userID,TestDriveRequestCars.carID,TestDriveRequestCars.TestDriveDate,TestDriveRequestCars.TestDriveTime,TestDriveRequestCars.TestDriveRequestType');
        $this->db->from('TestDriveRequestCars');
        $this->db->where('TestDriveRequestCars.ID',$TestDriveReqID);
        $query=$this->db->get();
        $userResult=$query->row_array();
    
        return $userResult;
       
    }
    
     public function GetSellerStripeAccountID($userID){
        $this->db->select('stripeAccountID');
        $this->db->from('SellerStripeAccount');
        $this->db->where('SellerStripeAccount.userID',$userID);
        $query=$this->db->get();
        $userResult=$query->row_array();
      
        return $userResult;
       
    }
    
     public function GetCarIDByRentReqID($RentReqID){
        $this->db->select('RentRequestCars.carID,RentRequestCars.FromDate,RentRequestCars.ToDate,RentRequestCars.FromTime,
        RentRequestCars.ToTime,RentRequestCars.userID');
        $this->db->from('RentRequestCars');
        $this->db->where('RentRequestCars.RentRequestID',$RentReqID);
        $query=$this->db->get();
        $userResult=$query->row_array();
      
        return $userResult;
       
    }
    
    
    
     public function BuyerDetailsByRequestID($requestID){
        $this->db->select('TestDriveRequestCars.TestDriveDate,TestDriveRequestCars.TestDriveTime,TestDriveRequestCars.Name as Tname,TestDriveRequestCars.Phone as Tphone,TestDriveRequestCars.Location as Tlocation,users.*');
        $this->db->from('TestDriveRequestCars');
        $this->db->join('users','users.id=TestDriveRequestCars.userID','Left');
        $this->db->where('TestDriveRequestCars.ID',$requestID);
        $query=$this->db->get();
        $userResult=$query->row_array();
      
        return $userResult;
       
    }
   
   
   
     
     public function BuyerDetailsByRentRequestID($requestID){
        $this->db->select('RentRequestCars.*,users.*');
        $this->db->from('RentRequestCars');
        $this->db->join('users','users.id=RentRequestCars.userID','Left');
        $this->db->where('RentRequestCars.RentRequestID',$requestID);
        $query=$this->db->get();
        $userResult=$query->row_array();
      
        return $userResult;
       
    }
   
    /*SAVE SaveNoification*/
    public function SaveNoification($SenderID,$userID,$Message,$NotificationType,$CreatedDate){
       
        $data = array(
        'SenderID'           =>  $SenderID,
        'userID'            => $userID,
        'Message'              =>  $Message,
        'NotificationType'    => $NotificationType,
        'CreatedDate'    =>  $CreatedDate
        );
        if($this->db->insert('Notifications', $data))
        {
            return true;
        }
        else
        {
           return false; 
        }
    }
    
    
      //Update buyerisInterested
      
      public function updateBuyerInterested($TestBookRequestID,$isBuyerInterested)
    {
      
              $accountStatus=array( 
                'isBuyerInterested'=>$isBuyerInterested
                ); 
              $this->db->where('ID',$TestBookRequestID);
              $this->db->update('TestDriveRequestCars', $accountStatus);
               $this->db->trans_complete();
                  if($query=$this->db->affected_rows())
                {
                  return true;
                }
                else
                {
                    if ($this->db->trans_status() === FALSE)
                    {
                    return false;
                    }
                    else
                    {
                    return true;
                    }
                } 
    }
    
    // Check Rating already provided
    
     public function checkRatingOfCar($userID,$carID)
     {
        $this->db->select('RatingID');
        $this->db->from('CarRating');
        $this->db->where('userID',$userID);
        $this->db->where('carID',$carID);
       
       
        $query=$this->db->get();
        if($query->num_rows()>0){
          return false;
        }else{
          return true;
        }
   }
   
   
    public function saveRating($userid,$carID,$Rating,$Comment){
       
        $data = array(
        'userID'           =>  $userid,
        'Comment'           =>  $Comment,
        'Rating'              =>  $Rating,
        'carID'           =>  $carID,
        'RatingDateTime'    =>  date("Y-m-d H:i:s")
        );
        $this->db->insert('CarRating', $data);
        if($this->db->insert_id())
        {
            return true;
        }
        else
        {
            return false;
        }
      
    }
    
    
    // Update Rating
    
    public function UpdateRating($userid,$carID,$Rating,$Comment){
        $accountStatus=array( 
            'Comment'=>$Comment,
            'Rating'=>$Rating
            ); 
          $this->db->where('userID', $userid);
          $this->db->where('carID', $carID);
          $this->db->update('CarRating', $accountStatus);
          
          $this->db->trans_complete();
          if($query=$this->db->affected_rows())
        {
          return true;
        }
        else
        {
            if ($this->db->trans_status() === FALSE)
            {
        return false;
             }
             else
             {
            return true;
             }
        }
          
          
   }
   
   
     /*RETURN CAR Rating */
    public function CarRating($carID)
    {
        $this->db->select('CarRating.Comment,CarRating.Rating,CarRating.RatingDateTime,users.FirstName,users.LastName,users.Username,users.Image');
        $this->db->from('CarRating');
        $this->db->join('users','users.id=CarRating.userID','Left');
        $this->db->where('CarRating.carID',$carID);
        $query=$this->db->get();
        $userResult=$query->result_array();
        return $userResult;
       
    }
    
    
     /*RETURN CAR Rating */
    public function CarRatingBySingleUser($carID,$userID)
    {
        $this->db->select('CarRating.Comment,CarRating.Rating,CarRating.RatingDateTime,users.FirstName,users.LastName,users.Username,users.Image');
        $this->db->from('CarRating');
        $this->db->join('users','users.id=CarRating.userID','Left');
        $this->db->where('CarRating.carID',$carID);
        $this->db->where('CarRating.userID', $userID);
        $query=$this->db->get();
        $userResult=$query->row_array();
        return $userResult;
       
    }
     /*RETURN Avg CAR Rating */
    public function AvgCarRating($carID)
    {
        $query=$this->db->query("SELECT Count(*) as rows,SUM(Rating) as Ratings FROM CarRating WHERE carID='".$carID."'");
        $result=$query->result_array();
        
         $rows=$result[0]['rows'];
         if($rows>=1)
         {
           $totals=$result[0]['Ratings'];   
           $avgRating=$totals/$rows;
         }
         else
         {
          $avgRating=0;
         }
       
       
        return $avgRating;
       
    }
    
    public function CompleteRequest($TestRequestID){
        $accountStatus=array( 
            'TestDriveStatus'=>'Completed'
            ); 
          $this->db->where('ID', $TestRequestID);
          $this->db->update('TestDriveRequestCars', $accountStatus);
          if($query=$this->db->affected_rows())
        {
          return true;
        }
        else
        {
            return false;
        }
   }
   
   
    public function CompleteRequestAjax($requestID){
        $accountStatus=array( 
            'TestDriveStatus'=>'Completed'
            ); 
        
          $this->db->where('ID', $requestID);
          $this->db->update('TestDriveRequestCars', $accountStatus);
          if($query=$this->db->affected_rows())
        {
          return true;
        }
        else
        {
            return false;
        }
   }
   
    
    
      /*RETURN Notification  OF USER */
    public function BuyerNotificationListDB($userID){
        $this->db->select('Notifications.*,users.Username as sellerName,users.Image as sellerImage');
        $this->db->from('Notifications');
        $this->db->join('users','users.id=Notifications.SenderID','Left');
        $this->db->where('Notifications.userID',$userID);
        $this->db->order_by("Notifications.NotificationID", "desc");
       
     
        $query=$this->db->get();
         
        $userResult=$query->result_array();
        return $userResult;
        
    }
    
    
      /*RETURN Notification  OF USER */
    public function SellerNotificationListDB($userID){
        $this->db->select('Notifications.*,users.Username as buyerName,users.Image as buyerImage');
        $this->db->from('Notifications');
         $this->db->join('users','users.id=Notifications.SenderID','Left');
        $this->db->where('Notifications.userID',$userID);
        $this->db->order_by("Notifications.NotificationID", "desc");
       
     
        $query=$this->db->get();
         
        $userResult=$query->result_array();
        return $userResult;
        
    }
    
    
       public function DeleteNotification($notificationID){
        
        $this->db->where('NotificationID', $notificationID);
        if($this->db->delete('Notifications'))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    
     public function DeleteAllNotification($userID,$userType){
        
        if($userType=='Seller')
        {
            $this->db->where('userID', $userID);
            if($this->db->delete('Notifications'))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
                $this->db->where('userID', $userID);
                if($this->db->delete('Notifications'))
                {
                    return true;
                }
                else
                {
                    return false;
                }
        }
    }
    
      public function GetRentRequestDetails($carID,$userID){
        $query=$this->db->query("SELECT RentRequestCars.DeliveryCost,RentRequestCars.pickupCost,RentRequestCars.PerDayCost,RentRequestCars.TotalDays,
        RentRequestCars.FuelCostsTotal,RentRequestCars.CleaningCostTotal,RentRequestCars.ReservationFeeTotal
        FROM RentRequestCars where RentRequestCars.userID='".$userID."' AND RentRequestCars.carID='".$carID."'");
        
        $Result=$query->result_array();
        if(empty($Result))
        {
            return false;
        }
        else
        {
        return $Result;
        }
        
        
    }
    
    
    
     /*SAVE Webhook Response DETAIL*/
    public function SaveWebhookResponse($invoiceData){
       
        $data = array(
        'invoiceContent'           =>  $invoiceData,
        'addedDate'    =>  date("Y-m-d H:i:s")
        );
        $this->db->insert('StripeWebhookTB', $data);
        $userId= $this->db->insert_id();
      
        return $userId;
    }
    
    
   
   
}//Class end here0