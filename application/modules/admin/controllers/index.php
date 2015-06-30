<?php //error_reporting(0); ?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//error_reporting(0);
class index extends CI_Controller {

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
		 $this->lang->load('cms');
		 $this->lang->load('user');
		 
	}
    public function index() {
	

      // $this->pre($this->session->userdata('is_admin_login'));
       //$this->layout->title('11Site index page'); // Set page title
      if ($this->session->userdata('is_admin_login')) {
            redirect('admin/dashboard');
        } else {
			$message = Message::getMessage();
			$data['message'] = $message;
			$this->load->view('login', $data);     
        }
     }
    
    
     public function do_login() {
	 
		
        if ($this->session->userdata('is_admin_login')) {
	
            redirect('admin/dashboard');
        } else {
		

            $user = $this->input->post('username');
            $password = $this->input->post('password');

            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() == FALSE) {
				$message        = validation_errors();
				$msg_class		= "error";
				Message::setPageMessage($message, $msg_class);
				
				$message = Message::getMessage();
				$data['message'] = $message;
               $this->load->view('login', $data); 
            } else {
              
				$data['username'] = $user;
				$data['password'] = $password;
					
                $res = Auth::loggin($data);
			
                if ($res) {
			
                        $this->session->set_userdata(array(
                            'id' => $res->user_id,
                            'username' => $res->first_name.' '.$res->last_name,
                            'email' => $res->email,                            
                            'is_admin_login' => true,
                            // 'user_type' => $res->user_type
                                )
                        );
				
                    redirect('admin/dashboard');
                } else {
                    $message        = "Invalid Username or password";
					$msg_class		= "error";
					Message::setPageMessage($message, $msg_class);
					
					$message = Message::getMessage();
					$data['message'] = $message;
                    $this->load->view('login', $data); 
                }
            }
        }
      }
	  
	   public function logout() {
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('user_type');
        $this->session->unset_userdata('is_admin_login');   
        $this->session->sess_destroy();
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        redirect('admin/index', 'refresh');
    }
   
  
    /*
     * function to load the cms pages
     */
    public function cms($page=''){
		if (!$this->session->userdata('is_admin_login')) 
            redirect('admin/index');
    	$cmsList = Cms::getAllPages($page);
			// $this->pre($cmsList);
		// echopre($userlist);
    	$arrPager['totalitems'] 	= $cmsList->totalrecords;
    	$arrPager['url'] 			= BASE_URL.'admin/index/cms/';
    	$arrPager['page'] 			= $cmsList->currentpage;
    	
    	$paginate = Pagination::showlinks($arrPager);
		$message = Message::getMessage();
    	$data = array('cmslist' => $cmsList,'message'=>$message,'pagination' =>$paginate,'cur_page' =>$page,'per_page' => PAGE_LIST_COUNT);
		$this->layout->title('Content');
       	$this->layout->view('cmslist', $data);
    }
    
    
	/*
	 * function for the admin dashboard
	 */
	 public function dashboard() {
	

       if (!$this->session->userdata('is_admin_login')) {
            redirect('admin/index');
        }
		
	   $data['user'] 		= User::getAllUsers(1,5);
	   $data['seminars'] 	= Product::getAllPages(1,5);
	   $data['paymentlist']     = Payment::getAllPayments(1,5);
	    
	  // $lastday = date('Y-m-d h:i:s', strtotime('-10 days'));	 
	   
	   $data['paymentgraph']  = Analytics::getLastTransactions();
	   
       $this->layout->title('Dashboard'); // Set page title
       $this->layout->view('dashboard', $data);     // Render view and layout

	   
	   
	   
	   
    }
	
	/*
	 * function for the user listing
	 */
	
	public function user($page='') {

		if (!$this->session->userdata('is_admin_login')) 
            redirect('admin/index');
			
 		$userlist = User::getAllUsers($page);
       
      	// echopre($userlist);
    	$arrPager['totalitems'] 	= $userlist->totalrecords;
    	$arrPager['url'] 			= BASE_URL.'admin/user/';
    	$arrPager['page'] 			= $userlist->currentpage;
    	
    	$paginate = Pagination::showlinks($arrPager);
       	$data = array('userlist' => $userlist,'pagination' =>$paginate,'cur_page' =>$page,'per_page' => PAGE_LIST_COUNT );  
		$this->layout->title('Users');
       	$this->layout->view('userlist', $data);     // Render view and layout

    }
    
     /*
     * function to load the cms editor
     */
    public function getCms($alias) {
    	
			
			if($alias != ''){
    		$cmsDetails = Cms::getCmsInfo($alias);
			// $this->pre($cmsDetails);
			foreach( $cmsDetails as $details){
				
				if($details->cnt_lng==1){
					$data['cnt_id'] 			= $details->cnt_id;
					$data['cnt_alias'] 			= $details->cnt_alias;
					$data['cnt_title'] 			= $details->cnt_title;
					$data['cnt_content']		= $details->cnt_content;
				
				}/*elseif($details->cnt_lng==2){
					$data['cnt_id_thai'] 		= $details->cnt_id;
					$data['cnt_title_thai'] 	= $details->cnt_title;
					$data['cnt_content_thai']	= $details->cnt_content;
					
				}elseif($details->cnt_lng==3){
					$data['cnt_id_hindi'] 		= $details->cnt_id;
					$data['cnt_title_hindi'] 	= $details->cnt_title;
					$data['cnt_content_hindi']	= $details->cnt_content;
					
				}*/
				
			}
			
			// $this->pre($data);
    	}
	
	
		$message = Message::getMessage();
    	$data['message'] = $message;
		$this->layout->title('Edit Content');
       	$this->layout->view('editcms', $data);
	}
	
    /*
     * function to load the cms editor
     */
    public function editcms() {
    	
		if($this->input->post()){
		
		$this->load->library('form_validation');
		$language 					= $this->input->post('language');
		if($language==1){
			$this->form_validation->set_rules('txttitleenglish', 'Title', 'required|trim');
			$this->form_validation->set_rules('txtcontentenglish', 'Title', 'required|trim');
		}/*elseif($language==2){
			$this->form_validation->set_rules('txttitlethai', 'Title', 'required|trim');
			$this->form_validation->set_rules('txtcontentthai', 'Title', 'required|trim');
		}elseif($language==3){
			$this->form_validation->set_rules('txttitlehindi', 'Title', 'required|trim');
			$this->form_validation->set_rules('txtcontenthindi', 'Title', 'required|trim');
		}*/
		if ($this->form_validation->run() == FALSE)
			{
				$message        = validation_errors();
				$msg_class		= "error";
				Message::setPageMessage($message, $msg_class);
				
				$message = Message::getMessage();
				$data['message'] = $message;
				$alias		= $this->input->post('alias');
				if($alias != ''){
    		$cmsDetails = Cms::getCmsInfo($alias);
			// $this->pre($cmsDetails);
			foreach( $cmsDetails as $details){
				
				if($details->cnt_lng==1){
					$data['cnt_id'] 			= $details->cnt_id;
					$data['cnt_alias'] 			= $details->cnt_alias;
					$data['cnt_title'] 			= $details->cnt_title;
					$data['cnt_content']		= $details->cnt_content;
				
				}/*elseif($details->cnt_lng==2){
					$data['cnt_id_thai'] 		= $details->cnt_id;
					$data['cnt_title_thai'] 	= $details->cnt_title;
					$data['cnt_content_thai']	= $details->cnt_content;
					
				}elseif($details->cnt_lng==3){
					$data['cnt_id_hindi'] 		= $details->cnt_id;
					$data['cnt_title_hindi'] 	= $details->cnt_title;
					$data['cnt_content_hindi']	= $details->cnt_content;
					
				}*/
				
			}
			
			// $this->pre($data);
    	}
				//$this->layout->view('editcms', $data);
			}
			else{
		
				$cnt_id = $this->input->post('txtcntid');
				if($cnt_id){
				
					$alias 						= $this->input->post('alias');
					
					if($language==1){
						$data['cnt_title'] 		= $this->input->post('txttitleenglish');
						$data['cnt_content'] 	= $this->input->post('txtcontentenglish');
					}/*elseif($language==2){
						$data['cnt_title'] 		= $this->input->post('txttitlethai');
						$data['cnt_content'] 	= $this->input->post('txtcontentthai');
					}elseif($language==3){
						$data['cnt_title'] 		= $this->input->post('txttitlehindi');
						$data['cnt_content'] 	= $this->input->post('txtcontenthindi');
					}*/
					
					$condition = array('id'=>$cnt_id,'alias'=>$alias,'language'=>$language);
					// $this->pre($condition);
					$result = Cms::updateContent($condition,$data);
					if($result)	{
					
					$message        = "Page updated successfully";
					$msg_class		= "success";
					Message::setPageMessage($message, $msg_class);
					redirect('admin/cms');
					}
					else{
					
						$message        = "No changes done,Page updated successfully";
						$msg_class		= "success";
						Message::setPageMessage($message, $msg_class);
						redirect('admin/cms');
					}
				}else{
				
					
				
				}
			
			}
		
		}
    	///$message = Message::getMessage();
    	//data['message'] = $message;
		$this->layout->title('Edit Content');
       	$this->layout->view('editcms', $data);
	}
	public function addcontent()
	{
		// $this->pre($this->input->post());
		if($this->input->post()){
					
					$language = $this->input->post('language');
					$this->load->library('form_validation');
					if($language==1){
						$this->form_validation->set_rules('txttitleenglish', 'Title English', 'required|trim');
						$this->form_validation->set_rules('txtcontentenglish', 'Content English', 'required|trim');
					}/*elseif($language==2){
						$this->form_validation->set_rules('txttitlethai', 'Title Thai', 'required|trim');
						$this->form_validation->set_rules('txtcontentthai', 'Content Thai', 'required|trim');
					}elseif($language==3){
						$this->form_validation->set_rules('txttitlehindi', 'Title Hindi', 'required|trim');
						$this->form_validation->set_rules('txtcontenthindi', 'Content Hindi', 'required|trim');
					}*/
					
					if ($this->form_validation->run() == FALSE)
					{
						$message        = validation_errors();
						$msg_class		= "error";
						Message::setPageMessage($message, $msg_class);
						
						$message = Message::getMessage();
						$data['message'] = $message;
						
						$this->layout->view('addcms', $data);
					}
					else{
							
							$data['cnt_alias'] 			= $this->input->post('txtalias');
							
							$data['cnt_lng']		= 1;
							$data['cnt_title'] 		= $this->input->post('txttitleenglish');
							$data['cnt_content'] 	= $this->input->post('txtcontentenglish');
							$result = Cms::addContent($data);
						
							/*$data['cnt_lng']		= 2;
							$data['cnt_title'] 		= $this->input->post('txttitlethai');
							$data['cnt_content'] 	= $this->input->post('txtcontentthai');
							$result = Cms::addContent($data);
						
							$data['cnt_lng']		= 3;
							$data['cnt_title'] 		= $this->input->post('txttitlehindi');
							$data['cnt_content'] 	= $this->input->post('txtcontenthindi');
							$data['cnt_published'] 	= 1;
							$result = Cms::addContent($data);*/
						
							
							$message        = "Page added successfully";
							$msg_class		= "success";
							Message::setPageMessage($message, $msg_class);
							redirect('admin/cms');
							
					}
		
		}else{
		
		$message = Message::getMessage();
    	$data = array('message'=>$message);
		$this->layout->title('Add Content');
       	$this->layout->view('addcms', $data);
		}
	}
	public function forgotten_password()
	{
		
			 $email=$data['email']= $this->input->post('email');
			 
			 $details 		= Admin::selectAdmin($email);		
			
			if(!$details){	
				
				$message       			   = "No such admin email found";
				$msg_class	               = "error";
				Message::setPageMessage($message, $msg_class);
				redirect('admin/index');
				
			} else {

			//$res_code = 
			
			$forgot_password_code =  $this->generateRandomString();
			$emailAddress[$email] 	    = "Thornproof Admin";								
			$replaceParameters['SHOW_MAIL'] 			= 1;
			$replaceParameters['forgot_password_code'] 	= $forgot_password_code;		
		    //echopre1($replaceParameters);
			$objMailer 		= new Mailer();
			 if(!$objMailer->sendMail($emailAddress, 'forgotten-password', $replaceParameters)){
			
				$message       			   = "Mail sending failed";
				$msg_class	               = "error";
				Message::setPageMessage($message, $msg_class);
				redirect('admin/index');
			} else {
				
				$save['password']          =  md5($forgot_password_code);			
				$saveResult 			   = Admin::updateAdmin($save);
			
				$message       			   = "Forgotten password code send to your email successfully, please check your email";
				$msg_class	               = "success";
				Message::setPageMessage($message, $msg_class);					
				redirect('admin/index');
			}
			}
		
	   
	}
	 public function email_check($str)
	{
		
		$res = Auth::check_email($str);
	
		  if (!empty($res))
		  {
			   return true;
		  }
		  else
		  {    
			  $this->form_validation->set_message('email_check', 'This Email does not exist.');
			  return false;
		  }
	} 
	
	public function reset_password(){
		
		$post_data = $this->input->post();
		if($post_data)
		{
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_check');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[7]|max_length[20]|matches[passconf]|md5');
			$this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required');

			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_flashdata('message', 'Validation errors');
				redirect('admin/index');			 
			}
			else
			{
				$data['email'] = $this->input->post('email');
				$data['password'] = $this->input->post();

				$res_data = Auth::reset_pasword($data);
				
				if($res_data)
				{
					$this->session->set_flashdata('message', 'Your password reset successfully,please login with your username and password');
					redirect('admin/index');
				}
				else
				{
					$this->session->set_flashdata('message', 'password reset failed');
					redirect('admin/index');
				}
			}
		}
		// else
		// {
			// $result = Auth::get_user_by_random($code);
			
		// }
		  
	}
	
	function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
	}

	/*
	 * function to view the user details
	 */
	public function viewuser($userid) {
		if($userid != ''){
     		$userDetails = User::getUserInfo($userid);   		 
     	}
		 
		
		
		
		$message = Message::getMessage();     	
    	$data = array('userinfo' => $userDetails,'message' => $message);
		
		$data['postList'] = Product::getUserItems($userid);
		 
		
		$this->layout->title('View User');
        $this->layout->view('viewuser', $data);
	}
 	  /*
      * function to load the user editor
      */
     public function edituser($userid) {
		 
		
    	if($userid != ''){
     		$userDetails = User::getUserInfo($userid);   		 
     	}
		$message = Message::getMessage();     	
    	$data = array('userinfo' => $userDetails,'message' => $message);
		$this->layout->title('Edit User');
        $this->layout->view('edituser', $data);
 		
 		if($this->input->post())
		{
	 
		   
		    $post_data =        $this->input->post();
		    $txtid =            $this->input->post('txtusrid');     		
    		$txtemail =         $this->input->post('txtemail');
    		$txtoldpass =       $this->input->post('txtoldpass');
			$txtnewpass =       $this->input->post('txtnewpass');
			$txtconfirmpass =   $this->input->post('txtconfirmpass');
			$paid_status =      $this->input->post('paid_status');
			$username =         $this->input->post('txtusername');
			
			if($post_data)	{
				//echopre1($post_data);
				$this->load->helper(array('form', 'url'));				
				$this->form_validation->set_rules('txtemail', 'Email', 'trim|required|valid_email');				
			
			    if($txtfname != '' && $txtlname != '' && $txtemail != '' && $txtoldpass != '' && $txtnewpass != '' && $txtconfirmpass != ''){
				
					//$this->pre($this->input->post());
					$this->form_validation->set_rules('md5(txtoldpass)', 'Old Password', 'trim|required|matches[txtoldpassword]');
					//$this->form_validation->set_rules('txtoldpassword', 'Old Password', 'trim|required');
					$this->form_validation->set_rules('txtnewpass', 'Password', 'trim|required|min_length[7]|max_length[20]|matches[txtconfirmpass]|md5');
					$this->form_validation->set_rules('txtconfirmpass', 'Password Confirmation', 'trim|required');
			    }
				if ($this->form_validation->run() == FALSE)
				{
					//$this->session->set_flashdata('message', validation_errors());
				$message       			   = validation_errors();
				$msg_class	               = "error";
				Message::setPageMessage($message, $msg_class);				
				redirect('admin/index/edituser/'.$txtid);			 
				}
				else
				{
				if( $txtemail != '' && $txtoldpass == '' && $txtnewpass == '' && $txtconfirmpass == ''){
					 
					$cntInfo['u_email']			= $txtemail;   
					 if($paid_status==1){
					 $cntInfo['u_paystatus']	= 1; 
					 $cntInfo['u_paidon']		= date('Y-m-d H:i:s'); 
						
					}					 
				   
				    $updateData =User::updateUser($txtid,$cntInfo);
					
				}
				else if( $txtemail != '' && $txtoldpass != '' && $txtnewpass != '' && $txtconfirmpass != ''){
					
					  $cntInfo['u_email']			= $txtemail;
					  $cntInfo['u_pwd']             = $txtnewpass;   		
					 if($paid_status==1){
					 $cntInfo['u_paystatus']= 1; 
					 $cntInfo['u_paidon']	= date('Y-m-d H:i:s'); 	
					}		
					   $updateData =User::updateUser($txtid,$cntInfo);	
					 
				}
					if($updateData)
					{						
						$message       			   = 'Your details updated successfully';
						$msg_class	               = "success";
						Message::setPageMessage($message, $msg_class);				
						redirect('admin/index/edituser/'.$txtid);	
					}
					else
					{						
						$message       			   = 'Nothing to update';
						$msg_class	               = "error";
						Message::setPageMessage($message, $msg_class);				
						redirect('admin/index/edituser/'.$txtid);	
					}
				}
		   }	
	    }
	 }
		public function enable_disableUser($id,$status)  {	
	
			 $cntInfo  = array(
				'u_status'      => $status                    
			   );                  
			   User::updateUser($id,$cntInfo);
			   redirect('admin/user', 'refresh');
		}
		
		public function deleteUser($id)  {	
	
			 $cntInfo  = array(
				'u_delete'      => 1,
				'u_status'      => 0                        
			   );                  
			   User::deleteUser($id);
			   // function to delete the user products
			   Product::deleteUserProducts($id);
			   redirect('admin/user', 'refresh');				   
		}
		public function adduser()
		{
			
			if($this->input->post()){
			
			//$this->pre($this->input->post());
				$this->form_validation->set_rules('txt_fname', lang('user_fname'), 'trim|required');
				$this->form_validation->set_rules('txt_lname', lang('user_lname'), 'trim|required');
				$this->form_validation->set_rules('txt_email', lang('user_email'), 'trim|required|valid_email');
				$this->form_validation->set_rules('txt_password', lang('user_password'), 'trim|required');
			
				if ($this->form_validation->run() == FALSE)
				{
					$message        = validation_error();
					$msg_class		= "error";
					Message::setPageMessage($message, $msg_class);
					
					$this->layout->title('Add User');
					$this->layout->view('adduser', $data);
				}
				else
				{
				
					$save['u_fname'] 	=	$this->input->post('txt_fname'); 
					$save['u_lname'] 	=	$this->input->post('txt_lname'); 
					$save['u_email'] 	=	$this->input->post('txt_email'); 
					$save['u_name'] 	=	$this->input->post('txt_username'); 
					$save['u_pwd'] 		=	md5($this->input->post('txt_password')); 
					$save['u_paystatus']=	$this->input->post('paid'); 
					$save['u_status'] 	=	$this->input->post('active'); 
					$save['u_lastlogin']=	 date('Y-m-d H:i:s'); 
					if($save['u_paystatus']==1){
					
					$save['u_paidon'] 	= date('Y-m-d H:i:s');
					
					}else{
					
					$save['u_paidon'] 	= "";
					}
					$result				=	User::addUser($save);
					
					if($result){
						
						$message        = "Added new user successfully.";
						$msg_class		= "success";
						Message::setPageMessage($message, $msg_class);
						
						redirect('admin/user');
					}
			
				}
			
			}
			
			//$message = Message::getMessage();
			//$data = array('message'=>$message);
			$this->layout->title('Add User');
			$this->layout->view('adduser', $data);
		}
		public function sendpassword($user_id){
	
		$data['userdetails'] = User::getUserInfo($user_id);
		if($this->input->post()){
		
			$save['u_fname'] =$txtfname 	=	$this->input->post('txt_fname'); 
			$save['u_lname'] =$txtlname	=	$this->input->post('txt_lname'); 
			$save['u_email'] =$txt_email 	=	$this->input->post('txt_email'); 					
			$save['u_status'] =$active 	=	$this->input->post('active');
			$generated_pwd 			= Util::generate_password();
			$save['u_pwd']  		= md5($generated_pwd);
			$result				=	User::updateUser($user_id,$save);
			//$password 			=  md5($data['userdetails']->u_pwd);
					
			$emailAddress[$txt_email] 	= $txt_email;
			$replaceParameters['name'] 					= $txtfname.' '.$txtlname;
			$replaceParameters['USERNAME'] 				= $txt_email;
			$replaceParameters['PASSWORD'] 				= $generated_pwd;
			$replaceParameters['LINK'] 					= "http://innomindtech.in/development/happythaiforex/login";
			$replaceParameters['SHOW_MAIL'] 			= 1;
			
			$objMailer 		= new Mailer();
			$objMailer->sendMail($emailAddress, 'send-password', $replaceParameters); 
			
			$message        = "password successfully send to user";
			$msg_class		= "sucess";
			Message::setPageMessage($message, $msg_class);
			
			redirect('admin/user');
		}
		
		
		$message = Message::getMessage();
		$data['message'] = $message;
		
		$this->layout->title('Send Password');
		$this->layout->view('sendpassword', $data);
		
		
		}
		
	
}
