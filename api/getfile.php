<?php
//header('X-Sendfile: /uploads/logo.png');
//header('Content-type: mime');
//header('Content-type: application/pdf');
//header('Content-type: image/png');
//header('Content-Disposition: inline; filename="logo.png"');

$path = $_GET["path"];

$type=mime_content_type($path);
header("Content-type: $type");
readfile($path);

?>