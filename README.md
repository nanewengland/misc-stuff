# misc-stuff

## Description

This is just a catch all for some miscellaneous scripts.

## File getkml.php
    
### Brief 
Gets Correct KML file from BMLT endpoint for use with the Flexible Map Plugin.
    
### Problem:

BMLT Endpoint Must be in following fomat to get multiple items (array)

`/main_server/client_interface/kml/?switcher=GetSearchResults&services[]=1&services=8&services=9&services=10&services=11`
    
However the shortcode is like so [flexiblemap parameters] and we can't have square brackets [] inside the shortcode, this would cause errors.

### Solution

Pass the service bodies seperated by comma ',' to this file as a querystring '?services=' it will then put in right format and output the kml as file to browser.

### Example of use

`[flexiblemap src="https://www.nerna.org/nerna_scripts/getkml.php?services=15,12" width="100%" kmlcache="5 minutes"]`

This will get a KML file of all meetings in Service body 15 (Westen Mass) and Service body 12 (Pioneer Valley). It sets the wifht to 100% and asks google to only cache for 5 minutes.

## File area-towns.php

This is just a fun script I made to get a list of all unique towns served by each area
