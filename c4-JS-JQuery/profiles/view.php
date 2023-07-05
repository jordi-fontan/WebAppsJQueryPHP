<?php 
 session_start();
 include('pdo.php');

 if ( !isset($_SESSION['name'] ) ) {
    // Redirect the browser to index.php
    die("Name parameter missing");
}
$user_id = $_SESSION['user_id'];
$first_name = "";
$last_name = "";
$email= "";
$headline = "";
$summary = "";
$stmt = $pdo->prepare('SELECT *  FROM profile WHERE profile_id = :id ');

$stmt->execute(array( ':id' => $_GET['profile_id']));

$row = $stmt->fetch(PDO::FETCH_ASSOC);


if ( $row !== false ) {
    
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $email= $row['email'];
    $headline = $row['headline'];
    $summary = $row['summary'];
}
else {
    $failure = "Not found";
    error_log($stmt);
    $_SESSION["error"] = $failure ;
    header( 'Location: index.php' ) ;
    return;
}  
?>

<!DOCTYPE html>
<html>
<head>
<title>Jordi Fontan's Profile View</title>
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
<h1>Profile information</h1>
<p>First Name: <?php echo($first_name);?></p>
<p>Last Name:
<?php echo($last_name);?></p>
<p>Email:
<a href="<?php echo($email);?>"><?php echo($email);?></a></p>
<p>Headline:<br/>
<?php echo($headline);?></p>
<p>Summary:<br/>
<?php echo($summary);?><p>
</p>
<a href="index.php">Done</a>
</div>

</html>