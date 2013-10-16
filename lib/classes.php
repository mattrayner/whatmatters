<?php
class Blackboard {
	private $mysql_connection;
	
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
		if (mysqli_connect_errno($mysql_connection)){
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
		
			return commentsArray($dbresult);
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
		$comments;
		
		//Iterate over every row in the result
		while($row = mysqli_fetch_array($dbresult)){
		        array_push($comments, new Comment($row['id'], $row['timestamp'], $row['comment'], $row['status'])); //Add an array entry
		}
		
		return $comments;
	}
	
	/**
	 * Close the database connection
	 **/
	public function close(){
		//Close the database connection
		mysqli_close($this->mysql_connection);
	}
	
	/**
	 * Output the json we have to the browser!
	 * - Check if there is a callback (JSONP)
	 *   - Output appropriate json
	 *
	 * @param        JSON        A json string to be outputted including the {}
	 * @return        String     The json string with or without a vcallback
	 **/
	public function outputJSON($json){
		if(isset($_GET['callback'])){
	    	return "{$_GET['callback']}(".$json.")";
		}else{
			return $json;
		}
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
    public function __construct ($id,$timestamp,$comment,$status) {
        $this->id = $id;
        $this->timestamp = $timestamp;
        $this->comment = $comment;
        $this->status = $status;
    }
    
        
    /**
     * getID function.
     * 
     * @access public
     * @return int
     */
    public function getID() {
	    return $this->id;
    }
    
    public function getTimeStamp() {
	    return $this->timestamp;
    }
    
    public function getComment() {
	    return $this->comment;
    }
    
    public function getStatus() {
	    return $this->status;
    }
}
?>