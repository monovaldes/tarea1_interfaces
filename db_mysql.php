<?php 
/* 
        SMyCC [Pronounced "smEEk"] 
        (Simple MySQL Connection Class) 
        © 2005-2006 Steve Castle 
        http://www.stscac.com 

*/ 
class mysql 
{ 
    var $server; 
    var $conn_username; 
    var $conn_password; 
    var $database_name; 
    var $connection; 
    var $select; 
    var $query; 

    function connect() 
 { 
    require "database.inc.php"; 
     
    $connection = mysql_connect($server,$conn_username,$conn_password); 
    $select = mysql_select_db($database_name,$connection); 
    if (!$connection)
    {
    die('Could not connect: ' . mysql_error());
    }
} 
    function query($query) 
    { 
        $result = mysql_query($query); 
        if (!$result) { 
            echo 'Could not run query: ' . mysql_error(); 
            exit; 
} 
    } 
    function end() 
    { 
        mysql_free_result($connection); 
    } 
}
?>