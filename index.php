<?php
/**
 * Casual bit of admin - allows you to confirm etc
 **/
require('lib/loggedincheck.php');

if(isset($_GET['errorno'])){
	$error = $_GET['errorno'];
}else{
	$error = null;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="assets/ico/favicon.png">

    <title>Blackboard Login</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/signin.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
      <script src="assets/js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
      <form class="form-signin" action="login.php" method="post">
      <?php if(isset($error)){ ?>
	  <div class="alert alert-danger">
		<?php
		  switch($error){
			case 0 : echo "Please enter a valid username and password.";
					 break;
			case 1 : echo "Error connecting to database - please try again later.";
					 break;
			case 2 : echo "Error doing XYZ";
					 break;
			default : echo "An error happened - please get in touch and tell us what you did!";
						   break;
		  }
		?>
	  </div>
	  <?php } ?>
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" class="form-control" placeholder="Username" name="un" autofocus>
        <input type="password" class="form-control" placeholder="Password" name="pw">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
