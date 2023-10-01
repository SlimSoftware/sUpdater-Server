<?php
namespace App\Helpers;

class VariableHelper
{
    public static function parseDownloadLink(string $downloadLink, string|null $version): string
    {
        if ($version !== null) {
            $downloadLink = str_replace('%ver%', $version, $downloadLink);
            $downloadLink = str_replace('%ver.0%', str_replace('.', '', $version), $downloadLink);
            $downloadLink = str_replace('%ver.1%', self::splitVersion($version, 1), $downloadLink);
            $downloadLink = str_replace('%ver.2%', self::splitVersion($version, 2), $downloadLink);
            $downloadLink = str_replace('%ver.3%', self::splitVersion($version, 3), $downloadLink);
        }

        return $downloadLink;
    }

    private static function splitVersion(?string $version, int $numberOfDots)
    {
        if (!$version) {
            return '';
        }

        // +2 because the last element of the array could contain the rest of the string
        $numbers = explode('.', $version, $numberOfDots + 2); 

        // remove the last element containing the rest of the string if present
        if (count($numbers) > $numberOfDots + 1) {
            array_pop($numbers);
        }

        $newVersion = implode('.', $numbers);
        return $newVersion;
    }
}
