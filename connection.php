<?php 
	session_start();
	$hostname = "localhost";
	//$username = "id15224571_project";
	 $username = "root";
	//$password = "Sem4ng4t45!untukproject";
	 $password = "";
	// $dbname = "id15224571_projectaset";
	$dbname = "project";
	
	// key cipher
	$chiave = "skripsi";

	$conn = new mysqli($hostname, $username, $password, $dbname);

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
 ?>