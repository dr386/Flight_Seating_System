<?php

interface FlightInterface   {
    function assignSeatingPlan(Array $seatingPlan);
    function getSeatingPlan() : Array;
    function generateStatistics() : Array;
}