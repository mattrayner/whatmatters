var totalComments = 0;

/**
 * Grab the comments from the API
 *
 * JSONP the connection
 *
 * @return JSONP JSON from the server
 **/
function getAcceptedComments(){
	$.ajax({
     type : "GET",
     dataType : "jsonp",
     url : "http://kentuniononline.co.uk/projects/whatmatters/api/?status=1&nonce="+Math.floor(Math.random()*12345678)+"&callback=?", // ?callback=?
     success: function(data){
      //Make sure there are no errors
      if(typeof data['comments'] != 'undefined'){
       redrawComments(data);
      }else{
	   displayError(data);
      }
     }
	});
	
	return true;
}

/**
 * Display an error sent in!
 **/
function displayError(data){
	console.log(data);
}

/**
 * Redraw the comments on the blackboard!
 **/
function redrawComments(data){
	console.log("Comments!");

    var comments = data['comments'];
    
    //Count the comments
    var key, count = 0;
	for(key in data['comments']) {
	  if(data['comments'].hasOwnProperty(key)) {
	    count++;
	  }
	}
	
	if(count < totalComments)
		totalComments = 0;
    
    var domString;
    
    if(totalComments > 0)
    	domString = $("#blackboardContainer").html();
	else
		domString = "";
    
    for(i = totalComments; i<count; i++){
	    var comment = comments[i]['comment'];
	    
	    domString += "<div class=\"row-fluid\"><div class=\"span6 commentDiv";
	    
	    if(!isEven(i))
	    	domString += " pull-right";
	    	
	    var color = Math.floor(Math.random()*5);
	    
	    switch(color){
	    	case 1: domString += " pink";
	    			break;
	    	case 2: domString += " orange";
	    			break;
	    	case 3: domString += " cyan";
	    			break;
	    }
	    	
	    domString += "\">"+comment+"</div></div><hr>";
	    
	    totalComments++;
    }
    
    $("#blackboardContainer").html(domString);
}

/**
 * Build the blackboard (form and associated dom stuff)
 **/
function buildBlackboard(bbc){
	
}

$(document).ready(function(){
	var blackboardContainer = $("#blackboardContainer");

	//Does the container exist
	if(blackboardContainer.length > 0){
		//Now that we have the comments lets build the blackboard
		buildBlackboard(blackboardContainer);
		
		getAcceptedComments();
	}else{console.log("Oh... No div founds :( shoulds probs fix that.");}

	$("#submitButton").on("click", function(event){
		event.preventDefault();
		//Get content
		var commentText = $("#commentText").val();
		
		$("#commentText").val("");
		
		$("#blackboardAlertContainer").html("<div class=\"alert alert-information\"><b>Submitting comment</b> - please wait</div>");
		
		if(commentText.length > 4 && commentText != "" && commentText != null){
			$.ajax({
		     type : "GET",
		     dataType : "jsonp",
		     url : "http://kentuniononline.co.uk/projects/whatmatters/api/newComment.php?comment="+commentText+"&nonce="+Math.floor(Math.random()*12345678)+"&callback=?", // ?callback=?
		     success: function(data){
		      //Make sure there are no errors
		      if(typeof data['success'] != 'undefined')
		      	$("#blackboardAlertContainer").html("<div class=\"alert alert-success\"><b>Comment Submitted</b> - Your comment is now awaiting approval.</div>");
		      else
		      	
		      	$("#blackboardAlertContainer").html("<div class=\"alert alert-danger\"><b>Whoops!</b> - There was a problem submitting your comment. Please try again later.</div>");

		      
			  displayError(data);
			  
			  getAcceptedComments();
		     }
			});
		} else {
			$("#blackboardAlertContainer").html("<div class=\"alert alert-danger\"><b>Whoops!</b> - Please enter a valid comment (should be atleast 5 characters).</div>");
		}
	});
	
	//Load new comments on every load
	setInterval(function(){getAcceptedComments()},1000);
});

function isEven(value) {
	if (value%2 == 0)
		return true;
	else
		return false;
}