<?php

class Flight implements FlightInterface
{

    //Store the flight number
    private $_flightNo = "";

    //Store the seating plan
    private $_seatingPlan = array();

    //Store the statistics
    private $_seatingStatistics = array();

    //assigns the seating plan to the object
    function assignSeatingPlan(array $seatingPlan)
    {
        $this->_seatingPlan = $seatingPlan;
    }

    //return the seating plan
    function getSeatingPlan(): array
    {
        return $this->_seatingPlan;
    }

    function generateStatistics(): array
    {

        $stats = array();
        $seatingPlan = $this->getSeatingPlan();
        $islePos = $seatingPlan['islePosition'];
        /**
         * Walk through the array
         *  Get a total of the number of:
         *      Total seats
         *          Total Isle Seats
         *          Total Window Seats
         *          Total Seats with Legroom
         *      Seats booked
         *      Isle Seats booked
         *      Window Seats booked
         *      Seats with Legroom booked
         * 
         */
        $stats["totalSeats"] = 0;
        $stats["totalWindowSeats"] = 0;
        $stats["totalIsleSeats"] = 0;
        $stats["totalLegRoomSeats"] = 0;
        $stats["seatsBooked"] = 0;
        $stats["windowSeatsBooked"] = 0;
        $stats["isleSeatsBooked"] = 0;
        $stats["legRoomSeatsBooked"] = 0;

        for ($x = 0; $x < count($seatingPlan) - 3; $x++) {

            for ($y = 0; $y < count($seatingPlan[$x]); $y++) {
                // If the seat is not at the isle
                if ($y != $islePos - 1) {

                    // Only if the user give me the correct isle position are there isle seats available
                    if($islePos != 0){
                        if ($seatingPlan[$x][$y]->getIsleSeat()) {
                            $stats["totalIsleSeats"]++;
                        }
                        if ($seatingPlan[$x][$y]->getOccupied()) {
                            if ($seatingPlan[$x][$y]->getIsleSeat()) {
                                $stats["isleSeatsBooked"]++;
                            }
                        }
                    }

                    // Otherwise there are no isle seats because the isle does not exsit!
                    $stats["totalSeats"]++;
                    if ($seatingPlan[$x][$y]->getIsWindowSeat()) {
                        $stats["totalWindowSeats"]++;
                    }
                    if ($seatingPlan[$x][$y]->getLegRoom()) {
                        $stats["totalLegRoomSeats"]++;
                    }
                    if ($seatingPlan[$x][$y]->getOccupied()) {
                        $stats["seatsBooked"]++;
                        if ($seatingPlan[$x][$y]->getIsWindowSeat()) {
                            $stats["windowSeatsBooked"]++;
                        }
                        if ($seatingPlan[$x][$y]->getLegRoom()) {
                            $stats["legRoomSeatsBooked"]++;
                        }
                    }
                }                   
            }
        }
        
        if ($stats["totalIsleSeats"] == 0){
            // Just in case the mathmatic exception: 0 / 0;
            $stats["totalIsleSeats"] = 1;
        }

        //Return the statistics array
        $this->_seatingStatistics = $stats;
        return $stats;
    }
}
