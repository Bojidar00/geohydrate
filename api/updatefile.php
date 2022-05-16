<?php
$host = "localhost"; 
$user = "root"; 
$password = ""; 
$dbname = "geohydrate"; 


$con = mysqli_connect($host, $user, $password,$dbname);

$method = $_SERVER['REQUEST_METHOD'];



header('Access-Control-Allow-Origin: localhost');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");



if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}

$username = $_POST["username"];
      $password = $_POST["password"];
      $sql1 =  "select access as ac from users where username = '$username' AND password = '$password'";
      $result1 = mysqli_query($con,$sql1);
      $ac=(object) mysqli_fetch_object($result1);
      if($ac->ac==1 || $ac->ac==2 ){
switch ($method) {
    case 'POST':
      $id =  $_POST["id"];
      $access = $_POST["access"];
 


      $sql = "UPDATE files SET access = $access where file_id = $id;"; 
      break;
}
      }
// run SQL statement
$result = mysqli_query($con,$sql);

// die if SQL statement failed
if (!$result) {
  http_response_code(404);
  die(mysqli_error($con));
}

if ($method == 'POST') {
     echo '[';
    for ($i=0 ; $i<mysqli_num_rows($result) ; $i++) {
      echo ($i>0?',':'').json_encode(mysqli_fetch_object($result));
    }
     echo ']';
  } elseif ($method == 'POST') {
    echo json_encode($result);
  } else {
    echo mysqli_affected_rows($con);
  }

$con->close();