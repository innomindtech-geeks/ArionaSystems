<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | Singleton Database Class                                             |
// | File name : database.php                                             |
// | PHP version >= 5.2                                                   |
// +----------------------------------------------------------------------+
// | Author: Jinson Mathew<jinson@innomindtech.in>              |
// +----------------------------------------------------------------------+
// |----------------------------------------------------------------------+
// | Copyrights Innomindtech                                    |
// | All rights reserved                                                  |
// +----------------------------------------------------------------------+

class Database {
	/**
    * Instance of this
	* @var instance
    **/
    private static $_instance = null;
    /**
    * Database connection
	* @var object
    **/
    private static $_connection = null;
	/**
	* constructor
	**/
    public function __construct()  {
        
    }
	/**
	* Method to get instance of AbstractDatabase
	* @return object $_instance
	**/
    public static function getInstance()     {
        if (self::$_instance == null)    {
            self::$_instance = new self;
        }
        return self::$_instance;
    }
    
	/**
	* Method to connect mysql server
	**/
    public function _connect()  {
	        if (!is_resource(self::$_connection)) {
	        	if (self::$_connection != null) 
	        	  @mysql_close(self::$_connection);
	        	 
	            self::$_connection = @mysql_connect(MYSQL_HOST, MYSQL_USERNAME, MYSQL_PASSWORD)
	             or die('Sorry, Unable to connect server');
	            //        or die(mysql_error());
	            mysql_select_db(MYSQL_DB);
	        }
    	 

    }
    
    
	/**
	* Method to close mysql connection
	**/
    public function close()  {
        if (is_resource(self::$_connection))    {
            mysql_close(self::$_connection);
        }
    }
    
    
    /**
	* Destructor
	**/
    public function __destruct()    {
    	//Close sql connection
       // $this->close();
    }
}
?>