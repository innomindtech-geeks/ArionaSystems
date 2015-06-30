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

class Admin {

	
	public static function get_admin($id)
	{
		$db                    	= new Db();
        $condition              = "user_id='".$id."'";
        $adminDetails        	= $db->selectRecord('admin','*' , $condition);
		return $adminDetails;
	}
	
	/*
     * function to get the details of a newsletter group
     */
	public static function selectAdmin($email){
		 
        $db                     = new Db();
        $condition              = "email='" . $email."'";
        $Info         			= $db->selectRecord('admin', '*', $condition);
        return $Info;
	} 
	
	/*
     * function to use insert and update the Subsriber group
     */
	public function updateAdmin($data)
	{
		$db                     = new Db();
		
		$condition        = "user_id = 1";
		
        return $db->updateFields('admin', $data, $condition);
		
	}

}
?>