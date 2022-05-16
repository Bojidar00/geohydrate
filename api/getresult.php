<?php
$host = "localhost"; 
$user = "root"; 
$password = ""; 
$dbname = "geohydrate"; 


$con = mysqli_connect($host, $user, $password,$dbname);

$method = $_SERVER['REQUEST_METHOD'];
//$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
//$input = json_decode(file_get_contents('php://input'),true);


header('Access-Control-Allow-Origin: localhost');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");



if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}


switch ($method) {
    case 'POST':
      $id = $_POST["id"];
   
      $sql = "Select * from result where result_id=$id"; 
      break;
}

// run SQL statement
$result = mysqli_query($con,$sql);

$data=array();
for ($i=0 ; $i<mysqli_num_rows($result) ; $i++) {
   $data[$i]=(mysqli_fetch_row($result));
  }
  echo json_encode($data);
//$data = mysqli_fetch_object($result);

// die if SQL statement failed
if (!$result) {
  http_response_code(404);
  die(mysqli_error($con));
}

/*if ($method == 'POST') {
    if (!$id) echo '[';
    for ($i=0 ; $i<mysqli_num_rows($result) ; $i++) {
      echo ($i>0?',':'').json_encode( mysqli_fetch_row($result));
    }
    if (!$id) echo ']';
  } elseif ($method == 'POST') {
    echo json_encode($result);
  } else {
    echo mysqli_affected_rows($con);
  } */

$con->close();