<?php

interface SeatServiceInterface  {
    static function getSeatingPlan() : Array;
    static function generateSeatingPlan(int $rowNums, int $rowWidth, int $islePos = 0);
    static function serialize($seatingPlan) : string; 
    static function parse($serializedSeatingPlan);
}