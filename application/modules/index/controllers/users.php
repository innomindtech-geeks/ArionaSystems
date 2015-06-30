<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

 // Layout used in this controller
   
	public function __construct() {
   	 	parent::__construct();
   	 	/*Additional code which you want to run automatically in every function call */
   	 	 $this->load->library('layout');          // Load layout library
		 $this->load->helper('url');
		 
	}
 
 
 
	/*
     * function to register the user's
     */
    public function register() {  	
		
		$this->load->library('form_validation');
			
		$this->form_validation->set_rules('username', 'user Name', 'required|trim|callback_is_username_exists');
		$this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email|callback_is_email_exists');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');
		$this->form_validation->set_rules('country', 'Country', 'required');
		
		if ($this->form_validation->run() == FALSE)			{
		
			echo validation_errors();
			exit();
		
		}else{			
			
			$data['u_username']   	 	   		= $this->input->post('username');
			$data['u_email']	    	 	    = $this->input->post('email');
			$data['u_pwd']      	  	  		= md5($this->input->post('password'));
			$data['u_country']	      	   		= $this->input->post('country');
			$data['u_subscribe_newsletter']     = $this->input->post('subscribe_newsletter');
			$data['u_joinedon']       	   		= date('Y-m-d H:i:s');
			$data['u_forgot_pwd_code']     		= Util::randomCode();
			$data['u_status']     		   		= 1;
		
			$result 		=	User::addUser($data);
			
			if($result){
					$emailAddress[$data['u_email']] 	        	= "Admin";
					$replaceParameters['name'] 				    	= $data['u_username'];	
					$replaceParameters['email'] 					= $data['u_email'];	
					$replaceParameters['password'] 					= $this->input->post('password');	
					$replaceParameters['SHOW_MAIL'] 				= 1;									  
					$objMailer 		= new Mailer();
					$objMailer->sendMail($emailAddress, 'Registration-user', $replaceParameters);
					
					echo 'You are successfully registered with us';
					exit();
			}else{
					echo 'Registration failed';
					exit();
			}
		
		}
		
		
    }
	 /* function to check the email exists in user table*/
	function is_email_exists($email) 
	{
		
          // $result=$this->db->query('SELECT email FROM tbl_user WHERE email=? LIMIT 1',array($email));
          $result=User::checkEmail($email);
		  	  
		  if($result){
			 $this->form_validation->set_message('is_email_exists', 'This email is already registered with us. Please use another email id. ');
			 return false;  
		  }
		  
    }
	 /* function to check the email exists in user table*/
	function is_username_exists($username) 
	{
		
          // $result=$this->db->query('SELECT email FROM tbl_user WHERE email=? LIMIT 1',array($email));
          $result=User::checkusername($username);
		  	  
		  if($result){
			 $this->form_validation->set_message('is_username_exists', 'The username you entered is already in use. please try another one.');
			 return false;  
		  }
		  
    }
	/* function to chack the alphanumeric charecters*/
	function alpha_dash_space($str)
	{
		if( ! preg_match("/^([-a-z0-9_ ])+$/i", $str)) {
		
			$this->form_validation->set_message('alpha_dash_space', 'Password must be alphanumeric');
			return FALSE; 
			
			} else{ 
			
			return TRUE;
			
			}
		
	} 
 
	/* function to login */
	function loggin(){
		header("Access-Control-Allow-Origin: *");
	 $this->load->library('form_validation');
            $this->form_validation->set_rules(array(
                                                    array('field'=>'login_email','label'=>'User Name','rules'=>'required'),
                                                    array('field'=>'login_password','label'=>'Password','rules'=>'max_length[20]|required')
            ));
            if ($this->form_validation->run()===FALSE)
            { 
				echo validation_errors();
				exit();
			}else{
				
				// $result=User::checkEmail($this->input->post('login_email'));
				// if(empty($result)){
					// echo 'The email you entered is not found. Please register to login';
					// exit();
				// }
					
				 $check_result=User::is_user_exist($this->input->post('login_email'),$this->input->post('login_password'));	
	
				 if($check_result){
						$data = array(	   'user_id'  	=> $check_result->u_id,
										   'email'    	=> $check_result->u_email,
										   'name'     	=> $check_result->u_username,
										   'logged_in'	=> TRUE
									   );						
						$this->session->set_userdata($data);
						echo '1';
						exit();
				 }else{
					echo '2';
					exit();
				 }
				 
			}
   }
   
   /* function to logout from site */
   function logout(){  
		$userid		=	$this->session->userdata('user_id');
		removeUserFromChat($userid);
   
		$this->session->sess_destroy();
		redirect(BASE_URL);
   }
    /* function to update the userdetails */
   function editaccount(){   
			
			$userid				 = $this->input->post('user_id');
			$data['u_country']	 = $this->input->post('country');
			$data['u_height']    = $this->input->post('height');
			$data['u_weight']    = $this->input->post('weight');

			$result 		=	User::updateUser($userid,$data);
			if($result){
				
				echo 'Your account updated successfully';
				exit();
			}else {
				echo 'No changes made. Your account updated successfully';
				exit();
			}
   }
   function changepassword(){   
	
		$this->load->library('form_validation');
			
		$this->form_validation->set_rules('old_password', 'Old Password', 'required|trim');
		$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|matches[confirm_password]|min_length[5]');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|trim|min_length[5]');		
		
		if ($this->form_validation->run() == FALSE)			{
		
			echo validation_errors();
			exit();
		
		}else{	
			
			$userid 			= $this->input->post('user_id');
			$password  			= $this->input->post('old_password');
			$newpassword 		= $this->input->post('new_password');
			$confirmpassword 	= $this->input->post('confirm_password');
			
			$userdetails		=	User::getUserInfo($userid);
		
			$currentpassword 	= $userdetails->u_pwd;
			
			if($currentpassword != md5($password)){
				echo 'Old password you entered is incorrect';
				exit();			
			}
			$data['u_pwd']	=  md5($newpassword);			
			$result	=	User::updateUser($userid,$data);			
			if($result){
				echo 'Password updated successfully';
				exit();	
			}
			
		}
   
   }
   /* function to update newsletter subscription from user dashboard*/
   function subscribenewsletter(){

	$userid		=	$this->session->userdata('user_id');
	$subscribe	=	$this->input->post('subscribe');
	$data['u_subscribe_newsletter']	=  $subscribe;
	$result	=	User::updateUser($userid,$data);
	if($result){
				echo 'Newsletter subscription updated sucessfully';
				exit();	
			}
   }
   
   
   /*
    *	load the shipping form
	*/
	public function loadshippingform($prodid) {
	
		if($prodid != '')  {
			$prodInfo = Product::getProductInfo($prodid);
			$data['product']			=	$prodInfo;
			
		}
	
	
		$this->load->view('loadshippingform',$data);   
	 
		 
	}
   
   
   
   /*
    *	function to load the notifications details by ajax
	*/
	public function loadnotifications($type,$page) {
		//$this->disableLayout = TRUE;
		
		//$this->$layout = null;
	 
		$id						=	$this->session->userdata('user_id');  
		if($id==""){
	
			return false;
		}
	 
		if($type == 0) {
			$data['inbox']			=	Notifications::getNotificatons($id,$page,$type);  
			$data['type']			=	$type;  
			//  echopre($data['inbox']);

			$inPager['totalitems'] 	= $data['inbox']->totalrecords;
			$inPager['url'] 			= BASE_URL.'index/users/notifications/inbox/';
			$inPager['page'] 		= $data['inbox']->currentpage;
			$inPager['listcount'] 	= 25;
			$inPager['class'] 		= 'loadinbox';

			$data['inboxpagination'] = Pagination::shownotificationlinks($inPager);
			//echopre($data['inboxpagination']);
		}
		else if($type == 1) {
			$data['outbox']			=	Notifications::getNotificatons($id,$page,$type);
			$data['type']			=	$type;  
			$outPager['totalitems'] 	= $data['outbox']->totalrecords;
			$outPager['url'] 		= BASE_URL.'index/users/notifications/outbox/';
			$outPager['page'] 		= $data['outbox']->currentpage;
			$outPager['listcount'] 	= 25;
			$outPager['class'] 		= 'loadoutbox';
			$data['outpagination'] 	= Pagination::shownotificationlinks($outPager);
		}
		$this->load->view('loadnotifications',$data);    
		 
	
	}
   
   /*function to display user notifications inbox/outbox */
   public function notifications($type='inbox',$page=''){   
    $page1=$page2='';
	if($type=='inbox'){
		
		$page1=$page;
	}else if($type=='outbox'){
		$page2=$page;
	}
   $id						=	$this->session->userdata('user_id');  
		
		if($id==""){
	
			redirect(BASE_URL);
		}
	
	/* inbox*/
	
   $data['inbox']			=	Notifications::getNotificatons($id,$page1,0);  
   $data['type']			=	$type;  
   // echopre($data['inboxpagination']);
	
   $inPager['totalitems'] 	= $data['inbox']->totalrecords;
   $inPager['url'] 			= BASE_URL.'index/users/notifications/inbox/';
   $inPager['page'] 		= $data['inbox']->currentpage;
   $inPager['listcount'] 	= 2;
   $inPager['class'] 		= 'pagination';
	
   $data['inboxpagination'] = Pagination::showfrontlinks($inPager);
  // echopre1($data['inboxpagination']);
	
	/* outbox*/
   $data['outbox']			=	Notifications::getNotificatons($id,$page2,1);

   $outPager['totalitems'] 	= $data['outbox']->totalrecords;
   $outPager['url'] 		= BASE_URL.'index/users/notifications/outbox/';
   $outPager['page'] 		= $data['outbox']->currentpage;
   $outPager['listcount'] 	= 2;
   $outPager['class'] 		= 'pagination';
   $data['outpagination'] 	= Pagination::showfrontlinks($outPager);
    
	// echopre1($data);
   $this->layout->view('notifications',$data);    
   
   }
   
   
	/*
	function to list the user items
	*/
	function useritems($username='',$display="myitems") {
		$data['message']	= '';
		if($username != '') {
			// find the userid from username
			$userId = User::getUserIdFromUname($username);
			$data['username']	= $username;
		}
		else {
			$userId						=	$this->session->userdata('user_id');
		
			if($userId != ''){
				$userInfo = User::getUserInfo($userId);
				$data['username']	= $userInfo->u_username;				
				$message 			= Message::getMessage(1);
				$data['message'] 	= $message;
				
			}
		}
			
		if($userId != '') {
			// get the products
			$userItems = Product::getUserItems($userId);
			$data['prodlist']	= $userItems->records;
			
			// get the poster info
			$data['productowner'] = 	User::getPosterdInfos($userId);
			$fileid					=	$data['productowner']->profile_image_id;
			$imageinfo	= User::getProfileImage($fileid);
			if($imageinfo){
			$data['profileimage']	= $imageinfo->file_path;
			}else{
			$data['profileimage']	= "";
			}

		}
		else
			redirect( BASE_URL);
			
		$countryList		= $this->config->item('countryList');	
 	    $data['countryList'] = $countryList;	
		$this->layout->view('useritems',$data);    
	}
    
	
	
	
	/*
     * function to show my selections
     */
    public function myselections($username="",$pageno=1) {  	
	 
		$logUserId						=	$this->session->userdata('user_id');
		$data['logUserId']  		= $logUserId;
		if($username != '') {
			// find the userid from username
			$userId = User::getUserIdFromUname($username);
			$data['username']	= $username;
		}
		else {
			$userId						=	$this->session->userdata('user_id');
			if($userId != ''){
				$userInfo = User::getUserInfo($userId);
				$data['username']	= $userInfo->u_username;
			}
		}
		
		if($userId == ''){
			redirect( BASE_URL);
		}
		else{
			
			$userItems = Product::getUserSelections($userId,$pageno);
			 
			$arrPager['totalitems'] 	= $userItems->totalrecords;
			if($username != '') 
				$arrPager['url'] 			= BASE_URL.'user/'.$username.'/myselections/';
			else	
				$arrPager['url'] 			= BASE_URL.'my-selections/';
			
			$arrPager['page'] 			= $userItems->currentpage;
			$arrPager['listcount'] 			= 10;
			$paginate = Pagination::showfrontlinks($arrPager);
		
			//echopre($paginate);
		
			//echopre($userItems);
			$data['prodlist']	= $userItems->records;
			
			
			$data['pagination'] =  $paginate;;  
	
	
	
		}
		// echopre($data);
		$data['metaTitle']		= META_TITLE." : My selections";	
		$this->layout->view('myselections',$data);    
    } 
	
	
	
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */

