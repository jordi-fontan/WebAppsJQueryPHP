<?php // Do not put any HTML above this line
 session_start();
 include('pdo.php');
if ( !isset($_SESSION['name'] ) ) {
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
if ( isset($_POST['model']) && isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])) {
    if ( strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1 ) {
        $failure = "All fields are required";
        error_log("Login fail : empty field make= ");
        $_SESSION["error"] = $failure ;
        header( 'Location: add.php' ) ;
        return;
    }
    
    if(!is_numeric($_POST['year'])   ){
        $failure = "Year must be an integer";
        error_log("Mileage and year must be numeric year= ".$_POST['year']." mileage= ".$_POST['mileage']);
        $_SESSION["error"] = $failure ;
        header( 'Location: add.php' ) ;
        return;
    } 
    if( !is_numeric($_POST['mileage']) ){
        $failure = "Mileage must be an integer";
        error_log("Mileage and year must be numeric year= ".$_POST['year']." mileage= ".$_POST['mileage']);
        $_SESSION["error"] = $failure ;
        header( 'Location: add.php' ) ;
        return;
    } 
    else {

       /*
       UPDATE table_name
SET column1 = value1, column2 = value2, ...
WHERE condition; */

        $stmt = $pdo->prepare('UPDATE autos
       SET make=:mk,model=:ml, year=:yr, mileage=:mi where autos_id=:id');
    $stmt->execute(array(
        ':mk' => htmlentities($_POST['make']),
        ':ml' => htmlentities($_POST['model']),
        ':yr' => $_POST['year'],
        ':mi' => $_POST['mileage'],
        ':id' => $_GET['autos_id'])
    );
        $_SESSION['success'] = "Record inserted";
        header("Location: view.php");
        return;
       // header("Location: autos.php?name=".urlencode($_POST['who'])."&succes=y");
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
  
if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
  }
  $q='SELECT * from autos where autos_id='.$_GET['autos_id'];
 foreach($pdo->query($q) as $fila) {
    echo('<p style="color: red;">'.$q."</p>\n");

 
?>

<form method="post">
<p>Make:
<input type="text" name="make" size="60" value="<?php  echo(htmlentities($fila['make'])) ;  ?>"/></p>
<p>Model:
<input type="text" name="model" size="60" value="<?php echo(htmlentities($fila['model'])) ;  ?>"/></p>
<p>Year:
<input type="text" name="year" value="<?php  echo(htmlentities($fila['year'])) ;  ?>"/></p>
<p>Mileage:
<input type="text" name="mileage" value="<?php echo(htmlentities($fila['mileage'])) ;  ?>"/></p>
<input type="submit" value="Save">
<input type="submit" name="logout" value="Logout">
</form>
<?php } ?>

</div>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script></body>
</html>
