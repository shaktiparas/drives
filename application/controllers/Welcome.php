<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        define('HTTP_OK', '200');
        $this->load->database();
        $this->load->helper('url');
        $this->load->model('Model_test');
    }

	public function allUser() {

		$allUsers = $this->Model_test->allUser();

		$countUsers = count($allUsers);
		if(!empty($allUsers))
		{
			$response=array("success"=>1,"message"=>"All Bottom's Up users here!", "count" => $countUsers, "data" => $allUsers);  
		}  else {
			$response=array("success"=>1,"message"=>"No Users!", "data" => $allUsers);  
		}  

        echo json_encode($response);  
    }


	public function index()
	{
		$this->load->view('welcome_message');
	}
}
