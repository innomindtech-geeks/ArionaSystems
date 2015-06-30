<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//error_reporting(0);
class Admin extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
 // Layout used in this controller
    public $layout_view = 'layout/admin';
	public function __construct() {
   	 	parent::__construct();
   	 	/*Additional code which you want to run automatically in every function call */
   	 	 
		 $this->load->library('layout');          // Load layout library
		 $this->load->library('form_validation');
	}
    public function index() {

		if($this->input->post())
		{
		
			$this->form_validation->set_rules('txtfname', 'First Name', 'required');
            $this->form_validation->set_rules('txtlname', 'Last Name', 'required');
            $this->form_validation->set_rules('txtemail', 'Email', 'required|trim|valid_email');
			
			 if ($this->form_validation->run() == FALSE) {
			
				$message        = validation_errors();
				$msg_class		= "error";
				Message::setPageMessage($message, $msg_class);
				
				$message = Message::getMessage();
				$data['message'] = $message;
				
				$this->layout->view('adminProfile', $data);
			 
            } else {
			
			$save['user_id']   = $this->session->userdata('id');
			$save['first_name'] = $this->input->post('txtfname');
            $save['last_name'] = $this->input->post('txtlname');
            $save['email']	   = $this->input->post('txtemail');
            $save['username']  = $this->input->post('txtusername');
			
			$result = Auth::update_admin($save);
			// $this->pre($result);
			if($result!="")
			{
				$message        = "Details updated successfully";
				$msg_class		= "success";
				Message::setPageMessage($message, $msg_class);
			}	
			
			redirect('admin/admin');
			
			}
				
		}
		else
		{
			
			$id = $this->session->userdata('id');
			
			$res = Auth::get_admin($id);
			
			$message = Message::getMessage();
			$data = array('adminDetails' => $res,'message' => $message);
			$this->layout->view('adminProfile', $data);
		
		}
	 }
    
	public function changePassword()
	{
		
		if($this->input->post())
		{
			
			$this->form_validation->set_rules('txtOldPassword','Old Password','trim|required|min_length[4]|max_length[32]|callback_checkPassword');
			$this->form_validation->set_rules('txtNewPassword','New Password','trim|required|min_length[4]|max_length[32]');
			$this->form_validation->set_rules('txtConfirmPassword','Confirm Password','trim|required|min_length[4]|max_length[32]|matches[txtNewPassword]');
	
			 if ($this->form_validation->run() == FALSE) {
			
				$message        = validation_errors();
				$msg_class		= "error";
				Message::setPageMessage($message, $msg_class);
				
				$message = Message::getMessage();
				$data['message'] = $message;
				
				$this->layout->view('changePassword', $data);
			 
            } else {
		
			$oldPassword 		= $this->input->post('txtOldPassword');
			
            $id					= $this->session->userdata('id');
            $save['password']	= md5($this->input->post('txtNewPassword'));
		
			$result = Auth::change_password($id,$save);
			
			// $this->pre($result);
			
			
           
			if($result!="")
			{
				$message        = "Password updated successfully";
				$msg_class		= "success";
				Message::setPageMessage($message, $msg_class);
			}	
			
			redirect('admin/admin/changePassword');
			
			}
				
		}
		else
		{
			$message = Message::getMessage();
			$data = array('message' => $message);
			$this->layout->view('changePassword', $data);
		}
	}

	public function checkPassword($str)
	{
		
		$id     = $this->session->userdata('id');
		$result = Auth::check_password($id);
		
		if($result)
		{
		
			$oldPassword = md5($str);
			$password 	 = $result->password;

			if($oldPassword == $password )
			{	
				return true;
			}
			else {
				 $this->form_validation->set_message('checkPassword', "Old password you entered is incorrect");
				return false;
			}
		
		}
		else{
			return false;
		}
		
	}

	
	
	
	
	
	
	
}
