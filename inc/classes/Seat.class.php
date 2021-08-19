<?php

class Seat implements SeatInterface {

    //Store all the member attributes
    private $_rowNo;
    private $_seatNo;
    private $_price;
    private $_isOccupied = false;
    private $_isWindowSeat = false;
    private $_isLegRoom = false;
    private $_isIsleSeat = false;
    
    //Default Constructor
    public function __construct(int $rowNo, int $seatNo)   {
        //Assign the member attributes
        $this->_rowNo = $rowNo;
        $this->_seatNo = $seatNo;
    }

    //Getters
    public function getRowNo() : int {
        return $this->_rowNo;
    }

    public function getSeatNo() : int {
        return $this->_seatNo;
    }

    public function getOccupied() : bool {
        return $this->_isOccupied;
    }

    public function getIsWindowSeat() : bool {
        return $this->_isWindowSeat;
    }

    public function getLegRoom() : bool {
        return $this->_isLegRoom;
    }

    public function getIsleSeat() : bool {
        return $this->_isIsleSeat;
    }

    //Setters
    public function setRowNo(int $rowNo) {
        $this->_rowNo = $rowNo;
    }

    public function setSeatNo(int $seatNo) {
        $this->_seatNo = $seatNo;
    }

    public function setOccupied() {
        $this->_isOccupied = true; 
    }

    public function setWindowSeat(){
        $this->_isWindowSeat = true;
    }

    public function setIsleSeat() {
        $this->_isIsleSeat = true;
    }

    public function setLegRoom() {
        $this->_isLegRoom = true;
    }
    
    //Implement toString because there is no html we can use this to output to our file
    public function __toString() : string {

        $seatString  = "";
        return $seatString;
    }

    //Calculate price
    public function getPrice() : int  {

        //Go through each of the boolean values and add up the cost
        if($this->getOccupied()) {
            $this->_price = 0;
        } else {
            $this->_price = 200;
            if($this->getIsWindowSeat()) {
                $this->_price += 20;
            }
            if($this->getLegRoom()) {
                $this->_price += 50;
            }
            if($this->getIsleSeat()) {
                $this->_price += 15;
            }
        }

        return $this->_price;

    }

}

?>