<?php

interface FileServiceInterface  {
    static function read() : string;
    static function write(string $contents);
}