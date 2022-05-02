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
      $activity = $_POST["activity"];
      $deadline = $_POST["deadline"];
      $kolektiv = json_decode($_POST["kolektiv"],true);
      $results = json_decode($_POST["results"],true);



      $sql = "insert into grafik (activity,deadline) values ('$activity', '$deadline')"; 
      break;
}

// run SQL statement
$result = mysqli_query($con,$sql);

$sql = "SELECT LAST_INSERT_ID() as l"; 

$last_id = mysqli_query($con,$sql);
$l_id=(object) mysqli_fetch_object($last_id);

$val=0;
foreach ($results as $value){
    $val=(object) $value;
    $sql = "insert into result  (result) values ('$val->value')"; 
    $res = mysqli_query($con,$sql);
    $sql = "SELECT LAST_INSERT_ID() as l"; 
    $res = mysqli_query($con,$sql);
    $l_insert= (object) mysqli_fetch_object($res);
    $sql = "insert into grafik_result  (grafik_id,result_id) values ('$l_id->l','$l_insert->l')"; 
    $res = mysqli_query($con,$sql);

} 
foreach ($kolektiv as $value){
  $sql = "insert into grafik_kolektiv  (grafik_id,pearson_id) values ('$l_id->l','$value')"; 
  $res = mysqli_query($con,$sql);
}


// die if SQL statement failed
if (!$result) {
  http_response_code(404);
  die(mysqli_error($con));
}

if ($method == 'POST') {
    if (!$id) echo '[';
    for ($i=0 ; $i<mysqli_num_rows($last_id) ; $i++) {
      echo ($i>0?',':'').json_encode(mysqli_fetch_object($last_id));
      echo json_encode($value);
      echo json_encode($kolektiv);
      
    }
    if (!$id) echo ']';
  } elseif ($method == 'POST') {
    echo json_encode($result);
  } else {
    echo mysqli_affected_rows($con);
  }

$con->close();