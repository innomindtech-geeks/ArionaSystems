<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);
class Index extends CI_Controller {

 
	
 // Layout used in this controller
   
    
	public function __construct() {
   	 	parent::__construct();
   	 	/*Additional code which you want to run automatically in every function call */
   	 	$this->load->library('layout');          // Load layout library
		$this->load->helper('url');
		$this->load->helper('usersession');
		//$this->load->helper('custom');
		
		// echopre($this->session->userdata('site_lang'));
		// $this->config->set_item('language', $this->session->userdata('site_lang'));
		$this->lang->load('menu',$this->session->userdata('site_lang'));
		 
		 
	}
 
 
 
	/*
     * function to show the static content
     */
    public function content($alias=false) {  	

		$data['content']   = Cms::getPages($alias);
		
	   
		$this->layout->view('content', $data);    
    }
	 
 
 
 
   	/*
     * function to show the history details
     */
    public function history() {  	

		$this->layout->view('history');    
    }        

 
 
 
 
	/* site landing page
	*/
    public function index() {
		$countryList		= $this->config->item('countryList');			
 	    $data 				= array('countryList'=>$countryList);		
		$bannerImages 		= Banner::getAllPages();
		$data['bannerlist'] = $bannerImages->records;		
		$this->layout->view('homepage', $data);     // Render view and layout		 		  
    }

	/*
     * function to show my account
     */
    public function myaccount() { 			
		
		$user_id = $this->session->userdata('user_id');
		if($user_id==""){
		
			redirect(BASE_URL);
		}
		
		$userdetails	=	User::getUserInfo($user_id);
	
		$data['userdetails']	=	$userdetails;
		
		$fileid = $userdetails->profile_image_id;
		if($fileid!=0){
		
			$filedetails 		= User::getProfileImage($fileid); 
			$data['file_name'] 	= $filedetails->file_path;
			$data['file_id'] 	= $fileid;
		}else{
		$data['file_name'] 	= "";
		$data['file_id'] 	= "";
		}
		$data['metaTitle']		= META_TITLE." : User Dashboard";
		
		$this->layout->view('myaccount', $data);    
    }        

	
	/*
	 *	function to show the chat history 
	 */
	function chathistory($toid='',$toname='') {
 
		$user_id = $this->session->userdata('user_id');
		if($user_id=="")		
			redirect(BASE_URL);
		$data['fromid']		=$user_id;
		if($toid == '' ){
			$data['chatMembers'] = Chat::getChatMembers($user_id);
			
			$data['metaTitle']		= META_TITLE." : User chat history";
			$this->layout->view('chathistory', $data);    
		}
		else {
		
			$data['toid']		= $toid;
			$data['toname']		= $toname;
			$userImage = User::getUserProfileImage($toid);
			$data['userImage']		= $userImage;
			$data['metaTitle']		= META_TITLE." : User chat history";
			$this->layout->view('chatmsg', $data);    
		}
		
		
	}
	
   	/*
     * function to show my items
     */
    public function myitems() {  	

		$this->layout->view('myitems');    
    }        

	
	
	/*
     * function to show the notifications
     */
    public function notifications() { 
	
		$this->layout->view('notifications');    
    }
	 
	 
	/*
     * function to show the product details page
     */
    public function product($id='') {  	
		
		
		if($id =='') $id=5;	// TODO: remove this condition
		$userid= $this->session->userdata('user_id');	
		$prodid = explode('-',$id);
		if($prodid[0] == '')
			redirect( BASE_URL.'pagenotfound');
 
		$productInfo 	= Product::getProductInfos($prodid[0],$userid);
		$product 		= $productInfo->records[0]; 
		
		if(sizeof($product) <= 0 ) 
			redirect( BASE_URL.'pagenotfound');
				
		// check the product is deleted		
		if($product->pr_status == 2)
			redirect( BASE_URL.'pagenotfound');
		 
		$data['product'] 	= $product;
		$data['userid']		=	'';
		$data['shippingtext']	= '';
		
		$data['prodadperiod'] = '';
		$data['prodImages'] = Product::getProductImages($prodid[0]);
		// echopre1($data['prodImages']);
		$data['remainbumbhr']		= '';
		$userid				= $this->session->userdata('user_id');
		if($userid != '' ) {
			$data['userid']			= $userid;
			// check the product is in selection list or not
			$data['selitem']		= Product::checkselection($prodid[0],$userid);
			
			// check the product is in selection list or not
			$data['upvoteitem']		= Product::checkupvote($prodid[0],$userid);
			
			// if the logined user and poster is same
			if($userid == $product->pr_addedby) {
				
			
				// find next bumbdate
				$nxtbdate =  Product::checkBumb($prodid[0]);
				
				if($nxtbdate > date('Y-m-d H:i:s') ) {
					$curdate 		= new DateTime();
					$since_start 	= $curdate->diff(new DateTime($nxtbdate));
					$days 			= $since_start->format('%d');
					$data['remainbumbhr'] = $days * 24 + $since_start->h;
				}
				
				// code to check the age
				if($data['remainbumbhr'] == '') {
					$addDate = $product->pr_addedon;
					$curdate 		= new DateTime();
					$since_start 	= $curdate->diff(new DateTime($addDate));
					$data['prodadperiod']  = $since_start->format('%m')*30 + $since_start->format('%d');
				}
				
			}
			
		}
		
		// find the no of slectection count
		$noOfSelCnt	= Product::getTotalSelections($prodid[0]);
		if($noOfSelCnt > 0 )
			$data['noselectioncount']	= '<span class="selectedNo">'.$noOfSelCnt.' user(s) added this product in their Selections</span>';
		else $data['noselectioncount'] = '';
		
		
		// get the poster info
		$data['productowner'] = 	User::getPosterdInfos($product->pr_addedby);
		
		$fileid					=	$data['productowner']->profile_image_id;
		$imageinfo				= User::getProfileImage($fileid);
		
		if($imageinfo){
		$data['profileimage']	= $imageinfo->file_path;
		}else{
		$data['profileimage']	= "";
		}
		
		//function to get user product count
		$data['prodcount'] = Product::getUserProductCount($product->pr_addedby);
		
		// get and update the shipping text
		if($product->pr_buyitnow == 1) {
			$shippingtext 	= Cms::getCmsContent('shippingmsg');
			$shippingtext	= str_replace('{SHIPPICE}', DEFAULT_CURRENCY.$product->pr_shipcoast,$shippingtext);
     	 	$shippingtext 	= str_replace('{SHIPCOUNTRY}', $product->pr_country,$shippingtext);
			$data['shippingtext'] =	$shippingtext;
		}
		$countryList		= $this->config->item('countryList');	
 	    $data['countryList'] = $countryList;	
		
		$data['metaTitle']		= META_TITLE." : ".stripslashes($product->pr_title);
		//$data['productowner']			=  User::getUserName($product->pr_addedby);
		
		$this->layout->view('product-details',$data);    
    }        

	/*
	function to load the designer details in selling page
	*/
	
	public function ajaxloaddesigners(){
	
	
		$jsdesignerlist = '';
		$category = $_POST['selcat'];
		$designers = Designers::getAllDesigners($category);
		$designerlist = $designers->records;
		if(sizeof($designerlist) > 0) {
			foreach($designerlist as $designer){
				$jsdesignerlist.= $designer->de_name.',';
			}
		}
		$jsdesignerlist = substr($jsdesignerlist, 0, -1);
        
		echo $jsdesignerlist;
		exit();
   
	}
	
	/*
	function to upload the images
	*/
	public function ajaximageuploader() {
	
		$uploadPath = 'files/';
		ob_start();
		$callback = &$_REQUEST['fd-callback'];

		if (!empty($_FILES['fd-file']) and is_uploaded_file($_FILES['fd-file']['tmp_name'])) {
			// Regular multipart/form-data upload.
			$name = $_FILES['fd-file']['name'];
			$data = file_get_contents($_FILES['fd-file']['tmp_name']);
			echopre($data);
		} else {
		
			// Raw POST data.
			$name = urldecode(@$_SERVER['HTTP_X_FILE_NAME']);
			
			$randVal = createRandomKey(8);
			$newfileName = $randVal.'_'.$name;
			// insert the file details to the database
			$data = array(	'file_orig_name' 	=> $name,
							'file_path' 		=> $newfileName
							);

     
			$dbh 					= new Db();
			$file_id = $dbh->insert('tbl_files', $data);
			
			
			$data = file_get_contents("php://input");
			file_put_contents($uploadPath.$newfileName, $data);
			
			$data       = file_get_contents($uploadPath.$newfileName);
			$size_info = getimagesizefromstring($data);
			$info_msg = '';
			if($size_info){
				$width = $size_info[0];
				$height = $size_info[1];
				if($width < 500 || $height < 550){
					$info_msg = 'Please upload a image with high resolution for a better view of the product';
				}
			
			}
			
			// resize the files
			$thumbRes =  Fileuploader::createThumbnail($file_id,'productlist',false);
			$thumbRes =  Fileuploader::createThumbnail($file_id,'productdet',false);
			$thumbRes =  Fileuploader::createThumbnail($file_id,'productthumb',false);
			echo $file_id.":".$newfileName.":".$info_msg;
			//echopre($data);
		}
		
		 
		 
	 
		exit();
	}
	 
	 /*
	 fucntion to load the size of the categories
	 */
	 public function ajaxloadsize() {
	 
		$sizedrop = '';
		$category 	= $_POST['selcat'];
		if($category != '') {
			$szId 		= Categorymanagement::getCategoryField($category,'sz_cat');
			$sizes 		= Designers::getSizes($szId);
			$sizeList 	= $sizes->records;
			if(sizeof($sizeList) > 0) {
				//$sizedrop =  '<select class="dropdown1" id="jqitemsize">';
				foreach($sizeList as $sizes){
					//echopre($sizes);
					$sizedrop .= '<option value="'.$sizes->sz_id.'">'.$sizes->sz_value.'</option>';
				}
				$sizedrop .= '<option value="0">Not Listed</option>';
				//$sizedrop .= '</select>	';
			}
		}
		else $sizedrop = '<option value="">Please select category</option>';
		echo $sizedrop;
		exit();
	 }
	 
	 
   	/*
     * function to show the sell page
     */
    public function sell($prodid='',$action='') {  	
	
		checksession();
		$userid		= $this->session->userdata('user_id');
		$this->load->library('form_validation');
		//echopre1($_POST);
		$this->form_validation->set_rules('jqcatlist', 'Category', 'required');
		$this->form_validation->set_rules('itemdesigner', 'Designer', 'required|trim');
		$this->form_validation->set_rules('itemtitle', 'Title', 'required|trim');
		$this->form_validation->set_rules('jqitemsize', 'Size', 'required|trim|numeric');
		
		$this->form_validation->set_rules('itemprice', 'Price', 'required|trim|numeric');
		$this->form_validation->set_rules('itempaypalemail', 'Paypal Email', 'required|trim|valid_email');
		$this->form_validation->set_rules('itemdes', 'Description', 'required|trim');

		//$this->form_validation->set_rules('itemdes', 'Description', 'callback_validateprice');
		 
		$data['message'] = '';
		$data['jsdesignerlist'] = '';
		
		$data['upimgitems'] = '';
		
		$data['jsdesignerlist'] = '';
		$data['jqsizelist'] ='';
		
		if ($this->form_validation->run() == FALSE) {	// validation failed. but we are retaining the data
			$message        	= validation_errors();
			 
			$msg_class			= "error";
			Message::setPageMessage($message, $msg_class);
				
			$message = Message::getMessage();
			$data['message']	 = $message;
			$data['productid']	 		= $this->input->post('productid');
			$data['jqcatlist']	 		= $this->input->post('jqcatlist');
			$data['itemdesigner']	 	= addslashes($this->input->post('itemdesigner'));
			
			$data['itemdesigner']		= $data['itemdesigner'];
			$data['itemtitle']	 		= $this->input->post('itemtitle');
			$data['itemprice']	 		= $this->input->post('itemprice');
			$data['itempaypalemail']	= $this->input->post('itempaypalemail');
			$data['itemdes']	 		= $this->input->post('itemdes');
			
			$data['pr_buyitnow']	 	= $this->input->post('chkbuyitnow');
			$data['pr_shipcoast']	 	= $this->input->post('shipcost');
			$data['pr_country']			= $this->input->post('shipcountry');
			$data['pr_acceptoffer']	 	= $this->input->post('chkacceptoffers');
			$data['pr_listorder']	 	= $this->input->post('prodlistorder');
			
			
			$data['pr_image']	 		= $this->input->post('prodcoverimg');
			$data['upimglist']	= 	$prImage	= $this->input->post('upimglist');
			$arrUpImg = array();
			if($prImage != '') {
				$prList = explode(':',$prImage);
				foreach($prList as $primages) {
					if($primages != '') {
						$db                 = new Db();
						$imgInfo			= $db->selectRow('files','file_path',"file_id=" . $primages);
						 
						$arrUpImg[] = $imgInfo;
					}
				}
			}	

			$data['upimgitems']		= $arrUpImg;
			$data['jqitemsize'] 	        = $this->input->post('jqitemsize');	
			// load the sizes
			if($data['jqcatlist'] != '') {
				$catsid 	= Categorymanagement::getCategoryField($data['jqcatlist'],'sz_cat');
				$izelist	= Designers::getSizes($catsid);
				$data['jqsizelist'] =$izelist->records;
			}
			 
			// load the designers
			$designers = Designers::getAllDesigners($data['jqcatlist']);
			$jsdesignerlist	= '';
			$designerlist = $designers->records;
			if(sizeof($designerlist) > 0) {
				foreach($designerlist as $designer){
					$jsdesignerlist.= $designer->de_name.',';
				}
			}
			$data['jsdesignerlist'] = substr($jsdesignerlist, 0, -1);
			//echopre($data['jsdesignerlist']);

		
		}else{
			$msg =  "";
			
			
			 
			// insert/update the product details
			$product['pr_id']	 			= $this->input->post('productid');
			if($product['pr_id'] == '') {
				$product['pr_addedon'] 			= date('Y-m-d H:i:s');
				$msg =  "?action=addsuccess";
			}
			else
				$msg =  "?action=editsuccess";
			$product['pr_cat'] 	        	= $this->input->post('jqcatlist');				
			$product['pr_designer'] 		= addslashes($this->input->post('itemdesigner'));
			$product['pr_size'] 	        = $this->input->post('jqitemsize');				
			$product['pr_title'] 		    = addslashes($this->input->post('itemtitle'));
			$product['pr_prize'] 	        = $this->input->post('itemprice');				
			$product['pr_paypal_email'] 	= $this->input->post('itempaypalemail');
			$product['pr_description'] 	    = addslashes($this->input->post('itemdes'));
			$product['pr_addedby'] 	        = $this->session->userdata('user_id');
			$product['pr_status'] 	        = '1';
			
			$product['pr_image']	 		= $this->input->post('prodcoverimg');
			//$product['pr_id'] 				= '';
			//TODO: find designer id 
			$product['pr_designer']			=	Designers::getDesignerId($product['pr_cat'],$product['pr_designer']);
			//echopre1($product);
			$product['pr_alias'] 			= getAlias($product['pr_title']);
			
			$product['pr_buyitnow']	 		= $this->input->post('chkbuyitnow');
			$product['pr_shipcoast']	 	= $this->input->post('shipcost');
			$product['pr_country']			= $this->input->post('shipcountry');
			$product['pr_acceptoffer']	 	= $this->input->post('chkacceptoffers');
			
			if($product['pr_id']==""){			
				$product['pr_listorder'] 		= Product::getLatestListOrder();
			}
	 
			
			$productId	 			        = Product::addData($product);
			//echopre1($product);
			// update the file table
			$db                     = new Db();
			$prImage						= $this->input->post('upimglist');
			if($prImage != '') {
				$prList = explode(':',$prImage);
				$selImageId = $db->selectRow('files','file_id',"file_path='" . $product['pr_image']."'");
				foreach($prList as $primages) {
					if($primages != '') {
					$defImg = 0;
						if($selImageId == $primages)
							$defImg = 1;
						
						$db->customQuery("update ".MYSQL_TABLE_PREFIX."files set created_by = '".$productId."',file_status=".$defImg." where file_id = '".$primages."'");
					}
				}
				
				 
			}	
					
			// TODO redirect to details page
			redirect(BASE_URL.'product/'.$productId.$msg);

		}
		$categories = Categorymanagement::getAllCategories();
		$data['categories'] = $categories->records;		
	
		 
		// edit the product
		if($prodid != '') {
		
		 
		
			// get the product details 
			$productInfo = Product::getProductInfo($prodid);
			
			// check the ownership of the product
			if($userid	!= $productInfo->pr_addedby)
				redirect( BASE_URL.'pagenotfound');
			 
			// checking the deletion option
			if($action == 'delete') {
				Product::delete($prodid);
				$message        = 'This product has successfully been deleted';
				$msg_class		= "success";
				Message::setPageMessage($message, $msg_class);
				redirect( BASE_URL.'myitems');

			}
		
			//echopre($productInfo);
			$data['jqcatlist']	 		= $productInfo->pr_cat;
			//$data['itemdesigner']	 	= $productInfo->pr_designer;
			$data['itemdesigner']		= Designers::getDesignerName($productInfo->pr_designer);
			$data['itemtitle']	 		= $productInfo->pr_title;
			$data['itemprice']	 		= $productInfo->pr_prize;
			$data['itempaypalemail']	= $productInfo->pr_paypal_email;
			$data['itemdes']	 		= $productInfo->pr_description;
			$data['jqitemsize'] 	    = $productInfo->pr_size;
			$data['pr_image']	 		= $productInfo->pr_image;
			$data['pr_listorder']	 	= $productInfo->pr_listorder;
			
			if($data['jqcatlist'] != '') {
				$catsid 	= Categorymanagement::getCategoryField($data['jqcatlist'],'sz_cat');
				$izelist	= Designers::getSizes($catsid);
				$data['jqsizelist'] =$izelist->records;
			}
			  
			// load the designers
			$designers = Designers::getAllDesigners($data['jqcatlist']);
			$jsdesignerlist	= '';
			$designerlist = $designers->records;
			if(sizeof($designerlist) > 0) {
				foreach($designerlist as $designer){
					$jsdesignerlist.= $designer->de_name.',';
				}
			}
			$data['jsdesignerlist'] = substr($jsdesignerlist, 0, -1);
			
			// load the images
			$arrUpImg = array();
			$prdImages = Product::getProductImages($prodid);
			if(sizeof($prdImages) > 0 ) {
				foreach($prdImages as $imgs) {
					$arrUpImg[] = $imgs->file_path;
					$prImage	.= ':'.$imgs->file_id;
				}
			}
			
			$data['upimglist']	= 	$prImage;
			
			$data['upimgitems']		= $arrUpImg;
			//echopre($prdImages );
			$data['productid']	= $prodid;
			
			
			$data['pr_buyitnow']	 	= $productInfo->pr_buyitnow;;
			$data['pr_shipcoast']	 	= $productInfo->pr_shipcoast;;
			$data['pr_country']			= $productInfo->pr_country;;
			$data['pr_acceptoffer']	 	= $productInfo->pr_acceptoffer;;

			
			
		}
		
		if($data['itempaypalemail'] == '')
			$data['itempaypalemail']	= User::getUserPaypal($userid);
		
		$data['metaTitle']		= META_TITLE." : Create Listing";
		
		$data['countryList']	= $this->config->item('countryList');
		$this->layout->view('sell',$data);    
    }        
	
	/* function to ask a question by user on a product */
	public function askquestion(){
	
	$data['nt_from_userid']		=	$this->session->userdata('user_id');
	$data['nt_to_userid']		=	$this->input->post('pdt_addedby');
	$data['nt_pdtid']		=	$this->input->post('pdt_id');
	$data['nt_text']		=	$this->input->post('question');
	if($data['nt_from_userid']	== $data['nt_to_userid'])
	$data['nt_type']		=	0;
	else
	$data['nt_type']		=	1;
	$data['nt_action']		=	2;
	$data['nt_time']		=	date('Y-m-d H:i:s');
	
	$result	=	Notifications::addData($data);
	if($result){
				echo 'Your question send to the seller';
				exit();	
			}
	}
	/* function to make an offer for a user */
	public function makeoffer(){
	
	
	$offer['ofr_from_userid']		=	$this->session->userdata('user_id');
	
	$offer['ofr_to_userid']			=	$this->input->post('pdt_addedby');
	$offer['ofr_pdtid']				=	$this->input->post('pdt_id');
	$offer['ofr_text']				=	$this->input->post('description');
	$offer['ofr_date']				=	date('Y-m-d H:i:s');
	$offer['ofr_actualprice']		= 	$this->input->post('pdt_actualprice');
	$offer['ofr_requestprice']		=	$this->input->post('offer_price');	
	
	$result	=	Product::addOffer($offer);
	
	$insert_id	=	 mysql_insert_id();
	
	$msg['nt_from_userid']		=	$this->session->userdata('user_id');
	$msg['nt_to_userid']		=	$this->input->post('pdt_addedby');
	$msg['nt_pdtid']			=	$this->input->post('pdt_id');
	$msg['nt_text']				=	$this->input->post('description');
	
	if($msg['nt_from_userid']	== $msg['nt_to_userid'])
	$data['nt_type']		=	0;
	else
	$data['nt_type']		=	1;
	
	$msg['nt_action']		=	1;
	$msg['nt_time']			=	date('Y-m-d H:i:s');
	$msg['nt_offerid']		=	$insert_id;
	
	$result	=	Notifications::addData($msg);
	/* mail to product added user*/
	$userdetails		=	User::getUserInfo($msg['nt_from_userid']);
	
	$email_buyer	=	$userdetails->u_email;
	$name_buyer	=	$userdetails->u_username;
	
	$sellerdetails		=	User::getUserInfo($msg['nt_to_userid']);
	
	$seller_name	=	$sellerdetails->u_username;
	
	// get the product details 
	$productInfo = Product::getProductInfo($msg['nt_pdtid']);
	
	
	// $emailAddress[$email_buyer] 	        = "Admin";
	// $replaceParameters['NAME'] 				= $name_buyer;	
	// $replaceParameters['SELLER_NAME'] 		= $seller_name;
	// $replaceParameters['SHOW_MAIL'] 		= 1;									  
	// $objMailer 		= new Mailer();
	// $objMailer->sendMail($emailAddress, 'offer-accept', $replaceParameters);
	if($result){
				echo 'Your offer has been sent to the seller';
				exit();	
			}
	}
	/* function to reply from notification sestion */
	public function reply(){
	
		$msg['nt_from_userid']	=	$this->session->userdata('user_id');
		$msg['nt_to_userid']	=	$this->input->post('to_id');
		$msg['nt_pdtid']		=	$this->input->post('pdt_id');
		$msg['nt_text']			=	$this->input->post('reply');
		$msg['nt_type']			=	1;
		$msg['nt_action']		=	3;
		$msg['nt_time']			=	date('Y-m-d H:i:s');
		$msg['nt_reply_ref']	=	$this->input->post('nt_id');
		//echopre1($msg);
		$result	=	Notifications::addData($msg);
		if($result){
				echo 'Your reply send successfully';
				exit();	
			}
	}
	
    
	
	/*
	function to load the image from the image url
	*/
	public function loadimagefromurl() {
	
		$imgurl	= $this->input->post('imgurl');
		//$imgurl = 'http://www.rubyeyes.com/wp-content/uploads/2011/07/Patina-Sale1.jpg';
		if($imgurl != '') {
		
		
		$is = @getimagesize ($imgurl);
		if ( !$is ) $link='';
		elseif ( !in_array($is[2], array(1,2,3))   ) $link='';
		elseif ( ($is['bits']>=8) ) $link=true;;
		
		if($link == true) {
			$fileres = Fileuploader::handleimageurl($imgurl);
			$newfileName	= $fileres->file_path;
			$file_id	= $fileres->file_id;
			
			$uploadPath = 'files/';
			$data       = file_get_contents($uploadPath.$newfileName);
			$size_info = getimagesizefromstring($data);
			
			$info_msg = '';
			if($size_info){
				$width = $size_info[0];
				$height = $size_info[1];
				if($width < 500 || $height < 550){
					$info_msg = 'Please upload a image with high resolution for a better view of the product';
				}
			
			}
			
			// resize the files
			$thumbRes =  Fileuploader::createThumbnail($file_id,'productlist',false);
			$thumbRes =  Fileuploader::createThumbnail($file_id,'productdet',false);
			$thumbRes =  Fileuploader::createThumbnail($file_id,'productthumb',false);
			echo $file_id.":".$newfileName.":".$info_msg;
		}
		else	echo "0:Please provide a valid image url";
		}
		exit();
	}
	public function counter(){
	
		$offer['ofr_from_userid']		=	$this->session->userdata('user_id');
		$offer['ofr_to_userid']			=	$this->input->post('offer_userid');
		$offer['ofr_pdtid']				=	$this->input->post('pdt_id');
		$offer['ofr_text']				=	$this->input->post('counter_reply');
		$offer['ofr_date']				=	date('Y-m-d H:i:s');
		$offer['ofr_actualprice']		= 	$this->input->post('pdt_actualprice');
		$offer['ofr_requestprice']		=	$this->input->post('offer_price');	
		// echopre1($offer);
		$result	=	Product::addOffer($offer);
		
		$insert_id	=	 mysql_insert_id();
		
		$msg['nt_from_userid']		=	$this->session->userdata('user_id');
		$msg['nt_to_userid']		=	$this->input->post('offer_userid');
		$msg['nt_pdtid']		=	$this->input->post('pdt_id');
		$msg['nt_text']			=	$this->input->post('counter_reply');
		if($msg['nt_from_userid']	== $msg['nt_to_userid'])
		$data['nt_type']		=	0;
		else
		$data['nt_type']		=	1;
		$msg['nt_action']		=	1;
		$msg['nt_time']			=	date('Y-m-d H:i:s');
		$msg['nt_offerid']		=	$insert_id;
		
		$result	=	Notifications::addData($msg);
		
		if($result){
					echo 'Your offer has been sent to the seller';
					exit();	
				}
	
		
	}
	public function accept_offer(){
	
	 
				
		$offer_id			=	$this->input->post('offer_id');
		$msg['ofr_confirm']	=	1;
		$result	=	Notifications::updateOffer($offer_id,$msg);
		
		$accept_price	=	$this->input->post('offer_price');
		
		$data['nt_from_userid']		=	$this->session->userdata('user_id');
		$data['nt_to_userid']		=	$this->input->post('offer_userid');
		$data['nt_pdtid']			=	$prodId = $this->input->post('pdt_id');
		//$data['nt_text']			=	'Your offer accepted for $'.$accept_price;
		$data['nt_text']			=	'Your offer of $'.$accept_price.' has been accepted by the seller' ;
		if($data['nt_from_userid']	==	$data['nt_to_userid'])
			$data['nt_type']		=	0;
		else
			$data['nt_type']		=	1;
			
			
		$data['nt_action']			=	1;
		$data['nt_time']			=	date('Y-m-d H:i:s');
		$data['nt_offerid']			=	$this->input->post('offer_id');
		
		$result	=	Notifications::addData($data);
		
		// email send to poster and buyer
		Mailmanagement::sendOfferMail($data['nt_offerid']);
	
		// check whether it has buy now option
		$prodOwner = Product::getProductOwner($prodId);
		if($data['nt_from_userid']	== $prodOwner)
			$type = 1;
		else
			$type = 2;
		 
	 
	 
	 
		 
		
	
		if($result){
			
				echo $type;
				exit();	
			}
	}
	public function buy(){
	
		$data['sh_userid']		=	$this->input->post('user_id');
		$data['sh_pdtid']		=	$this->input->post('pdt_id');
		$data['sh_name']		=	$this->input->post('name');
		$data['sh_street1']		=	$this->input->post('street1');
		$data['sh_street2']		=	$this->input->post('street2');
		$data['sh_city']		=	$this->input->post('city');
		$data['sh_zip']			=	$this->input->post('zip');
		$data['sh_state']		=	$this->input->post('state');
		$data['sh_country']		=	$this->input->post('country');
		$data['sh_date']		=	date('Y-m-d H:i:s');
		
		$ofrArr['userid']		=	$this->input->post('user_id');
		$ofrArr['pdtid']		=	$this->input->post('pdt_id');	

		$product_deatils		=	Product::getProductInfo($data['sh_pdtid']);
		
		$pr_status				=	$product_deatils->pr_status;
		
		if($pr_status==3){
			echo 'Product already soldout';
			exit;
		}

		
		$payData['greatertext'] = '';
		$amountResult			=	Product::getOfferByUser($ofrArr);

		if(!empty($amountResult)){
		
			$amount 		= $amountResult->ofr_requestprice;		
			$actualprice	=	$this->input->post('pdt_price');		
			if($amount > $actualprice){
				$payData['greatertext'] = "Your offer is more than the product's listed price";	
			}
		}else{
			
			$amount = $this->input->post('pdt_price');
			
		}
		
		$result					=	Product::addShipping($data,$amount);		
		$payData['paypalform']				= $result;
		$this->layout->view('redirect',$payData);
		
		// if($result){
				// echo 'You are buy the product successfully';
				// exit();	
			// }
	
	}
	/* function to show the upload profile image window*/
	public function showUpload(){
		$userid 					= $this->session->userdata('user_id');
		
		$result = User::getUserInfo($userid);
		$fileid = $result->profile_image_id;
		if($fileid!=0){
		$filedetails = User::getProfileImage($fileid); 
		$data['file_name'] = $filedetails->file_path;
		}else{
		$data['file_name'] = "";
		}
		$this->load->view('showupload',$data);
	}
	/* function to change the profile image*/
	public function profilechange(){
	
		$userid 					= $this->input->post('userid');
	
		if($_FILES['photoimg']){
			$filetype = $_FILES['photoimg']['type'];
			 
			if( ($filetype!='image/jpeg')&&($filetype != "image/jpg")&&($filetype != "image/png")&&($filetype != "image/gif")){ // || $filetype!='image/png' || $filetype!='image/gif'
			
			echo 'error:invalid file type'; exit;
			
			}else{
				$uploadedfile = $_FILES['photoimg']['tmp_name'];
				list($width,$height)=getimagesize($uploadedfile);				
				if($width<145 && $height<150 ){
				echo 'error:Please upload image with height above 150 pixels and width above 145 pixels'; exit;				
				}else{
					
					$result 			= User::getUserInfo($userid);
					$imgId 				= $result->profile_image_id;
					if($imgId!=0){
						$filedetails 		= User::getProfileImage($imgId); 
						$imgurl         	= $filedetails->file_path;
						
						$db 		= new Db();
						$imgId 	= $db->deleteRecord('files', " file_id=" . $imgId );
						
						if(file_exists(FILE_UPLOAD_DIR.'/'.$imgurl))
							unlink(FILE_UPLOAD_DIR.'/'.$imgurl);

						if(file_exists(FILE_UPLOAD_DIR.'/profilethumb_'.$imgurl)) 
							unlink(FILE_UPLOAD_DIR.'/profilethumb_'.$imgurl);
					}	
					
					$fileUpres 					=  Fileuploader::uploadfile($_FILES['photoimg']);
			
					$file_id 					=  $fileUpres->file_id;
					$thumbRes 					=  Fileuploader::createThumbnail($fileUpres->file_id,'profilethumb',false);
					$thumbReschat 				=  Fileuploader::createThumbnail($fileUpres->file_id,'chatthumb',false);
				
					$filedetails 		= User::getProfileImage($file_id); 
					$imgurl         	= $filedetails->file_path;
					
					echo $imgurl.':'.$file_id;exit;
				}
			}
			
			
		}
	}
	/* function save the changes */
	public function savechages(){
			$fileid 			= $this->input->post('fileid');
			$userid 			= $this->input->post('user');
			
			if($fileid!=""){
			
			$save['profile_image_id'] 	= $fileid;
			
			$result = User::updateUser($userid,$save);
			echo 'changes Updated successfully';exit;
			}else{
				echo 'No changes made';exit;
			}
	}
	
	
	
	/*
	 *	Function to show the 404 page
	 */
	public function pagenotfound() {
		$this->layout->view('pagenotfound');
		
	}
	
	
	public function chattest() {
		$this->layout->view('chattest');
	
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */

