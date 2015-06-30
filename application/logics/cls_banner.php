<?php 
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

// +----------------------------------------------------------------------+
// | File name : cls_category.php                                      		  |
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

class Banner {
	
	/*
     * function to get all categories from category table
     */
	
	public function getAllPages($pagenum=1,$itemperpage=PAGE_LIST_COUNT,$search='',$searchFieldArray=array()) {
        
        $db = new Db();
        $objPost               		= new stdClass();
		$objPost->table         	= 'banners';
        $objPost->key           	= 'banner_id';
		$objPost->join				= 'LEFT JOIN tbl_files ON tbl_files.file_id = tbl_banners.banner_file_id';
        $objPost->fields	    	= '*';
        $objPost->itemperpage   	= $itemperpage;
        $objPost->page	    		= $pagenum;		// by default its 1
        $objPost->debug	    		= true;
        $postList              		= $db->getData($objPost);
         
        return $postList;
    }
	/*
     * function to use insert and update the category
     */
	public function insertData($data)
	{
		$db                     = new Db();
		if($data['banner_id']!="")
		{
		
        $condition              = "banner_id =" . $data['banner_id'];
        return $db->updateFields('banners', $data, $condition);
		}
		else
		{
			
			 return $db->addFields('banners',$data);
		}
	}
	
	/*
     * function to get the details of a banner
     */
	public static function getBannerInfo($id){
		 
        $db = new Db();
        $objPost               		= new stdClass();
		$objPost->table         	= 'banners';
        $objPost->key           	= 'banner_id';
        $objPost->fields	    	= '*';
		$objPost->join				= 'LEFT JOIN tbl_files ON tbl_files.file_id = tbl_banners.banner_file_id';
		$objPost->where				= 'banner_id ='.$id;
		$objPost->itemperpage   	= 1;
        $objPost->page	    		= 1;		// by default its 1
        $objPost->debug	    		= true;
        $bannerInfo	        		= $db->getData($objPost);
         
        return $bannerInfo;
       
	} 
	
	/*
     * function to delete banner
     */
	public static function delete($id){
		 
        $db                     = new Db();
		
        $condition              = "banner_id=" . $id;
        $result         		= $db->deleteRecord('banners', $condition);
        return $result;
	} 
	
	
	
}
?>