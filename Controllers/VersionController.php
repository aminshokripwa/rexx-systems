<?php

class VersionComparator
{
    
    public static function isPriorTo($currentVersion, $targetVersion)
    {
        $currentComponents = self::parseVersion($currentVersion);
        $targetComponents = self::parseVersion($targetVersion);

        // Compare major version
        if ($currentComponents['major'] < $targetComponents['major']) {
            return true;
        } elseif ($currentComponents['major'] > $targetComponents['major']) {
            return false;
        }

        // Compare minor version
        if ($currentComponents['minor'] < $targetComponents['minor']) {
            return true;
        } elseif ($currentComponents['minor'] > $targetComponents['minor']) {
            return false;
        }

        // Compare patch version
        if ($currentComponents['patch'] < $targetComponents['patch']) {
            return true;
        } elseif ($currentComponents['patch'] > $targetComponents['patch']) {
            return false;
        }

        // Compare build metadata
        if (isset($currentComponents['build']) && isset($targetComponents['build'])) {
            $currentBuild = (int)$currentComponents['build']; // Remove the "+" sign
            $targetBuild = (int)$targetComponents['build'];
            if($currentBuild < $targetBuild){
                return true;
            }else{
                return false;
            }
        }
        return false;
    }

    private static function parseVersion($versionString)
    {
        $pattern = '/^(\d+)(?:\.(\d+))?(?:\.(\d+))?(?:\+(\d+))?$/';
        preg_match($pattern, $versionString, $matches);

        $components = [
            'major' => (int) $matches[1],
            'minor' => isset($matches[2]) ? (int) $matches[2] : 0,
            'patch' => isset($matches[3]) ? (int) $matches[3] : 0,
            'build' => isset($matches[4]) ? $matches[4] : null,
        ];
        return $components;
    }
}

// Test the class
/*
$currentVersion = "1.0.15+83";
$targetVersion = "1.0.17+60";

if (VersionComparator::isPriorTo($currentVersion, $targetVersion)) {
    echo $currentVersion . " is prior to " . $targetVersion;
} else {
    echo $currentVersion . " is afterwards than " . $targetVersion;
}
*/

