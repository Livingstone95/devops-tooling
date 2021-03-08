<?php 
include('db_conn.php');
  //$conn = mysqli_connect('localhost', 'root', '', 'dare');
  $username = "";
  $email = "";
  if (isset($_POST['save_environment'])) {
    $environmentType = $_POST['environment_type'];
    $environmentName = $_POST['env_name'];
  	$IP_address = $_POST['env_ip'];
  // session_start();
  // $_SESSION['environ_Type']=$environmentType;
  // $_SESSION['environ_Name']=$environmentName;
  // $_SESSION['environ_ip']=$IP_address;
  
  	$sql_et = "SELECT * FROM environments WHERE environment_type='$environmentType'";
  	$sql_en = "SELECT * FROM environments WHERE environment_name='$environmentName'";
    $sql_eip = "SELECT * FROM environments WHERE ip_address='$IP_address'";
    
  	$res_et = mysqli_query($conn, $sql_et);
    
  	$res_en = mysqli_query($conn, $sql_en);
    $res_eip = mysqli_query($conn, $sql_eip);
   
  	if (mysqli_num_rows($res_et) > 0 && mysqli_num_rows($res_en) > 0 &&  mysqli_num_rows($res_eip) > 0) {
  	  $name_error = "Environment already exist"; 	
  		echo $name_error ;
  	}else{
           $query = "INSERT INTO environments (environment_type, environment_name, ip_address) 
      	    	  VALUES ('$environmentType', '$environmentName', '$IP_address' )";
           $results = mysqli_query($conn, $query);
           header("Location: environment.php"); 
           echo  $query;
           //exit();
  	}
  }
?>