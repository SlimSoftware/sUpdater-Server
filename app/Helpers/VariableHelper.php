<?php
namespace App\Helpers;

class VariableHelper
{
    public static function parseDownloadLink(string $downloadLink, string|null $version): string
    {
        if ($version !== null) {
            $downloadLink = str_replace('%ver%', $version, $downloadLink);
            $downloadLink = str_replace('%ver.0%', str_replace('.', '', $version), $downloadLink);
            $downloadLink = str_replace('%ver.1%', self::splitVersion($version, 2), $downloadLink);
            $downloadLink = str_replace('%ver.2%', self::splitVersion($version, 3), $downloadLink);
            $downloadLink = str_replace('%ver.3%', self::splitVersion($version, 4), $downloadLink);
        }

        return $downloadLink;
    }

    private static function splitVersion(?string $version, int $digits)
    {
        if (!$version) {
            return '';
        }

        $numbers = explode('.', $version, $digits);
        $newVersion = implode('.', $numbers);

        return $newVersion;
    }
}
