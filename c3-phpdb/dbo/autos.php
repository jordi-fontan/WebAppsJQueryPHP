<?php // Do not put any HTML above this line
 include('pdo.php');
if ( !isset($_GET['name'] ) ) {
    // Redirect the browser to index.php
    die("Name parameter missing");
}
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

// Check to see if we have some POST data, if we do process it
if ( isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])) {
    if ( strlen($_POST['make']) < 1 ) {
        $failure = "Make is required";
        error_log("Login fail : empty field make= ");
    }
    if(!is_numeric($_POST['year'])  || !is_numeric($_POST['mileage']) ){
        $failure = "Mileage and year must be numeric";
        error_log("Mileage and year must be numeric year= ".$_POST['year']." mileage= ".$_POST['mileage']);
    } 
    else {

       

        $stmt = $pdo->prepare('INSERT INTO autos
        (make, year, mileage) VALUES ( :mk, :yr, :mi)');
    $stmt->execute(array(
        ':mk' => htmlentities($_POST['make']),
        ':yr' => $_POST['year'],
        ':mi' => $_POST['mileage'])
    );
   
        header("Location: autos.php?name=".urlencode($_POST['who'])."&succes=y");
    }
}
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
<h1>Tracking Autos for <?php echo(htmlentities($_GET['name'])) ; ?></a></h1>
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

<form method="post">
<p>Make:
<input type="text" name="make" size="60" value="<?php if ( isset($_POST['make'] ) ) echo(htmlentities($_POST['make'])) ;  ?>"/></p>
<p>Year:
<input type="text" name="year" value="<?php if ( isset($_POST['year'] ) ) echo(htmlentities($_POST['year'])) ;  ?>"/></p>
<p>Mileage:
<input type="text" name="mileage" value="<?php if ( isset($_POST['mileage'] ) ) echo(htmlentities($_POST['mileage'])) ;  ?>"/></p>
<input type="submit" value="Add">
<input type="submit" name="logout" value="Logout">
</form>

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
</div>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script></body>
</html>
