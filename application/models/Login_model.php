<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Login_model (Login Model)
 * Login model class to get to authenticate user credentials 
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Login_model extends CI_Model
{
    
    /**
     * This function used to check the login credentials of the user
     * @param string $email : This is email of the user
     * @param string $password : This is encrypted password of the user
     */
    function loginMe($email, $password)
    {
        $this->db->select('*');
        $this->db->from('admin');
        $this->db->where('email', $email);
        $this->db->where('password',$password);
        $query=$this->db->get();
        
        
        if($query)
        {
           return $query->row_array();
        }
        else{
          return false;
        }
    }
    
   /*Start checkExistEmail Model*/
   public function checkExistEmail($email){
        $this->db->select('*');
        $this->db->from('tbl_admin');
        $this->db->where('email',$email);
        $query=$this->db->get();
        if($query->num_rows()>0){
          return false;
        }else{
          return true;
        }
    }
    /*End checkExistEmail Model*/
      /*Start resetPassword Model*/
        public function resetPassword($email, $newPassword){
         $changePasswordData=array(
            'password'=>$newPassword
            );   
        $this->db->where('email', $email);
        $this->db->update('tbl_admin', $changePasswordData);
        if($query=$this->db->affected_rows())
        {
          return 1;
        }
        else {
            return 0;
        }
      }
      /*End resetPassword Model*/
   }

?>