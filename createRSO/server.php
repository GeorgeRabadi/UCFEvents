<?php

session_start();

if (!isset($_SESSION['userID'])){
    header("Location: registration/login.php");
    die;}

$db = mysqli_connect("localhost", 'root', '', 'cop4710');

if (mysqli_connect_errno()) 
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());


$name = "";
$admin = "";
$arsize = "";
$student = array();
$errors = array(); 

if (isset($_POST['create_rso'])) {

  $name = mysqli_real_escape_string($db, $_POST['name']);
  $admin = mysqli_real_escape_string($db, $_POST['admin']);
  $arsize = mysqli_real_escape_string($db, $_POST['arsize']);
  for($i = 0; $i<$arsize; $i++)
  {
    if(isset("student[$i]"))
        array_push($errors, mysqli_real_escape_string($db, $_POST["student[$i]"]));
  }
  
  $query = "SELECT * FROM rso WHERE rsoName ='$name' LIMIT 1";
  $result = mysqli_query($db, $query);
  $rName = mysqli_fetch_assoc($result);
  

  if (!empty($rName)) {
      array_push($errors, "RSO already exists!");
    }

  if (count($errors) == 0) {

  	$query = "INSERT INTO rso (rsoName, adminID)  
    VALUES('$name',' $admin' )";
  	mysqli_query($db, $query);

    
    $query = "INSERT INTO rsomembership (rsoName, studentID)  
      VALUES('$name','$admin')";

    for($i = 0; $i<sizeof($student); $i++)
    {  
      $query = "INSERT INTO rsomembership (rsoName, studentID)  
      VALUES('$name','$student[$i]' )";
      mysqli_query($db, $query);
    }
    echo "<script>alert('RSO Created Successfully');</script>";
    
  }
}


?>