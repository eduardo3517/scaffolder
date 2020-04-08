<?php
class Database{

    private static $dbName = "u800399338_bdpv" ;
    private static $dbHost = "localhost" ;
    private static $dbUsername = "u800399338_root";
    private static $dbUserPsd = "dXiM0M6JIOwf";
     
    private static $cont  = null;
     
    public function __construct() {
        die("Init function is not allowed");
    }
     
    public static function connect()
    {
       // One connection through whole application
       if ( null == self::$cont ){     
			try{
				self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPsd); 
			}
			catch(PDOException $e){
				die($e->getMessage()); 
			}
       }
       return self::$cont;
    }
     
    public static function disconnect()
    {
        self::$cont = null;
    }

    public static function getDataBaseName(){
        return self::$dbName;
    }
}
?>
