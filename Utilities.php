<?php
class Utilities
{
    public static function convertToDotlessVersion(string $version)
    {
        return str_replace(".", "", $version);
    }

    public static function convertToMajorMinorVersion(string $version)
    {
        $numbers = explode(".", $version, 3);
        $major = $numbers[0];
        $minor = $numbers[1];
        return "$major.$minor";
    }
}