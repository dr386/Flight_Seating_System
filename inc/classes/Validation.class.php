<?php

class Validation
{
    public static $_rows;
    public static $_rowWidth;
    public static $_islePos;
    public static $_rowsError = "";
    public static $_widthError = "";
    public static $_isislePosError = "";
    
    public static function validate() {

        if (empty($_POST["rows"]) || $_POST["rows"] <= 0) {
            self::$_rowsError = "Rows is required and need to be more than 1!";
            return false;
        } else {
            self::$_rows = $_POST["rows"];
        }

        if (empty($_POST["width"]) || $_POST["width"] <= 0) {
            self::$_widthError = "Row Width is required and need to be more than 1!";
            return false;
        } else {
            self::$_rowWidth = $_POST["width"];
        }

        if (empty($_POST["islePos"]) || $_POST["islePos"] > $_POST["width"]) {
            self::$_islePos = 0;
        } else {
            self::$_islePos = ($_POST["islePos"]);
        }
        return true;
    }
}
