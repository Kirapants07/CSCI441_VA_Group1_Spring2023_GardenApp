<?php

//uncomment the below line to use zip code import on initial data base creation
define('MyConst', TRUE);

// This script is for recreating and refilling a blank database
// In the event of changes, delete your local plantData database and run this script via a web browser
// then it will automatically refill and rebuild that database with the relevant data for testing

require_once("../../../config/database.php");

//1. Create fresh tables from empty plant database
require_once("tableCreation.php");

//2. Import Zones
require_once("zoneImport.php");

//3. Import Zipcode (this one takes around 50 seconds to complete, 40,000~ rows to import)
require_once("zipCodeImport.php");

//4. Import Plants

//5. Import plantgrowingrelationship