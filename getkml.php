<?php
/**
    \file getkml.php
    
    \brief Gets Correct KML file from BMLT endpoint for use with the Flexible Map Plugin.
    
	Problem:
    BMLT Endpoint Must be in following fomat to get multiple items (array)
	/main_server/client_interface/kml/?switcher=GetSearchResults&services[]=1&services=8&services=9&services=10&services=11
    
	However the shortcode is like so [flexiblemap parameters] and we can't have square brackets [] inside the shortcode, this would cause errors.
	
	Solution:
	Pass the service bodies seperated by comma ',' to this file as a querystring '?services=' it will then put in right format and output the kml as file to browser.
	
	Example of use: [flexiblemap src="https://www.nerna.org/nerna_scripts/getkml.php?services=15,12" width="100%" kmlcache="5 minutes"]
	This will get a KML file of all meetings in Service body 15 (Westen Mass) and Service body 12 (Pioneer Valley)
	It sets the wifht to 100% and asks google to only cache for 5 minutes.
	
	How do I find the service body ID for a service body? bB logging into the BMLT or by going to the semantic interface https://www.nerna.org/main_server/semantic/
	
	Where is this in use on NERNA.ORG?
		- Currently the only place this is needed is https://nerna.org/meetings-by-area/pioneer-valley-western-mass/
	the Pioneer Valley/Western Mass meeting page. This is because we must pass 2 different service body parameters as array, if it were a single service body
	it could simply be a string and wouldnt be a problem. hence this file.
	
    This file is part of the New England Region of Narcotics Anonymous Website.
	URL: https://www.nerna.org
	
	Author: if help is needed or have questions you can reach out to an addict named Patrick J (Martha's Vineyar).
		Patrick Joyce
		pjaudiomv@gmail.com
		508-939-1663
		
	More info can be found on the BMLT here https://bmlt.app/
 */

// HTTP Headers We are expecting XML
header ( 'Content-Type:application/xml; charset=UTF-8' );
// Output as attachment and set filename, the file name is arbitrary and could really just be anything 
header ( 'Content-Disposition: attachment; filename="SearchResults.kml"');

// Get the Service Body IDs and explode them into an array, this is to be expected in this format filename.php?services=8,9,10 etc
$serviceBodies = explode(',', $_REQUEST['services']);

// Now that we have our array we must traverse it
foreach ($serviceBodies as $serviceBody) {
	$services .= '&services[]=' . $serviceBody;
	// Get array in right format for the BMLT endpoint
}

// We are now ready to get our KML file from the BMLT KML Endpoint.
$getKML = file_get_contents("https://www.nerna.org/main_server/client_interface/kml/?switcher=GetSearchResults" . $services);

// Output KML File
echo $getKML;
