<?php
$host = "localhost"; 
$user = "root"; 
$password = ""; 
$dbname = "geohydrate"; 
$id = '';

$con = mysqli_connect($host, $user, $password,$dbname);

$method = $_SERVER['REQUEST_METHOD'];
//$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
//$input = json_decode(file_get_contents('php://input'),true);


header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");



if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}


switch ($method) {
    case 'POST':
      $name = $_POST["name"];
      $job_location = $_POST["job_location"];
      $education = $_POST["education"];
      $last_job = $_POST["last_job"];
      $job = $_POST["job"];
      $email = $_POST["email"];


      $sql = "insert into pearson (name,job_location, education,last_job,job,email) values ('$name', '$job_location', '$education', ' $last_job', '$job','$email')"; 
      break;
}

// run SQL statement
$result = mysqli_query($con,$sql);

// die if SQL statement failed
if (!$result) {
  http_response_code(404);
  die(mysqli_error($con));
}

if ($method == 'POST') {
    if (!$id) echo '[';
    for ($i=0 ; $i<mysqli_num_rows($result) ; $i++) {
      echo ($i>0?',':'').json_encode(mysqli_fetch_object($result));
    }
    if (!$id) echo ']';
  } elseif ($method == 'POST') {
    echo json_encode($result);
  } else {
    echo mysqli_affected_rows($con);
  }

$con->close();