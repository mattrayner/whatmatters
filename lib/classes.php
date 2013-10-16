<?php
class Blackboard {
	public $mysql_connection;
	
	/**
	 * Load in our config file and use the information to connect to the givecat database.
	 * If there is an error then output it as a json error string.
	 *
	 * @param	String	Path to config file.
	 **/
	public function __construct(){
		include_once("config.inc.php");
		
		//Connect to the database using the information from our config file.
		$this->mysql_connection = mysqli_connect("localhost",$databaseuser,$databasepass,$databasename);
		
		// Check connection
		if (mysqli_connect_errno($this->mysql_connection)){
			//Build our error string
			$json = '{error: "Failed to connect to MySQL: '.mysqli_connect_error().'"}';
			
			//Stop us going any further and output the JSON
			die(outputJSON($json));
		}
	}
	
	/**
	 * Load an array of Comment objects from the database.
	 *
	 * @return	Array	An array of Comment objects.
	 **/
	public function getCommentsWithStatus($status){
		if (is_numeric($status)) {
        	$dbresult = mysqli_query($this->mysql_connection,"SELECT *  FROM `comments` WHERE `status` = ".$status);
		
			return $this->commentsArray($dbresult);
		}
		
		return null;
	}
		 
	/**
	 * Generate an array of Comment objects from a mysqli_query result.
	 *
	 * @param	mysqli_query	The query result
	 * @return	Array	An array of Comment objects
	 **/
	private function commentsArray($dbresult){
		//Create a comments array
		$comments = null;
		
		//Iterate over every row in the result
		while($row = mysqli_fetch_array($dbresult)){
				if($comments == null){
					$comments[0] = serialize(new Comment($row['id'], $row['timestamp'], $row['comment'], $row['status']));
				}else{
					array_push($comments, serialize(new Comment($row['id'], $row['timestamp'], $row['comment'], $row['status']))); //Add an array entry
				}
		}
		
		return $comments;
	}
	
	/**
	 * Echo out rows of comments
	 **/
	public function echoCommentsRow($comments, $activate, $deactivate){
		if(!isset($comments) || $comments == null || count($comments) == 0){echo "<tr><td>no results</td></tr>";}else{					  	
			foreach($comments as $comment){							
				$comment = unserialize($comment);
				
				if(!isset($comment->id) || $comment->id != ""){
					$string = '<tr><td>'.$comment->id.'</td><td>'.$comment->timestamp.'</td><td>'.$comment->comment.'</td><td>';
					
					if($activate == true)
						$string .= '<a href="updateStatus.php?id='.$comment->id.'&status=1">Activate</a></td></tr>';
						
					if($deactivate == true)
						$string .= '<a href="updateStatus.php?id='.$comment->id.'&status=-1">Dectivate</a></td></tr>';
					
					echo($string);
				}
			}	  
		}
	}
	
	/**
	 * Check to see if the user and password supplied matched the database
	 * 
	 * @param	String	Username
	 * @param	String	Password
	 * @return	Boolean	Are they authenticated
	 **/
	public function authCheck($username, $password){
		$dbresult = mysqli_query($this->mysql_connection,"SELECT * FROM `users` WHERE `username` = '".$username."'");
		
		//Have we had any users come back?
		if($dbresult->num_rows > 0){
			$user = mysqli_fetch_array($dbresult);
			
			include_once('pbkdf2.php');
			
			if(validate_password($password, $user['hash'])){
				return true;
			}
		}
	
		return false;
	}
	
	/**
	 * Update comment's status
	 *
	 * @param	int	Comment's ID
	 * @param	int	New status
	 **/
	public function updateStatus($id, $status){
		//Check the inputs before doing anything.
		if(is_numeric($id) && is_numeric($status)){
			$dbresult = mysqli_query($this->mysql_connection,"UPDATE `kuonlin_blackboard`.`comments` SET `status` = '".$status."' WHERE `comments`.`id` = ".$id.";");
			
			return $dbresult;
		}
		
		return null;
	}
	
	/**
	 * Close the database connection
	 **/
	public function close(){
		//Close the database connection
		mysqli_close($this->mysql_connection);
	}
}

/**
 * A php Comment class
 * - Use when maipulating Comments
 * 
 * @author Matt Rayner
 */
class Comment {
    /**
     * Some comment properties
     * 
     * @var int, timestamp, string, int
     * @access public
     */
    public $id,$timestamp,$comment,$status;
    
    /**
     * Set some values for Cat::properties
     * 
     * @param int Comment ID
     * @param timestamp Comment TIMESTAMP
     * @param string Comment COMMENT
     * @param int Comment STATUS
     */
    public function __construct ($idx,$timestampx,$commentx,$statusx) {
        $this->id = $idx;
        $this->timestamp = $timestampx;
        $this->comment = $commentx;
        $this->status = $statusx;
    }
}

/*********** BEGIN HELPER FUNCTIONS (CLASSES IS AN INCORRECT NAME) ****************/
/**
 * Output the json we have to the browser!
 * - Check if there is a callback (JSONP)
 *   - Output appropriate json
 *
 * @param        JSON        A json string to be outputted including the {}
 * @return        String     The json string with or without a vcallback
 **/
function outputJSON($json){
	if(isset($_GET['callback'])){
    	return $_GET['callback']."(".$json.")";
	}else{
		return $json;
	}
}
?>