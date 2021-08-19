<?php


class FileService implements FileServiceInterface {

    static function read() : string {
        //Clear the file cache
        clearstatcache();

        //Try
        try {
            //Open the DATA_FILE            
            $fileHandler = fopen(DATA_FILE, "r");
            if(!$fileHandler) {
                throw new Exception("Cannot open the file!");
            }
            
            //Check for file handle, for our purposes its ok to get an empty file.
            if(filesize(DATA_FILE)){
                //Read the contents
                $fileContents = fread($fileHandler, filesize(DATA_FILE));
            } else {               
                $fileContents = "";
            }
        } catch (Exception $ex) {
            //Catch the exception
            //Write the error to the PHP log file.
            error_log($ex->getMessage(),1);
        } finally {
            //Close the file handle
            fclose($fileHandler);
        }
        //return the file contents
        return $fileContents;
    }
    //Write
    static function write(string $contents) {
        //Clear the file cache
        clearstatcache();

        try {
            //Same same just use fwrite to write the file contents
            $fileHandler = fopen(DATA_FILE, "r+");
            
            //No file handle? throw an error
            if(!$fileHandler) {
                throw new Exception("Cannot open the file!");
            }

            if(filesize(DATA_FILE)) {
                ftruncate($fileHandler, 0);
            } 
            fwrite($fileHandler, $contents);

        } catch (Exception $ex) {
            error_log($ex->getMessage(),1);
        } finally {
            fclose($fileHandler);
        }
    }

}