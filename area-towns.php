<?php

$serviceBodiesURL =  file_get_contents("https://www.nerna.org/main_server/client_interface/json/?switcher=GetServiceBodies");
$serviceBodies_results = json_decode($serviceBodiesURL,true);
$serviceBodies = array();

foreach($serviceBodies_results as $subKey => $subArray){
    if($subArray['name'] == 'New England Region'){
        unset($serviceBodies_results[$subKey]);
    }
}

foreach($serviceBodies_results as $servicebody) {
    $serviceBodies[$servicebody['id']] .= $servicebody['name'];
}
asort($serviceBodies); ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>NERNA Towns Served</title>
</head>
<body>

<?php

foreach($serviceBodies as $id=>$name) {
	echo '<div style="font-weight: bold; font-size: 18pt;">' . $name . '</div>';
	echo '<div style="font-weight: normal; font-size: 14pt;">' .get_unique_cities($id). '</div>';
	echo "<br>";
}
echo '<div style="font-weight: normal; font-size: 14pt;">' . "Total Unique Towns Served: " .get_region_count(). '</div>';
echo "<br>";
function get_unique_cities($serviceBodyId) {
	$meetingsURL =  file_get_contents("https://www.nerna.org/main_server/client_interface/json/?switcher=GetSearchResults&services=" . $serviceBodyId);
	$meetings = json_decode($meetingsURL,true);
	$unique_city = array();
	foreach($meetings as $value) {
		if ($value['location_municipality']) {
			$unique_city[] = $value['location_municipality'] . ", " . $value['location_province'];
		}
	}
	$unique_city = array_unique($unique_city);
	asort($unique_city);
	foreach ($unique_city as $city_value) {
		$output .= $city_value . '<br>';
	}
	$output .= "<br>" . count($unique_city) . " Cities";
	
	return $output;
}

function get_region_count() {
	$meetingsURL =  file_get_contents("https://www.nerna.org/main_server/client_interface/json/?switcher=GetSearchResults&services=1&recursive=1");
	$meetings = json_decode($meetingsURL,true);
	$unique_city = array();
	foreach($meetings as $value) {
		if ($value['location_municipality']) {
			$unique_city[] = $value['location_municipality'];
		}
	}
	$unique_city = array_unique($unique_city);
	$output = count($unique_city);
	
	return $output;
}
?>

	</body>
</html>