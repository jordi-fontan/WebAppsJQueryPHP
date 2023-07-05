<?php // Do not put any HTML above this line
/*
if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to index.php
    header("Location: index.php");
    return;
}
*/
session_start();
if ( isset($_POST["email"]) && isset($_POST["pass"]) ) {
    unset($_SESSION["name"]);  // Logout current user
    
}


/*
$_SESSION['name'] = $_POST['email'];
header("Location: view.php");
return;


$_SESSION['error'] = "Email must have an at-sign (@)";
header("Location: login.php");
return;


if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
  }
*/
$salt = 'XyZzy12*_';
#$stored_hash = 'a8609e8d62c043243c4e201cbb342862';  // Pw is meow123
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1'; // Pw is php123

$failure = false;  // If we have no POST data
/*if ( $_POST['pass'] == 'umsi' ) {
    $_SESSION["name"] = $_POST["who"];
    $_SESSION["success"] = "Logged in.";
    header( 'Location: view.php' ) ;
    return;
} else {
    $_SESSION["error"] = "Incorrect password.";
    header( 'Location: login.php' ) ;
    return;
}*/
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
        $check = hash('md5', $salt.$_POST['pass']);
        if ( $check == $stored_hash ) {
            // Redirect the browser to game.php
            # header("Location: game.php?name=".urlencode($_POST['who']));
            $_SESSION["name"] = $_POST["email"];
            $_SESSION["success"] = "Logged in.";
            header( 'Location: view.php' ) ;
            return;
           
           
        } else {
            $failure = "Incorrect password";
            error_log("Login fail ".$_POST['email']." $check");
            $_SESSION["error"] = $failure ;
            header( 'Location: login.php' ) ;
            return;
        }
    }
}
    
// Fall through into the View
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once "bootstrap.php"; ?>
<title>Jordi Fontan Login Page</title>
</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php
// Note triple not equals and think how badly double
// not equals would work here...

if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
  }
/*if ( $failure !== false ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
}*/
?>
<form method="POST">
<label for="nam">Email</label>
<input type="text" name="email" id="nam" value="<?php if ( isset($_POST['email'] ) ) echo(htmlentities($_POST['email'])) ;  ?>"><br/>
<label for="id_1723">Password</label>
<input type="text" name="pass" id="id_1723" value="<?php if ( isset($_POST['pass'] ) ) echo(htmlentities($_POST['pass'])) ;  ?>"><br/>
<input type="submit" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
<p>
For a password hint, view source and find a password hint
in the HTML comments.
<!-- Hint: The password is the four character sound a cat
makes (all lower case) followed by 123. -->
</p>
</div>
</body>
