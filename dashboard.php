<?php
/**
 * Dashboard!
 **/
require('lib/logincheck.php');
require('lib/classes.php');

error_reporting(0); //Supress errors caused when access a non-object even though its an object.

$blackboard = new Blackboard();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="assets/ico/favicon.png">

    <title>Blackboard Dashboard</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/offcanvas.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
      <script src="assets/js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Blackboard Dashboard</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#pending">Pending</a></li>
            <li><a href="#active">Active</a></li>
            <li><a href="#disabled">Disabled</a></li>
            <li><a href="logout.php">Log out</a></li>
          </ul>
        </div><!-- /.nav-collapse -->
      </div><!-- /.container -->
    </div><!-- /.navbar -->

    <div class="container">

      <div id="active" class="row row-offcanvas row-offcanvas-right hiddenpanel">
        <div class="col-xs-12 col-sm-12">
          <div class="jumbotron">
            <h1>Active!</h1>
            <p>These comments are all approved - you can disable them from here!</p>
          </div>
          
		  <hr/>
		
		  <!-- List of all the pending comments -->
		
		  <div class="panel panel-default">
			<!-- Default panel contents -->
			<div class="panel-heading">Comments</div>
			<div class="panel-body">
				<p>Below are all of the comments currently in the database. You can peruse or delete them at your leisure! Remember that hitting the delete button is <b>PERMANENT</b> and can not be undone.</p>
			</div>
		
			<!-- Table -->
			<table class="table">
				<thead>
					<tr>
						<th>ID</th>
						<th>Posted</th>
						<th>Comment</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<?php
					  $comments = $blackboard->getCommentsWithStatus(1);
					  $blackboard->echoCommentsRow($comments, false, true);
					?>
				</tbody>
			</table>
		  </div>
        </div><!--/span-->
      </div><!--/row-->

      <div id="pending" class="row row-offcanvas row-offcanvas-right hiddenpanel">
        <div class="col-xs-12 col-sm-12">
          <div class="jumbotron">
            <h1>Pending!</h1>
            <p>These comments are all awaiting your approval!</p>
          </div>
          
          
		
		  <hr/>
		
		  <!-- List of all the pending comments -->
		
		  <div class="panel panel-default">
			<!-- Default panel contents -->
			<div class="panel-heading">Comments</div>
			<div class="panel-body">
				<p>Below are all of the comments currently in the database. You can peruse or delete them at your leisure! Remember that hitting the delete button is <b>PERMANENT</b> and can not be undone.</p>
			</div>
		
			<!-- Table -->
			<table class="table">
				<thead>
					<tr>
						<th>ID</th>
						<th>Posted</th>
						<th>Comment</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<?php
					  $comments = $blackboard->getCommentsWithStatus(0);
					  $blackboard->echoCommentsRow($comments, true, true);
					?>
				</tbody>
			</table>
		  </div>
        </div><!--/span-->
      </div><!--/row-->
      
      <div id="disabled" class="row row-offcanvas row-offcanvas-right hiddenpanel">
        <div class="col-xs-12 col-sm-12">
          <div class="jumbotron">
            <h1>Disabled!</h1>
            <p>These comments are all Disabled - you can approve them from here!</p>
          </div>
          
          
		
		  <hr/>
		
		  <!-- List of all the pending comments -->
		
		  <div class="panel panel-default">
			<!-- Default panel contents -->
			<div class="panel-heading">Comments</div>
			<div class="panel-body">
				<p>Below are all of the comments currently in the database. You can peruse or delete them at your leisure! Remember that hitting the delete button is <b>PERMANENT</b> and can not be undone.</p>
			</div>
		
			<!-- Table -->
			<table class="table">
				<thead>
					<tr>
						<th>ID</th>
						<th>Posted</th>
						<th>Comment</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<?php
					  $comments = $blackboard->getCommentsWithStatus(-1);
					  $blackboard->echoCommentsRow($comments, true, false);
					?>
				</tbody>
			</table>
		  </div>
        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; Company 2013</p>
      </footer>

    </div><!--/.container-->



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/offcanvas.js"></script>
  </body>
</html>
