<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true){
	die(outputJSON("{error: 'Please log in to do this... You have insufficient rights'}"));
}

require('lib/classes.php');

$blackboard = new Blackboard();

if(!isset($_GET['id'], $_GET['status']))
	die(outputJSON("{error: 'Please specify both an ID and a status'}"));

$result = $blackboard->updateStatus($_GET['id'], $_GET['status']);

echo outputJSON("{ result: ".$result." }");

header("location: index.php");

?>