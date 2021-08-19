<?php

interface SeatInterface {
    function __construct(int $rowNo, int $seatNo);
    function getOccupied() : bool;
    function getIsWindowSeat() : bool;
    function getRowNo() : int;
    function getSeatNo() : int;
    function getLegRoom() : bool;
    function getPrice() : int;
    function setOccupied();
    function setWindowSeat();
    function setIsleSeat();
    function setRowNo(int $rowNo);
    function setSeatNo(int $seatNo);
    function setLegRoom();
    //This next one is good to pay attention to!
    function __toString() : string;
}
?>