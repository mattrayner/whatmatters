<?php
session_start();
error_reporting(0); //Supress errors caused when access a non-object even though its an object.

/**
 * API to grab each comment in JSON format :)
 **/
require("../lib/classes.php");

if(!isset($_GET['status']) || $_GET['status'] == null){exit(outputJSON("{error: 'Please specify an ID'}"));}

$status = $_GET['status'];

$allowedToExecute = false;

//Anyone is allowed to access approved comments
if($status == 1){
	$allowedToExecute = true;
} else if($status == 0 || $status == -1){	//You need to be logged in for denied and limbo comments
	if($_SESSION['loggedin'] == true)
		$allowedToExecute = true;
}

if($allowedToExecute){
	$blackboard = new Blackboard();
	$comments = $blackboard->getCommentsWithStatus($status);
	
	//Are there some actual comments
	if(count($comments) > 0){
		$jsonString = '{ "generated": "'.date("c").'", "comments" : {';
		
		$totalComments = count($comments);
		
		foreach($comments as $key => $comment){	
			
			$comment = unserialize($comment);
		
			$jsonString .= $key." : { id : ".$comment->id.", timestamp : ".$comment->timestamp.", comment : ".$comment->comment.", status : ".$comment->status." }";
			
			//Append a comma if this is not the last comment
			if($key < $totalComments){$jsonString .=", ";}
		}
		
		//Finish our JSON string
		$jsonString .= "}";
		
		echo outputJSON($jsonString);
	}else{
		echo outputJSON("{warning: 'No comments were retrived from the server....'}");
	}
} else {
	echo outputJSON("{error: 'You have insufficient permissions to access this call. Please validate your account and try again. Alternatively, ensure the parameters passed are correct.'}");
}
?>