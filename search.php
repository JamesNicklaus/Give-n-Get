<?php
    // Search pages
 require('landing.php');
        
function getGeoCode($address)
{
        // geocoding api url
		include ('config.php');
        $url = "https://maps.google.com/maps/api/geocode/json?address=$address&key=$apiKey";
        // send api request
        $geocode = file_get_contents($url);
        $json = json_decode($geocode);
        $data['lat'] = $json->results[0]->geometry->location->lat;
        $data['lng'] = $json->results[0]->geometry->location->lng;
        return $data;
}
	
	// Variables
	$pgm2 	= 'GnG.php?p=search';
	$msg	= NULL;


	if (isset($_POST['submit']))  $stateSelected = $_POST['state']; else $stateSelected= NULL;
	// State Dropdown  
		$state = array('AL'=>'Alabama','AK'=>'Alaska','AZ'=>'Arizona','AR'=>'Arkansas','CA'=>'California','CO'=>'Colorado','CT'=>'Connecticut','DE'=>'Delaware','FL'=>'Florida','GA'=>'Georgia','HI'=>'Hawaii','ID'=>'Idaho','IL'=>'Illinois','IN'=>'Indiana','IA'=>'Iowa','KS'=>'Kansas','KY'=>'Kentucky','LA'=>'Louisiana','ME'=>'Maine','MD'=>'Maryland','MA'=>'Massachusetts','MI'=>'Michigan','MN'=>'Minnesota','MS'=>'Mississippi','MO'=>'Missouri','MT'=>'Montana','NE'=>'Nebraska','NV'=>'Nevada','NH'=>'New Hampshire','NJ'=>'New Jersey','NM'=>'New Mexico','NY'=>'New York','NC'=>'North Carolina','ND'=>'North Dakota','OH'=>'Ohio','OK'=>'Oklahoma','OR'=>'Oregon','PA'=>'Pennsylvania','RI'=>'Rhode Island','SC'=>'South Carolina','SD'=>'South Dakota','TN'=>'Tennessee','TX'=>'Texas','UT'=>'Utah','VT'=>'Vermont','VA'=>'Virginia','WA'=>'Washington','WV'=>'West Virginia','WI'=>'Wisconsin','WY'=>'Wyoming');
		
		$staticStates = array('Georgia','Florida','South Carolina','North Carolina','New Jersey','Connecticut','New York','Virginia','Delaware','Rhode Island','Massachusetts','New Hampshire');
		$stateIni = array('GA','FL','SC','NC','NJ','CT','NY','VA','DE','RI','MA','NH');
		
		$state_list = array('AL'=>"Alabama",  
		'AK'=>"Alaska",  
		'AZ'=>"Arizona",  
		'AR'=>"Arkansas",  
		'CA'=>"California",  
		'CO'=>"Colorado",  
		'CT'=>"Connecticut",  
		'DE'=>"Delaware",  
		'DC'=>"District Of Columbia",  
		'FL'=>"Florida",  
		'GA'=>"Georgia",  
		'HI'=>"Hawaii",  
		'ID'=>"Idaho",  
		'IL'=>"Illinois",  
		'IN'=>"Indiana",  
		'IA'=>"Iowa",  
		'KS'=>"Kansas",  
		'KY'=>"Kentucky",  
		'LA'=>"Louisiana",  
		'ME'=>"Maine",  
		'MD'=>"Maryland",  
		'MA'=>"Massachusetts",  
		'MI'=>"Michigan",  
		'MN'=>"Minnesota",  
		'MS'=>"Mississippi",  
		'MO'=>"Missouri",  
		'MT'=>"Montana",
		'NE'=>"Nebraska",
		'NV'=>"Nevada",
		'NH'=>"New Hampshire",
		'NJ'=>"New Jersey",
		'NM'=>"New Mexico",
		'NY'=>"New York",
		'NC'=>"North Carolina",
		'ND'=>"North Dakota",
		'OH'=>"Ohio",  
		'OK'=>"Oklahoma",  
		'OR'=>"Oregon",  
		'PA'=>"Pennsylvania",  
		'RI'=>"Rhode Island",  
		'SC'=>"South Carolina",  
		'SD'=>"South Dakota",
		'TN'=>"Tennessee",  
		'TX'=>"Texas",  
		'UT'=>"Utah",  
		'VT'=>"Vermont",  
		'VA'=>"Virginia",  
		'WA'=>"Washington",  
		'WV'=>"West Virginia",  
		'WI'=>"Wisconsin",  
		'WY'=>"Wyoming");

		$reverse = array();
		foreach ( $state_list as $key=>$state ) {
			$reverse[$state] = $key;
		}
		$state_list = $reverse;
		
		//Getting unique states from database
		require('serverconnect.php');
			
	$sqlStates= "SELECT DISTINCT State
				 FROM food_banks ORDER BY State";	
	$resultState = mysqli_query($mysqli, $sqlStates);
	if (!$resultState) echo "Query Failure [$sqlStates]: " . mysqli_error($mysqli);
	while($row = $resultState->fetch_assoc()){
	$arrayTemp[] = $row;
	}
	
		$stateQuery = '';

	echo "<form action='$pgm2' method='POST'>
		  <p><left><b><u>Look for food banks by state</u></b></left><p>";
	echo "<select name='state'>";

	
foreach ($staticStates as $cat) {
	if ($cat == $category) $se = 'SELECTED';
		else $se = NULL;
	echo "<option $se>$cat </option>\n";
	$stateSelected == $cat;
	}
		 
		/** 
		 $array_length = count($arrayTemp);
		 for ($i = 0; $i < $array_length; $i++)  {
           echo "<option $i>$arrayTemp[$i]</option>\n";
        }
		 **/
echo "</select>";
echo "<p><input type='submit' name='submit' value='Submit'>";
 echo "<p><left><b><u>$stateSelected</u></b></left><p>";


 //Dynamically set stateQuery
 foreach($state_list as $x => $x_value) {
	if($stateSelected == $x) {
		$stateQuery = $x_value;
	}
 }
 /*
 	if($stateSelected == 'Georgia') $stateQuery = $stateIni[0];
	if($stateSelected == 'Florida') $stateQuery = $stateIni[1];
	if($stateSelected == 'South Carolina') $stateQuery = $stateIni[2];
	if($stateSelected == 'North Carolina') $stateQuery = $stateIni[3];
	if($stateSelected == 'New Jersey') $stateQuery = $stateIni[4];
	if($stateSelected == 'Connecticut') $stateQuery = $stateIni[5];
	if($stateSelected == 'New York') $stateQuery = $stateIni[6];
	if($stateSelected == 'Virginia') $stateQuery = $stateIni[7];
	if($stateSelected == 'Delaware') $stateQuery = $stateIni[8];
	if($stateSelected == 'Rhode Island') $stateQuery = $stateIni[9];
	if($stateSelected == 'Massachusetts') $stateQuery = $stateIni[10];
	if($stateSelected == 'New Hampshire') $stateQuery = $stateIni[11];
*/


	
	
	
echo "<form>";
	
		
	//Fill Array with the full address

	

	$sql1= "SELECT CONCAT (address,',',city,',',state,',',zipcode)
		    FROM food_banks";	   
	$result1 = mysqli_query($mysqli, $sql1);
	$address =  array();
	if(mysqli_num_rows($result1)>0){
		while($row =  mysqli_fetch_row($result1)){
		$address[] = $row;
		}
	}

	
		//Fill Array with the lat
	$sql8= "SELECT latitude
		   FROM food_banks
		   WHERE state = '$stateQuery' ";	
    $result8 = mysqli_query($mysqli, $sql8);
	$lat = array();
	if(mysqli_num_rows($result8)>0){
		while($row =  mysqli_fetch_row($result8)){
		$lat[] = $row;
		}
	};
			//Fill Array with the lat
	$sqlLng = "SELECT longitude
		   FROM food_banks
		   WHERE state = '$stateQuery' ";	
    $resultLng = mysqli_query($mysqli, $sqlLng);
	$lng= array();
	if(mysqli_num_rows($resultLng)>0){
		while($row =  mysqli_fetch_row($resultLng)){
		$lng[] = $row;
		}
	};
	
	
		//Fill Array with the locations name
	$sql3= "SELECT name
		   FROM food_banks
		   WHERE state = '$stateQuery'  ";	
    $result3 = mysqli_query($mysqli, $sql3);
	$names = array();
	if(mysqli_num_rows($result3)>0){
		while($row =  mysqli_fetch_row($result3)){
		$names[] = $row;
		}
	};
		//Fill Array with the urls
	$sql4= "SELECT url
		   FROM food_banks
		   WHERE state = '$stateQuery' ";	
    $result4 = mysqli_query($mysqli, $sql4);
	$urls = array();
	if(mysqli_num_rows($result4)>0){
		while($row =  mysqli_fetch_row($result4)){
		$urls[] = $row;
		}
	};
		// Create the side Table Query
		$query = "SELECT name,url,address,city,state,zipcode,phoneNumber
				  FROM food_banks
				  WHERE state = '$stateQuery'";
		// Execute the Query
	$result = mysqli_query($mysqli, $query);
	if (!$result) echo "Query Failure [$query]: " . mysqli_error($mysqli);
	
		// Output the Results	  
	    echo "<!doctype HTML>
		<html><body>";
		
		  echo "<table width='200'
		  align='left' border-collapse: 'collapse'>
		  <tr>
		  </tr>";

		  // Loop Through Query Results		  
	while(list($fbname,$url,$address,$city,$state,$zipcode,$phoneNumber) = mysqli_fetch_row($result)) {
        $redirect = 'GnG.php?p=fbPage&fb='. $fbname;
		echo "<tr>
			  <td align='center'  style='color:black;border: 1px solid black; padding: 15px 15px 15px 15px;background-color: white; font-family: Arial; font-size: 18px;font-weight: bold;' font><a href = '$redirect' style='color:black'>$fbname</a>  </td>
			  </tr>
			  <tr><td align='left'; style='color:black; background-color: lightgray; border: 1px solid black; border-bottom: 4px solid black;width ='100'; height = '100';>$address $city $state, $zipcode</br>
			 Tel. $phoneNumber
			  </td>
			  </tr>";
		}
		echo "</table><br>";
	
// End of Page
		echo "</body></html>";

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        width: 800px;
        height: 500px;
        margin-left: 40%;
      }
    </style>
  </head>
  <body>

    <div class="mb-5" id="map"></div>
    <script>
      var lat =   	 <?php echo json_encode($lat); ?>;
      var lng =  	 <?php echo json_encode($lng); ?>;	
      var name =     <?php echo json_encode($names); ?>;
      var urls =      <?php echo json_encode($urls); ?>;
      var map;
	  const points = name.split(',');
		
	console.log(name);
      
      function initMap() {
		//40.63039271558678, -96.06190831780623 is the center of US
          map = new google.maps.Map(document.getElementById('map'), {
          zoom: 4,
          center: {lat: 40.63039271558678, lng:-96.06190831780623 },
        });
        
		  const infowindow = new google.maps.InfoWindow();
		  var marker,i;
		  
		  for (i = 0; i < lat.length; i++) {  
			marker = new google.maps.Marker({
			position: {lat: parseFloat(lat[i]), lng: parseFloat(lng[i])},
			map: map,
         });

		  google.maps.event.addListener(marker, 'click', (function(marker, i) {
			return function() {
				infowindow.setContent(JSON.stringify(points[i]));
				infowindow.open(map, marker);
        }
		
      })(marker, i));
		 
		 };	 
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=$apiKey&callback=initMap"
    async defer></script>
  </body>
</html>