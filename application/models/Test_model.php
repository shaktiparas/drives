<?php
class Test_model extends CI_model{
    
    public function __construct() {
        parent::__construct();
        $this->data = array(
            'adminRole' => 1,
            'barberRole' => 2,
            'customerRole' => 3
        );

    }
    
    public function completedAppointmentsByBarber()
    {
        $this->db->select('u.firstName,u.lastName,b.intialBarberLatitude,b.intialBarberLongitude,r.totalAmount,r.date,r.bookingID');
        $this->db->where('b.barberStatus','4');
        $this->db->from('tbl_paymentRequestByBarber as r');
        $this->db->join('tbl_request_bookings as b','b.requestBookingID = r.bookingID','left');
        $this->db->join('tbl_users as u','u.id = r.userID','left');
        $query = $this->db->get();
        $data =  $query->result_array();
        foreach($data as $value){
            $bookingID = $value['bookingID'];
            $title = $this->getSelectedServicesByBooking($bookingID);
            $value['serviceName'] = $title;
            $result[] = $value;
        }
        return $result;
    }
    public function completedPaymentByClient()
    {
        $this->db->select('u.firstName,u.lastName,b.intialClientLatitude,b.intialClientLongitude,r.TotalamountDeduct,r.date,r.bookingID');
        $this->db->where('b.clientStatus','3');
        $this->db->from('tbl_paymentRequestByBarber as r');
        $this->db->join('tbl_request_bookings as b','b.requestBookingID = r.bookingID','left');
        $this->db->join('tbl_users as u','u.id = r.userID','left');
        $query = $this->db->get();
        $data = $query->result_array();
        foreach($data as $value){
            $bookingID = $value['bookingID'];
            $title = $this->getSelectedServicesByBooking($bookingID);
            $value['serviceName'] = $title;
            $result[] = $value;
        }
        return $result;
    }
    public function getSelectedServicesByBooking($bookingID){
        $this->db->select('ss.servicesID,s.name,s.description,s.price');
        $this->db->where('ss.bookingID',$bookingID);
        $this->db->from('tbl_selectedServices as ss');
        $this->db->join('tbl_services as s','s.id = ss.servicesID','left');
        $query = $this->db->get();
        $data = $query->result_array();
        if($data){
            $title = $this->servicesTitleString($data);
        }
        else{
            $title = "";
        }
        return $title; 
    }
    public function servicesTitleString($services){
        $title = implode(', ', array_map(function ($entry) {
                            return $entry['name'];
                        }, $services));
        return  $title;          
    }
}
?>