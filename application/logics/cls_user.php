<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

// +----------------------------------------------------------------------+
// | File name : cls_user.php                                      		  |
// | PHP version >= 5.2                                                   |
// +----------------------------------------------------------------------+ 
// +----------------------------------------------------------------------+
// | Copyrights Innomindtech                                              |
// | All rights reserved                                                  |
// +----------------------------------------------------------------------+
// | This script may not be distributed, sold, given away for free to     |
// | third party, or used as a part of any internet services such as      |
// | webdesign etc.                                                       |
// +----------------------------------------------------------------------+

class User {
    
   
	/*
	 * function to list the users in the system
	 */
    public static function getAllUsers($pagenum=1,$itemperpage=PAGE_LIST_COUNT,$search='',$searchFieldArray=array()) {
        
        $db = new Db();
        $objUserData                	= new stdClass();
		$objUserData->table         	= 'user';
        $objUserData->key           	= 'u_id';
        $objUserData->fields	    	= '*';
		$objUserData->join	    	    = 'ORDER BY u_id DESC';
        $objUserData->itemperpage   	= $itemperpage;
        $objUserData->page	    		= $pagenum;		// by default its 1
        $objUserData->debug	    		= true;
        $userlist                   	= $db->getData($objUserData);
        return $userlist;
    }

    /*
     * function to get the details of a user.
     */
	public static function getUserInfo($userid){
		 
        $db                     = new Db();
        $condition              = "u_id=" . $userid;
        $userInfo           	= $db->selectRecord('user', '*', $condition);
        return $userInfo;
	} 
	
	/*
	function to get user info from user id
	*/
	public static function getUserIdFromUname($uname){
		 
        $db                     = new Db();
        $condition              = "u_username='" . $uname."'";
        $userInfo           	= $db->selectRow('user', 'u_id', $condition);
        return $userInfo;
	} 
	
	
	public static function editUser($userid){
		 
        //echo $userid; exit;	
		$db                     = new Db();
        $condition              = "u_id=" . $userid;
        $userInfo          		= $db->selectRecord('user', '*', $condition);
        return $userInfo;
	} 
	
	/*
	 * function to update the user details
	 */
	public static function updateUser($userid, $dataArray){
		  
        $db                     = new Db();
        $condition              = "u_id =" . $userid;		
        return $db->updateFields('user', $dataArray, $condition);
	}
	/*
	 * function to add the user details-from admin
	 */
	public static function addUser($data){
	
	 $db        = new Db();	
	 return $db->addFields('user',$data);
	 
	}
	public static function deleteUser($userid){
		$db                     = new Db();
        $condition              = "u_id =" . $userid;	
	    return $db->deleteRecord('user',$condition);
	}
	public static function checkEmail($email){
	
		$db                     = new Db();
        $condition              = "u_email='" . $email."'";
        $emailInfo          	= $db->selectRecord('user', '*', $condition);
        return $emailInfo;
	}
	public static function checkusername($username){
	
		$db                     = new Db();
        $condition              = "u_username='" .$username."'";
        $Info          	= $db->selectRecord('user', '*', $condition);
        return $Info;
	}
	public static function get_forgotten_code($email){
		
		$db                     = new Db();
        $condition              = "u_email='".$email."'";
        $pwd_code         	 	= $db->selectRecord('user', 'u_forgot_pwd_code', $condition);
        return $pwd_code;
	}
	/* for reset password */
	public static function get_userdetails_by_code($code){
	
		$db                     = new Db();
        $condition              = "u_forgot_pwd_code='".$code."'";
        $userdetails         	= $db->selectRecord('user', '*', $condition);
        return $userdetails;
	}
	/*function to check user exists for loggin */
	public static function is_user_exist($user_email,$user_password){
	
		$db                     = new Db();
        $condition              = "u_username='".$user_email."' AND u_pwd='".md5($user_password)."' AND u_status=1";
        $userdetails         	= $db->selectRecord('user', '*', $condition);
        return $userdetails;
	}
	/* function to add ask a qustion into table questions */
	
	public static function addQuestion($data){
	
	 $db        = new Db();	
	 return $db->addFields('questions',$data);
	 
	}
	
	
	/*
	 * function to get the users latest paypal email
	 */ 
	public static function getUserPaypal($userid) {
		$db        		= new Db();	
		$condition      = "pr_addedby='" .$userid."' ORDER BY pr_id DESC";
        $paypalEmail    = $db->selectRow('products', 'pr_paypal_email', $condition);
		return $paypalEmail;
	}
	
	/*
	 *	Function to get the user name from the user id
	 */
	public static function getUserName($userid) {
		$db        		= new Db();	
		$condition      = "u_id=" .$userid;
        $username    	= $db->selectRow('user', 'u_username', $condition);
		return $username;
	}
	
	/*
	 *	function to return the user rating and product coun
	 */
	public static function getPosterdInfos($userid) {
		$db        		= new Db();	
		$condition      = "u_id=" .$userid;
        $userInfo    	= $db->selectRecord('user', 'u_id,u_username,u_country,u_height,u_weight,u_rating,u_prcount,profile_image_id', $condition);
		return $userInfo;
	
	}
	
	
	/*
	 *	function to return the required user field
	 */	
	public static function getUserField($uid,$field="u_username"){ 
        $db                     = new Db();
        $condition              = "u_id='" . $uid."'";
        $userField           	= $db->selectRow('user', $field, $condition);
        return $userField;
	} 
	/*function to get the user profile image details from files table*/
	public static function getProfileImage($fileid){
		$db                     = new Db();
        $condition              = "file_id='" . $fileid."'";
        $fileField           	= $db->selectRecord('files','*', $condition);
        return $fileField;
	}
	
	/*
	 *	function to get the user profile image
	 */
	public static function getUserProfileImage($uid){
		$db                     = new Db();
        $condition              = "U.u_id='" . $uid."'";
        $fileField           	= $db->selectRow('files AS F LEFT JOIN tbl_user AS U ON U.profile_image_id = F.file_id','F.file_path', $condition);
        return $fileField;
	}
	
	 
	
	
}

?>