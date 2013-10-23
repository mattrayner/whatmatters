<?php
//check that we have a comment inserted
include_once("../lib/classes.php");

//Username and pw sent from login form
$comment = $_GET['comment'];

//Create a Blackboard object to authenticate our user with
$blackboard = new Blackboard();

$inserted = $blackboard->insertComment($comment);

if(isset($_GET['callback'])){
	echo($_GET['callback']."(".$inserted.");");
}else{
	echo($inserted);	
}
?>