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

$username = $_POST["username"];
      $password = $_POST["password"];
      $sql1 =  "select access as ac from users where username = '$username' AND password = '$password'";
      $result1 = mysqli_query($con,$sql1);
      $ac=(object) mysqli_fetch_object($result1);
      if($ac->ac==1 || $ac->ac==2 ){
switch ($method) {
    case 'POST':
      $title = $_POST["title"];
      $content = $_POST["content"];
      $snimka=$_FILES["file"]["name"];
      

      $target_dir = "uploads/";
       $target_file = $target_dir . basename($_FILES["file"]["name"]);
        move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
        
    
      

      $sql = "insert into news (title, content, pic) values ('$title', '$content','$target_file')"; 
      break;
}
      }
// run SQL statement
$result = mysqli_query($con,$sql);

// die if SQL statement failed
/*if (!$result) {
  http_response_code(404);
  die(mysqli_error($con));
} */

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