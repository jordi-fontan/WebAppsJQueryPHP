<?php 
/*
index.php Will present a list of all profiles in the system with a link to a detailed view with view.php whether or not you are logged in. 
If you are not logged in, you will be given a link to login.php. 
If you are logged in you will see a link to add.php add a new resume and links to delete or edit any resumes that are owned by the logged in user.


*/

require('pdo.php');
session_start();
$logged=isset($_SESSION['name']);

?>
<!DOCTYPE html>
<html>
<head>
<title>Jordi Fontan's Resume Registry</title>
<!-- bootstrap.php - this is HTML -->

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" 
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" 
    integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" 
    crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" 
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" 
    integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" 
    crossorigin="anonymous">

</head>
<body>
<div class="container">
<h1>Jordi Fontan's Resume Registry</h1>


<h2>Profiles</h2>
<p><?php 
if ( isset($_SESSION['success']) ) {
    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['error']);
  }
 ?> 
<p>
<table border="1">
<thead><tr>
<th>name</th>
<th>mail</th>
<th>headline</th>

<?php if($logged) echo '<th>Action</th>' ?>
</tr></thead>

<?php 
try {
   
    foreach($pdo->query('SELECT * from profile') as $fila) {
       // print_r($fila);
       $fn=$fila['first_name']." ".$fila['last_name'];
       echo("<tr><td><a href=\"view.php?profile_id=".$fila['profile_id']."\">");
       echo($fn."</a></td><td> ".$fila['email']." </td><td> ".$fila['headline']." </td>"); 
      if($logged) echo ("<td><a href=\"edit.php?profile_id=".$fila['profile_id']."\">Edit</a> / <a href=\"delete.php?profile_id=".$fila['profile_id']."\">Delete</a></td>");
       echo("</tr>"); 
       //-->$fila['year'] $fila['make'] / $fila['mileage']  
    }
    $mbd = null;
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>



</table>
<p>
<?php
    if($logged){
        echo('<p><a href="add.php">Add New Entry</a></p>');

        echo('<p><a href="logout.php">Logout</a>');
       
    }
    else{
        echo('<p><a href="login.php">Please log in</a></p>')    ;

    }
    
    

?>
<p>

</div>
</body>
