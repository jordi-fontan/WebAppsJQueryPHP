<?php // Do not put any HTML above this line
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


$failure = false;  // If we have no POST data

// Check to see if we have some POST data, if we do process it
if ( isset($_POST['email']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['headline']) && isset($_POST['summary'])) 
{//summary
      
    
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email= $_POST['email'];
    $headline =$_POST['headline'];
    $summary = $_POST['summary'];
   
   
   
   
    if ( strlen($_POST['first_name']) < 1 || strlen($_POST['email']) < 1 || strlen($_POST['last_name']) < 1 || strlen($_POST['headline']) < 1  || strlen($_POST['summary']) < 1 ){
        $failure = "All fields are required";
        error_log("Login fail : empty requiered field  ");
        $_SESSION["error"] = $failure ;
        header( 'Location: add.php' ) ;
        return;
    }
    
   
    else {
        // NO POST SO WE ARE UPDATING
       /*
       UPDATE table_name SET column1 = value1, column2 = value2, ... WHERE condition; */

        


        $stmt = $pdo->prepare('UPDATE Profile
       SET user_id=:uid,first_name=:fn, last_name=:ln, email=:em, headline=:he, summary=:su where profile_id=:uid');
        $stmt->execute(array(
            ':uid' => $_SESSION['user_id'],
            ':fn' => $_POST['first_name'],
            ':ln' => $_POST['last_name'],
            ':em' => $_POST['email'],
            ':he' => $_POST['headline'],
            ':su' => $_POST['summary'])
            );
  
        $_SESSION['success'] = "Record updated";
        header("Location: index.php");
        return;
       // header("Location: autos.php?name=".urlencode($_POST['who'])."&succes=y");
    }
}
else{

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
<h1>Editing Profile for UMSI</h1>

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

<form method="post" action="edit.php">
<p>First Name:
<input type="text" name="first_name" size="60"
value="<?php echo($first_name);?>"
/></p>
<p>Last Name:
<input type="text" name="last_name" size="60"
value="<?php echo($last_name);?>"
/></p>
<p>Email:
<input type="text" name="email" size="30"
value="<?php echo($email);?>"
/></p>
<p>Headline:<br/>
<input type="text" name="headline" size="80"
value="<?php echo($headline);?>"
/></p>
<p>Summary:<br/>
<textarea name="summary" rows="8" cols="80">
<?php echo($summary);?></textarea>
<p>
<input type="hidden" name="profile_id" value="<?php echo($user_id);?>" />
<input type="submit" value="Save">
<input type="submit" name="cancel" value="Cancel">
</p>
</form>
</div>
</body>
</html>