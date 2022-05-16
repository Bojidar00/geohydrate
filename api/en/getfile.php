<?php


$path = $_GET["path"];

$type=mime_content_type($path);
header("Content-type: $type");
readfile($path);

?>