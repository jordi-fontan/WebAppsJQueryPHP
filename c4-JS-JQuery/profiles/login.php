<?php
require('pdo.php');
session_start();

// If there is a session and some error print it
if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
  }

// If there is a POST unset SESSION.name  
if ( isset($_POST["email"]) && isset($_POST["pass"]) ) {
    unset($_SESSION["name"]);  // Logout current user
    
}




$failure = false;  // If we have no POST data

// Check to see if we have some POST data, if we do process it
if ( isset($_POST['email']) && isset($_POST['pass']) ) {
    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
        $failure = "Email and password are required";
        error_log("Login fail : empty field email= ".$_POST['email']." pass= ".$_POST['pass']);
        $_SESSION["error"] = $failure ;
        header( 'Location: login.php' ) ;
        return;
    }
    elseif(strlen($_POST['email']) >= 1 && strpos($_POST['email'],'@')===FALSE){
        $failure = "Email must have an at-sign (@)";
       error_log("Login fail ".$_POST['email']." no @");
       $_SESSION["error"] = $failure ;
        header( 'Location: login.php' ) ;
        return;
    } 
    else {

        $salt = 'XyZzy12*_';

        // $stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1'; // Pw is php123

        
        $check = hash('md5', $salt.$_POST['pass']);

        $stmt = $pdo->prepare('SELECT user_id, name FROM users
   
            WHERE email = :em AND password = :pw');
   
        $stmt->execute(array( ':em' => $_POST['email'], ':pw' => $check));
   
        $row = $stmt->fetch(PDO::FETCH_ASSOC); 

        if ( $row !== false ) {

            $_SESSION['name'] = $row['name'];

            $_SESSION['user_id'] = $row['user_id'];

            // Redirect the browser to index.php

            header("Location: index.php");
            error_log("Login OK ".$_POST['email']." $check");    
            return;
        }    
        //Make sure to redirect back to login.php with an error message when there is no row selected.
        else {
            $failure = "Incorrect password";
            error_log("Login fail ".$_POST['email']." $check");
            $_SESSION["error"] = $failure ;
            header( 'Location: login.php' ) ;
            return;
        }    
    }    



// Fall through into the View    
    }
?>    

<!DOCTYPE html>
<html>
<head>
<title>Jordi Fontan's Login Page</title>
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
<h1>Please Log In</h1>
<form method="POST" action="login.php">
<label for="email">Email</label>
<input type="text" name="email" id="email"><br/>
<label for="id_1723">Password</label>
<input type="password" name="pass" id="id_1723"><br/>
<input type="submit" onclick="return doValidate();" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
<p>
For a password hint, view source and find an account and password hint
in the HTML comments.
<!-- Hint: 
The account is c
The password is the three character name of the 
programming language used in this class (all lower case) 
followed by 123. -->
</p>
<script>
function doValidate() {
    console.log('Validating...');
    try {
        addr = document.getElementById('email').value;
        pw = document.getElementById('id_1723').value;
        console.log("Validating addr="+addr+" pw="+pw);
        if (addr == null || addr == "" || pw == null || pw == "") {
            alert("Both fields must be filled out");
            return false;
        }
        if ( addr.indexOf('@') == -1 ) {
            alert("Invalid email address");
            return false;
        }
        return true;
    } catch(e) {
        return false;
    }
    return false;
}
</script>

</div>
</body>