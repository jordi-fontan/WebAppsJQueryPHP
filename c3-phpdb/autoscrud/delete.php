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
      DELETE FROM table_name WHERE condition;*/
      if ( isset($_POST['delete']) ) {
$stmt = $pdo->prepare('DELETE from autos where autos_id=:id');
$stmt->execute(array(
 ':id' => $_GET['autos_id'])
);
 $_SESSION['success'] = "Record deleted";
 $_SESSION['successd'] = "Record deleted";
 header("Location: view.php");
 return;
// header("Location: autos.php?name=".urlencode($_POST['who'])."&succes=y");

      }
?>
<html>
<head>
<title>Deleting...</title>

<link rel="stylesheet" 
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" 
    integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" 
    crossorigin="anonymous">

<link rel="stylesheet" 
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" 
    integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" 
    crossorigin="anonymous">

<link rel="stylesheet" 
    href="https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css">

<script
  src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous"></script>

<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
  integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
  crossorigin="anonymous"></script>

</head>
<body>
<div class="container">


<?php
  if ( isset($_GET['succes'] ) ) {
    echo('<p style="color: green;">Record inserted</p>');
  }
  
if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
  }
  $q='SELECT * from autos where autos_id='.$_GET['autos_id'];
  echo $q;
 foreach($pdo->query($q) as $fila) {
    echo('<p style="color: red;">'.$q."</p>\n");

 
?>

<p>Confirm: Deleting <?php  echo(htmlentities($fila['make'])) ;  ?></p>
<form method="post"><input type="hidden" name="autos_id" value="<?php  echo(htmlentities($fila['autos_id'])) ;  ?>"> <input type="submit" value="Delete" name="delete"><a href="index.php">Cancel</a>
</form>

<?php } ?>
</div>
</body>