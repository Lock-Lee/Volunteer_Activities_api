<?php

abstract class BaseModel{
 
    public static $db;
    protected $host="localhost";
    
    // protected $username="root"; 
    // protected $password="root123456"; 
    // protected $db_name="phaisithong_server";
  
    protected $username="root"; 
    protected $password=""; 
    protected $db_name="bass";

    function __construct(){
        static::$db = mysqli_connect($host,$username,$password,$db_name);
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            
        }else{
            echo "connect";
        }
        mysqli_set_charset(static::$db,"utf8");
    }
}

?>