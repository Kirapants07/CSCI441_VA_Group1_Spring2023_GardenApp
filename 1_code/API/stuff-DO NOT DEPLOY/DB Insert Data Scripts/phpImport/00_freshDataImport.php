<?php

//uncomment the below line to use zip code import on initial data base creation
define('MyConst', TRUE);

// This script is for recreating and refilling a blank database
// In the event of changes, delete your local plantData database and run this script via a web browser
// then it will automatically refill and rebuild that database with the relevant data for testing

require_once("../../../config/database.php");

//1. Drop database and re-create database
require_once("01_freshDB.php");

//Instance of Database class for plantData class used from here forward 02-07
$plantData = new Database("plantData");
$plants = $plantData->connect();

//2. Create fresh tables from empty plant database
require_once("02_plantTableCreation.php");

//3. Import Zones
require_once("03_zoneImport.php");

//4. Import Zipcode (this one takes around 50 seconds to complete, 40,000~ rows to import)
require_once("04_zipCodeImport.php");

//5. Import Plants
require_once("05_plantImport.php");

//6. Import plantgrowingrelationship
require_once("06_plantRelationshipImport.php");

//7. Import plantingInstructions
require_once("07_plantingInstructionsImport.php");

//Instance of Database class for useradmin class used from here forward 08-09
$admin = new Database("useradmin");
$adm = $admin->connect();

//8. Create fresh tables for users
require_once("08_userTableAdminCreation.php");

//9. Import dummy users and data for testing
require_once("09_userDataImport.php");