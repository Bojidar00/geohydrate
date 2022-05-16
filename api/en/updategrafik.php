<?php
$host = "localhost"; 
$user = "root";  $user2 = "root2"; 
$password = "";  $password2 = ""; 
$dbname = "engeohydrate"; 
$dbname2 = "geohydrate"; 

$con = mysqli_connect($host, $user2, $password2,$dbname);
$con2 = mysqli_connect($host, $user, $password,$dbname2);

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
      $result1 = mysqli_query($con2,$sql1);
      $ac=(object) mysqli_fetch_object($result1);
      if($ac->ac==1 || $ac->ac==2 ){
$id=0;
switch ($method) {
    case 'POST':
      $id = $_POST["id"];
      $activity = $_POST["activity"];
      $deadline = $_POST["deadline"];
      $kolektiv = json_decode($_POST["kolektiv"],true);
      $results = json_decode($_POST["results"],true);

      $sql = "Update grafik SET activity = '$activity', deadline='$deadline' where grafik_id=$id"; 
      break;
}

// run SQL statement
$result = mysqli_query($con,$sql);

$val=0;

$sql = "delete from grafik_result where grafik_id = $id"; 
$res = mysqli_query($con,$sql);
foreach ($results as $value){
    $val=(object) $value;
    $sql = "DELETE FROM result where result_id=$val->id"; 
    $res = mysqli_query($con,$sql);
    $sql = "INSERT into result (result) values ('$val->value')";
    $res = mysqli_query($con,$sql);
    $sql = "SELECT LAST_INSERT_ID() as l"; 
    $res = mysqli_query($con,$sql);
    $l_insert= (object) mysqli_fetch_object($res);
    $sql = "insert into grafik_result  (grafik_id,result_id) values ('$id','$l_insert->l')"; 
    $res = mysqli_query($con,$sql);

}  
$sql = "delete from grafik_kolektiv where grafik_id = $id"; 
$res = mysqli_query($con,$sql);
foreach ($kolektiv as $value){
  $sql = "insert into grafik_kolektiv  (grafik_id,pearson_id) values ('$id','$value')"; 
  $res = mysqli_query($con,$sql);
}  

      }
// die if SQL statement failed
if (!$result) {
  http_response_code(404);
  die(mysqli_error($con));
}

if ($method == 'POST') {
     echo '[';
    for ($i=0 ; $i<mysqli_num_rows($result) ; $i++) {
      echo ($i>0?',':'').json_encode(mysqli_fetch_object($result));
      echo json_encode($value);
      echo json_encode($kolektiv);
      
    }
     echo ']';
  } elseif ($method == 'POST') {
    echo json_encode($result);
  } else {
    echo mysqli_affected_rows($con);
  }

$con->close();