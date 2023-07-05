<?php // Do not put any HTML above this line
   session_start();
if ( ! isset($_SESSION['name']) ) {
    die('Not logged in');
  }
 include('pdo.php');

if ( isset($_POST['logout'] ) ) {
    // Redirect the browser to index.php
    header('Location: index.php');
}
/*
Mileage and year must be numeric
Also if the make is empty (i.e. it has less than 1 character in the string) you need to put out a message as follows:
Make is required
*/

$failure = false;  // If we have no POST data


?>

<!DOCTYPE html>
<html>
<head>
<title>Jordi Fontan Automobile Tracker</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
</head>
<body>
<div class="container">
<h1>Tracking Autos for <?php echo(htmlentities($_SESSION['name'])) ; ?></a></h1>
<?php
// Note triple not equals and think how badly double
// not equals would work here...
if ( $failure !== false ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
}
?>
<?php
  if ( isset($_GET['succes'] ) ) {
    echo('<p style="color: green;">Record inserted</p>');
  }
?>

<h2>Automobiles</h2>
<p>
<ul>

<?php 
try {
   
    foreach($pdo->query('SELECT * from autos') as $fila) {
       // print_r($fila);
       echo("<li><!--".$fila['auto_id']."-->".$fila['year']." ".$fila['make']." / ".$fila['mileage']."</li>"); 
      //-->$fila['year'] $fila['make'] / $fila['mileage']  
    }
    $mbd = null;
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>



</ul>
<p>
<a href="add.php">Add New</a> |
<a href="logout.php">Logout</a>
</p>
</div>
</body>
</html>
