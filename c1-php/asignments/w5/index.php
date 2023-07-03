<!DOCTYPE html>
<html>
<head>
<title>Jorge Fontan - Request/Response Cycle</title>
</head>
<body>
<h1>Jorge Fontan Request / Response</h1>
<p><?php
$h= hash('sha256', 'Jorge Fontan'); 
echo 'The SHA256 hash of "Jorge Fontan" is'."\n$h" ?>
</p>
<pre>
ASCII ART:
  ╔╗
  ║║
  ║║
╔╗║║
║╚╝║
╚══╝
</pre>
<a href="check.php">Click here to check the error setting</a>
<br/>
<a href="fail.php">Click here to cause a traceback</a>
</body>
