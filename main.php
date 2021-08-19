<?php

//Config file
include_once("inc/config.inc.php");

//Interfaces
include_once("inc/interfaces/FileServiceInterface.php");
include_once("inc/interfaces/FlightInterface.php");
include_once("inc/interfaces/IsleInterface.php");
include_once("inc/interfaces/SeatInterface.php");
include_once("inc/interfaces/SeatServiceInterface.php");

//Classes
include_once("inc/classes/Flight.class.php");
include_once("inc/classes/Isle.class.php");
include_once("inc/classes/Seat.class.php");
include_once("inc/classes/SeatService.class.php");

//Utility Classes
include_once("inc/classes/Validation.class.php");
include_once("inc/classes/FileService.class.php");
include_once("inc/classes/Page.class.php");

//If someone hit reset
if (isset($_POST['clear'])) {
    //Write the blank file
    FileService::write("");
}

//If there is no data in the file make one based on the form parameters
clearstatcache();
if (filesize(DATA_FILE) == 0) {

    //Cast the row number, row width and isle position.
    if (Validation::validate()) {
        
        $rows = Validation::$_rows;
        $rowWidth = Validation::$_rowWidth;
        $islePos = Validation::$_islePos;

        //Seat Service - Generate Plan
        SeatService::generateSeatingPlan($rows, $rowWidth, $islePos);

        //Seat Service - Get the new Plan
        $seatingPlan = SeatService::getSeatingPlan();

        //Serialize the seating plan and write it to disk
        $serializedSeatingPlan = SeatService::serialize($seatingPlan);
        FileService::write($serializedSeatingPlan);
    }
}

//If there was get data and row and seat are set (the user click on a seat)
if (isset($_GET["data"]) && isset($_GET["row"]) && isset($_GET["seat"])){
    //Cast the $_GET variables to ints
    $row = $_GET["row"];
    $seat = $_GET["seat"];
    $seatingPlan = array();

    //Pull the seating plan from the file
    $serializedSeatingPlan = FileService::read(DATA_FILE);

    //Parse the seating plan
    $seatingPlan = SeatService::parse($serializedSeatingPlan);

    //Find the corresponding seat and set it to occupied
    $seatingPlan[$row][$seat]->setOccupied(); 

    //Re-serialize the seating plan
    $serializedSeatingPlan = SeatService::serialize($seatingPlan);

    //Write the seating Plan back to the file.
    FileService::write($serializedSeatingPlan);
}

//If the file size is NOT zero
clearstatcache();
if (filesize(DATA_FILE) > 0) {
    //Read in the file seating plan
    $serializedSeatingPlan = FileService::read(DATA_FILE);
    //Parse the seating plan
    $seatingPlan = SeatService::parse($serializedSeatingPlan);
    //Create the flight and assign the seating plan.
    $flight = new Flight();
    $flight->assignSeatingPlan($seatingPlan);
    $stats = $flight->generateStatistics($seatingPlan);
}

//New Page and header stuff...
$p = new Page("Assignment1-RDi-75");
$p->header();

//Check the data file, if it is empty then present the form to create the seating plan.
if (filesize(DATA_FILE) == 0) {
    //Display the manifest form
    $p->displayManifestform();
} else {
    //Otherwise show the seating plan from the flight and show the statistics
    $p->displaySeatingPlan($seatingPlan);
    $p->displayStatistics($stats);
}

//Page footer
$p->footer();
