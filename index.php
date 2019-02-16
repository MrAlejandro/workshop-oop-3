<?php

function getDirFileNamesWithoutDots(string $path): array
{
    $dir_file_names = [];
    $directoryIterator = new DirectoryIterator($path);

    foreach ($directoryIterator as $file) {
        if (strpos($file->getFilename(), '.') === 0) {
            continue;
        }

        $dir_file_names[] = $file->getFilename();
    }

    return $dir_file_names;
}

function calculateMiddleIndex(array $arr): int
{
    return (int) round(count($arr) / 2);
}

function sortAlphabetically(array $arr): array
{
    sort($arr);
    return $arr;
}

$fileNames = getDirFileNamesWithoutDots('/srv/www/');
$sortedFileNames = sortAlphabetically($fileNames);
$middleIndex = calculateMiddleIndex($fileNames);
$uppercaseMiddleFileName = strtoupper($sortedFileNames[$middleIndex]);

$endsWithS = strpos($uppercaseMiddleFileName, 'S') === strlen($uppercaseMiddleFileName) - 1;
if ($endsWithS) {
    echo $uppercaseMiddleFileName;
} else {
    echo "{$uppercaseMiddleFileName}S";
}

echo PHP_EOL;
