<?php
    // Search pages
 require('landing.php');
        
	
	// Variables
	$pgm2 	= 'GnG.php?p=searchItem';
	$msg	= NULL;

	
	if (isset($_POST['submit']))  $stateSelected = $_POST['state']; else $stateSelected= NULL;
	if (isset($_POST['submit']))  $foodItemSelected = $_POST['foodItem']; else $foodItemSelected= NULL;
		//state arrays
		$staticStates = array('Georgia','Florida','South Carolina','North Carolina','New Jersey','Connecticut','New York','Virginia','Delaware','Rhode Island','Massachusetts','New Hampshire');
		$stateIni = array('GA','FL','SC','NC','NJ','CT','NY','VA','DE','RI','MA','NH');
		//Foods array
		$foodItems = array ('Baked Beans', 'Beefaroni','Black Beans','Brownie Mix', 'Cake Mix','Canned Beef Stew','Canned Chicken', 'Canned Chilli', 'Carrots', 'Cereal', 'Chickpeas','Chicken Helper','Coffee', 'Condensed Milk'
		, 'Conditioner','Cookies', 'Corn', 'Crackers','Canned Cranberries','Deodrant','Evaporated Milk', 'Gravy', 'Hamburger Helper', 'Hot Chocolate','Icing','Jam','Jello','Juice','Ketchup', 'Laundry Detergent', 'Lentils'
		,'Macaroni & Cheese','Mayonnaise',  'Canned Mixed Fruit', 'Mixed Vegtables','Mustard','Napkins','Oatmeal','Canned Oranges','Pancake Mix','Pancake Syrup','Paper Towels','Pasta Roni','Canned Peaches','Peanut Butter'
		,'Canned Pears','Peas','Canned Pineapple','Potatoes','Powdered Milk','Pudding', 'Red Beans', 'Rice', 'Rice-A-Roni', 'Salad Dressing', 'Salmon', 'Salt',  'Shampoo','Soap',  'Spaghettios', 'Spinach', 'Sugar'
		,'Tea','Tissues','Toilet Paper','Pasta','Tomato Sauce','Tomatoes','Toothpaste','Tuna',  'White Beans','Yams');
				  
		//Getting unique states from database
		require('serverconnect.php');
			
			
		$stateQuery = '';

	echo "<form action='$pgm2' method='POST'>
		  <p><center><b><u>Look for food items by state</u></b></center><p>";
	echo "<center><select name='state'><center>";

foreach ($staticStates as $cat) {
	if ($cat == $category) $se = 'SELECTED';
		else $se = NULL;
	echo "<option $se>$cat </option>\n";
	$stateSelected == $cat;
	}
		 
echo "</select></center>";

	echo "<center><b><select name='foodItem'>";
	
	foreach ($foodItems as $cat) {
	if ($cat == $category) $se = 'SELECTED';
		else $se = NULL;
	echo "<option $se>$cat </option>\n";
	}
	
	echo "</select></b></center>";
	
	 
	
	echo "<p><center><input type='submit' name='submit' value='Submit'></center>";
 echo "<p><center><b><u>$stateSelected</u></b></center><p>";
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
	
	
echo "<form>";
		// Create the side Table Query

		//Select foodbanks ein numbers to get all the food banks in one particular state
		$query2 ="SELECT ein_number 
				  FROM food_banks
				  WHERE state = '$stateQuery'";
		$arrayEinNumbers = array(); 
		$result = mysqli_query($mysqli, $query2);
        while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        $info = $row[0];
        $fb = preg_replace("/-/", "", $info, 1);
        $arrayEinNumbers[] = "" . $fb . "_inv";
		}

		//Query the databse with the new arrayEinNumbers
		$arrayOfItems = array();
		foreach($arrayEinNumbers as $einNumber){
		$query3 = "SELECT quantity
				   FROM `$einNumber`
				   WHERE name = '$foodItemSelected'";
				   
		$resultItem = mysqli_query($mysqli, $query3);
		while($row = mysqli_fetch_array($resultItem, MYSQLI_NUM)){
			$arrayOfItems[] = $row;
		}
		}
		
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
		  align='center' border-collapse: 'collapse'>
		  <tr>
		  </tr>";

		  // Loop Through Query Results		  
	while(list($fbname,$url,$address,$city,$state,$zipcode,$phoneNumber) = mysqli_fetch_row($result)) {
        $redirect = 'GnG.php?p=fbPage&fb='. $fbname;
		echo "<tr>
			  <td align='center'  style='color:black;border: 1px solid black; padding: 15px 15px 15px 15px;background-color: white; font-family: Arial; font-size: 18px;font-weight: bold;' font><a href = '$redirect' style='color:black'>$fbname</a>  </td>
			  </tr>";
		}
		echo "</table><br>";
	
// End of Page
		echo "</body></html>";

?>