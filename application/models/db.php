<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | Singleton Database Class                                             |
// | File name : db.php                                             |
// | PHP version >= 5.2                                                   |
// +----------------------------------------------------------------------+
// | Author: Jinson Mathew<jinson@innomindtech.in>              |
// +----------------------------------------------------------------------+
// |----------------------------------------------------------------------+
// | Copyrights Innomindtech                                    |
// | All rights reserved                                                  |
// +----------------------------------------------------------------------+
include 'database.php';
include 'model.php';

class Db extends Model{
	
	public function __construct() 	{
		 
		parent::__construct();
	}
	
	
	/*
	Common function to check the existance of an item
	*/
	function checkExists($table,$field,$where)     {
		if($where!='')
			$where= ' WHERE '.$where;
    		$query = "SELECT count(".$field.") as cnt
    	         	 FROM ".$this->tablePrefix .$table.$where ;
				  				  
        $res = $this->execute($query);
    	return $this->fetchOne($res);
    }
    
	/*
	Function to insert the values to table
	*/
	function addFields($table,$postedArray) 	{
		foreach($postedArray as $key=>$val){
			$postedArray[$key] = mysql_real_escape_string($postedArray[$key]);  
		}
		return $this->insert($this->tablePrefix.$table, $postedArray);
	}
	
	/*
	Function to update the table details
	*/
	function updateFields($table,$postedArray,$condition) 	{
		foreach($postedArray as $key=>$val){
			$postedArray[$key] = mysql_real_escape_string($postedArray[$key]);  
		}
		return $this->update($this->tablePrefix.$table, $postedArray,$condition);
	}
	

	
	/*
	Common function to return the row fields
	*/
	function selectRow($table,$field,$where)     {
		if($where!='')
			$where= ' WHERE '.$where;
    	$query = "SELECT ".$field."
    	          FROM ".$this->tablePrefix .$table.$where ;
        $res = $this->execute($query);
    	return $this->fetchOne($res);
    }

	/*
	Common function to return the row fields
	*/
	function selectRecord($table,$field,$where)     {
		if($where!='')
			$where= ' WHERE '.$where;
    	$query = "SELECT ".$field."
    	          FROM ".$this->tablePrefix .$table.$where ;
		 // echo $query.'<br>';exit;
        $res = $this->execute($query);
    	return $this->fetchRow($res);
    }

	/*
 	Common function to return the resultset details
	*/
	function selectResult($table,$field,$where)     {
		if($where!='')
			$where= ' WHERE '.$where;
    	$query = "SELECT ".$field."
    	          FROM ".$this->tablePrefix .$table.$where ;
		//echo $query;//exit;
        $res = $this->execute($query);
    	return $this->fetchAll($res);
    }

	/*
	Function to delete the  keywords of a Brands
	*/
	function deleteRecord($table,$where) 	{
		$query = "DELETE FROM ".$this->tablePrefix  .$table.'  WHERE '.$where ;
        $res = $this->execute($query);

	}
	
	/*
	Function to execute a query to delete a records
	*/
	function customQuery($query) 	{
         $res = $this->execute($query);
		 return  $res;
	}
	
	
	 
	

	/*
	Function to delete the  keywords of a Brands
	*/
	function selectQuery($query) 	{
		if($query != '')		{
	        $res = $this->execute($query);
			return $this->fetchAll($res);
		}
	}
	
	/*
	 *Function to fetch single row from result set after executing a query
	 */
	function fetchSingleRow($query) 	{
		if($query != '') 		{
	        $res = $this->execute($query);
	        $data = $this->fetchAll($res);
	        if($data) return $data[0]; 
		}
	}


	/*
	 *function to get the count of records 
	 */


	function getDataCount($table='',$selFields = '*',$where='') 	{
		$query 	= 'SELECT COUNT('.$selFields.') AS cnt FROM ' . $this->tablePrefix . $table .' ' .$where;				 
  		
 		return $this->fetchOne($this->execute($query));
	}

	 
 	
	 /*
 	 * function to get the data with pagination. Pass the following parameters to the function.
 	 *  If don't have the values, no need to pass the values
 	 * 
 	 * 	$objSearch 					= new stdClass();
	 *	$objSearch->table			= 'products';
	 *	$objSearch->key  			= 'product_id';
	 *	$objSearch->fields			= '*';
	 *	$objSearch->join			= 'LEFT JOIN USER';
	 *	$objSearch->where			= 'USERID = 2';
	 *	$objSearch->groupbyfield	= 'last_update';
	 *	$objSearch->orderby			= 'ASC';
	 *	$objSearch->orderfield		= 'last_update';
	 *	$objSearch->itemperpage		= '2';
	 *	$objSearch->page			= '1';		// by default its 1
	 *	$objSearch->debug			= true;
 	 * 
 	 */
 	function getData($objData) {
 		$start 	= 'SELECT ';
 		$joinPart = $wherePart = $groupBy= $orderBy ='';
 		// field validation
 		if($objData->fields) 		$fieldPart 	= $objData->fields;
 		else 						$fieldPart 	= ' * ';
 		
 		// table specification
 		if($objData->table)			$tablepart 	= ' FROM '.$this->tablePrefix . $objData->table;
 		else						return false;
 		
 		// join section
 		if(property_exists($objData, 'join') && $objData->join)			$joinPart	= ' '.$objData->join;
 		
 		// where condition
 		if(property_exists($objData, 'where') && $objData->where)			$wherePart	= ' WHERE '.$objData->where;
 		
 		// group by section
 		if(property_exists($objData, 'groupbyfield') && $objData->groupbyfield)	$groupBy	=' GROUP BY '.$objData->groupbyfield;
 		
 		// sort by section
 		if(property_exists($objData, 'orderby') && $objData->orderby)		$orderBy 	=' ORDER BY '.$objData->orderfield.' '.$objData->orderby.' ';
 		
 		
 		// section to get the count of records
 		if($objData->key)			$countOf	= ' COUNT('.$objData->key.')';
 		$sqlGetCount = $start.$countOf.$tablepart.$joinPart.$wherePart.$groupBy.$orderBy;
 		
 		//$totRecords = $this->fetchOne($this->execute($sqlGetCount));
 		// $totRecords = mysql_num_rows($this->execute($sqlGetCount));
 		$objRes = new StdClass;
 		
 		
 		$resCount 		= $this->execute($sqlGetCount);
		if(mysql_num_rows($resCount) > 1)
			$totRecords = mysql_num_rows($resCount);
		else
			$totRecords = $this->fetchOne($resCount);			
		    $objRes->totalrecords = $totRecords;
 		
 		
 		
 		if($objData->itemperpage) 	$itemPerPage 	= $objData->itemperpage;
 		else 						$itemPerPage 	= PAGE_LIST_COUNT;
 		
 		if($objData->page) 			$currentPage 	= $objData->page;
 		else 						$currentPage 	= '1';
 		$totPages 					= ceil($totRecords/$itemPerPage);
 		$objRes->totpages 			= $totPages;
 		$objRes->currentpage 		= $currentPage;

 		// get the limit of the query
 		$limitStart = ($currentPage * $itemPerPage) - $itemPerPage;
 		$limitEnd 	= $itemPerPage;
 		$limitVal 	= ' LIMIT '.$limitStart.','.$limitEnd;

  		// get the records
 		$selectQuery = $start.$fieldPart.$tablepart.$joinPart.$wherePart.$groupBy.$orderBy.$limitVal;
 			//echo $selectQuery;echo '<br/>';
 		// debug the query
 		if($objData->debug)	$objRes->query = $selectQuery;

 		$res    			=	$this->execute($selectQuery);
        $objRes->records 	= $this->fetchAll($res);
 		return $objRes;	
 	}
 	
	
}
?>