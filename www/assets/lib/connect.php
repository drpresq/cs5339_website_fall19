<?php // connect.php
      // Change the username to your utep name prior to upload
require_once 'strut.php';
	function get_connection(){
	  $realtest = true;
	  
	  if($realtest){
		$hn = 'cssrvlab01.utep.edu';
		$db = 'mysql';
		$un = 'gwwood';
		$pw = '*utep2020!';
	  
		$connection = new mysqli($hn, $un, $pw, null);
		if ($connection->connect_error){
			echo $connection->error."<br>";
			echo $connection->connect_error."<br>";
		}
		$connection->select_db("gwwood_f19_db");
	  
	  } else {
		$hn = '127.0.0.1:3306';
		$db = 'mysql';
		$un = 'user';
		$pw = '*utep2020!';

		$connection = new mysqli($db, $un, $pw, null);
		if ($connection->connect_error) die("Fatal Error");


		$connection->select_db("user_f19_db");
	  }

	  return $connection;

	}
?>
