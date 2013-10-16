<?php
/**
 * Authrnticate given user credentials
 **/
require('lib/loggedincheck.php');

//Do an additional check to make sure un and pw are set on post - kick'em back if not
if(!isset($_POST['un'], $_POST['pw']))
  header("location: index.php?errorno=0");

include_once("lib/classes.php");

//Username and pw sent from login form
$un = $_POST['un'];
$pw = $_POST['pw'];

//Create a Blackboard object to authenticate our user with
$blackboard = new Blackboard();

if( $blackboard->authCheck($un, $pw) ){
  $_SESSION['loggedin'] = true;
  $_SESSION['username'] = $un;
  
  $location = "dashboard.php";
} else {
  $location = "index.php?errorno=0";
}

header("location: ".$location);
?>