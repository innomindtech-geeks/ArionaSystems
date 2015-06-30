<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

// +----------------------------------------------------------------------+
// | File name : cls_auth.php                                      		  |
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

class Auth {

	public static function loggin($data)
	{
	
		$db                    	= new Db();
        $condition              = "username='".$data['username']."' AND password='".MD5($data['password'])."' AND status=1";
        $userDetails          	= $db->selectRecord('admin', '*', $condition);
		
		return $userDetails;
		
	}
	public static function check_email($data)
	{
		$db                    	= new Db();
        $condition              = "email='".stripslashes($data)."'";
        $emailDetails          	= $db->selectRecord('admin', '*', $condition);
		
		return $emailDetails;
	}
	public static function get_forgotten_password_code($data)
	{
		$db                    	= new Db();
        $condition              = "email='".$data['email']."'";
        $passwordDetails        = $db->selectRecord('admin', 'forgot_password_code', $condition);
		return $passwordDetails;
	}
	public function reset_pasword($data)
	{
		$db                    	= new Db();
        $condition              = "email='".$data['email']."'";
        $pwdReset        		= $db->updateFields('admin',$data['password'] , $condition);
		return $pwdReset;
		
	}
	public static function get_user_by_random($data)
	{
		$db                    	= new Db();
        $condition              = "forgot_password_code='".$data['random']."'";
        $userDetails        	= $db->updateFields('admin','*' , $condition);
		return $userDetails;
	}
	
	public static function get_admin($id)
	{
		$db                    	= new Db();
        $condition              = "user_id='".$id."'";
        $adminDetails        	= $db->selectRecord('admin','*' , $condition);
		return $adminDetails;
	}
	public function update_admin($data)
	{
		$db                     = new Db();
        $condition              = "user_id =" . $data['user_id'];
        return $db->updateFields('admin', $data, $condition);
	}
	public static function check_password($id)
	{
		$db                    	= new Db();
        $condition              = "user_id='".$id."'";
		
        $passwordDetails       	= $db->selectRecord('admin', 'password', $condition);
		
		return $passwordDetails;
	}
	public static function change_password($id,$data)
	{
		$db                    	= new Db();
        $condition              = "user_id='".$id."'";
        $passwordChange       	= $db->updateFields('admin', $data, $condition);
		return $passwordChange;
	}
	
	/* function to return user details for login from bl_user for front end*/
	public static function userLoggin($data)
	{
		
		$db                    	= new Db();
        $condition              = "u_email='".$data['username']."' AND u_pwd='".md5($data['password'])."' AND u_status=1";
	
        $userDetails          	= $db->selectRecord('user', '*', $condition);
		return $userDetails;
		
	}
	/*
     * function to use register the user
     */
	public function register($data)
	{
		$db                     = new Db();
		return $db->addFields('user',$data);
		
	}
}
?>