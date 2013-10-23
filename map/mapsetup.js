/**
 * Map Object - stores map positions and start times
 **/
function MapObject(label, pointlat, pointlon, endtimestamp, contentstring, isend, isweekend, isbeginning){
  this.label=label;
  this.pointlon=pointlon;
  this.pointlat=pointlat;
  this.endtimestamp=endtimestamp;
  this.contentstring=contentstring;
  this.isend=isend;
  this.isweekend=isweekend;
  this.isbeginning=isbeginning;
}

var mapMarkers=[
  new MapObject("END NOTIFICATION", 51.295820, 1.067573, new Date(2013,9,21,00,00,00,00), '<p><b>It all starts on the 21/10/2013!</p>', false, false, true),
  new MapObject("Keynes 21st", 51.295307, 1.065856, new Date(2013,9,22,00,00,00,00), '<p><b>Keynes Foyer</b>, Canterbury Campus.</p>', false, false, false),
  new MapObject("Eliot 22nd", 51.296165, 1.068619, new Date(2013,9,23,00,00,00,00), '<p><b>Eliot Foyer</b>, Canterbury Campus.</p>', false, false, false),
  new MapObject("Rutherford 23rd", 51.297464, 1.065856, new Date(2013,9,24,00,00,00,00), '<p><b>Rutherford Foyer</b>, Canterbury Campus.</p>', false, false, false),
  new MapObject("Pilkington 24th", 51.397981, 0.537989, new Date(2013,9,25,00,00,00,00), '<p><b>Pilkington Reception</b>, Medway Campus.</p>', false, false, false),
  new MapObject("Darwin 25th", 51.298819, 1.072884, new Date(2013,9,26,00,00,00,00), '<p><b>Darwin Foyer</b>, Canterbury Campus.</p>', false, false, false),
  new MapObject("WEEKEND", 51.295820, 1.067573, new Date(2013,9,28,00,00,00,00), "<p><b>The box will be back at Woolf on Monday!</b></p>", false, true, false),
  new MapObject("Woolf 28th", 51.299976, 1.070808, new Date(2013,9,29,00,00,00,00), '<p><b>Woolf Foyer</b>, Canterbury Campus.</p>', false, false, false),
  new MapObject("Woodys 29th", 51.297843, 1.059172, new Date(2013,9,30,00,00,00,00), '<p><b>Woodys/Parkwood Reception</b>, Canterbury Campus.</p>', false, false, false),
  new MapObject("Keynes 30th", 51.295307, 1.065856, new Date(2013,9,31,00,00,00,00), '<p><b>Keynes Foyer</b>, Canterbury Campus.</p>', false, false, false),
  new MapObject("Pilkington 31st", 51.397981, 0.537989, new Date(2013,10,1,00,00,00,00), '<p><b>Pilkington Reception</b>, Medway Campus.</p>', false, false, false),
  new MapObject("Eliot 1st", 51.296165, 1.068619, new Date(2013,10,2,00,00,00,00), '<p><b>Eliot Foyer</b>, Canterbury Campus.</p>', false, false, false),
  new MapObject("END NOTIFICATION", 51.295820, 1.067573, new Date(2013,11,30,00,00,00,00), "<p><b>We're off counting comments!</b></p>", true, false, false)
];

/**
 * Initialize the google map
 **/
function initialize() {
  var mapOptions = {
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  var map = new google.maps.Map(document.getElementById('map-canvas'),
                                mapOptions);
  map.setZoom(19);

  //Get the current date
  var currentDate = new Date();
  
  var ourMarker = null;
  
  //Which point are we on?
  for(i=0; i<mapMarkers.length; i++){
  	var tempMarker = mapMarkers[i];
  	
  	console.log(tempMarker.label);
  	
  	//Is the current date less than the end time?
  	if(currentDate < tempMarker.endtimestamp){
  	  ourMarker = tempMarker;
  	  console.log("done");
  	  break;
  	}
  }
  
  //Set up the info window
  var contentString = '<p>Check back soon...</p>';
  
  if(ourMarker != null){
    //Set the marker image
	var image = 'http://www.kentunion.co.uk/stylesheet/WhatMatters/purplebox.png';
	
	if(ourMarker.isend == true)
	  image = 'http://www.kentunion.co.uk/stylesheet/WhatMatters/thanks.jpg';	//"we're counting" image
		
	if(ourMarker.isweekend == true)
	  image = 'http://www.kentunion.co.uk/stylesheet/WhatMatters/weekend.jpg';
	  
	if(ourMarker.isbeginning == true)
	  image = 'http://www.kentunion.co.uk/stylesheet/WhatMatters/comingsoon.jpg';
	  
    //Set up the marker
	var myLatLng = new google.maps.LatLng(ourMarker.pointlat, ourMarker.pointlon);
	var postBoxMarker = new google.maps.Marker({
	  position: myLatLng,
	  map: map,
	  icon: image,
	  title: "Where's the box?"
	});
	
	//Get the current date as a string
	var curr_date = currentDate.getDate();
    var curr_month = currentDate.getMonth() + 1;
    var curr_year = currentDate.getFullYear();
    var dateString = curr_date + "-" + curr_month + "-" + curr_year;
    
    console.log(dateString);
	
	//Set the content string
	contentString = '<div id="content"><div id="siteNotice"></div><div id="bodyContent"><p>Today the post box can be found at:</p>'+ourMarker.contentstring+'<p><b>The box will be there from</b>: 10am - 4pm on '+dateString+'</p></div></div>';
	if(ourMarker.isend)
	  contentString = '<div id="content"><div id="siteNotice"></div><div id="bodyContent"><p><b>We\'re off counting the comments!</b></p></div></div>';
	  
	if(ourMarker.isweekend)
	  contentString = '<div id="content"><div id="siteNotice"></div><div id="bodyContent"><p><b>The box will be back at Woolf on Monday!</b></p></div></div>';

	if(ourMarker.isbeginning)
	  contentString = '<div id="content"><div id="siteNotice"></div><div id="bodyContent"><p><b>Just a couple of days until you can tell us what matters!</b></p></div></div>';
	  
	var infowindow = new google.maps.InfoWindow({
	  content: contentString
	});
	  
	//Set the centre point
	if((ourMarker.isend == true) || (ourMarker.isweekend == true) || (ourMarker.isbeginning == true)){ //So you can see the big markers
	  map.setCenter(new google.maps.LatLng(51.296060, 1.067594));
	}else{
	  map.setCenter(new google.maps.LatLng(ourMarker.pointlat, ourMarker.pointlon));
	  //infowindow.open(map,postBoxMarker);	
	}
	
	//Add a marker click event - when the marker is clicked open the info window.
	google.maps.event.addListener(postBoxMarker, 'click', function() {
	  infowindow.open(map,postBoxMarker);
	});
  }
}

google.maps.event.addDomListener(window, 'load', initialize);