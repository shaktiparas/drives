<?php
class Dashboard_model extends CI_model{
    
    public function __construct() {
        parent::__construct();
        $this->data = array(
            'adminRole' => 1,
            'barberRole' => 2,
            'customerRole' => 3
        );
    }
    
    
    public function updatePasswordByUserID($userid,$password){
        $accountStatus=array( 
            'password'=>md5($password),
            ); 
          $this->db->where('ID', $userid);
          $this->db->update('admin', $accountStatus);
          
         
          if($query=$this->db->affected_rows())
        {
          return true;
        }
        else
        {
            return false;
        }
   }
   
       /* Get Seller details by CarID */
     
    public function SellerDetailsByCarID($carID){
        $this->db->select('Cars.carID,Cars.Model,Cars.vehicleType,users.Username as sellerName,users.Email as sellerEmail');
        $this->db->from('Cars');
        $this->db->join('users','users.id=Cars.userID','Left');
        $this->db->where('Cars.carID',$carID);
        $query=$this->db->get();
        
        $userResult=$query->row_array();
      
        return $userResult;
       
    }
    public function totalBuyer()
    {
        $this->db->select('id');
        $this->db->from('users');
        $this->db->where('userType','Buyer');
        $result=$this->db->get();
        return $result->num_rows();
    }
   
     public function totalSeller()
    {
        $this->db->select('id');
        $this->db->from('users');
        $this->db->where('userType','Seller');
        $result=$this->db->get();
        return $result->num_rows();
    }
    
     public function totalBookings()
    {
        $this->db->select('ID');
        $this->db->from('TestDriveRequestCars');
        $this->db->where('CarPaymentStatus','Completed');
        $result=$this->db->get();
        return $result->num_rows();
    }
    
    
    
    
    public function totalPointsWallet()
    {
        $this->db->select('SUM(points) as totalPoints');
        $this->db->from('users');
        $result=$this->db->get();
        return $result->result_array();
    }
    
     public function activeBuyer()
    {
        $this->db->select('id,Username,PhoneNumber,Email,Address');
        $this->db->from('users');
        $this->db->where('userType','Buyer');
        $result=$this->db->get();
        return $result->result_array();
    }
    
      public function activeSeller()
    {
        $this->db->select('id,Username,PhoneNumber,Email,Address');
        $this->db->from('users');
        $this->db->where('userType','Seller');
        $result=$this->db->get();
        return $result->result_array();
    }
   
    
       public function userProfileData($id)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('id',$id);
        $result=$this->db->get();
        return $result->row_array();
    }
    
       public function carListings()
    {
        $this->db->select('Cars.*,users.Username');
        $this->db->from('Cars');
        $this->db->join('users','users.id=Cars.userID','Left');
        $result=$this->db->get();
        return $result->result_array();
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
    
      public function carDetails($id)
    {
        $this->db->select('*');
        $this->db->from('Cars');
        $this->db->where('carID',$id);
        $result=$this->db->get();
        return $result->row_array();
    }
    
    public function CheckCarStatus($type,$carID)
    {
        if($type=='Sell')
        {
            
        }
        else
        {
            
        }
    }
    
    public function blockUser($id)
    {
        $updateData=array( 
            'status'=> 0
            );
            
          $this->db->where('id', $id);
          $this->db->update('users', $updateData);
          if($query=$this->db->affected_rows())
        {
         return true;
        }
        else
        {
            return false;
        }
    }
    
      public function unblockUser($id)
    {
        $updateData=array( 
            'status'=> 1
            );
            
          $this->db->where('id', $id);
          $this->db->update('users', $updateData);
          if($query=$this->db->affected_rows())
        {
         return true;
        }
        else
        {
            return false;
        }
    }
    
    
     /*SAVE SMS FIELD VALUE */
     
    public function SaveSmsField($Gateway,$FixedCost,$BaseCost,$SmsCost,$Profit,$Adjust){
       
        $this->db->select('ID');
        $this->db->from('sms_calculation_field');
        $result=$this->db->get();
        $RESULTS=$result->row_array();
        
        if(empty($RESULTS))
        {
            $data = array(
            'Gateway'           =>  $Gateway,
            'FixedCost'           =>  $FixedCost,
            'BaseCost'              =>  $BaseCost,
            'SmsCost'           =>  $SmsCost,
            'Profit'                  =>  $Profit,
            'Adjust'         =>  $Adjust
            );
            $this->db->insert('sms_calculation_field', $data);
            $insertId= $this->db->insert_id();
            
            if($insertId)
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
            $data = array(
            'Gateway'           =>  $Gateway,
            'FixedCost'           =>  $FixedCost,
            'BaseCost'              =>  $BaseCost,
            'SmsCost'           =>  $SmsCost,
            'Profit'                  =>  $Profit,
            'Adjust'         =>  $Adjust
            );
            
          $this->db->update('sms_calculation_field', $data);
          if($query=$this->db->affected_rows())
        {
         return true;
        }
        else
        {
            return false;
        }
        }
       
    } 
    
    
     public function reportManagement()
     {
        $this->db->select('help_center.subject,help_center.message,help_center.created_date,users.email,users.image');
        $this->db->from('help_center');
        $this->db->join('users','users.id = help_center.userid');
        $query=$this->db->get();
        $Result=$query->result_array();
        return $Result;
        
        
    }
    
       /*RETURN outright test drive */
    public function outrightTestDriveRequestListing(){
        $query=$this->db->query("SELECT TestDriveRequestCars.*,users.Username,users.PhoneNumber FROM TestDriveRequestCars LEFT JOIN users ON TestDriveRequestCars.userID=users.id where TestDriveRequestCars.TestDriveRequestType='OBP' ORDER BY TestDriveRequestCars.ID DESC");
        
        $userResult=$query->result_array();
       
    
         foreach($userResult as $value)
		{
			$carID = $value['carID'];
			$sellerDetails=$this->SellerDetailsByCarID($carID);
			
		    
		     $value['sellerName']=$sellerDetails['sellerName'];
		     $value['vehicleType']=$sellerDetails['vehicleType'];
		   
 			$response[]=$value;
		}
        
        return $response;
       
       
    }
    
     /*RETURN RTO test drive */
    public function RTOTestDriveRequestListing(){
        $query=$this->db->query("SELECT TestDriveRequestCars.*,users.Username,users.PhoneNumber FROM TestDriveRequestCars LEFT JOIN users ON TestDriveRequestCars.userID=users.id where TestDriveRequestCars.TestDriveRequestType='RTO' ORDER BY TestDriveRequestCars.ID DESC");
        
        $userResult=$query->result_array();
       
    
         foreach($userResult as $value)
		{
			$carID = $value['carID'];
			$sellerDetails=$this->SellerDetailsByCarID($carID);
			
		    
		     $value['sellerName']=$sellerDetails['sellerName'];
		     $value['vehicleType']=$sellerDetails['vehicleType'];
		   
 			$response[]=$value;
		}
        
        return $response;
       
       
    }
    
    
     /*RETURN outright test drive */
    public function outrightTestDriveRequestDetails($requestID){
        $query=$this->db->query("SELECT TestDriveRequestCars.*,users.Username,users.PhoneNumber FROM TestDriveRequestCars LEFT JOIN users ON TestDriveRequestCars.userID=users.id where TestDriveRequestCars.ID='".$requestID."'");
        
        $userResult=(array)$query->row();
        
    
			$carID = $userResult['carID'];
			$sellerDetails=$this->SellerDetailsByCarID($carID);
			$carDetails=$this->carDetails($carID);
			$imagesData = $this->CarImages($carID);
		    
			
		    
		     $userResult['sellerName']=$sellerDetails['sellerName'];
		     $userResult['vehicleType']=$sellerDetails['vehicleType'];
		     
		     $userResult['vehicleType']=$carDetails['vehicleType'];
		     $userResult['carType']=$carDetails['carType'];
		     $userResult['Model']=$carDetails['Model'];
		     $userResult['Color']=$carDetails['Color'];
		     $userResult['Brand']=$carDetails['Brand'];
		     $userResult['Mileage']=$carDetails['Mileage'];
		     $userResult['Seater']=$carDetails['Seater'];
		     $userResult['Year']=$carDetails['Year'];
		     $userResult['Price']=$carDetails['Price'];
		     $userResult['Description']=$carDetails['Description'];
		     $userResult['addedDate']=$carDetails['addedDate'];
		     if($imagesData)
		    {
		      $userResult['images']=$imagesData;
		       
		    }
		    else
		    {
		       $userResult['images']="";
		    }
		     
		  
 		
        
        return $userResult;
       
       
    }
    
    public function GetCarIDByTestReqID($TestDriveReqID){
        $this->db->select('TestDriveRequestCars.userID,TestDriveRequestCars.carID,TestDriveRequestCars.TestDriveDate,TestDriveRequestCars.TestDriveTime');
        $this->db->from('TestDriveRequestCars');
        $this->db->where('TestDriveRequestCars.ID',$TestDriveReqID);
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
    
     
     public function transactionHistory(){
            
        $query=$this->db->query("SELECT Payments.*,users.Username as buyerName FROM Payments LEFT JOIN users ON users.ID=Payments.userID order by Payments.PaymentID desc");
         
      
        $Result=$query->result_array();
        
        foreach($Result as $values)
        {
            $RequestType=$values['RequestType'];
            $RequestID=$values['RequestID'];
            
            if($RequestType=='Sell')
            {
                $Cars=$this->GetCarIDByTestReqID($RequestID);
            }
            else
            {
                $Cars=$this->GetCarIDByRentReqID($RequestID);
            }
            
            $carid=$Cars['carID'];
            
            $Sellers=$this->SellerDetailsByCarID($carid);
            $SellerName=$Sellers['sellerName'];
            //$sellerEmail=$Sellers['sellerEmail'];
            
            $values['sellerName']=$SellerName;
            //$values['sellerEmail']=$sellerEmail;
             
             $results[]=$values;
        }
        return $results;
        
        
    }
   
   public function transactionDetails($id)
   {
        $query=$this->db->query("SELECT Payments.*,users.Username as buyerName,users.Email FROM Payments LEFT JOIN users ON users.ID=Payments.userID where Payments.PaymentID='".$id."' order by Payments.PaymentID desc");
         
      
        $values=$query->row_array();
        
          $RequestType=$values['RequestType'];
            $RequestID=$values['RequestID'];
            
            if($RequestType=='Sell')
            {
                $Cars=$this->GetCarIDByTestReqID($RequestID);
            }
            else
            {
                $Cars=$this->GetCarIDByRentReqID($RequestID);
            }
            
            $carid=$Cars['carID'];
            
            $Sellers=$this->SellerDetailsByCarID($carid);
            $SellerName=$Sellers['sellerName'];
            $sellerEmail=$Sellers['sellerEmail'];
            
            $values['sellerName']=$SellerName;
            $values['sellerEmail']=$sellerEmail;
             
             return $values;
        
       
       
   }
 
}