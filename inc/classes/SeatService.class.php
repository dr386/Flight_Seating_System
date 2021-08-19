<?php

class SeatService implements SeatServiceInterface
{

    //Store the seathing plan
    private static $seatPlan = array();

    //Return the seathing Plan
    static function getSeatingPlan(): array
    {
        return self::$seatPlan;
    }

    static function generateSeatingPlan(int $rowNums, int $rowWidth, int $islePos = 0)
    {
        //Reset the current seating plan
        self::$seatPlan = array();

        //Walk through the rows
        for ($rows = 0; $rows < $rowNums; $rows++) {

            //Walk through the seats
            for ($cols = 0; $cols < $rowWidth; $cols++) {

                //Create the seat
                $seat = new Seat($rows, $cols);

                //If we are in the first row, legroom
                if ($rows == 0) {
                    $seat->setLegRoom();
                }

                //If we are at the beginning or the end of the row then we must be in a window seat
                if ($cols == 0 || $cols == ($rowWidth - 1)) {
                    $seat->setWindowSeat();
                }

                if ($islePos == 1) {
                    if ($cols == $islePos) {
                        $seat->setIsleSeat();
                    }
                } else if ($islePos == $rowWidth) {
                    if ($cols == ($islePos - 2)) {
                        $seat->setIsleSeat();
                    }
                } else {
                    if ($cols == ($islePos - 2)) {
                        $seat->setIsleSeat();
                    }
                    if ($cols == $islePos) {
                        $seat->setIsleSeat();
                    }
                }
                self::$seatPlan[$rows][$cols] = $seat;
            }
        }
        //Record the seating Plan parameters such as the number of rows, the width and the isle position, other functions will need this information
        self::$seatPlan['rows'] = $rowNums;
        self::$seatPlan['rowWidth'] = $rowWidth;
        self::$seatPlan['islePosition'] = $islePos;
    }

    static function serialize($seatingPlan): string
    {

        $contents = "";
        $islePos = $seatingPlan['islePosition'];

        //PSV seperation for each row get the rowNums we stored not the count otherwise the count will go over the index.

        //For each row
        for ($x = 0; $x < (count($seatingPlan) - 3); $x++) {
            //for each seat
            for ($y = 0; $y < count($seatingPlan[$x]); $y++) {

                if ($y == $islePos - 1) {

                    $contents .= "Isle" . "|";
                } else {
                    //Append the Seat to the seatingPlan
                    $contents .= $seatingPlan[$x][$y]->getRowNo() . ",";
                    $contents .= $seatingPlan[$x][$y]->getSeatNo() . ",";
                    $contents .= $seatingPlan[$x][$y]->getOccupied() . ",";
                    $contents .= $seatingPlan[$x][$y]->getIsWindowSeat() . ",";
                    $contents .= $seatingPlan[$x][$y]->getLegRoom() . ",";
                    $contents .= $seatingPlan[$x][$y]->getIsleSeat();
                    $contents .= "|";
                }
                //If its all but the last seat in the row, then put a seperating pipe
                if ($y == (count($seatingPlan[$x]) - 1)) {
                    $contents = rtrim($contents, "|");
                    $contents .= "\n";
                }
            }
        }

        //Only put a breakline up until and including the last line     
        $contents = rtrim($contents, "\n");

        return $contents;
    }

    //Parse out the file contents back to a seathing Plan
    static function parse($serializedSeatingPlan)
    {

        //A place to store the new seating plan
        $seatingPlan = array();
        $islePos = 0;

        //go through each row
        $lines = explode("\n", $serializedSeatingPlan);
        $rowNums = count($lines);
        for ($rows = 0; $rows < $rowNums; $rows++) {
            //Go through each seat
            $seats = explode("|", $lines[$rows]);
            //Set the rowWidth
            $rowWidth = count($seats);
            for ($cols = 0; $cols < $rowWidth; $cols++) {
                //Explode the seat if its a seat
                if ($seats[$cols] == "Isle") {
                    //record the islePosition
                    $islePos = $cols + 1;
                    $seat = new Seat($rows, $cols);
                } else {
                    //If its not a string I know that its a seat.
                    $traits = explode(",", $seats[$cols]);
                    $seat = new Seat($traits[0], $traits[1]);
                    //Is the seat occupied?
                    if ($traits[2]) {
                        $seat->setOccupied();
                    }
                    //Check to see if its a window seat
                    if ($traits[3]) {
                        $seat->setWindowSeat();
                    }
                    //Check to see if it has legroom
                    if ($traits[4]) {
                        $seat->setLegRoom();
                    }
                    //Check to see if its an isle seat
                    if ($traits[5]) {
                        $seat->setIsleSeat();
                    }
                }
                //Add the seat to the plan
                $seatingPlan[$rows][$cols] = $seat;
            }
        }

        //Put in the row width
        //Put in the islewidth
        //Put in the rowCount
        $seatingPlan['rows'] = $rowNums;
        $seatingPlan['rowWidth'] = $rowWidth;
        $seatingPlan['islePosition'] = $islePos;

        //Record the seating Plan parameters
        //ksort($seatingPlan);
        return $seatingPlan;
    }
}
