$(document).ready(function() {
  $('[data-toggle=offcanvas]').click(function() {
    $('.row-offcanvas').toggleClass('active');
  });
  
  var savedHash = window.location.hash;
  
  updateHashed();
  
  /**
   * Check to see if the window.location.hash has changed
   **/
  function hashCheck(){
	  var currentHash = window.location.hash;
	  
	  if(currentHash == "")
	  	window.location.hash = "#pending";
	  		  
	  if(currentHash != savedHash){
		  savedHash = currentHash;
		  updateHashed();
	  }
  }
  
  /**
   * Changed the displayed hash
   **/
  function updateHashed(){
  	  $(".hiddenpanel").hide();
	  $(window.location.hash).show();
	  
	  $(".navbar li").removeClass("active");
	  $(".navbar li a").each(function(){
		 if($(this).attr("href") == savedHash)
		 	$(this).parent().addClass("active"); 
	  });
  }
  
  setInterval(hashCheck, 1);
});