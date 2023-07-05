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
if ( isset($_POST['email']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['headline']) && isset($_POST['summary'])) {//summary
    if ( strlen($_POST['first_name']) < 1 || strlen($_POST['email']) < 1 || strlen($_POST['last_name']) < 1 || strlen($_POST['headline']) < 1  || strlen($_POST['summary']) < 1 ){
        $failure = "All fields are required";
        error_log("Login fail : empty requiered field  ");
        $_SESSION["error"] = $failure ;
        header( 'Location: add.php' ) ;
        return;
    }
    
    else {

       

                $stmt = $pdo->prepare('INSERT INTO Profile
        (user_id, first_name, last_name, email, headline, summary)
        VALUES ( :uid, :fn, :ln, :em, :he, :su)');

        $stmt->execute(array(
        ':uid' => $_SESSION['user_id'],
        ':fn' => $_POST['first_name'],
        ':ln' => $_POST['last_name'],
        ':em' => $_POST['email'],
        ':he' => $_POST['headline'],
        ':su' => $_POST['summary'])
        );
        $_SESSION['success'] = "Record added";
        header("Location: index.php");
        return;
     
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Jordi Fontan Profile Tracker</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
</head>
<body>
<div class="container">
<h1>Tracking Profiles for <?php echo(htmlentities($_SESSION['name'])) ; ?></a></h1>
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
?>

<form method="post">
<p>first_name:
<input type="text" name="first_name" size="60" value="<?php if ( isset($_POST['first_name'] ) ) echo(htmlentities($_POST['first_name'])) ;  ?>"/></p>
<p>last_name:
<input type="text" name="last_name" size="60" value="<?php if ( isset($_POST['last_name'] ) ) echo(htmlentities($_POST['last_name'])) ;  ?>"/></p>
<p>email:
<input type="text" name="email" value="<?php if ( isset($_POST['email'] ) ) echo(htmlentities($_POST['email'])) ;  ?>"/></p>
<p>headline:
<input type="text" name="headline" value="<?php if ( isset($_POST['headline'] ) ) echo(htmlentities($_POST['headline'])) ;  ?>"/></p>
<p>summary:
<input type="text" name="summary" value="<?php if ( isset($_POST['summary'] ) ) echo(htmlentities($_POST['summary'])) ;  ?>"/></p>
<input type="submit" value="Add">
<input type="submit" name="logout" value="Logout">
</form>


</div>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script></body>
</html>
